@extends('template-full')

@section('content')
<style>
    /* Hide scrollbar for Chrome, Safari and Opera */
    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .hide-scrollbar {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }

    /* Custom Radio Button Colors */
    .radio-green {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        border: 2px solid #22c55e;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
    }

    .radio-green:checked {
        background-color: #22c55e;
        border-color: #22c55e;
    }

    .radio-green:checked::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: white;
    }

    .radio-yellow {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        border: 2px solid #eab308;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
    }

    .radio-yellow:checked {
        background-color: #eab308;
        border-color: #eab308;
    }

    .radio-yellow:checked::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: white;
    }

    .radio-red {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        border: 2px solid #ef4444;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
    }

    .radio-red:checked {
        background-color: #ef4444;
        border-color: #ef4444;
    }

    .radio-red:checked::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: white;
    }

    /* Hover effects */
    .radio-green:hover {
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
    }

    .radio-yellow:hover {
        box-shadow: 0 0 0 4px rgba(234, 179, 8, 0.1);
    }

    .radio-red:hover {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }
</style>

<div class="flex flex-col h-full">

    <!-- Content Area -->
    <div class="flex-1 overflow-y-auto px-5 py-6 hide-scrollbar">
        <!-- Title -->
        <h2 class="text-center text-[#003d82] text-xl font-bold mb-6">Informasi</h2>

        <!-- Tabs Navigation -->
        <div class="bg-white -mx-5 px-5 mb-5">
            <div class="grid grid-cols-3 relative">
                <!-- Garis bawah abu-abu untuk semua tab -->
                <div class="absolute bottom-0 left-0 w-full h-[2px] bg-[#E5E7EB]"></div>

                <!-- Tab Alur Penjelasan -->
                <a href="{{ url('/alur-penjelasan') }}"
                class="flex items-center justify-center text-[13px] font-normal text-[#6B7280] py-3 relative whitespace-nowrap">
                    Alur Penjelasan
                </a>

                <!-- Tab FAQ -->
                <a href="{{ url('/faq') }}"
                class="flex items-center justify-center text-[13px] font-normal text-[#6B7280] py-3 relative whitespace-nowrap">
                    FAQ
                </a>

                <!-- Tab Kirim Pertanyaan (Active) -->
                <div class="flex items-center justify-center text-[13px] font-semibold text-[#003d82] py-3 relative whitespace-nowrap">
                    Kirim Pertanyaan
                    <!-- Garis bawah biru untuk tab aktif -->
                    <div class="absolute bottom-0 left-0 w-full h-[3px] bg-[#003d82]"></div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border-2 border-green-500 text-green-800 rounded-lg px-4 py-3 mb-5 text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="bg-red-50 border-2 border-red-500 text-red-800 rounded-lg px-4 py-3 mb-5 text-sm">
            <div class="font-semibold mb-2 flex items-center gap-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                Terjadi Kesalahan:
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Error from Session -->
        @if(session('error'))
        <div class="bg-red-50 border-2 border-red-500 text-red-800 rounded-lg px-4 py-3 mb-5 text-sm font-semibold flex items-center gap-2">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
        @endif

        <!-- Pertanyaan Saya Section - Update bagian ini saja -->
        <div class="mb-6">
            <h3 class="text-[#003d82] text-base font-semibold mb-4">Pertanyaan Saya</h3>

            @if($pertanyaan->count() > 0)
                <div class="space-y-2.5">
                    @foreach($pertanyaan as $p)
                    <a href="{{ route('kirimpertanyaan.show', $p->pertanyaanid) }}"
                    class="block bg-gray-50 border border-gray-200 rounded-lg px-4 py-3.5 cursor-pointer hover:bg-gray-100 transition">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex-1">
                                <p class="text-sm text-gray-800 mb-2 line-clamp-2">{{ $p->isi_pertanyaan }}</p>

                                <!-- Badge Sifat -->
                                <div class="flex items-center gap-2 flex-wrap">
                                    @php
                                        $badgeColors = [
                                            'rendah' => 'bg-green-100 text-green-700 border-green-300',
                                            'sedang' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                            'tinggi' => 'bg-red-100 text-red-700 border-red-300',
                                        ];
                                        $badgeClass = $badgeColors[$p->sifat] ?? 'bg-gray-100 text-gray-700 border-gray-300';
                                    @endphp

                                    <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium border {{ $badgeClass }}">
                                        {{ ucfirst($p->sifat) }}
                                    </span>

                                    <!-- Status Jawaban -->
                                    @if($p->jawaban)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-700 border border-blue-300">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                            Terjawab
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-orange-100 text-orange-700 border border-orange-300">
                                            Menunggu Jawaban
                                        </span>
                                    @endif

                                    <!-- Badge Lampiran -->
                                    @if($p->lampiran)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-purple-100 text-purple-700 border border-purple-300">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"/>
                                            </svg>
                                            Ada Lampiran
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <i class="fas fa-chevron-right text-gray-400 text-xs mt-1"></i>
                        </div>
                    </a>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-8 text-center">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm text-gray-500 italic">Belum ada pertanyaan yang Anda ajukan</p>
                </div>
            @endif
        </div>

        <!-- Divider -->
        <div class="flex items-center gap-3 my-6">
            <div class="flex-1 h-px bg-[#E5E7EB]"></div>
        </div>

        <!-- Form Section -->
        <div class="bg-gradient-to-br from-blue-50 to-white border border-[#DBEAFE] rounded-lg shadow-sm px-5 py-5 mb-6">
            <h3 class="text-center text-[#003d82] text-base font-semibold mb-5">Buat Pertanyaan</h3>

            <form action="{{ route('kirimpertanyaan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Textarea Pertanyaan -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-800 mb-2">
                        Pertanyaan (max. 500 Kata)
                    </label>
                    <textarea
                        name="isi_pertanyaan"
                        id="pertanyaan"
                        class="w-full min-h-[120px] px-3 py-3 border border-gray-300 rounded-lg text-sm resize-none focus:outline-none focus:ring-2 focus:ring-[#003d82] focus:border-transparent transition"
                        maxlength="500"
                        placeholder="Tulis pertanyaan Anda di sini..."
                        required
                    >{{ old('isi_pertanyaan') }}</textarea>
                    <div class="text-right text-xs text-gray-500 mt-1">
                        <span id="charCount">0</span>/500
                    </div>
                </div>

                <!-- File Upload -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-800 mb-2">
                        Dokumen (Opsional)
                    </label>
                    <div
                        class="flex items-center justify-center border-2 border-dashed border-gray-300 rounded-lg px-4 py-4 text-center bg-gray-50 cursor-pointer hover:bg-gray-100 hover:border-[#003d82] transition"
                        onclick="document.getElementById('fileInput').click()"
                    >
                        <input
                            type="file"
                            id="fileInput"
                            name="lampiran"
                            class="hidden"
                            accept=".pdf,.jpg,.jpeg,.png"
                            onchange="displayFileName(this)"
                        >
                        <div class="flex items-center justify-center gap-2 text-gray-600 text-sm">
                            <i class="fas fa-cloud-upload-alt text-lg"></i>
                            <span>Unggah File</span>
                        </div>
                        <div id="fileName" class="mt-2 text-sm text-[#003d82] font-medium"></div>
                    </div>
                </div>

                <!-- Radio Sifat Pertanyaan -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-800 mb-3">
                        Sifat Pertanyaan
                    </label>
                    <div class="flex justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <input
                                type="radio"
                                id="rendah"
                                name="sifat"
                                value="rendah"
                                class="radio-green"
                                {{ old('sifat') == 'rendah' ? 'checked' : '' }}
                            >
                            <label for="rendah" class="text-sm text-gray-800 cursor-pointer">Rendah</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input
                                type="radio"
                                id="sedang"
                                name="sifat"
                                value="sedang"
                                class="radio-yellow"
                                {{ old('sifat') == 'sedang' ? 'checked' : '' }}
                            >
                            <label for="sedang" class="text-sm text-gray-800 cursor-pointer">Sedang</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input
                                type="radio"
                                id="tinggi"
                                name="sifat"
                                value="tinggi"
                                class="radio-red"
                                {{ old('sifat') == 'tinggi' ? 'checked' : '' }}
                            >
                            <label for="tinggi" class="text-sm text-gray-800 cursor-pointer">Tinggi</label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    id="submitBtn"
                    class="w-full bg-[#003d82] text-white py-3.5 rounded-lg text-base font-semibold hover:bg-[#002a5c] active:scale-[0.98] transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <span id="btnText">Kirim</span>
                    <span id="btnLoading" class="hidden">
                        <svg class="animate-spin inline-block w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mengirim...
                    </span>
                </button>
            </form>
        </div>
    </div>

    <!-- Bottom Navigation -->
    <x-navbar active="info" />
</div>

<script>
    // Character counter
    const textarea = document.getElementById('pertanyaan');
    const charCount = document.getElementById('charCount');

    if (textarea && charCount) {
        textarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });

        // Initialize character count if there's old input
        if (textarea.value) {
            charCount.textContent = textarea.value.length;
        }
    }

    // Display uploaded file name
    function displayFileName(input) {
        const fileName = document.getElementById('fileName');
        if (input.files && input.files[0]) {
            fileName.textContent = input.files[0].name;
        }
    }

    // Form submission with loading state
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');

    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
        });
    }
</script>
@endsection
