@extends('template-full')

@section('content')
<div class="flex flex-col h-full">
    <!-- Header Section with Back Button -->
    <div class="flex flex-row items-center bg-white px-6 pt-8">
            <a href="{{ route('admin.ruangan.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>

            <div class="flex flex-col justify-center text-center m-auto">
                <h1 class="text-md font-bold text-gray-900">Edit Ruangan</h1>
            </div>

            <div class="w-6 h-6"></div>
    </div>

    <!-- Content Area (Scrollable) -->
    <div class="flex flex-col flex-1 bg-gray-50">
        <div class="flex-1 overflow-y-auto p-6 pt-2 scrollbar-hide">
            <form action="{{ route('admin.ruangan.update', $ruangan->ruanganid) }}" method="POST" class="space-y-4">
                @csrf
                    <div>
                        <!-- Nama Ruangan -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Ruangan</label>
                            <input type="text" name="nama_ruangan" required value="{{ $ruangan->nama_ruangan }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B4EA2] focus:border-transparent text-sm" placeholder="Contoh: TW-101">
                            @error('nama_ruangan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lokasi Ruangan -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Ruangan</label>
                            <input type="text" name="lokasi_ruangan" required value="{{ $ruangan->lokasi_ruangan }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B4EA2] focus:border-transparent text-sm" placeholder="Contoh: Tower 1, Lantai 2">
                            @error('lokasi_ruangan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kapasitas -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kapasitas (Orang)</label>
                            <input type="number" name="kapasitas" required min="1" value="{{ $ruangan->kapasitas }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B4EA2] focus:border-transparent text-sm" placeholder="Contoh: 50">
                            @error('kapasitas')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <textarea name="deskripsi" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B4EA2] focus:border-transparent text-sm resize-none" rows="4" placeholder="Deskripsi ruangan...">{{ $ruangan->deskripsi }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fasilitas -->
                        <div class="mb-5">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fasilitas</label>
                            <textarea name="fasilitas" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B4EA2] focus:border-transparent text-sm resize-none" rows="4" placeholder="Contoh: AC, Proyektor, Speaker, Mic">{{ $ruangan->fasilitas }}</textarea>
                            @error('fasilitas')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Foto -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto (URL)</label>
                            <input type="text" name="foto" value="{{ $ruangan->foto }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0B4EA2] focus:border-transparent text-sm" placeholder="https://...">
                            @error('foto')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
            </form>
        </div>

        <!-- Sticky Action Buttons -->
        <div class="flex gap-2 bg-white px-6 py-4 items-stretch">
            <form action="{{ route('admin.ruangan.update', $ruangan->ruanganid) }}" method="POST" class="flex-1">
            @csrf
            <x-button type="submit" variant="solid" size="md" :full="true" class="w-full flex items-center justify-center">
                Simpan
            </x-button>
            </form>

            <a href="{{ route('admin.ruangan.index') }}" class="flex-1">
            <x-button variant="solid" size="md" :full="true" class="w-full bg-gray-600 text-white hover:bg-gray-700 flex items-center justify-center">
                Batal
            </x-button>
            </a>
        </div>
    </div>
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
