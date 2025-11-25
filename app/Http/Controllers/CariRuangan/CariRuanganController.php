<?php

namespace App\Http\Controllers\CariRuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CariRuanganController extends Controller
{
    /**
     * Menampilkan halaman pencarian ruangan
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $rooms = DB::table('ruangan')
            ->select(
                'ruangan.ruanganid',
                'ruangan.nama_ruangan',
                'ruangan.lokasi_ruangan',
                'ruangan.deskripsi',
                'ruangan.kapasitas',
                'ruangan.foto',
                'ruangan.fasilitas'
            )
            ->when($search, function ($query, $search) {
                return $query->where('nama_ruangan', 'like', '%' . $search . '%')
                            ->orWhere('lokasi_ruangan', 'like', '%' . $search . '%')
                            ->orWhere('deskripsi', 'like', '%' . $search . '%');
            })
            ->get();

        $formattedRooms = $rooms->map(function ($room) {
            // Ambil foto dari database (string dipisah koma)
            $images = [];
            if ($room->foto) {
                $images = array_filter(array_map('trim', explode(',', $room->foto)));
            }

            // Ambil foto pertama jika ada, atau gunakan default
            $mainImage = !empty($images) ? $images[0] : null;

            // Format imageUrl dengan deteksi URL dan fallback
            if ($mainImage && (str_starts_with($mainImage, 'http://') || str_starts_with($mainImage, 'https://'))) {
                $imageUrl = $mainImage;
            } elseif ($mainImage) {
                $imageUrl = asset('storage/' . ltrim($mainImage, '/'));
            } else {
                $imageUrl = asset('img/room/tw-01.png');
            }

            return [
                'id' => $room->ruanganid,
                'name' => $room->nama_ruangan,
                'type' => 'Room',
                'location' => $room->lokasi_ruangan ?? '-',
                'desc' => $room->deskripsi ?? 'Tidak ada deskripsi',
                'facilities' => $room->fasilitas ?? 'Tidak ada fasilitas',
                'capacity' => $room->kapasitas ?? 0,
                'capacityLabel' => $room->kapasitas ? $room->kapasitas . ' Orang' : 'N/A',
                'price' => null,
                'image' => $imageUrl,
            ];
        });

        return view('page/cariruangan/cariruangan', [
            'rooms' => $formattedRooms,
            'search' => $search
        ]);
    }

    /**
     * API endpoint untuk pencarian ruangan (AJAX)
     */
    public function search(Request $request)
    {
        $search = $request->input('query', '');
        $filterDate = $request->input('date');
        $filterTime = $request->input('time');
        $filterCapacity = $request->input('capacity');
        $filterFacilities = $request->input('facilities', []);

        $query = DB::table('ruangan')
            ->select(
                'ruangan.ruanganid',
                'ruangan.nama_ruangan',
                'ruangan.lokasi_ruangan',
                'ruangan.deskripsi',
                'ruangan.kapasitas',
                'ruangan.foto',
                'ruangan.fasilitas'
            );

        // Filter pencarian nama ruangan, lokasi, atau deskripsi
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_ruangan', 'like', '%' . $search . '%')
                  ->orWhere('lokasi_ruangan', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        // Filter kapasitas (minimal kapasitas yang dicari)
        if (!empty($filterCapacity)) {
            $capacityNumber = (int) filter_var($filterCapacity, FILTER_SANITIZE_NUMBER_INT);
            if ($capacityNumber > 0) {
                $query->where('kapasitas', '>=', $capacityNumber);
            }
        }

        // Filter fasilitas - cari ruangan yang memiliki SEMUA fasilitas yang dipilih
        if (!empty($filterFacilities) && is_array($filterFacilities)) {
            foreach ($filterFacilities as $facility) {
                // Mapping nama fasilitas dari checkbox ke database
                $facilityMap = [
                    'ac' => 'AC',
                    'speaker' => 'Sound System',
                    'layar' => 'Proyektor',
                    'mic' => 'Mic',
                    'smart-tv' => 'TV',
                    'wifi' => 'WiFi',
                    'whiteboard' => 'Whiteboard',
                ];

                $dbFacilityName = $facilityMap[$facility] ?? $facility;
                $query->where('fasilitas', 'like', '%' . $dbFacilityName . '%');
            }
        }

        // Filter berdasarkan ketersediaan tanggal dan waktu
        if (!empty($filterDate) && !empty($filterTime)) {
            $query->whereNotExists(function ($subQuery) use ($filterDate, $filterTime) {
                $subQuery->select(DB::raw(1))
                    ->from('peminjaman')
                    ->whereColumn('peminjaman.ruanganid', 'ruangan.ruanganid')
                    ->where('peminjaman.tanggal', $filterDate)
                    ->where('peminjaman.nama_shift', $filterTime);
            });
        }

        $rooms = $query->get();

        $formattedRooms = $rooms->map(function ($room) {
            // Ambil foto dari database (string dipisah koma)
            $images = [];
            if ($room->foto) {
                $images = array_filter(array_map('trim', explode(',', $room->foto)));
            }

            // Ambil foto pertama jika ada, atau gunakan default
            $mainImage = !empty($images) ? $images[0] : null;

            // Format imageUrl dengan deteksi URL dan fallback
            if ($mainImage && (str_starts_with($mainImage, 'http://') || str_starts_with($mainImage, 'https://'))) {
                $imageUrl = $mainImage;
            } elseif ($mainImage) {
                $imageUrl = asset('storage/' . ltrim($mainImage, '/'));
            } else {
                $imageUrl = asset('img/room/tw-01.png');
            }

            return [
                'id' => $room->ruanganid,
                'name' => $room->nama_ruangan,
                'type' => 'Room',
                'location' => $room->lokasi_ruangan ?? '-',
                'desc' => $room->deskripsi ?? 'Tidak ada deskripsi',
                'facilities' => $room->fasilitas ?? 'Tidak ada fasilitas',
                'capacity' => $room->kapasitas ?? 0,
                'capacityLabel' => $room->kapasitas ? $room->kapasitas . ' Orang' : 'N/A',
                'price' => null,
                'image' => $imageUrl,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedRooms,
            'count' => $formattedRooms->count()
        ]);
    }

    public function show($id)
    {
        $room = DB::table('ruangan')
            ->where('ruanganid', $id)
            ->first();

        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Ruangan tidak ditemukan'
            ], 404);
        }

