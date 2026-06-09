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

            <!-- ===================== -->
            <!-- MODAL: PREVIEW SURAT -->
            <!-- ===================== -->
            <div id="suratModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-60 flex items-end justify-center">
                <div class="bg-white w-full max-w-lg rounded-t-2xl flex flex-col" style="max-height:92vh">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 flex-shrink-0">
                        <h3 class="text-sm font-bold text-gray-900">Surat Permohonan Peminjaman</h3>
                        <button onclick="closeSuratModal()" class="text-gray-400 hover:text-gray-600 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body — scrollable -->
                    <div class="overflow-y-auto flex-1 px-5 py-4 space-y-3">

                        <!-- Nomor Surat -->
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nomor Surat</label>
                            <input id="s_nomor" type="text" placeholder="Contoh: 001/HMT-ITS/VI/2026"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        </div>

                        <!-- Nama Kegiatan -->
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Kegiatan</label>
                            <input id="s_kegiatan" type="text" placeholder="Contoh: Rapat Koordinasi Himpunan"
                                value="{{ $peminjaman->keterangan ?? '' }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        </div>

                        <!-- Nama Unit / Organisasi -->
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Unit / Organisasi / Himpunan</label>
                            <input id="s_unit" type="text" placeholder="Contoh: Himpunan Mahasiswa Teknik ITS"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        </div>

                        <!-- Nama Penandatangan -->
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Nama Penandatangan</label>
                            <input id="s_nama_ttd" type="text" placeholder="Nama lengkap"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        </div>

                        <!-- NIP / NRP -->
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">NIP / NRP Penandatangan</label>
                            <input id="s_nip" type="text" placeholder="Contoh: 5024231001"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        </div>

                        <!-- Data otomatis (readonly) -->
                        <div class="bg-gray-50 rounded-xl p-3 space-y-1.5">
                            <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide mb-2">Data Peminjaman (otomatis)</p>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500">Ruangan</span>
                                <span class="font-medium text-gray-800">{{ $peminjaman->nama_ruangan }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500">Hari</span>
                                <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($peminjaman->tanggal)->locale('id')->isoFormat('dddd') }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500">Tanggal</span>
                                <span class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($peminjaman->tanggal)->locale('id')->isoFormat('D MMMM Y') }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-gray-500">Waktu</span>
                                <span class="font-medium text-gray-800">{{ $peminjaman->nama_shift }}</span>
                            </div>
                        </div>

                        <p class="text-[10px] text-gray-400 text-center">PDF akan langsung terunduh ke perangkatmu</p>
                    </div>

                    <!-- Modal Footer -->
                    <div class="px-5 py-4 border-t border-gray-100 flex-shrink-0">
                        <button type="button" onclick="downloadSuratPDF()"
                            class="w-full flex items-center justify-center gap-2 py-3 bg-[#003D82] text-white font-semibold rounded-xl text-sm hover:bg-[#002a5c] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download Surat (PDF)
                        </button>
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
                            <p class="text-xs text-blue-800">Klik "Generate Surat" → isi data yang kosong di form</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="flex-shrink-0 w-5 h-5 bg-blue-700 text-white rounded-full text-[10px] font-bold flex items-center justify-center">2</span>
                            <p class="text-xs text-blue-800">Klik "Download Surat" → simpan sebagai PDF dari browser/Files</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="flex-shrink-0 w-5 h-5 bg-blue-700 text-white rounded-full text-[10px] font-bold flex items-center justify-center">3</span>
                            <p class="text-xs text-blue-800">Upload file PDF-nya di bawah → Kirim</p>
                        </div>
                    </div>

                    <!-- Generate Button -->
                    <button onclick="openSuratModal()" class="w-full flex items-center justify-center gap-2 px-4 py-3 border-2 border-blue-600 text-blue-700 font-semibold rounded-xl text-sm hover:bg-blue-100 transition-colors bg-white mb-4">
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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

    function openSuratModal() {
        document.getElementById('suratModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeSuratModal() {
        document.getElementById('suratModal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    document.getElementById('suratModal').addEventListener('click', function(e) {
        if (e.target === this) closeSuratModal();
    });

    function downloadSuratPDF() {
        const nomor    = document.getElementById('s_nomor').value.trim() || '_______________';
        const kegiatan = document.getElementById('s_kegiatan').value.trim() || '_______________';
        const unit     = document.getElementById('s_unit').value.trim() || '_______________';
        const namaTtd  = document.getElementById('s_nama_ttd').value.trim() || '_______________';
        const nip      = document.getElementById('s_nip').value.trim() || '_______________';

        const namaRuangan = "{{ $peminjaman->nama_ruangan ?? '' }}";
        const lokasi      = "{{ $peminjaman->lokasi_ruangan ?? '' }}";
        const hari        = "{{ \Carbon\Carbon::parse($peminjaman->tanggal)->locale('id')->isoFormat('dddd') }}";
        const tanggal     = "{{ \Carbon\Carbon::parse($peminjaman->tanggal)->locale('id')->isoFormat('D MMMM Y') }}";
        const shift       = "{{ $peminjaman->nama_shift ?? '' }}";
        const today       = new Date().toLocaleDateString('id-ID', {day:'numeric', month:'long', year:'numeric'});

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });

        const marginL = 30;
        const marginR = 210 - 25;
        const lineW   = marginR - marginL;
        let y = 20;

        const center = (text, yPos, size = 12, style = 'normal') => {
            doc.setFontSize(size);
            doc.setFont('times', style);
            doc.text(text, 210 / 2, yPos, { align: 'center' });
        };

        const left = (text, yPos, size = 12, style = 'normal') => {
            doc.setFontSize(size);
            doc.setFont('times', style);
            doc.text(text, marginL, yPos);
        };

        const wrap = (text, yPos, size = 12, style = 'normal') => {
            doc.setFontSize(size);
            doc.setFont('times', style);
            const lines = doc.splitTextToSize(text, lineW);
            doc.text(lines, marginL, yPos);
            return yPos + (lines.length * 6);
        };

        // KOP SURAT
        center('INSTITUT TEKNOLOGI SEPULUH NOPEMBER', y, 14, 'bold');
        y += 6;
        center('Direktorat Sarana dan Prasarana', y, 11);
        y += 5;
        center('Kampus ITS Sukolilo, Surabaya 60111  |  Telp. (031) 5994251', y, 10);
        y += 6;
        doc.setLineWidth(0.8);
        doc.line(marginL, y, marginR, y);
        doc.setLineWidth(0.3);
        doc.line(marginL, y + 1.5, marginR, y + 1.5);
        y += 8;

        // NOMOR & HAL
        doc.setFontSize(12); doc.setFont('times', 'normal');
        doc.text('Nomor', marginL, y);
        doc.text(':', marginL + 22, y);
        doc.text(nomor, marginL + 26, y);
        y += 6;
        doc.text('Hal', marginL, y);
        doc.text(':', marginL + 22, y);
        doc.text('Peminjaman Ruang di ' + (lokasi || namaRuangan), marginL + 26, y);
        y += 12;

        // KEPADA
        left('Kepada  Yth :', y);  y += 6;
        left('Direktur Pendidikan', y); y += 6;
        left('Di Kampus ITS Sukolilo', y); y += 6;
        left('Surabaya', y); y += 12;

        // SALAM
        left('Dengan hormat,', y); y += 8;

        // ISI
        const kalimatIsi = 'Sehubungan dengan akan diselenggarakan kegiatan ' + kegiatan + ', oleh ' + unit + ', maka bersama ini kami mengajukan permohonan peminjaman ruangan:';
        y = wrap(kalimatIsi, y, 12, 'normal') + 4;

        // DETAIL TABLE
        const col1 = marginL + 5;
        const col2 = col1 + 42;
        const col3 = col2 + 8;
        const rows = [
            ['Hari', hari],
            ['Tanggal', tanggal],
            ['Jam', shift],
            ['Ruang yang dipinjam', namaRuangan],
        ];
        rows.forEach(([label, val]) => {
            doc.setFontSize(12); doc.setFont('times', 'normal');
            doc.text(label, col1, y);
            doc.text(':', col2, y);
            doc.text(val, col3, y);
            y += 6;
        });
        y += 6;

        // PENUTUP
        y = wrap('Demikian permohonan kami, atas perhatian dan kerjasamanya kami sampaikan terima kasih.', y, 12, 'normal') + 10;

        // TTD
        const ttdX = 210 - 25 - 50;
        doc.setFontSize(12); doc.setFont('times', 'normal');
        doc.text('Surabaya, ' + today, ttdX, y, { align: 'center' });
        y += 6;
        doc.text('Kepala Unit/Departemen,', ttdX, y, { align: 'center' });
        y += 24; // ruang tanda tangan
        doc.setFont('times', 'bold');
        doc.text(namaTtd, ttdX, y, { align: 'center' });
        y += 6;
        doc.setFont('times', 'normal');
        doc.text('NIP. ' + nip, ttdX, y, { align: 'center' });
        y += 14;

        // TEMBUSAN
        left('Tembusan Yth:', y, 11); y += 5;
        left('1. Kepala Subdirektorat Koordinasi Perkuliahan Bersama', y, 11); y += 5;
        left('2. Kepala Biro Sarana dan Prasarana', y, 11);

        // SAVE
        const filename = 'Surat_Peminjaman_' + namaRuangan.replace(/\s+/g, '_') + '_' + tanggal.replace(/\s+/g, '-') + '.pdf';
        doc.save(filename);
        closeSuratModal();
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
