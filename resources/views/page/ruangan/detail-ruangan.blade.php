@extends('template-full')

@section('content')
<div class="relative h-full">
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Modal Overlay */
        .modal-overlay {
            transition: opacity 0.3s ease;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .modal-overlay.hidden {
            opacity: 0;
            pointer-events: none;
        }

        /* Modal Slide Up Animation */
        .modal-content {
            transition: transform 0.3s ease;
            transform: translateY(0);
        }

        .modal-overlay.hidden .modal-content {
            transform: translateY(100%);
        }
    </style>

    <!-- Main Scrollable Content -->
    <div class="flex flex-col h-full overflow-y-auto" style="scrollbar-width: none; -ms-overflow-style: none;">
        <!-- Header with Back Button - Sticky -->
        <div class="sticky top-0 z-10 bg-white shadow-sm flex items-center mb-6 px-6 pt-6 pb-4">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>

            <div class="flex flex-col justify-center text-center m-auto">
                <h1 class="text-md font-bold text-[#003D82]">{{ $ruangan->nama_ruangan ?? 'TW-101' }}</h1>
            </div>
            <div class="w-6 h-6"></div>
        </div>

        <div class="flex flex-col px-6 py-1">
            <!-- Image Gallery -->
            <div class="mb-6">
                @php
                    // Ambil foto dari database (string dipisah koma)
                    $images = [];

                    if ($ruangan->foto) {
                        $images = array_filter(array_map('trim', explode(',', $ruangan->foto)));
                    }

                    // Default fallback jika tidak ada data
                    if (empty($images)) {
                        $images = [asset('img/room/tw-01.png')];
                    }

                    // Batasi max 4 gambar
                    $images = array_slice($images, 0, 4);

                    // Gambar besar awal
                    $mainImage = $images[0];
                @endphp

                {{-- MAIN IMAGE --}}
                <div class="relative rounded-2xl overflow-hidden mb-3">
                    <img id="main-room-image"
                        src="{{ $mainImage }}"
                        alt="{{ $ruangan->nama_ruangan }}"
                        class="w-full h-48 object-cover">
                </div>

                {{-- THUMBNAILS --}}
                <div class="flex gap-2 w-full">
                    @foreach($images as $index => $img)
                        <button
                            type="button"
                            class="thumbnail-item w-full h-16 rounded-lg overflow-hidden border
                                {{ $index === 0 ? 'border-2 border-[#003D82]' : 'border-gray-200' }}"
                            data-large-src="{{ $img }}">

                            <img src="{{ $img }}"
                                alt="Thumbnail {{ $index + 1 }}"
                                class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h2 class="text-base font-bold text-gray-800 mb-2">Deskripsi</h2>
                <p class="text-xs text-gray-600 leading-relaxed text-justify">
                    {{ $ruangan->deskripsi ?? 'Tower 1 ITS, atau MIPA Tower, menyediakan berbagai ruang kelas dengan kapasitas bervariasi yang dapat dipinjam untuk kegiatan perkuliahan, seminar, atau acara akademik lainnya.' }}
                </p>
            </div>

            <!-- Location -->
            <div class="mb-6">
                <h2 class="text-base font-bold text-gray-800 mb-2">Lokasi</h2>
                <p class="text-xs text-gray-600 leading-relaxed">
                    {{ $ruangan->lokasi_ruangan ?? 'Jl. Teknik Mesin, Keputih, Kec. Sukolilo, Surabaya, Jawa Timur 60117' }}
                </p>
            </div>

            <!-- Capacity -->
            <div class="flex flex-col items-left mb-6">
                <span class="font-bold text-gray-800 mb-2">Kapasitas</span>
                <span class="text-gray-600 text-xs">{{ $ruangan->kapasitas ?? 150 }} Orang</span>
            </div>

            <!-- Facilities -->
            <div class="mb-6">
                <div class="flex items-center mb-3">
                    <span class="font-bold text-gray-800">Fasilitas</span>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    @foreach($ruangan->fasilitas ? explode(',', $ruangan->fasilitas) : ['AC', 'Speaker', 'Layar', 'Mic'] as $item)
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                            <span class="text-xs text-gray-600">{{ trim($item) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Room Availability Calendar -->
            <div class="mb-6">
                <h2 class="text-base font-bold text-gray-800 mb-4">Ketersediaan Ruangan</h2>

                <!-- Calendar Header with Navigation -->
                <div class="flex justify-between items-center mb-4">
                    <button id="prevMonth" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <span id="calendarMonth" class="text-sm font-semibold text-gray-800">{{ now()->format('F Y') }}</span>
                    <button id="nextMonth" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>

                <!-- Scrollable Calendar Container -->
                <div id="calendarContainer" class="overflow-x-auto pb-2" style="scrollbar-width: thin;">
                    <div id="calendarGrid" class="inline-block min-w-full">
                        <!-- Calendar will be rendered here by JavaScript -->
                    </div>
                </div>

                <!-- Legend -->
                <div class="flex justify-center gap-4 mt-4 text-xs text-gray-600">
                    <div class="flex items-center gap-1">
                        <div class="w-3 h-3 rounded-full bg-gray-200"></div>
                        <span>Hari ini</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span>Penuh</span>
                    </div>
                </div>
            </div>

            <!-- Booking Button -->
            <div class="flex flex-col w-full pb-4">
                <x-button variant="solid" size="md" :full="true" class="mt-3" onclick="openBookingModal()">
                    Ajukan Peminjaman
                </x-button>
            </div>
        </div>

    </div>

    <!-- Booking Modal (Fixed Position Inside Frame) -->
    <div id="bookingModal" class="modal-overlay hidden bg-black bg-opacity-50 z-50 flex items-end -m-6">
        <div class="modal-content bg-white w-full shadow-2xl overflow-hidden rounded-t-3xl flex flex-col" style="max-height: 85%;">
            <!-- Modal Header -->
            <div class="flex items-center justify-between px-6 py-6 border-b border-gray-200">
                <button onclick="closeBookingModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <h2 class="text-lg font-bold text-gray-800">Peminjaman</h2>
                <div class="w-6"></div>
            </div>

            <!-- Modal Content -->
            <form id="bookingForm" class="flex-1 px-6 pt-8 pb-10 flex flex-col justify-center" enctype="multipart/form-data">
                @csrf

                <!-- Room Info -->
                <div class="flex items-center mb-5">
                    <span class="text-sm text-gray-700 font-medium mr-3">Room</span>
                    <span class="text-sm text-gray-700">:</span>
                    <span class="text-sm text-gray-800 font-semibold ml-3">{{ $ruangan->nama_ruangan }}</span>

                    <input type="hidden" name="ruangan_id" value="{{ $ruangan->ruanganid }}">
                    <input type="hidden" name="nama_ruangan" value="{{ $ruangan->nama_ruangan }}">
                </div>

                <!-- Date Field -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date"
                        name="tanggal"
                        id="tanggal"
                        min="{{ now()->addDay()->format('Y-m-d') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#003D82] focus:border-transparent text-sm"
                        required>
                    <span class="text-xs text-red-500 hidden" id="error-tanggal"></span>
                </div>

                <!-- Time Field -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                    <select name="waktu"
                            id="waktu"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#003D82] focus:border-transparent text-sm appearance-none bg-white"
                            style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg width=%2712%27 height=%278%27 viewBox=%270 0 12 8%27 fill=%27none%27 xmlns=%27http://www.w3.org/2000/svg%27%3e%3cpath d=%27M1 1.5L6 6.5L11 1.5%27 stroke=%27%23374151%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 12px 8px;"
                            required>
                        <option value="">Pilih waktu</option>
                        <option value="sesi1" data-label="Sesi 1 (07.00 - 10.00)">Sesi 1 (07.00 - 10.00)</option>
                        <option value="sesi2" data-label="Sesi 2 (10.15 - 12.45)">Sesi 2 (10.15 - 12.45)</option>
                        <option value="sesi3" data-label="Sesi 3 (13.30 - 16.00)">Sesi 3 (13.30 - 16.00)</option>
                        <option value="sesi4" data-label="Sesi 4 (16.00 - 18.30)">Sesi 4 (16.00 - 18.30)</option>
                    </select>
                    <span class="text-xs text-red-500 hidden" id="error-waktu"></span>
                </div>

                <!-- Description Field -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <textarea name="keterangan"
                            id="keterangan"
                            rows="4"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#003D82] focus:border-transparent text-sm resize-none"
                            placeholder="Masukkan keterangan..."
                            required></textarea>
                    <span class="text-xs text-red-500 hidden" id="error-keterangan"></span>
                </div>

                <!-- File Upload -->
                <div class="mb-6">
                    <div class="flex items-center">
                        <span class="text-sm font-medium text-gray-700 mr-3">File</span>
                        <span class="text-sm text-gray-700">:</span>
                        <label class="ml-3 flex items-center cursor-pointer text-sm text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span id="file-label">Unggah File</span>
                            <input type="file"
                                name="dokumen"
                                id="dokumen"
                                class="hidden"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                onchange="updateFileName(this)">
                        </label>
                    </div>
                    <span class="text-xs text-gray-500 ml-16 mt-1 block">Format: PDF, DOC, DOCX, JPG, PNG (Max: 5MB)</span>
                    <span class="text-xs text-red-500 hidden" id="error-dokumen"></span>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <x-button type="submit" id="submitBtn" variant="solid" size="md" :full="true" class="mt-3">
                        Kirim
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Calendar Navigation & Rendering
    let currentDate = new Date();
    const bookedDates = @json($jadwalTerpakai);

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        const monthDisplay = new Date(year, month).toLocaleString('en-US', { month: 'long', year: 'numeric' });
        document.getElementById('calendarMonth').textContent = monthDisplay;

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();

        let html = '<div class="grid grid-cols-7 gap-2 text-center p-2">';

        // Day headers
        const dayHeaders = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
        dayHeaders.forEach(day => {
            html += `<div class="text-xs font-semibold text-gray-500 pb-2">${day}</div>`;
        });

        // Empty cells for days before month starts
        for (let i = 0; i < firstDay; i++) {
            html += '<div class="text-xs text-gray-300 py-2"></div>';
        }

        // Days of month
        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const isToday = date.toDateString() === today.toDateString();
            const isPast = date < today && !isToday;
            const isBooked = bookedDates.includes(dateStr);

            let classes = 'text-xs py-2 rounded-lg transition-colors';
            let bgColor = 'bg-white text-gray-800';

            if (isToday) {
                bgColor = 'bg-gray-200 text-gray-800 font-semibold';
            } else if (isBooked) {
                bgColor = 'bg-red-100 text-red-600 font-semibold';
            } else if (isPast) {
                bgColor = 'text-gray-300';
            }

            html += `<div class="${classes} ${bgColor} w-8 h-8 flex items-center justify-center mx-auto">${day}</div>`;
        }

        html += '</div>';
        document.getElementById('calendarGrid').innerHTML = html;
    }

    document.getElementById('prevMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    // Render initial calendar
    renderCalendar();

    // Thumbnail → ganti gambar utama
    document.addEventListener('DOMContentLoaded', function () {
        const mainImage = document.getElementById('main-room-image');
        const thumbnails = document.querySelectorAll('.thumbnail-item');

        thumbnails.forEach((thumb) => {
            thumb.addEventListener('click', function () {
                const newSrc = this.getAttribute('data-large-src');

                // Ganti gambar utama
                mainImage.src = newSrc;

                // Reset border semua thumbnail
                thumbnails.forEach(t => {
                    t.classList.remove('border-2', 'border-[#003D82]');
                    t.classList.add('border-gray-200');
                });

                // Set border thumbnail aktif
                this.classList.remove('border-gray-200');
                this.classList.add('border-2', 'border-[#003D82]');
            });
        });
    });

    function openBookingModal() {
        const modal = document.getElementById('bookingModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.style.opacity = '1';
        }, 10);
    }

    function closeBookingModal() {
        const modal = document.getElementById('bookingModal');
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.classList.add('hidden');
            document.getElementById('bookingForm').reset();
            clearErrors();
        }, 300);
    }

    function updateFileName(input) {
        const label = document.getElementById('file-label');
        if (input.files && input.files[0]) {
            label.textContent = input.files[0].name;
        } else {
            label.textContent = 'Unggah File';
        }
    }

    function clearErrors() {
        const errorElements = document.querySelectorAll('[id^="error-"]');
        errorElements.forEach(el => {
            el.textContent = '';
            el.classList.add('hidden');
        });
    }

    function showError(field, message) {
        const errorElement = document.getElementById(`error-${field}`);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.remove('hidden');
        }
    }

    // Handle form submission
    document.getElementById('bookingForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        clearErrors();

        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';

        const formData = new FormData(this);

        try {
            const response = await fetch('{{ route("peminjaman.store") }}', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
            });

            const result = await response.json();

            if (result.success) {
                window.location.href = '/success';
            } else {
                if (result.errors) {
                    console.log('VALIDATION ERRORS:', result.errors);
                    Object.keys(result.errors).forEach(field => {
                        showError(field, result.errors[field][0]);
                    });
                } else {
                    alert(result.message || 'Terjadi kesalahan');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengirim data');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });

    // Check availability on date change → disable option penuh
    let checkTimeout;
    document.getElementById('tanggal').addEventListener('change', function () {
        clearTimeout(checkTimeout);
        checkTimeout = setTimeout(async () => {
            const tanggal = document.getElementById('tanggal').value;
            const selectWaktu = document.getElementById('waktu');

            if (!tanggal) return;

            // Reset pilihan & error
            selectWaktu.value = '';
            document.getElementById('error-waktu').classList.add('hidden');

            try {
                const response = await fetch('{{ route("peminjaman.slots") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({
                        ruangan_id: {{ $ruangan->ruanganid }},
                        tanggal: tanggal,
                    })
                });

                const result = await response.json();

                if (!result.success) {
                    console.log('Slot check error:', result);
                    return;
                }

                const slots = result.slots || {};

                // Untuk setiap option sesi, atur disabled & label
                Array.from(selectWaktu.options).forEach(opt => {
                    const value = opt.value;

                    if (!value) return; // skip "Pilih waktu"

                    const originalLabel = opt.getAttribute('data-label') || opt.textContent;

                    if (slots[value] === false) {
                        // slot penuh
                        opt.disabled = true;
                        opt.textContent = originalLabel + ' (Telah Dipinjam)';
                        opt.classList.add('text-gray-400');
                    } else {
                        // slot tersedia
                        opt.disabled = false;
                        opt.textContent = originalLabel;
                        opt.classList.remove('text-gray-400');
                    }
                });
            } catch (error) {
                console.error('Error checking slots:', error);
            }
        }, 400);
    });


    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('bookingModal');
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeBookingModal();
            }
        });
    });
</script>

@endsection
