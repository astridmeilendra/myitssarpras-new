@extends('template-full')

@section('content')
<div class="flex flex-col h-full bg-gray-50">
    <!-- Header with Back Button - Sticky -->
    <div class="sticky top-0 z-10 bg-white shadow-sm flex items-center px-6 pt-6 pb-4">
        <a href="{{ route('riwayat') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>

        <div class="flex flex-col justify-center text-center m-auto">
            <h1 class="text-md font-bold text-[#003D82]">Detail Peminjaman</h1>
        </div>
        <div class="w-6 h-6"></div>
    </div>

    <!-- Content -->
    <div class="flex-1 overflow-y-auto px-6 py-6 bg-gray-50">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">

            <!-- Confirmation Modal -->
            <div id="confirmModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white rounded-xl p-6 w-80 shadow-lg">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Batalkan Peminjaman?</h3>
                    <p class="text-sm text-gray-600 mb-6">Apakah Anda yakin ingin membatalkan peminjaman {{ $peminjaman->nama_ruangan }}?</p>
                    <div class="flex gap-3">
                        <button onclick="closeConfirmModal()" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Batal
                        </button>
                        <form id="cancelForm" method="POST" action="{{ route('peminjaman.cancel', $peminjaman->peminjamanid) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700">
                                Batalkan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Room -->
            <div class="flex items-start justify-between mb-4 gap-4">
                <div class="flex-1">
                    <span class="block text-xs font-medium text-gray-500 mb-0.5">Room</span>
                    <h2 class="text-xl font-bold text-gray-900 leading-tight">{{ $peminjaman->nama_ruangan }}</h2>

                    <div class="mt-3 space-y-1.5 text-xs text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $peminjaman->nama_shift }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>{{ $peminjaman->kapasitas }} Orang</span>
                        </div>
                    </div>
                </div>

                <div class="flex-shrink-0 pt-1">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
                        @if($statusTerakhir === 'Menunggu')
                            bg-yellow-100 text-yellow-700
                        @elseif($statusTerakhir === 'Disetujui')
                            bg-green-100 text-green-700
                        @elseif($statusTerakhir === 'Ditolak' || $statusTerakhir === 'Dibatalkan')
                            bg-red-100 text-red-700
                        @elseif($statusTerakhir === 'Verifikasi Data')
                            bg-blue-100 text-blue-700
                        @else
                            bg-gray-100 text-gray-700
                        @endif
                    ">
                        {{ $statusTerakhir ?? 'Menunggu' }}
                    </span>
                </div>
            </div>

            <!-- Timeline -->
            <div class="mt-4 pt-3 border-t border-gray-100">
                <div class="space-y-6">
                    @forelse($riwayatStatus as $status)
                        @php
                            $dotColor = 'bg-blue-600';
                            if ($status->nama_status === 'Ditolak') {
                                $dotColor = 'bg-red-600';
                            } elseif ($status->nama_status === 'Dibatalkan') {
                                $dotColor = 'bg-red-600';
                            } elseif ($status->nama_status === 'Menunggu') {
                                $dotColor = 'bg-yellow-400';
                            } elseif ($status->nama_status === 'Disetujui') {
                                $dotColor = 'bg-green-600';
                            } elseif ($status->nama_status === 'Verifikasi Data') {
                                $dotColor = 'bg-blue-500';
                            }
                        @endphp
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 pt-1">
                                <div class="w-3 h-3 rounded-full {{ $dotColor }}"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-gray-800">{{ $status->nama_status }}</p>
                                <p class="text-[11px] text-gray-600 mt-0.5">{{ $status->keterangan ?? 'Pengajuan peminjaman ruangan baru' }}</p>
                                <p class="text-[10px] text-gray-400 mt-1">
                                    {{ \Carbon\Carbon::parse($status->waktu_update)->format('d-m-Y / H:i') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500 text-center py-4">Belum ada riwayat status</p>
                    @endforelse
                </div>
            </div>

            <!-- Keterangan -->
            @if($peminjaman->keterangan)
                <div class="mt-6 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold text-gray-700 mb-1">Keterangan</p>
                    <p class="text-xs text-gray-600">{{ $peminjaman->keterangan }}</p>
                </div>
            @endif

            <!-- Dokumen (jika sudah ada) -->
            @if($peminjaman->dokumen && $dokumenUrl)
                <div class="mt-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-xs font-semibold text-gray-700 mb-2">Dokumen Pendukung</p>
                    <a href="{{ $dokumenUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 text-xs font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Lihat Dokumen
                    </a>
                </div>
            @endif

            <!-- ===================== -->
            <!-- SECTION: VERIFIKASI DATA -->
            <!-- ===================== -->
            @if($statusTerakhir === 'Verifikasi Data')
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="flex items-start gap-2 mb-3">
                        <svg class="w-4 h-4 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div>
                            <p class="text-xs font-bold text-blue-800">Langkah Selanjutnya: Upload Surat Permohonan</p>
                            <p class="text-xs text-blue-600 mt-0.5">Generate surat otomatis dari data yang kamu isi, lengkapi di browser, lalu upload PDF-nya di bawah.</p>
                        </div>
                    </div>

                    <!-- Steps -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-start gap-2">
                            <span class="flex-shrink-0 w-5 h-5 bg-blue-700 text-white rounded-full text-[10px] font-bold flex items-center justify-center">1</span>
                            <p class="text-xs text-blue-800">Klik "Generate Surat" → surat terbuka di tab baru</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="flex-shrink-0 w-5 h-5 bg-blue-700 text-white rounded-full text-[10px] font-bold flex items-center justify-center">2</span>
                            <p class="text-xs text-blue-800">Lengkapi nomor surat, nama unit &amp; penandatangan</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="flex-shrink-0 w-5 h-5 bg-blue-700 text-white rounded-full text-[10px] font-bold flex items-center justify-center">3</span>
                            <p class="text-xs text-blue-800">Cetak/Save as PDF → upload di bawah → Kirim</p>
                        </div>
                    </div>

                    <!-- Generate Button -->
                    <button onclick="generateSurat()" class="w-full flex items-center justify-center gap-2 px-4 py-3 border-2 border-blue-600 text-blue-700 font-semibold rounded-xl text-sm hover:bg-blue-100 transition-colors bg-white mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Generate Surat Permohonan
                    </button>

                    <!-- Upload Section -->
                    <div class="mb-1">
                        <p class="text-xs font-medium text-gray-700 mb-2">Upload Surat (PDF/DOC/JPG/PNG, maks 5MB)</p>
                        <input type="file" id="suratFile" class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" onchange="updateSuratFileName(this)">
                        <div onclick="document.getElementById('suratFile').click()" class="w-full flex items-center gap-3 px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-colors bg-white select-none">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <span id="suratFileLabel" class="text-sm text-gray-500 truncate">Pilih file surat...</span>
                        </div>
                        <p id="suratError" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>
                </div>

                <!-- Buttons for Verifikasi Data -->
                <div class="mt-4 space-y-2">
                    <x-button id="submitSuratBtn" variant="solid" size="md" :full="true" onclick="submitUploadSurat()">
                        Kirim Surat &amp; Ajukan Peminjaman
                    </x-button>
                    <x-button variant="danger" size="md" :full="true" onclick="openConfirmModal()">
                        Batalkan Peminjaman
                    </x-button>
                </div>

            @elseif($statusTerakhir === 'Menunggu')
                <!-- ===================== -->
                <!-- SECTION: MENUNGGU -->
                <!-- ===================== -->
                <div class="mt-6 space-y-2">
                    <a href="{{ route('ruangan.detail', $peminjaman->ruanganid) }}" class="block">
                        <x-button variant="solid" size="md" :full="true">
                            Lihat Detail Ruangan
                        </x-button>
                    </a>
                    <x-button variant="danger" size="md" :full="true" onclick="openConfirmModal()">
                        Batalkan Peminjaman
                    </x-button>
                </div>

            @elseif($statusTerakhir === 'Disetujui')
                <!-- ===================== -->
                <!-- SECTION: DISETUJUI -->
                <!-- ===================== -->
                <div class="mt-6 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-xs text-green-700">Peminjaman Anda telah disetujui. Silakan ambil kunci ruangan di Sarpras.</p>
                </div>

            @elseif($statusTerakhir === 'Ditolak' || $statusTerakhir === 'Dibatalkan')
                <!-- ===================== -->
                <!-- SECTION: DITOLAK / DIBATALKAN -->
                <!-- ===================== -->
                <div class="mt-6 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-xs text-red-700">Peminjaman ini telah {{ strtolower($statusTerakhir) }}. Hubungi Sarpras untuk informasi lebih lanjut.</p>
                </div>

            @elseif($statusTerakhir === 'Selesai')
                <!-- ===================== -->
                <!-- SECTION: SELESAI -->
                <!-- ===================== -->
                <div class="mt-6 p-3 bg-gray-50 border border-gray-200 rounded-lg">
                    <p class="text-xs text-gray-700">Peminjaman ini telah selesai. Terima kasih telah menggunakan layanan kami.</p>
                </div>
            @endif

        </div>
    </div>

    <!-- Bottom Navigation -->
    <x-navbar active="riwayat" />
</div>

<script>
    function openConfirmModal() {
        document.getElementById('confirmModal').classList.remove('hidden');
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    document.getElementById('confirmModal').addEventListener('click', function(e) {
        if (e.target === this) closeConfirmModal();
    });

    function updateSuratFileName(input) {
        const label = document.getElementById('suratFileLabel');
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = 'Pilih file surat...';
        }
    }

    function generateSurat() {
        const data = {
            nama_pemohon: "{{ $peminjaman->nama ?? '' }}",
            nama_ruangan: "{{ $peminjaman->nama_ruangan ?? '' }}",
            lokasi: "{{ $peminjaman->lokasi_ruangan ?? '' }}",
            hari: "{{ \Carbon\Carbon::parse($peminjaman->tanggal)->isoFormat('dddd') }}",
            tanggal: "{{ \Carbon\Carbon::parse($peminjaman->tanggal)->isoFormat('D MMMM Y') }}",
            shift: "{{ $peminjaman->nama_shift ?? '' }}",
            keterangan: "{{ addslashes($peminjaman->keterangan ?? '') }}",
            tanggalHari: new Date().toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'}),
        };

        const html = `<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Surat Permohonan Peminjaman Ruangan</title>
<style>
  * { box-sizing: border-box; }
  body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; margin: 2.5cm 3cm 2.5cm 3cm; color: #000; line-height: 1.5; }
  .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 24px; }
  .kop h2 { font-size: 14pt; margin: 0 0 2px 0; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; }
  .kop p { font-size: 10pt; margin: 2px 0; }
  .meta-table { margin-bottom: 20px; border-collapse: collapse; }
  .meta-table td { padding: 1px 0; vertical-align: top; }
  .meta-table td:first-child { min-width: 100px; }
  .meta-table td:nth-child(2) { padding: 1px 8px; }
  .kepada { margin-bottom: 16px; }
  .kepada p { margin: 1px 0; }
  .body-text { text-align: justify; }
  .body-text p { margin: 12px 0; }
  .detail-table { margin: 8px 0 8px 20px; border-collapse: collapse; }
  .detail-table td { padding: 2px 0; vertical-align: top; }
  .detail-table td:first-child { min-width: 130px; }
  .detail-table td:nth-child(2) { padding: 2px 12px; }
  .ttd-wrap { margin-top: 36px; display: flex; justify-content: flex-end; }
  .ttd { text-align: center; min-width: 220px; }
  .ttd .space { height: 70px; }
  .ttd .nama { font-weight: bold; text-decoration: underline; }
  .ttd .nip { font-size: 11pt; }
  .tembusan { margin-top: 36px; font-size: 11pt; }
  .tembusan p { margin: 1px 0; }
  .print-btn { position: fixed; bottom: 20px; right: 20px; padding: 12px 24px; background: #003D82; color: white; border: none; border-radius: 8px; font-size: 14px; font-weight: bold; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.3); z-index: 999; }
  .print-btn:hover { background: #002d62; }
  @media print { .print-btn { display: none !important; } body { margin: 2cm 2.5cm; } }
  input[type=text] { border: none; border-bottom: 1px dashed #aaa; background: transparent; font-family: inherit; font-size: inherit; color: inherit; padding: 0 4px 1px; }
  input[type=text]:focus { outline: none; border-bottom: 1px solid #003D82; }
  input[type=text]::placeholder { color: #aaa; font-style: italic; }
</style>
</head>
<body>

<!-- KOP SURAT -->
<div class="kop">
  <h2>Institut Teknologi Sepuluh Nopember</h2>
  <p>Direktorat Sarana dan Prasarana</p>
  <p>Kampus ITS Sukolilo, Surabaya 60111 &nbsp;|&nbsp; Telp. (031) 5994251</p>
</div>

<!-- NOMOR & HAL -->
<table class="meta-table">
  <tr>
    <td>Nomor</td>
    <td>:</td>
    <td><input type="text" placeholder="………………………" style="min-width:200px"></td>
  </tr>
  <tr>
    <td>Hal</td>
    <td>:</td>
    <td>Peminjaman Ruang di ${data.lokasi || 'Gedung ITS'}</td>
  </tr>
</table>

<!-- KEPADA -->
<div class="kepada">
  <p>Kepada &nbsp;Yth &nbsp;:</p>
  <p>Direktur Pendidikan</p>
  <p>Di Kampus ITS Sukolilo</p>
  <p>Surabaya</p>
</div>

<!-- BODY -->
<div class="body-text">
  <p>Dengan hormat,</p>
  <p>Sehubungan dengan akan diselenggarakan kegiatan <input type="text" placeholder="nama kegiatan" style="min-width:200px">, oleh <input type="text" placeholder="nama unit/organisasi/himpunan" style="min-width:180px">, maka bersama ini kami mengajukan permohonan peminjaman ruangan:</p>

  <table class="detail-table">
    <tr>
      <td>Hari</td>
      <td>:</td>
      <td>${data.hari}</td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>:</td>
      <td>${data.tanggal}</td>
    </tr>
    <tr>
      <td>Jam</td>
      <td>:</td>
      <td>${data.shift}</td>
    </tr>
    <tr>
      <td>Ruang yang dipinjam</td>
      <td>:</td>
      <td>${data.nama_ruangan}</td>
    </tr>
  </table>

  <p>Demikian permohonan kami, atas perhatian dan kerjasamanya kami sampaikan terima kasih.</p>
</div>

<!-- TTD -->
<div class="ttd-wrap">
  <div class="ttd">
    <p>Surabaya, ${data.tanggalHari}</p>
    <p>Kepala Unit/Departemen,</p>
    <div class="space"></div>
    <p class="nama"><input type="text" placeholder="Nama Penandatangan" style="min-width:160px; text-align:center; font-weight:bold; text-decoration:underline"></p>
    <p class="nip"><input type="text" placeholder="NIP" style="min-width:120px; text-align:center"></p>
  </div>
</div>

<!-- TEMBUSAN -->
<div class="tembusan">
  <p>Tembusan Yth:</p>
  <p>- Kepala Subdirektorat Koordinasi Perkuliahan Bersama</p>
  <p>- Kepala Biro Sarana dan Prasarana</p>
</div>

<button class="print-btn" onclick="window.print()">🖨️ Cetak / Save as PDF</button>

</body>
</html>`;

        const win = window.open('', '_blank');
        win.document.write(html);
        win.document.close();
    }

    async function submitUploadSurat() {
        const fileInput = document.getElementById('suratFile');
        const errorEl = document.getElementById('suratError');
        const btn = document.getElementById('submitSuratBtn');

        errorEl.classList.add('hidden');

        if (!fileInput || !fileInput.files || !fileInput.files[0]) {
            errorEl.textContent = 'Pilih file surat terlebih dahulu sebelum mengirim.';
            errorEl.classList.remove('hidden');
            return;
        }

        const file = fileInput.files[0];
        const maxSize = 5 * 1024 * 1024;
        if (file.size > maxSize) {
            errorEl.textContent = 'Ukuran file maksimal 5MB.';
            errorEl.classList.remove('hidden');
            return;
        }

        btn.disabled = true;
        btn.querySelector('span')
            ? btn.querySelector('span').textContent = 'Mengirim...'
            : btn.textContent = 'Mengirim...';

        const formData = new FormData();
        formData.append('surat', file);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}');

        try {
            const response = await fetch('{{ route("peminjaman.upload-surat", $peminjaman->peminjamanid) }}', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
            });

            const result = await response.json();

            if (result.success) {
                window.location.reload();
            } else {
                errorEl.textContent = result.message || 'Terjadi kesalahan saat mengirim surat.';
                errorEl.classList.remove('hidden');
                btn.disabled = false;
                btn.querySelector('span')
                    ? btn.querySelector('span').textContent = 'Kirim Surat & Ajukan Peminjaman'
                    : btn.textContent = 'Kirim Surat & Ajukan Peminjaman';
            }
        } catch (err) {
            console.error(err);
            errorEl.textContent = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
            errorEl.classList.remove('hidden');
            btn.disabled = false;
            btn.querySelector('span')
                ? btn.querySelector('span').textContent = 'Kirim Surat & Ajukan Peminjaman'
                : btn.textContent = 'Kirim Surat & Ajukan Peminjaman';
        }
    }
</script>
@endsection
