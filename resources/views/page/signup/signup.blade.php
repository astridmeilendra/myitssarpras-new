@extends('template-full')

@section('content')
<style>
    :root {
        --brand-blue: #003d82;
        --brand-blue-dark: #002952;
        --brand-blue-600: #0b3a7e;
        --brand-blue-500: #1159c3;
        --brand-blue-400: #2b78e4;
    }

    .hero {
        background: url('{{ asset('img/its-background.png') }}');
        background-size: cover;
        background-position: center;
        height: 180px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0, 61, 130, 0.85) 0%, rgba(0, 82, 168, 0.85) 100%);
    }

    .diagonal-lines {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        z-index: 5;
    }

    .diagonal-lines::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200%;
        height: 200%;
        background-image: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 10px,
            rgba(255, 255, 255, 0.03) 10px,
            rgba(255, 255, 255, 0.03) 11px
        );
    }

    .myits-logo {
        position: relative;
        z-index: 10;
        color: white;
        text-align: center;
    }

    .myits-logo img {
        height: 55px;
    }

    .sign-card {
        margin-top: -20px;
        border-top-left-radius: 28px !important;
        border-top-right-radius: 28px !important;
        background: white;
        min-height: calc(100vh - 180px);
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
        position: relative;
        z-index: 20;
    }

    .title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e3a5f;
        text-align: center;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        background: #fafbfc;
        border: 1px solid #e8ecf1;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #334155;
        transition: all 0.2s;
    }

    .form-control::placeholder {
        color: #cbd5e1;
    }

    .form-control:focus {
        outline: none;
        border-color: #0052a8;
        background: white;
        box-shadow: 0 0 0 3px rgba(0, 82, 168, 0.05);
    }

    .server-error {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .btn-submit {
        width: 100%;
        padding: 0.875rem;
        background: #003d82;
        color: white;
        border-radius: 10px;
        font-weight: 700;
        margin-top: 1.5rem;
        border: none;
    }

    /* Bungkus input yang ada icon mata */
    .input-wrapper {
        position: relative;
        margin-bottom: 0.75rem;
    }

    .input-wrapper .form-control {
        padding-right: 3rem; /* ruang buat icon */
    }

    .password-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        cursor: pointer;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4px;
    }

    .password-toggle:hover {
        color: #64748b;
    }

    /* Link ke login */
    .signup-link {
        text-align: center;
        font-size: 0.875rem;
        color: #64748b;
        margin-top: 1rem;
    }

    .signup-link a {
        color: #0052a8;
        font-weight: 600;
        text-decoration: none;
    }

    .signup-link a:hover {
        text-decoration: underline;
    }

    /* HAPUS icon mata default dari browser (Edge/Chrome) */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear {
        display: none;
    }
</style>

<section class="hero">
    <div class="hero-overlay"></div>
    <div class="diagonal-lines"></div>
    <div class="myits-logo">
        <img src="{{ asset('img/myits-sarpras-white.png') }}" alt="myITS Sarpras">
    </div>
</section>

<div class="sign-card">
    <div class="p-4" style="padding-top: 2.5rem;">
        <div class="text-center mb-4">
            <h2 class="title">Sign Up</h2>
        </div>

        @if ($errors->any())
            <div class="server-error mb-3">
                <div>Terdapat kesalahan pada input:</div>
                <ul style="margin-top: 4px; padding-left: 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/signup') }}">
            @csrf

            {{-- Nama --}}
            <div class="mb-3">
                <input type="text"
                       class="form-control"
                       name="name"
                       placeholder="Nama"
                       value="{{ old('name') }}">
                @error('name')
                    <div class="server-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email ITS --}}
            <div class="mb-3">
                <input type="email"
                       class="form-control"
                       name="email"
                       placeholder="Alamat Email"
                       value="{{ old('email') }}"
                       required>
                @error('email')
                    <div class="server-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="input-wrapper">
                <input type="password"
                       class="form-control"
                       id="password"
                       name="password"
                       placeholder="Password"
                       required>
                <button type="button"
                        class="password-toggle"
                        data-toggle-pass="#password">
                    {{-- mata silang (default, hidden text) --}}
                    <svg class="eye-slash" width="20" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                    {{-- mata biasa (muncul saat teks kelihatan) --}}
                    <svg class="eye" width="20" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         style="display:none;">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
                @error('password')
                    <div class="server-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Ulangi Password --}}
            <div class="input-wrapper">
                <input type="password"
                       class="form-control"
                       id="confirm"
                       name="password_confirmation"
                       placeholder="Ulangi Password"
                       required>
                <button type="button"
                        class="password-toggle"
                        data-toggle-pass="#confirm">
                    <svg class="eye-slash" width="20" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                    <svg class="eye" width="20" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         style="display:none;">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>

            {{-- Nomor Telepon --}}
            <div class="mb-3">
                <input type="text"
                       class="form-control"
                       name="phone"
                       placeholder="Nomor Telepon"
                       value="{{ old('phone') }}">
                @error('phone')
                    <div class="server-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Daftar</button>

            <div class="signup-link">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle show/hide password + ubah icon mata
    document.querySelectorAll('[data-toggle-pass]').forEach(btn => {
        btn.addEventListener('click', () => {
            const selector = btn.getAttribute('data-toggle-pass');
            const input = document.querySelector(selector);
            if (!input) return;

            const eyeSlash = btn.querySelector('.eye-slash');
            const eye      = btn.querySelector('.eye');

            if (input.type === 'password') {
                input.type = 'text';
                if (eyeSlash) eyeSlash.style.display = 'none';
                if (eye)      eye.style.display      = 'block';
            } else {
                input.type = 'password';
                if (eyeSlash) eyeSlash.style.display = 'block';
                if (eye)      eye.style.display      = 'none';
            }
        });
    });
</script>
@endsection
