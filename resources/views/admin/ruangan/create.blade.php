@extends('template-full')

@section('content')
<div class="flex flex-col h-full">
    <!-- Header Section -->
    <div class="bg-white px-6 pt-5 pb-4 border-b border-gray-200">
        <div class="flex items-center justify-between mt-4 mb-2">
            <h1 class="text-xl font-bold text-gray-900">
                Tambah Ruangan
            </h1>
        </div>
        <p class="text-sm text-gray-500">Masukkan informasi ruangan baru</p>
    </div>

    <!-- Content Area (Scrollable) -->
    <div class="flex-1 overflow-y-auto p-6 bg-gray-50 scrollbar-hide">
        <form action="{{ route('admin.ruangan.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                <!-- Nama Ruangan -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Nama Ruangan</label>
                    <input type="text" name="nama_ruangan" required class="w-full text-xs rounded border border-gray-300 py-2 px-3 bg-white text-gray-700" placeholder="Contoh: TW-101">
                    @error('nama_ruangan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi Ruangan -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Lokasi Ruangan</label>
                    <input type="text" name="lokasi_ruangan" required class="w-full text-xs rounded border border-gray-300 py-2 px-3 bg-white text-gray-700" placeholder="Contoh: Tower 1, Lantai 2">
                    @error('lokasi_ruangan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kapasitas -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Kapasitas (Orang)</label>
                    <input type="number" name="kapasitas" required min="1" class="w-full text-xs rounded border border-gray-300 py-2 px-3 bg-white text-gray-700" placeholder="Contoh: 50">
                    @error('kapasitas')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full text-xs rounded border border-gray-300 py-2 px-3 bg-white text-gray-700" rows="3" placeholder="Deskripsi ruangan..."></textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fasilitas -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Fasilitas</label>
                    <textarea name="fasilitas" class="w-full text-xs rounded border border-gray-300 py-2 px-3 bg-white text-gray-700" rows="3" placeholder="Contoh: AC, Proyektor, Speaker, Mic"></textarea>
                    @error('fasilitas')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto -->
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-700 mb-2">Foto (URL)</label>
                    <input type="text" name="foto" class="w-full text-xs rounded border border-gray-300 py-2 px-3 bg-white text-gray-700" placeholder="https://...">
                    @error('foto')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2 mt-6">
                    <button type="submit" class="flex-1">
                        <x-button variant="primary" size="sm" :full="true">
                            Simpan
                        </x-button>
                    </button>
                    <a href="{{ route('admin.ruangan.index') }}" class="flex-1">
                        <x-button variant="outline" size="sm" :full="true">
                            Batal
                        </x-button>
                    </a>
                </div>
            </div>
        </form>

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
