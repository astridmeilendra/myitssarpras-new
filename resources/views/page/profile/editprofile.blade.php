@extends('template-full')

@section('content')
<div class="flex flex-col h-full bg-gray-50">
    {{-- Header --}}
    <div class="bg-white px-6 pt-6 pb-4 flex items-center">
        <a href="{{ route('profile') }}" class="text-sm text-gray-500 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- Content --}}
    <div class="flex-1 px-6 pb-6">
        {{-- Avatar + Ganti Foto --}}
        <div class="flex flex-col items-center mt-2 mb-6">
            <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-400 via-blue-500 to-indigo-500 flex items-center justify-center text-white shadow-md">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                </svg>
            </div>
            <button type="button"
                    class="mt-3 text-xs px-4 py-1 rounded-full border border-blue-400 text-blue-600 bg-white">
                Ganti Foto
            </button>
        </div>

        {{-- Form Edit Akun --}}
        <form action="{{ route('account.update') }}" method="POST">
            @csrf

            {{-- Nama Lengkap --}}
            <div class="mb-4">
                <label class="block text-xs text-gray-500 mb-1">Nama Lengkap</label>
                <div class="relative">
                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama', $user->nama) }}"
                        class="w-full px-3 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nama Lengkap">
                </div>
                @error('nama')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- NRP --}}
            <div class="mb-4">
                <label class="block text-xs text-gray-500 mb-1">NRP</label>
                <div class="flex items-center bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl px-3 py-3 text-white">
                    <div class="mr-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="5" width="18" height="14" rx="2" ry="2"
                                  stroke-width="2"></rect>
                            <line x1="7" y1="9" x2="11" y2="9" stroke-width="2"></line>
                            <line x1="7" y1="13" x2="13" y2="13" stroke-width="2"></line>
                        </svg>
                    </div>

                    <input
                        type="text"
                        value="{{ $nrp }}"
                        readonly
                        class="flex-1 bg-transparent text-sm outline-none border-0 focus:ring-0">

                    <i class="fa-solid fa-lock ml-2 text-white text-sm"></i>
                </div>
            </div>

            {{-- Email ITS --}}
            <div class="mb-4">
                <label class="block text-xs text-gray-500 mb-1">Email ITS</label>
                <div class="flex items-center bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl px-3 py-3 text-white">
                    <div class="mr-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="5" width="18" height="14" rx="2" ry="2"
                                  stroke-width="2"></rect>
                            <polyline points="3,7 12,13 21,7" stroke-width="2"></polyline>
                        </svg>
                    </div>

                    <input
                        type="text"
                        value="{{ $user->email_its }}"
                        readonly
                        class="flex-1 bg-transparent text-sm outline-none border-0 focus:ring-0">

                    <i class="fa-solid fa-lock ml-2 text-white text-sm"></i>
                </div>
            </div>

            {{-- Nomor Telepon --}}
            <div class="mb-6">
                <label class="block text-xs text-gray-500 mb-1">Nomor Telepon</label>
                <div class="flex items-center bg-gradient-to-r from-purple-500 to-blue-500 rounded-2xl px-3 py-3 text-white">
                    <i class="fa-solid fa-phone mr-2 text-white text-sm"></i>

                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $user->no_telepon) }}"
                        class="flex-1 bg-transparent text-sm outline-none border-0 focus:ring-0"
                        placeholder="Nomor Telepon">
                </div>
                @error('phone')
                    <p class="text-xs text-red-200 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Simpan Perubahan --}}
            <button type="submit"
                    class="w-full py-3 rounded-2xl bg-blue-900 text-white text-sm font-semibold mb-3">
                Simpan Perubahan
            </button>
        </form>

        {{-- Hapus Akun --}}
        <form action="{{ route('account.destroy') }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')">
            @csrf
            <button type="submit"
                    class="w-full py-3 rounded-2xl bg-gray-200 text-gray-400 text-sm font-semibold
                           transition-colors duration-200
                           hover:bg-red-600 hover:text-white
                           focus:bg-red-600 focus:text-white
                           active:bg-red-700">
                Hapus Akun
            </button>
        </form>
    </div>
</div>
@endsection
