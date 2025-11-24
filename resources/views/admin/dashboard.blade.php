@extends('template-full')

@section('content')
<div class="flex flex-col h-full">
    <!-- Header Section -->
    <div class="bg-white px-6 pt-5 pb-4 border-b border-gray-200">
        <div class="flex items-center justify-between mt-4 mb-2">
            <h1 class="text-xl font-bold text-gray-900">
                Admin Dashboard
            </h1>
        </div>
        <p class="text-sm text-gray-500">Daftar semua permintaan peminjaman ruangan.</p>
    </div>

    <!-- Content Area (Scrollable) -->
    <div class="flex-1 overflow-y-auto px-6 py-3 bg-gray-50 scrollbar-hide">
        <!-- Filter Section with Chips - Collapsible (Inside Scrollable Content) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-4">
            <div class="flex items-center justify-between">
                <p class="text-sm font-semibold text-gray-700">Filter Peminjaman</p>
                <button type="button" id="filterToggle" onclick="toggleFilter()" class="text-gray-500 hover:text-gray-700 transition">
                    <svg id="filterIcon" class="w-5 h-5 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>

            <div id="filterContent" class="overflow-hidden transition-all duration-300 ease-in-out max-h-96" style="max-height: 0;">
                <form method="GET" action="{{ route('admin.dashboard') }}" id="filterForm">
                    <!-- Status Filter Chips -->
                    <div class="py-3">
                        <p class="text-xs text-gray-600 mb-2">Status:</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['status' => ''])) }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ !request('status') ? 'bg-[#0B4EA2] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Semua
                            </a>
                            @foreach($statuses as $s)
                                <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['status' => $s])) }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ request('status') == $s ? 'bg-[#0B4EA2] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                    {{ $s }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Room Filter Chips -->
                    <div class="pb-3">
                        <p class="text-xs text-gray-600 mb-2">Ruangan:</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['ruangan' => ''])) }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ !request('ruangan') ? 'bg-[#0B4EA2] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Semua
                            </a>
                            @foreach($ruangan as $r)
                                <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['ruangan' => $r])) }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ request('ruangan') == $r ? 'bg-[#0B4EA2] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                    {{ $r }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Session Filter Chips -->
                    <div class="pb-3">
                        <p class="text-xs text-gray-600 mb-2">Sesi:</p>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['sesi' => ''])) }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ !request('sesi') ? 'bg-[#0B4EA2] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Semua
                            </a>
                            @foreach($sesi as $ses)
                                <a href="{{ route('admin.dashboard', array_merge(request()->query(), ['sesi' => $ses])) }}" class="px-3 py-1 text-xs rounded-full transition font-medium {{ request('sesi') == $ses ? 'bg-[#0B4EA2] text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                    {{ $ses }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sorting Options -->
                    <div class="flex gap-3 items-center pt-2 border-t border-gray-200 pt-3">
                        <div class="flex-1">
                            <label class="text-xs text-gray-600 mb-2 block">Urutkan:</label>
                            <select name="sort" onchange="this.form.submit()" class="w-full text-xs rounded border border-gray-300 py-2 px-2 bg-white text-gray-700">
                                <option value="tanggal" @if(request('sort') == 'tanggal' || !request('sort')) selected @endif>Tanggal</option>
                                <option value="status" @if(request('sort') == 'status') selected @endif>Status</option>
                                <option value="ruangan" @if(request('sort') == 'ruangan') selected @endif>Ruangan</option>
                                <option value="sesi" @if(request('sort') == 'sesi') selected @endif>Sesi</option>
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="text-xs text-gray-600 mb-2 block">Arah:</label>
                            <select name="dir" onchange="this.form.submit()" class="w-full text-xs rounded border border-gray-300 py-2 px-2 bg-white text-gray-700">
                                <option value="desc" @if(request('dir') == 'desc' || !request('dir')) selected @endif>Terbaru</option>
                                <option value="asc" @if(request('dir') == 'asc') selected @endif>Terlama</option>
                            </select>
                        </div>
                        <div class="pt-6">
                            <x-button :href="route('admin.dashboard')" variant="destructive" size="xs">Reset</x-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function toggleFilter() {
                const filterContent = document.getElementById('filterContent');
                const filterIcon = document.getElementById('filterIcon');
                const isHidden = filterContent.style.maxHeight === '0px' || filterContent.style.maxHeight === '';

                if (isHidden) {
                    // Open
                    filterContent.style.maxHeight = filterContent.scrollHeight + 'px';
                    filterIcon.classList.add('rotate-180');
                } else {
                    // Close
                    filterContent.style.maxHeight = '0px';
                    filterIcon.classList.remove('rotate-180');
                }
            }

            // Show filter by default if there are active filters
            @if(request('status') || request('ruangan') || request('sesi'))
                const filterContent = document.getElementById('filterContent');
                const filterIcon = document.getElementById('filterIcon');
                filterContent.style.maxHeight = filterContent.scrollHeight + 'px';
                filterIcon.classList.add('rotate-180');
            @endif
        </script>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @forelse ($peminjaman as $item)
            @php
                // Mapping warna badge status
                $status = $item->nama_status;
                $badgeClass = 'bg-gray-100 text-gray-700';
                if ($status === 'Menunggu') {
                    $badgeClass = 'bg-yellow-100 text-yellow-700';
                } elseif ($status === 'Disetujui') {
                    $badgeClass = 'bg-green-100 text-green-700';
                } elseif ($status === 'Ditolak') {
                    $badgeClass = 'bg-red-100 text-red-700';
                } elseif ($status === 'Selesai') {
                    $badgeClass = 'bg-blue-100 text-blue-700';
                } elseif ($status === 'Revisi') {
                    $badgeClass = 'bg-purple-100 text-purple-700';
                }
            @endphp

            <!-- Booking Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-4">
                <!-- Card Header -->
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Peminjam: {{ $item->nama_peminjam }}</p>
                        <h3 class="text-lg font-bold text-gray-900">
                            {{ $item->nama_ruangan }}
                        </h3>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $badgeClass }}">
                        {{ $status }}
                    </span>
                </div>

                <!-- Booking Details -->
                <div class="space-y-2 mb-4">
                    <div class="flex items-center gap-2 text-xs text-gray-600">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-600">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ $item->nama_shift }}</span>
                    </div>
                    @if($item->keterangan_peminjaman)
                        <div class="flex items-start gap-2 text-xs text-gray-600">
                            <svg class="w-4 h-4 text-gray-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16h6M5 6h14M5 6a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2M5 6l2-2h10l2 2"></path></svg>
                            <span class="line-clamp-2">{{ $item->keterangan_peminjaman }}</span>
                        </div>
                    @endif
                </div>

                <!-- Status Update Form -->
                <form action="{{ route('admin.peminjaman.updateStatus', $item->peminjamanid) }}" method="POST">
                    @csrf
                    <div class="rounded-lg">
                        <p class="text-sm font-medium text-gray-700 mb-3">Ubah Status</p>
                        <div class="space-y-3">
                            <div>
                                <label for="status-{{$item->peminjamanid}}" class="block text-xs text-gray-600 mb-1">Status</label>
                                <select name="status" id="status-{{$item->peminjamanid}}" class="w-full px-4 py-2.5 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B4EA2] focus:border-transparent text-sm bg-white appearance-none bg-no-repeat bg-right" style="background-image: url('data:image/svg+xml;charset=UTF-8,%3csvg width=%2712%27 height=%278%27 viewBox=%270 0 12 8%27 fill=%27none%27 xmlns=%27http://www.w3.org/2000/svg%27%3e%3cpath d=%27M1 1.5L6 6.5L11 1.5%27 stroke=%27%23374151%27 stroke-width=%272%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27/%3e%3c/svg%3e'); background-position: right 0.75rem center; background-size: 12px 8px;">
                                    <option value="Disetujui" @if($item->nama_status == 'Disetujui') selected @endif>Disetujui</option>
                                    <option value="Ditolak" @if($item->nama_status == 'Ditolak') selected @endif>Ditolak</option>
                                    <option value="Revisi" @if($item->nama_status == 'Revisi') selected @endif>Revisi</option>
                                    <option value="Menunggu" @if($item->nama_status == 'Menunggu') selected @endif>Menunggu</option>
                                </select>
                            </div>
                            <div>
                                <label for="keterangan-{{$item->peminjamanid}}" class="block text-xs text-gray-600 mb-1">Keterangan (opsional)</label>
                                <input type="text" name="keterangan" id="keterangan-{{$item->peminjamanid}}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B4EA2] focus:border-transparent text-sm" placeholder="Masukkan keterangan...">
                            </div>
                        </div>
                        <x-button type="submit" variant="solid" size="sm" :full="true" class="mt-4">
                            Update Status
                        </x-button>
                    </div>
                </form>
            </div>
        @empty
            <div class="text-center py-10 px-5 bg-white rounded-lg shadow-sm">
                <p class="text-gray-500">Tidak ada data peminjaman untuk ditampilkan.</p>
            </div>
        @endforelse
    </div>

    <!-- Navbar Admin -->
    <x-navbar-admin active="dashboard" />
</div>

<style>
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;     /* Firefox */
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;             /* Chrome, Safari, Opera */
    }
</style>
@endsection
