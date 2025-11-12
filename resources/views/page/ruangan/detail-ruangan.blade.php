@php($statusbarTheme = 'dark')
@extends('template')

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
    <div class="flex flex-col h-full overflow-y-auto    " style="scrollbar-width: none; -ms-overflow-style: none;">
        <!-- Header with Back Button -->
        <div class="flex items-center mb-6">
            <a class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>

            <div class="flex flex-col justify-center text-center m-auto">
                <h1 class="text-md font-bold text-[#003D82]">TW-101</h1>
                <p class="text-gray-400 text-xs italic">Room</p>
            </div>
            <div class="w-6 h-6"></div>
        </div>

        <!-- Image Gallery -->
        <div class="mb-6">
            <div class="relative rounded-2xl overflow-hidden mb-3">
                <img src="{{ asset('img/room/tw-01.png') }}" alt="TW-101 Room" class="w-full h-48 object-cover">
            </div>

            <!-- Thumbnail Gallery -->
            <div class="flex gap-2">
                <div class="w-20 h-16 rounded-lg overflow-hidden border-2 border-[#003D82]">
                    <img src="{{ asset('img/room/tw-01.png') }}" alt="Thumbnail 1" class="w-full h-full object-cover">
                </div>
                <div class="w-20 h-16 rounded-lg overflow-hidden border border-gray-200">
                    <img src="{{ asset('img/room/tw-01.png') }}" alt="Thumbnail 2" class="w-full h-full object-cover">
                </div>
                <div class="w-20 h-16 rounded-lg overflow-hidden border border-gray-200">
                    <img src="{{ asset('img/room/tw-01.png') }}" alt="Thumbnail 3" class="w-full h-full object-cover">
                </div>
                <div class="w-20 h-16 rounded-lg overflow-hidden bg-gray-800 flex items-center justify-center">
                    <span class="text-white font-semibold">+ 2</span>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="mb-6">
            <h2 class="text-base font-bold text-gray-800 mb-2">Deskripsi</h2>
            <p class="text-xs text-gray-600 leading-relaxed text-justify">
                Tower 1 ITS, atau MIPA Tower, menyediakan berbagai ruang kelas dengan kapasitas bervariasi (misalnya 36, 40, hingga 80 kursi) yang dapat dipinjam untuk kegiatan perkuliahan, seminar, atau acara akademik lainnya, dikelola oleh Subdirektorat Perkuliahan Bersama (SKPB) ITS.
            </p>
        </div>

        <!-- Location -->
        <div class="mb-6">
            <h2 class="text-base font-bold text-gray-800 mb-2">Lokasi</h2>
            <p class="text-xs text-gray-600 leading-relaxed">
                Jl. Teknik Mesin, Keputih, Kec. Sukolilo, Surabaya, Jawa Timur 60117
            </p>
        </div>

        <!-- Capacity -->
        <div class="flex flex-col items-left mb-6">
            <span class="font-bold text-gray-800 mb-2">Kapasitas</span>
            <span class="text-gray-600 text-xs">150 Orang</span>
        </div>

        <!-- Facilities -->
        <div class="mb-6">
            <div class="flex items-center mb-3">
                <span class="font-bold text-gray-800">Fasilitas</span>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                    <span class="text-xs text-gray-600">AC</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                    <span class="text-xs text-gray-600">Speaker</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                    <span class="text-xs text-gray-600">Layar</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                    <span class="text-xs text-gray-600">Mic</span>
                </div>
            </div>
        </div>

        <!-- Room Availability Calendar -->
        <div class="mb-6">
            <h2 class="text-base font-bold text-gray-800 mb-4">Ketersediaan Ruangan</h2>

            <!-- Calendar Header -->
            <div class="flex justify-between items-center mb-4">
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <span class="text-sm font-semibold text-gray-400">February</span>
                <button class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-7 gap-2 text-center">
                <!-- Day Headers -->
                <div class="text-xs font-semibold text-gray-500 pb-2">S</div>
                <div class="text-xs font-semibold text-gray-500 pb-2">M</div>
                <div class="text-xs font-semibold text-gray-500 pb-2">T</div>
                <div class="text-xs font-semibold text-gray-500 pb-2">W</div>
                <div class="text-xs font-semibold text-gray-500 pb-2">T</div>
                <div class="text-xs font-semibold text-gray-500 pb-2">F</div>
                <div class="text-xs font-semibold text-gray-500 pb-2">S</div>

                <!-- Previous Month Days -->
                <div class="text-xs text-gray-300 py-2">27</div>
                <div class="text-xs text-gray-300 py-2">28</div>
                <div class="text-xs text-gray-300 py-2">29</div>
                <div class="text-xs text-gray-300 py-2">30</div>
                <div class="text-xs text-gray-300 py-2">31</div>

                <!-- Current Month Days -->
                <div class="text-xs text-gray-800 py-2">1</div>
                <div class="text-xs text-gray-800 py-2">2</div>
                <div class="text-xs text-gray-800 py-2 bg-gray-200 rounded-full w-7 h-7 flex items-center justify-center mx-auto">3</div>
                <div class="text-xs text-red-500 py-2">4</div>
                <div class="text-xs text-red-500 py-2">5</div>
                <div class="text-xs text-red-500 py-2">6</div>
                <div class="text-xs text-red-500 py-2">7</div>
                <div class="text-xs text-gray-800 py-2">8</div>
                <div class="text-xs text-orange-500 py-2">9</div>
                <div class="text-xs text-gray-800 py-2">10</div>
                <div class="text-xs text-gray-800 py-2">11</div>
                <div class="text-xs text-red-500 py-2">12</div>
                <div class="text-xs text-gray-800 py-2">13</div>
                <div class="text-xs text-gray-800 py-2">14</div>
                <div class="text-xs text-gray-800 py-2">15</div>
                <div class="text-xs text-gray-800 py-2">16</div>
                <div class="text-xs text-gray-800 py-2">17</div>
                <div class="text-xs text-red-500 py-2">18</div>
                <div class="text-xs text-red-500 py-2">19</div>
                <div class="text-xs text-gray-800 py-2">20</div>
                <div class="text-xs text-gray-800 py-2">21</div>
                <div class="text-xs text-gray-800 py-2">22</div>
                <div class="text-xs text-gray-800 py-2">23</div>
                <div class="text-xs text-gray-800 py-2">24</div>
                <div class="text-xs text-gray-800 py-2">25</div>
                <div class="text-xs text-gray-800 py-2">26</div>
                <div class="text-xs text-gray-800 py-2">27</div>
                <div class="text-xs text-gray-800 py-2">28</div>
                <div class="text-xs text-gray-800 py-2">29</div>
                <div class="text-xs text-gray-800 py-2">30</div>
            </div>
        </div>

        <!-- Booking Button -->
        <div class="flex flex-col w-full pb-4">
            <x-button variant="solid" size="md" :full="true" class="mt-3" onclick="openBookingModal()">
                Ajukan Peminjaman
            </x-button>
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
                <h2 class="text-lg font-bold text-gray-800">Book</h2>
                <div class="w-6"></div>
            </div>

            <!-- Modal Content (Non-Scrollable) -->
            <div class="flex-1 px-6 pt-8 pb-10 flex flex-col justify-center">
                <!-- Room Info -->
                <div class="flex items-center mb-5">
                    <span class="text-sm text-gray-700 font-medium mr-3">Room</span>
                    <span class="text-sm text-gray-700">:</span>
                    <span class="text-sm text-gray-800 font-semibold ml-3">TW1-101</span>
                </div>

                <!-- Date Field -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                    <input type="date" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#003D82] focus:border-transparent text-sm">
                </div>

                <!-- Time Field -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Waktu</label>
                    <select class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#003D82] focus:border-transparent text-sm appearance-none bg-white" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg width=%2712%27 height=%278%27 viewBox=%270 0 12 8%27 fill=%27none%27 xmlns=%27http://www.w3.org/2000/svg%27%3e%3cpath d=%27M1 1.5L6 6.5L11 1.5%27 stroke=%27%23374151%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27/%3e%3c/svg%3e'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 12px 8px;">
                        <option value="">Pilih waktu</option>
                        <option value="sesi1">Sesi 1 (07.00 - 10.00)</option>
                        <option value="sesi2">Sesi 2 (10.15 - 12.45)</option>
                        <option value="sesi3">Sesi 3 (13.30 - 16.00)</option>
                        <option value="sesi4">Sesi 4 (16.00 - 18.30)</option>
                    </select>
                </div>

                <!-- Description Field -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                    <textarea rows="4" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#003D82] focus:border-transparent text-sm resize-none" placeholder="Masukkan keterangan..."></textarea>
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
                            Unggah File
                            <input type="file" class="hidden">
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <x-button variant="solid" size="md" :full="true">
                        Kirim
                    </x-button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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
        }, 300);
    }

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
