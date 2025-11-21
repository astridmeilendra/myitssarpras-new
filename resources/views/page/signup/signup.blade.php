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
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        background: #fafbfc;
        border: 1px solid #e8ecf1;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #334155;
    }

    .invalid-feedback {
        font-size: 0.75rem;
        color: #ef4444;
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

        {{-- ERROR DETAIL --}}
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
                <input type="text" class="form-control" name="name" placeholder="Nama"
                       value="{{ old('name') }}">
                @error('name')
                    <div class="server-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email ITS --}}
            <div class="mb-3">
                <input type="email" class="form-control" name="email" placeholder="Email ITS"
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="server-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                @error('password')
                    <div class="server-error">{{ $message }}</div>
                @enderror
            </div>

            {{-- Konfirmasi --}}
            <div class="mb-3">
                <input type="password" class="form-control" name="password_confirmation"
                       placeholder="Ulangi Password" required>
            </div>

            {{-- Telepon --}}
            <div class="mb-3">
                <input type="text" class="form-control" name="phone" placeholder="Nomor Telepon"
                       value="{{ old('phone') }}">
                @error('phone')
                    <div class="server-error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Daftar</button>

            <div class="text-center mt-3">
                Sudah punya akun?
                <a href="{{ route('login') }}">Login</a>
            </div>

        </form>
    </div>
</div>

@endsection