        $bookings = DB::table('peminjaman')
            ->join('app_user', 'peminjaman.userid', '=', 'app_user.userid')
            ->where('peminjaman.ruanganid', $id)
            ->where('peminjaman.tanggal', '>=', now()->toDateString())
            ->select(
                'peminjaman.peminjamanid',
                'peminjaman.tanggal',
                'peminjaman.nama_shift',
                'peminjaman.keterangan',
                'app_user.nama as peminjam'
            )
            ->orderBy('peminjaman.tanggal', 'asc')
            ->get();

        $foto = $room->foto;
        if ($foto && (str_starts_with($foto, 'http://') || str_starts_with($foto, 'https://'))) {
            $imageUrl = $foto;
        } elseif ($foto) {
            $imageUrl = asset('storage/' . ltrim($foto, '/'));
        } else {
            $imageUrl = asset('img/default-room.png');
        }

        return response()->json([
            'success' => true,
            'data' => [
                'room' => [
                    'id' => $room->ruanganid,
                    'name' => $room->nama_ruangan,
                    'location' => $room->lokasi_ruangan,
                    'description' => $room->deskripsi,
                    'capacity' => $room->kapasitas,
                    'facilities' => $room->fasilitas,
                    'photo' => $imageUrl,
                ],
                'bookings' => $bookings
            ]
        ]);
    }

    public function getFacilities()
    {
        $facilities = DB::table('ruangan')
            ->select('fasilitas')
            ->whereNotNull('fasilitas')
            ->distinct()
            ->get()
            ->pluck('fasilitas')
            ->flatMap(function ($facility) {
                return explode(',', $facility);
            })
            ->map(function ($facility) {
                return trim($facility);
            })
            ->unique()
            ->values();

        return response()->json([
            'success' => true,
            'data' => $facilities
        ]);
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'ruanganid' => 'required|integer',
            'tanggal' => 'required|date',
            'shift' => 'required|string'
        ]);

        $isBooked = DB::table('peminjaman')
            ->where('ruanganid', $request->ruanganid)
            ->where('tanggal', $request->tanggal)
            ->where('nama_shift', $request->shift)
            ->exists();

        return response()->json([
            'success' => true,
            'available' => !$isBooked,
            'message' => $isBooked ? 'Ruangan sudah dipesan' : 'Ruangan tersedia'
        ]);
    }
}