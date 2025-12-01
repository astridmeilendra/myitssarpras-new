@extends('template-full')

@section('content')
<div class="flex flex-col h-full bg-white">
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
    <div class="flex-1 flex flex-col">
        <div class="flex-1 px-6 pb-6 overflow-y-auto">
        {{-- Avatar + Ganti Foto --}}
        <div class="flex flex-col items-center mt-2 mb-6">
            <div id="avatarContainer" class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center overflow-hidden shadow-md">
                @if($user->foto_profile)
                    @php
                        $photoUrl = $user->foto_profile;
                        // Jika belum format URL lengkap, construct dari env
                        if (!str_starts_with($photoUrl, 'http')) {
                            $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
                            $encodedPath = str_replace(' ', '%20', $photoUrl);
                            $photoUrl = "{$supabaseUrl}/storage/v1/object/public/{$encodedPath}";
                        }
                    @endphp
                    <img id="avatarImg" src="{{ $photoUrl }}" alt="Profile Photo" class="w-full h-full object-cover" onerror="this.style.display='none';">
                @else
                    <svg id="avatarPlaceholder" class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
                    </svg>
                @endif
            </div>
            <button type="button" id="changePhotoBtn"
                    class="mt-4 px-8 py-2 text-sm rounded-lg border-2 border-blue-600 text-blue-600 bg-white hover:bg-blue-50 font-medium transition duration-200">
                Ganti Foto
            </button>
            <span id="fileName" class="text-xs text-gray-400 mt-2"></span>
        </div>

        {{-- Form Edit Akun --}}
        <form id="editAccountForm" action="{{ route('account.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- File input HARUS DALAM FORM agar ter-submit --}}
            <input type="file" id="photoInput" name="photo" accept="image/*" class="hidden">

            {{-- Nama Lengkap --}}
            <div class="mb-4">
                <label class="block text-xs text-gray-500 mb-1">Nama Lengkap</label>
                <div class="relative">
                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama', $user->nama) }}"
                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
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
                <div class="relative">
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $user->no_telepon) }}"
                        class="w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nomor Telepon">
                </div>
                @error('phone')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </form>
        </div>

        {{-- Button Section - Always at bottom --}}
        <div class="px-6 py-4 bg-white space-y-3">
            {{-- Simpan Perubahan --}}
            <div id="saveButtonWrapper" class="hidden opacity-0 transition-all duration-300 ease-in-out">
                <button type="submit" form="editAccountForm" class="w-full px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition duration-200">
                    Simpan Perubahan
                </button>
            </div>

            {{-- Hapus Akun --}}
            <form action="{{ route('account.destroy') }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.')">
                @csrf
                <button type="submit" class="w-full px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-red-600 hover:text-white font-medium transition duration-200">
                    Hapus Akun
                </button>
            </form>
        </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== Form Change Detection =====
    const editForm = document.getElementById('editAccountForm');
    const saveButtonWrapper = document.getElementById('saveButtonWrapper');
    const namaInput = editForm.querySelector('input[name="nama"]');
    const phoneInput = editForm.querySelector('input[name="phone"]');
    const photoInput = document.getElementById('photoInput');

    // Store initial values
    const initialNama = namaInput.value;
    const initialPhone = phoneInput.value;

    // Function to check if form has changed
    function checkFormChanges() {
        const hasChanges =
            namaInput.value !== initialNama ||
            phoneInput.value !== initialPhone ||
            photoInput.files.length > 0;

        if (hasChanges) {
            saveButtonWrapper.classList.remove('hidden');
            // Trigger reflow to ensure transition works
            void saveButtonWrapper.offsetWidth;
            saveButtonWrapper.classList.remove('opacity-0');
        } else {
            saveButtonWrapper.classList.add('opacity-0');
            // Wait for transition to complete before hiding (300ms)
            setTimeout(() => {
                if (saveButtonWrapper.classList.contains('opacity-0')) {
                    saveButtonWrapper.classList.add('hidden');
                }
            }, 300);
        }
    }

    // Listen for changes
    namaInput.addEventListener('change', checkFormChanges);
    namaInput.addEventListener('input', checkFormChanges);
    phoneInput.addEventListener('change', checkFormChanges);
    phoneInput.addEventListener('input', checkFormChanges);
    photoInput.addEventListener('change', checkFormChanges);

    // Initial check
    checkFormChanges();

    // ===== Change Photo Button =====
    const changePhotoBtn = document.getElementById('changePhotoBtn');
    const fileName = document.getElementById('fileName');
    const avatarContainer = document.getElementById('avatarContainer');

    // Trigger file input when button is clicked
    changePhotoBtn.addEventListener('click', function(e) {
        e.preventDefault();
        photoInput.click();
    });

    // Handle file selection
    photoInput.addEventListener('change', function(e) {
        checkFormChanges(); // Trigger form change detection

        const file = e.target.files[0];
        if (file) {
            fileName.textContent = file.name;

            // Preview image
            const reader = new FileReader();
            reader.onload = function(event) {
                // Remove existing image or icon
                const existingImg = avatarContainer.querySelector('img');
                const existingSvg = avatarContainer.querySelector('svg');

                if (existingImg) {
                    existingImg.src = event.target.result;
                    existingImg.style.display = 'block';
                } else {
                    if (existingSvg) existingSvg.remove();
                    const img = document.createElement('img');
                    img.id = 'avatarImg';
                    img.src = event.target.result;
                    img.alt = 'Profile Photo';
                    img.className = 'w-full h-full object-cover';
                    avatarContainer.appendChild(img);
                }
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
