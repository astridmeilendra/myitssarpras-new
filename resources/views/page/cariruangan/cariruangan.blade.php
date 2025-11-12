@php
    $statusbarTheme = 'dark';
@endphp
@extends('template-full')

@section('content')
<div class="flex flex-col h-full relative">
    <!-- Header -->
    <div class="bg-white px-6 pt-5">
        <!-- Judul -->
        <h1 class="text-xl font-extrabold text-[#013880] mb-4 text-center tracking-wide">
            Cari Ruangan
        </h1>

        <!-- Search Bar -->
        <div class="relative flex items-center w-full max-w-2xl mx-auto">
            <!-- Input -->
            <input
                type="text"
                placeholder="Masukkan nama ruangan..."
                class="w-full pl-4 pr-24 py-3 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#013880] focus:border-transparent transition-all"
                id="searchInput"
            >

            <!-- Icon Search (Right Side) -->
            <button class="absolute right-14 p-2 rounded-lg hover:bg-gray-100 transition-colors" title="Search">
                <svg class="w-5 h-5 text-[#013880]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                    </path>
                </svg>
            </button>

            <!-- Filter Button -->
            <button id="filterButton" class="absolute right-3 p-2 rounded-lg hover:bg-gray-100 transition-colors" title="Filter">
                <svg class="w-5 h-5 text-[#013880]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Active Filters (Chip Container) -->
        <div id="activeFilters"
            class="flex flex-wrap justify-center gap-2 mt-4 max-w-3xl mx-auto">
            <!-- Chip akan muncul di sini via JS -->
        </div>
    </div>


    <!-- Filter Panel (Slide from Top) -->
    <div id="filterPanel" class="absolute top-0 left-0 right-0 bg-white shadow-lg z-50 transform -translate-y-full transition-transform duration-300 ease-out overflow-hidden">
        <div class="flex flex-col max-h-screen">
            <!-- Filter Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white">
                <button id="closeFilter" class="p-1 hover:bg-gray-100 rounded-full transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <h2 class="text-base font-bold text-gray-900">Filter</h2>
                <div class="w-6"></div> <!-- Spacer for centering -->
            </div>

            <!-- Filter Content (Scrollable) -->
            <div class="flex-1 overflow-y-auto px-6 py-5">
                <div class="space-y-5">
                    <!-- Tanggal -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-800 mb-2">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Tanggal
                        </label>
                        <input
                            type="date"
                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            id="filterDate"
                        >
                    </div>

                    <!-- Waktu -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-800 mb-2">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Waktu
                        </label>
                        <select
                            id="filterTime"
                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        >
                            <option value="">Pilih waktu</option>
                            <option value="07.00 - 10.00">Sesi 1 (07.00 - 10.00)</option>
                            <option value="10.15 - 12.45">Sesi 2 (10.15 - 12.45)</option>
                            <option value="13.30 - 16.00">Sesi 3 (13.30 - 16.00)</option>
                            <option value="16.00 - 18.30">Sesi 4 (16.00 - 18.30)</option>
                        </select>
                    </div>


                    <!-- Kapasitas -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-800 mb-2">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Kapasitas
                        </label>
                        <input
                            type="text"
                            placeholder="150 Orang"
                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            id="filterCapacity"
                        >
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-800 mb-2">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Harga
                        </label>
                        <input
                            type="text"
                            placeholder="Rp150.000"
                            class="w-full px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            id="filterPrice"
                        >
                    </div>

                    <!-- Fasilitas -->
                    <div>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-800 mb-3">
                            <!-- icon -->
                            Fasilitas
                        </label>
                        <div class="space-y-2.5">
                            <!-- Baris 1 -->
                            <div class="grid grid-cols-3 gap-3">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="facility[]" value="ac" class="w-4 h-4 text-blue-600 focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <span class="text-xs text-gray-700 group-hover:text-gray-900">AC</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="facility[]" value="speaker" class="w-4 h-4 text-blue-600 focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <span class="text-xs text-gray-700 group-hover:text-gray-900">Speaker</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="facility[]" value="remote" class="w-4 h-4 text-blue-600 focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <span class="text-xs text-gray-700 group-hover:text-gray-900">Remote</span>
                                </label>
                            </div>

                            <!-- Baris 2 -->
                            <div class="grid grid-cols-3 gap-3">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="facility[]" value="layar" class="w-4 h-4 text-blue-600 focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <span class="text-xs text-gray-700 group-hover:text-gray-900">Layar</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="facility[]" value="mic" class="w-4 h-4 text-blue-600 focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <span class="text-xs text-gray-700 group-hover:text-gray-900">Mic</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="facility[]" value="smart-tv" class="w-4 h-4 text-blue-600 focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                    <span class="text-xs text-gray-700 group-hover:text-gray-900">Smart TV</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Footer (Sticky Button) -->
            <div class="px-6 py-4 border-t border-gray-200 bg-white">
                <x-button id="applyFilter" variant="solid" size="md" :full="true">
                    Terapkan Filter
                </x-button>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="flex flex-col px-6 overflow-y-auto scrollbar-hide mb-4" style="scrollbar-width: none; -ms-overflow-style: none;">
        <h2 class="text-sm font-semibold text-gray-500 mb-4">Pencarian Cepat</h2>
        <!-- Room Cards -->
        <div class="space-y-4">
                        @php
                $rooms = [
                    [
                        'name' => 'TW-101',
                        'type' => 'Room',
                        'desc' => 'Tower I ITS adalah gedung 11 lantai di ITS Surabaya, berfungsi sebagai pusat perkuliahan dan kantor.',
                        'facilities' => 'Sound System, AC',
                        'capacity' => '150 Orang',
                        'price' => null,
                        'image' => 'img/tw-201.png',
                    ],
                    [
                        'name' => 'Teater A',
                        'type' => 'Room',
                        'desc' => 'Teater A ITS adalah auditorium utama di kampus ITS Surabaya untuk acara berskala besar.',
                        'facilities' => 'Sound System, AC',
                        'capacity' => '150 Orang',
                        'price' => 'Rp160.000',
                        'image' => 'img/tw-201.png',
                    ],
                    [
                        'name' => 'TW-505',
                        'type' => 'Room',
                        'desc' => 'Tower I ITS adalah gedung 11 lantai di ITS Surabaya, berfungsi sebagai pusat perkuliahan dan kantor.',
                        'facilities' => 'Sound System, AC',
                        'capacity' => '150 Orang',
                        'price' => 'Rp160.000',
                        'image' => 'img/tw-201.png',
                    ],
                    [
                        'name' => 'Ruang Sidang LT-3',
                        'type' => 'Room',
                        'desc' => 'Ruang rapat untuk 20-30 orang, cocok untuk FGD dan BEM meeting.',
                        'facilities' => 'AC, Smart TV',
                        'capacity' => '30 Orang',
                        'price' => 'Rp90.000',
                        'image' => 'img/tw-201.png',
                    ],
                ];
            @endphp

            <div class="space-y-4" id="roomList">
                @foreach ($rooms as $room)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="flex gap-4 p-4">
                        <!-- Image -->
                        <div class="flex-shrink-0">
                            <img
                                src="{{ $room['image'] }}"
                                alt="{{ $room['name'] }}"
                                class="w-[120px] h-full rounded-lg object-cover"
                            >
                        </div>

                        <!-- Info -->
                        <div class="flex-1 flex flex-col justify-between py-1">
                            <div>
                                <p class="text-xs font-medium text-gray-500 mb-1">{{ $room['type'] }}</p>
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $room['name'] }}</h3>
                                <p class="text-xs text-gray-600 leading-relaxed line-clamp-3">
                                    {{ $room['desc'] }}
                                </p>
                            </div>
                            <!-- Facilities -->
                            <div class="flex flex-wrap gap-2 mt-3 text-xs text-gray-700">
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                                    </svg>
                                    <span>{{ $room['facilities'] }}</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span>{{ $room['capacity'] }}</span>
                                </div>
                                @if ($room['price'])
                                <div class="flex items-center gap-1">
                                    <span class="text-gray-700">{{ $room['price'] }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <x-navbar active="search" />

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
</style>

<script>
    const filterButton = document.getElementById('filterButton');
    const filterPanel = document.getElementById('filterPanel');
    const closeFilter = document.getElementById('closeFilter');
    const applyFilter = document.getElementById('applyFilter');
    const activeFilters = document.getElementById('activeFilters');

    function openFilterPanel() {
        filterPanel.style.transform = 'translateY(0)';
        document.body.style.overflow = 'hidden';
    }

    function closeFilterPanel() {
        filterPanel.style.transform = 'translateY(-100%)';
        document.body.style.overflow = '';
    }

    filterButton.addEventListener('click', openFilterPanel);
    closeFilter.addEventListener('click', closeFilterPanel);
    applyFilter.addEventListener('click', () => {
        const date = document.getElementById('filterDate').value;
        const time = document.getElementById('filterTime').value;
        const capacity = document.getElementById('filterCapacity').value;
        const price = document.getElementById('filterPrice').value;
        const facilities = Array.from(document.querySelectorAll('input[name="facility[]"]:checked'))
            .map(el => el.value);

        // kosongkan dulu chip sebelumnya
        activeFilters.innerHTML = '';

        // buat chip helper
        const addChip = (label, value) => {
            if (!value) return;
            const chip = document.createElement('div');
            chip.className = `
            flex items-center gap-2 bg-gray-100 border border-gray-200
            text-gray-700 text-xs px-3 py-1.5 rounded-full
            shadow-sm hover:bg-gray-200 transition
            `;
            chip.innerHTML = `<span class="font-medium">${label}</span><span>${value}</span>`;
            activeFilters.appendChild(chip);
        };

        // tambah chip sesuai yang diisi
        addChip('Tanggal', date);
        addChip('Waktu', time);
        addChip('Kapasitas', capacity);
        addChip('Harga', price);
        // fasilitas bisa banyak
        facilities.forEach(f => addChip('Fasilitas', f.replace('-', ' ').toUpperCase()));

        console.log('Filter Applied:', { date, time, capacity, price, facilities });
        closeFilterPanel();
    });
</script>

@endsection
