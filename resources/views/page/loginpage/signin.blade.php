@extends('template-full')

@section('content')
<style>
    :root {
        --brand-blue: #003d82;
        --brand-blue-dark: #002952;
    }

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

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0, 61, 130, 0.85) 0%, rgba(0, 82, 168, 0.85) 100%);
    }

    .diagonal-lines {
        position: absolute;
        inset: 0;
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
            rgba(255,255,255,0.03) 10px,
            rgba(255,255,255,0.03) 11px
        );
    }

    .hero-logo img {
        height: 55px;
        position: relative;
        z-index: 10;
    }

    .login-card {
        background: white;
        border-top-left-radius: 28px;
        border-top-right-radius: 28px;
        padding: 2.5rem 1.75rem 2rem;
        margin-top: -20px;
        position: relative;
        z-index: 20;
    }

    .login-title {
        text-align: center;
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e3a5f;
        margin-bottom: 2rem;
    }

    .form-input {
        width: 100%;
        padding: 0.875rem 1rem;
        background: #fafbfc;
        border: 1px solid #e8ecf1;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #334155;
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
        cursor: pointer;
        color: #94a3b8;
    }

    .btn-submit {
        width: 100%;
        padding: 0.875rem;
        background: #003d82;
        color: white;
        font-weight: 700;
        border: none;
        border-radius: 10px;
        margin-top: 1.5rem;
    }

    .signup-link {
        text-align: center;
        margin-top: 1rem;
        color: #64748b;
        font-size: 0.875rem;
    }

    .signup-link a {
        color: #0052a8;
        text-decoration: none;
        font-weight: 600;
    }
</style>

<div class="hero-section">
    <div class="hero-overlay"></div>
    <div class="diagonal-lines"></div>
    <div class="hero-logo">
        <img src="{{ asset('img/myits-sarpras-white.png') }}" alt="myITS Sarpras">
    </div>
</div>

<div class="login-card">
    <h2 class="login-title">Login</h2>

    {{-- ERROR MESSAGE --}}
    @if ($errors->any())
        <div style="color:red; font-size:14px; margin-bottom:10px;">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- FORM LOGIN --}}
    <form method="POST" action="{{ route('login.process') }}">
        @csrf

        {{-- EMAIL --}}
        <div class="input-wrapper">
            <input
                type="email"
                name="email"
                class="form-input"
                placeholder="Alamat Email"
                value="{{ old('email') }}"
                required
            >
        </div>

        {{-- PASSWORD --}}
        <div class="input-wrapper">
            <input
                type="password"
                name="password"
                class="form-input"
                id="password"
                placeholder="Password"
                required
            >

            <button type="button" class="password-toggle" data-toggle-pass="#password">
                👁
            </button>
        </div>

        {{-- SUBMIT --}}
        <button type="submit" class="btn-submit">
            Masuk
        </button>

        {{-- SIGNUP LINK --}}
        <div class="signup-link">
            Belum punya akun?
            <a href="{{ route('signup') }}">Daftar Sekarang</a>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('[data-toggle-pass]').forEach(btn => {
        btn.addEventListener('click', () => {
            const target = document.querySelector(btn.dataset.togglePass);

            target.type = target.type === "password" ? "text" : "password";
        });
    });
</script>

@endsection
