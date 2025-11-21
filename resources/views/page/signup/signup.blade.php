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

    /* Hero Section dengan gambar background dari file lokal */
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

    .myits-logo {
        position: relative;
        z-index: 10;
        color: white;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Logo myITS dari file */
    .myits-logo img {
        height: 55px;
        display: block;
    }

    /* Card */
    .sign-card {
        margin-top: -20px;
        border-top-left-radius: 28px !important;
        border-top-right-radius: 28px !important;
        border: none;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
        background: white;
        position: relative;
        z-index: 20;
        min-height: calc(100vh - 180px);
    }

    /* Typography */
    .title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e3a5f;
        text-align: center;
        letter-spacing: .2px;
    }

    .title-underline {
        width: 44px;
        height: 3px;
        background: var(--brand-blue-500);
        border-radius: 99px;
        margin: .25rem auto 0;
    }

    /* Form Inputs - tanpa label, hanya placeholder */
    .form-control {
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

    .form-control::placeholder {
        color: #cbd5e1;
        font-weight: 400;
    }

    .form-control:focus {
        outline: none;
        border-color: #0052a8;
        background: white;
        box-shadow: 0 0 0 3px rgba(0, 82, 168, 0.05);
    }

    .input-wrapper {
        position: relative;
        margin-bottom: 1rem;
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

    .app-version {
        color: #cbd5e1;
        font-size: 0.75rem;
        text-align: center;
    }

    .form-text {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 0.25rem;
        margin-left: 0.25rem;
    }

    .invalid-feedback {
        font-size: 0.75rem;
        color: #ef4444;
        margin-top: 0.25rem;
        margin-left: 0.25rem;
        display: none;
    }

    .was-validated .form-control:invalid ~ .invalid-feedback {
        display: block;
    }

    .was-validated .form-control:invalid {
        border-color: #ef4444;
    }
</style>

<!-- Hero banner -->
<section class="hero">
    <div class="hero-overlay"></div>
    <div class="diagonal-lines"></div>

    <div class="myits-logo">
        <!-- Logo myITS dari file (sudah include tulisan Sarana Pra-Sarana di dalam gambar) -->
        <img src="{{ asset('img/myits-sarpras-white.png') }}" alt="myITS Sarana Pra-Sarana">
    </div>
</section>

<!-- Sign card -->
<div class="sign-card">
    <div class="p-4" style="padding-top: 2.5rem;">
        <div class="text-center mb-4">
            <h2 class="title">Sign Up</h2>
        </div>

        <form class="needs-validation" novalidate>
            <!-- Nama -->
            <div class="input-wrapper">
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="Nama"
                    required
                >
                <div class="invalid-feedback">Harap isi nama.</div>
            </div>

            <!-- Email -->
            <div class="input-wrapper">
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="Alamat Email"
                    required
                >
                <div class="invalid-feedback">Harap masukkan email yang valid.</div>
            </div>

            <!-- Password -->
            <div class="input-wrapper">
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    placeholder="Password"
                    required
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
                <div class="invalid-feedback">Password wajib diisi.</div>
            </div>

            <!-- Ulangi Password -->
            <div class="input-wrapper">
                <input
                    type="password"
                    class="form-control"
                    id="confirm"
                    placeholder="Ulangi Password"
                    required
                >
                <button type="button" class="password-toggle" data-toggle-pass="#confirm">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="eye-slash">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="eye" style="display:none;">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
                <div class="invalid-feedback">Harap ulangi password.</div>
            </div>

            <!-- Nomor Telepon -->
            <div class="input-wrapper" style="margin-bottom: 0.5rem;">
                <input
                    type="tel"
                    class="form-control"
                    id="phone"
                    placeholder="Nomor Telepon"
                    pattern="[0-9]{9,16}"
                    required
                >
                <div class="invalid-feedback">Masukkan nomor telepon yang valid.</div>
            </div>
            <div class="form-text" style="margin-bottom: 1.5rem;">Gunakan angka saja, 9–16 digit.</div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">
                Daftar
            </button>

            <!-- Login Link -->
            <div class="signup-link">
                Sudah punya akun? <a href="#">Login</a>
            </div>
        </form>

        <!-- Version at bottom -->
        <div style="padding: 1.5rem 0;">
            <div class="app-version">
                myITS Sarpres Versi 1.0.0
            </div>
        </div>
    </div>
</div>

<script>
    // Form validation
    (function () {
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();

    // Toggle password visibility
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
</script>
@endsection
