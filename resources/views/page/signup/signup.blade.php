@extends('template')

@section('content')
<div class="flex flex-col h-full bg-white">

    {{-- HERO BANNER (TANPA GAMBAR, CUMA GRADIENT BIRU) --}}
    <section
        class="h-[180px] grid place-items-center text-white relative
               bg-gradient-to-b from-[#0b3a7e] to-[#1159c3]">
        <div class="text-center leading-tight">
            <div class="font-extrabold text-[32px] tracking-wide">myITS</div>
            <div class="font-semibold text-[12px] mt-1">
                Sarana Pra-Sarana
            </div>
        </div>
    </section>

    {{-- CARD SIGN UP --}}
    <div
        class="-mt-4 flex-1 bg-white rounded-t-[24px]
               shadow-[0_-6px_18px_rgba(0,0,0,0.06)]
               px-6 pt-5 pb-4 overflow-y-auto">

        {{-- Title --}}
        <div class="text-center mb-4">
            <h1 class="text-[18px] font-extrabold text-[#183153] tracking-[0.02em] mb-1">
                Sign Up
            </h1>
            <div class="w-11 h-[3px] mx-auto rounded-full bg-[#1159c3]"></div>
        </div>

        {{-- FORM --}}
        <form class="space-y-3" onsubmit="return validateSignUp(this)">

            {{-- Nama --}}
            <div>
                <label for="name"
                       class="block text-[12px] font-semibold text-[#6c7a89] mb-1">
                    Nama
                </label>
                <input id="name" name="name" type="text" required
                       placeholder="Nama"
                       class="w-full rounded-[12px] border border-[#e5e7eb]
                              py-2.5 px-3 text-[13px] font-semibold text-[#1f2933]
                              placeholder:text-[#9aa6b2]
                              outline-none
                              focus:border-[#2b78e4] focus:ring-2 focus:ring-[#2b78e4]/20">
            </div>

            {{-- Email --}}
            <div>
                <label for="email"
                       class="block text-[12px] font-semibold text-[#6c7a89] mb-1">
                    Alamat Email
                </label>
                <input id="email" name="email" type="email" required
                       placeholder="nama@its.ac.id"
                       class="w-full rounded-[12px] border border-[#e5e7eb]
                              py-2.5 px-3 text-[13px] font-semibold text-[#1f2933]
                              placeholder:text-[#9aa6b2]
                              outline-none
                              focus:border-[#2b78e4] focus:ring-2 focus:ring-[#2b78e4]/20">
            </div>

            {{-- Password --}}
            <div>
                <label for="password"
                       class="block text-[12px] font-semibold text-[#6c7a89] mb-1">
                    Password
                </label>
                <div class="flex">
                    <input id="password" name="password" type="password" required
                           placeholder="Password"
                           class="flex-1 rounded-l-[12px] border border-r-0 border-[#e5e7eb]
                                  py-2.5 px-3 text-[13px] font-semibold text-[#1f2933]
                                  placeholder:text-[#9aa6b2]
                                  outline-none
                                  focus:border-[#2b78e4] focus:ring-2 focus:ring-[#2b78e4]/20">
                    <button type="button"
                            class="rounded-r-[12px] border border-l-0 border-[#e5e7eb]
                                   px-3 flex items-center justify-center bg-white"
                            onclick="togglePass('password', this)"
                            aria-label="Tampilkan/Sembunyikan password">
                        <svg class="w-5 h-5 text-[#6b7280]" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor">
                            <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z"
                                  stroke-width="1.5" />
                            <circle cx="12" cy="12" r="3" stroke-width="1.5" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Ulangi Password --}}
            <div>
                <label for="confirm"
                       class="block text-[12px] font-semibold text-[#6c7a89] mb-1">
                    Ulangi Password
                </label>
                <div class="flex">
                    <input id="confirm" name="confirm" type="password" required
                           placeholder="Ulangi Password"
                           class="flex-1 rounded-l-[12px] border border-r-0 border-[#e5e7eb]
                                  py-2.5 px-3 text-[13px] font-semibold text-[#1f2933]
                                  placeholder:text-[#9aa6b2]
                                  outline-none
                                  focus:border-[#2b78e4] focus:ring-2 focus:ring-[#2b78e4]/20">
                    <button type="button"
                            class="rounded-r-[12px] border border-l-0 border-[#e5e7eb]
                                   px-3 flex items-center justify-center bg-white"
                            onclick="togglePass('confirm', this)"
                            aria-label="Tampilkan/Sembunyikan password">
                        <svg class="w-5 h-5 text-[#6b7280]" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor">
                            <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z"
                                  stroke-width="1.5" />
                            <circle cx="12" cy="12" r="3" stroke-width="1.5" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Nomor Telepon --}}
            <div class="mb-1">
                <label for="phone"
                       class="block text-[12px] font-semibold text-[#6c7a89] mb-1">
                    Nomor Telepon
                </label>
                <input id="phone" name="phone" type="tel" required pattern="[0-9]{9,16}"
                       placeholder="08xxxxxxxxxx"
                       class="w-full rounded-[12px] border border-[#e5e7eb]
                              py-2.5 px-3 text-[13px] font-semibold text-[#1f2933]
                              placeholder:text-[#9aa6b2]
                              outline-none
                              focus:border-[#2b78e4] focus:ring-2 focus:ring-[#2b78e4]/20">
                <div class="text-[11px] text-gray-500 mt-1">
                    Gunakan angka saja, 9–16 digit.
                </div>
            </div>

            {{-- BUTTON MASUK --}}
            <button type="submit"
                    class="w-full rounded-[12px] bg-[#0b3a7e] text-white
                           font-extrabold text-[14px] py-2 mt-2 hover:brightness-105">
                Masuk
            </button>

            {{-- LINK LOGIN --}}
            <p class="text-center text-[12px] text-gray-600 mt-1">
                Sudah punya akun?
                <a href="{{ url('/login') }}" class="text-[#1159c3] underline">
                    Login
                </a>
            </p>
        </form>

        {{-- Versi app --}}
        <div class="mt-4 text-center text-[11px] text-[#94a3b8]">
            myITS Sarpres Versi 1.0.0
        </div>
    </div>
</div>

{{-- JS untuk toggle password & cek konfirmasi --}}
<script>
    function togglePass(id, btn) {
        const input = document.getElementById(id);
        if (!input) return;
        input.type = input.type === 'password' ? 'text' : 'password';
        btn.classList.toggle('bg-gray-50');
    }

    function validateSignUp(form) {
        if (form.password.value !== form.confirm.value) {
            alert('Password dan konfirmasi tidak sama.');
            return false;
        }
        return form.checkValidity();
    }
</script>
@endsection
