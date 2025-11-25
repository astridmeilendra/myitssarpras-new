@extends('template-full')

@section('content')
<div class="flex flex-col h-full">
    <!-- Header Section -->
    <div class="bg-white px-6 pt-5 pb-4 border-b border-gray-200">
        <div class="flex items-center justify-between mt-4 mb-2">
            <h1 class="text-xl font-bold text-gray-900">
                Daftar Ruangan
            </h1>
            <a href="{{ route('admin.ruangan.create') }}">
                <x-button variant="primary" size="sm" class="flex items-center gap-1 flex-col">
                    <div class="flex flex-row gap-2 items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah
                    </div>
                </x-button>
            </a>
        </div>
    </div>

    <!-- Content Area (Scrollable) -->
    <div class="flex-1 overflow-y-auto bg-gray-50 scrollbar-hide">
        <div class="p-6 space-y-4">
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

            @forelse ($ruangan as $item)
                <!-- Room Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-2">
                    <!-- Card Header -->
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                {{ $item->nama_ruangan }}
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">{{ $item->lokasi_ruangan }}</p>
                        </div>
                        <span class="px-3 py-1 w-28 text-center items-center text-xs font-semibold rounded-lg bg-blue-100 text-blue-700">
                            {{ $item->kapasitas }} Orang
                        </span>
                    </div>

                    <!-- Room Details -->
                    <div class="space-y-2 mb-4">
                        @if($item->deskripsi)
                            <div class="flex items-start gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="line-clamp-2">{{ $item->deskripsi }}</span>
                            </div>
                        @endif
                        @if($item->fasilitas)
                            <div class="flex items-start gap-2 text-xs text-gray-600">
                                <svg class="w-4 h-4 text-gray-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="line-clamp-2">{{ $item->fasilitas }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-row gap-2">
                        <a href="{{ route('admin.ruangan.edit', $item->ruanganid) }}" class="flex-1 flex flex-row">
                            <x-button variant="solid" size="sm" :full="true" class="flex flex-row py-2 items-center justify-center gap-2">
                                <div class="flex flex-row gap-2 items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    <span>Edit</span>
                                </div>
                            </x-button>
                        </a>
                        <form action="{{ route('admin.ruangan.destroy', $item->ruanganid) }}" method="POST" class="flex-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?');">
                            @csrf
                            <button type="submit" class="w-full flex flex-row">
                                <x-button variant="solid" size="sm" :full="true" class="flex flex-row py-2 items-center justify-center gap-2 bg-red-600 text-white hover:bg-red-700">
                                    <div class="flex flex-row gap-2 items-center justify-center">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus
                                    </div>
                                </x-button>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 px-5 bg-white rounded-lg shadow-sm">
                    <p class="text-gray-500">Belum ada ruangan. <a href="{{ route('admin.ruangan.create') }}" class="text-blue-600 hover:underline">Tambah ruangan sekarang</a></p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Navbar Admin -->
    <x-navbar-admin active="ruangan" />
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
