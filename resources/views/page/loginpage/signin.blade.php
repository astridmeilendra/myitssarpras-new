@extends('template-full')

@section('content')
<style>
    :root {
        --brand-blue: #003d82;
        --brand-blue-dark: #002952;
    }

    /* Hero Section dengan gambar background dari file lokal */
    .hero-section {
        background: url('{{ asset('img/its-background.png') }}');
        background-size: cover;
        background-position: center;
        padding: 2rem 1.5rem 2.5rem;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 180px;
    }

    /* Overlay biru di atas gambar */
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

    .hero-logo {
        position: relative;
        z-index: 10;
        color: white;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Logo myITS dari file */
    .hero-logo img {
        height: 55px;
        display: block;
    }

    /* Login Card with curved top */
    .login-card {
        background: white;
        border-top-left-radius: 28px;
        border-top-right-radius: 28px;
        padding: 2.5rem 1.75rem 2rem;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
        margin-top: -20px;
        position: relative;
        z-index: 20;
        min-height: calc(100vh - 180px);
    }

    .login-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e3a5f;
        text-align: center;
        margin-bottom: 2rem;
    }

    /* Form Inputs */
    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        background: #fafbfc;
        border: 1px solid #e8ecf1;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #334155;
        transition: all 0.2s;
        font-weight: 400;
    }

    .form-input::placeholder {
        color: #cbd5e1;
        font-weight: 400;
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

    .password-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
    }

    .password-toggle:hover {
        color: #64748b;
    }

    /* Submit Button */
    .btn-submit {
        width: 100%;
        padding: 0.875rem;
        background: #003d82;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 1.5rem;
        margin-bottom: 1.25rem;
    }

    .btn-submit:hover {
        background: #002952;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 61, 130, 0.25);
    }

    /* Sign Up Link */
    .signup-link {
        text-align: center;
        font-size: 0.875rem;
        color: #64748b;
    }

    .signup-link a {
        color: #0052a8;
        font-weight: 600;
        text-decoration: none;
    }

    .signup-link a:hover {
        text-decoration: underline;
    }

    /* Version - di paling bawah */
    .version-wrapper {
        position: absolute;
        bottom: 1.5rem;
        left: 0;
        right: 0;
    }

    .version-text {
        text-align: center;
        color: #cbd5e1;
        font-size: 0.75rem;
    }
</style>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="diagonal-lines"></div>

    <div class="hero-logo">
        <!-- Logo myITS dari file (sudah include tulisan Sarana Pra-Sarana di dalam gambar) -->
        <img src="{{ asset('img/myits-sarpras-white.png') }}" alt="myITS Sarana Pra-Sarana">
    </div>
</div>

<!-- Login Card -->
<div class="login-card">
    <h2 class="login-title">Login</h2>

    <!-- Email Input -->
    <div class="input-wrapper">
        <input
            type="email"
            class="form-input"
            id="email"
            placeholder="Alamat Email"
        >
    </div>

    <!-- Password Input -->
    <div class="input-wrapper">
        <input
            type="password"
            class="form-input"
            id="password"
            placeholder="Password"
        >
        <button type="button" class="password-toggle" data-toggle-pass="#password">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="eye-slash">
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            </svg>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="eye" style="display:none;">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
        </button>
    </div>

    <!-- Submit Button -->
    <button type="button" class="btn-submit" id="loginBtn">
        Masuk
    </button>

    <!-- Sign Up Link -->
    <div class="signup-link">
        Belum punya akun? <a href="#">Daftar Sekarang</a>
    </div>

    <!-- Version at bottom -->
    <div class="version-wrapper">
        <div class="version-text">
            MyITSsarpras Versi 1.0.0
        </div>
    </div>
</div>

<script>
    // Password Toggle
    document.querySelectorAll('[data-toggle-pass]').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.querySelector(btn.getAttribute('data-toggle-pass'));
            const eyeSlash = btn.querySelector('.eye-slash');
            const eye = btn.querySelector('.eye');

            if (input.type === 'password') {
                input.type = 'text';
                eyeSlash.style.display = 'none';
                eye.style.display = 'block';
            } else {
                input.type = 'password';
                eyeSlash.style.display = 'block';
                eye.style.display = 'none';
            }
        });
    });

    // Login Handler
    document.getElementById('loginBtn').addEventListener('click', () => {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (email && password) {
            alert('Login berhasil!');
        } else {
            alert('Mohon isi semua field');
        }
    });
</script>
@endsection
