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
    <!-- Header Section -->
    <div class="sticky top-0 z-10 bg-white shadow-sm flex items-center px-6 pt-6 pb-4">
        <a href="{{ route('admin.ruangan.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>

        <div class="flex flex-col justify-center text-center m-auto">
            <h1 class="text-md font-bold text-[#003D82]">Tambah Ruangan</h1>
        </div>
        <div class="w-6 h-6"></div>
    </div>

    <!-- Content Area (Scrollable) -->
    <div class="flex-1 overflow-y-auto px-6 pb-6 bg-white scrollbar-hide">
        <form action="{{ route('admin.ruangan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Nama Ruangan -->
            <div class="input-wrapper">
                <label>Nama Ruangan</label>
                <input type="text" name="nama_ruangan" required class="form-input" placeholder="Contoh: TW-101">
                @error('nama_ruangan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lokasi Ruangan -->
            <div class="input-wrapper">
                <label>Lokasi Ruangan</label>
                <input type="text" name="lokasi_ruangan" required class="form-input" placeholder="Contoh: Tower 1, Lantai 2">
                @error('lokasi_ruangan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kapasitas -->
            <div class="input-wrapper">
                <label>Kapasitas (Orang)</label>
                <input type="number" name="kapasitas" required min="1" class="form-input" placeholder="Contoh: 50">
                @error('kapasitas')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="input-wrapper">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-input" rows="4" placeholder="Deskripsi ruangan..."></textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fasilitas -->
            <div class="input-wrapper">
                <label>Fasilitas</label>
                <textarea name="fasilitas" class="form-input" rows="4" placeholder="Contoh: AC, Proyektor, Speaker, Mic"></textarea>
                @error('fasilitas')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto Upload - 3 Files -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">Foto Ruangan (Upload 3 Foto)</label>

                <!-- Foto 1 -->
                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-2">Foto 1</label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-[#0B4EA2] transition-colors cursor-pointer file-input-wrapper" data-index="0">
                        <input type="file" name="foto_1" accept="image/*" class="hidden file-input" data-index="0">
                        <div class="text-center file-input-label" data-index="0">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">Klik atau drag foto di sini</p>
                        </div>
                        <img class="hidden w-full h-32 object-cover rounded file-preview" data-index="0">
                    </div>
                </div>

                <!-- Foto 2 -->
                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-2">Foto 2</label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-[#0B4EA2] transition-colors cursor-pointer file-input-wrapper" data-index="1">
                        <input type="file" name="foto_2" accept="image/*" class="hidden file-input" data-index="1">
                        <div class="text-center file-input-label" data-index="1">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">Klik atau drag foto di sini</p>
                        </div>
                        <img class="hidden w-full h-32 object-cover rounded file-preview" data-index="1">
                    </div>
                </div>

                <!-- Foto 3 -->
                <div class="mb-3">
                    <label class="block text-sm text-gray-600 mb-2">Foto 3</label>
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-[#0B4EA2] transition-colors cursor-pointer file-input-wrapper" data-index="2">
                        <input type="file" name="foto_3" accept="image/*" class="hidden file-input" data-index="2">
                        <div class="text-center file-input-label" data-index="2">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <p class="text-sm text-gray-500 mt-2">Klik atau drag foto di sini</p>
                        </div>
                        <img class="hidden w-full h-32 object-cover rounded file-preview" data-index="2">
                    </div>
                </div>

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
                <a href="{{ route('admin.ruangan.index') }}" class="flex-1">
                    <x-button variant="solid" size="md" :full="true" class="flex flex-row py-2 items-center justify-center gap-2 bg-gray-600 text-white hover:bg-gray-700">
                        <div class="flex flex-row gap-2 items-center justify-center">
                            Batal
                        </div>
                    </x-button>
                </a>
                <div class="flex-1">
                    <x-button type="submit" variant="solid" size="md" :full="true" class="flex flex-row py-2 items-center justify-center gap-2">
                        <div class="flex flex-row gap-2 items-center justify-center">
                            Simpan
                        </div>
                    </x-button>
                </div>
            </div>
        </form>        <!-- JavaScript untuk file upload dan preview -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Setup untuk setiap file input
                for (let i = 0; i < 3; i++) {
                    const wrapper = document.querySelector(`.file-input-wrapper[data-index="${i}"]`);
                    const input = document.querySelector(`.file-input[data-index="${i}"]`);
                    const label = document.querySelector(`.file-input-label[data-index="${i}"]`);
                    const preview = document.querySelector(`.file-preview[data-index="${i}"]`);

                    // Click handler
                    wrapper.addEventListener('click', () => input.click());

                    // Change handler
                    input.addEventListener('change', function() {
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                label.style.display = 'none';
                                preview.src = e.target.result;
                                preview.style.display = 'block';
                            };
                            reader.readAsDataURL(this.files[0]);
                        }
                    });

                    // Drag and drop handlers
                    wrapper.addEventListener('dragover', (e) => {
                        e.preventDefault();
                        wrapper.classList.add('border-blue-400', 'bg-blue-50');
                    });

                    wrapper.addEventListener('dragleave', () => {
                        wrapper.classList.remove('border-blue-400', 'bg-blue-50');
                    });

                    wrapper.addEventListener('drop', (e) => {
                        e.preventDefault();
                        wrapper.classList.remove('border-blue-400', 'bg-blue-50');
                        const files = e.dataTransfer.files;
                        if (files && files[0]) {
                            input.files = files;
                            const event = new Event('change', { bubbles: true });
                            input.dispatchEvent(event);
                        }
                    });
                }
            });
        </script>
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
