@extends('template-full')

@section('content')
<style>
    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        background: #fafbfc;
        border: 1px solid #e8ecf1;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #334155;
        transition: all 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: #0052a8;
        background: white;
        box-shadow: 0 0 0 3px rgba(0, 82, 168, 0.05);
    }

    .input-wrapper {
        position: relative;
        margin-bottom: 1.25rem;
    }

    .input-wrapper label {
        display: block;
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }

    textarea.form-input {
        resize: vertical;
        font-family: inherit;
    }

    .file-input-wrapper {
        border: 2px dashed #e8ecf1;
        border-radius: 10px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .file-input-wrapper:hover {
        border-color: #0052a8;
        background: #f0f6ff;
    }
</style>

<div class="flex flex-col h-full">
    <!-- Header Section with Back Button -->
    <div class="sticky top-0 z-10 bg-white shadow-sm flex items-center mb-6 px-6 pt-6 pb-4">
        <a href="{{ route('admin.ruangan.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>

        <div class="flex flex-col justify-center text-center m-auto">
            <h1 class="text-md font-bold text-[#003D82]">Edit Ruangan</h1>
        </div>

        <div class="w-6 h-6"></div>
    </div>

    <!-- Content Area (Scrollable) -->
    <div class="flex-1 overflow-y-auto px-6 pb-6 bg-white scrollbar-hide">
        <form id="edit-form" action="{{ route('admin.ruangan.update', $ruangan->ruanganid) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Nama Ruangan -->
            <div class="input-wrapper">
                <label>Nama Ruangan</label>
                <input type="text" name="nama_ruangan" required value="{{ $ruangan->nama_ruangan }}" class="form-input" placeholder="Contoh: TW-101">
                @error('nama_ruangan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lokasi Ruangan -->
            <div class="input-wrapper">
                <label>Lokasi Ruangan</label>
                <input type="text" name="lokasi_ruangan" required value="{{ $ruangan->lokasi_ruangan }}" class="form-input" placeholder="Contoh: Tower 1, Lantai 2">
                @error('lokasi_ruangan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kapasitas -->
            <div class="input-wrapper">
                <label>Kapasitas (Orang)</label>
                <input type="number" name="kapasitas" required min="1" value="{{ $ruangan->kapasitas }}" class="form-input" placeholder="Contoh: 50">
                @error('kapasitas')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="input-wrapper">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-input" rows="4" placeholder="Deskripsi ruangan...">{{ $ruangan->deskripsi }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fasilitas -->
            <div class="input-wrapper">
                <label>Fasilitas</label>
                <textarea name="fasilitas" class="form-input" rows="4" placeholder="Contoh: AC, Proyektor, Speaker, Mic">{{ $ruangan->fasilitas }}</textarea>
                @error('fasilitas')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto -->
            <div class="mb-6">
                <label style="display: block; font-size: 0.875rem; color: #64748b; margin-bottom: 0.5rem; font-weight: 500;">Foto Ruangan</label>

                <!-- Tampilkan Foto yang Sudah Ada - Clickable untuk Update -->
                @php
                    $existingPhotos = \App\Helpers\SupabaseHelper::parseFotoUrls($ruangan->foto);
                @endphp

                @if(!empty($existingPhotos) && $existingPhotos[0] != '')
                    <div class="grid grid-cols-3 gap-4">
                        @foreach($existingPhotos as $index => $photoUrl)
                            @if($photoUrl)
                                <div class="relative group cursor-pointer">
                                    <!-- Hidden File Input -->
                                    <input type="file" name="foto_{{ $index + 1 }}" accept="image/*" class="hidden file-input-update" data-index="{{ $index }}">

                                    <!-- Photo Container -->
                                    <div class="relative overflow-hidden rounded-lg bg-gray-100 file-photo-container" data-index="{{ $index }}" style="aspect-ratio: 1;">
                                        <img src="{{ $photoUrl }}" alt="Foto {{ $index + 1 }}" class="w-full h-full object-cover file-photo-image" data-index="{{ $index }}">

                                        <!-- Overlay on Hover -->
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-200 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Label -->
                                    <p class="text-xs text-gray-500 mt-2 text-center">Foto {{ $index + 1 }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <p class="text-xs text-gray-500 mt-3">Klik foto untuk menggantinya</p>
                @else
                    <p class="text-sm text-gray-500 py-4">Belum ada foto</p>
                @endif

                @error('foto_1')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                @error('foto_2')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                @error('foto_3')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2 mt-8">
                <x-button
                    type="submit"
                    form="delete-form"
                    variant="danger"
                    size="md"
                    :full="true"
                    onclick="return confirm('Apakah Anda yakin ingin menghapus ruangan ini?');">
                    Hapus
                </x-button>

                <x-button
                    type="submit"
                    form="edit-form"
                    variant="solid"
                    size="md"
                    :full="true">
                    Edit
                </x-button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Form - Outside main content area -->
<form id="delete-form" action="{{ route('admin.ruangan.destroy', $ruangan->ruanganid) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<style>
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;     /* Firefox */
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;             /* Chrome, Safari, Opera */
    }
</style>

<!-- JavaScript untuk file upload dan preview -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup untuk setiap file input (update existing photos)
        const photoContainers = document.querySelectorAll('.file-photo-container');

        photoContainers.forEach(container => {
            const index = container.dataset.index;
            const fileInput = document.querySelector(`.file-input-update[data-index="${index}"]`);
            const photoImage = document.querySelector(`.file-photo-image[data-index="${index}"]`);

            if (!fileInput || !container) return;

            // Click handler untuk buka file dialog
            container.addEventListener('click', (e) => {
                e.preventDefault();
                fileInput.click();
            });

            // Change handler untuk update preview
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        photoImage.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    });
</script>

@endsection
