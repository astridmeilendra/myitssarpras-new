@extends('template')
@section('content')
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>myITS Sarpras — Login</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Optional: Manrope font agar mirip mobile UI -->
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root {
      --brand-blue-700:#0b3a7e;
      --brand-blue-500:#1159c3;
      --brand-blue-400:#2b78e4;
    }

    body{
      background:#f1f5f9;
      font-family:"Manrope", system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, Helvetica, Arial;
      min-height:100vh;
      display:grid;
      place-items:center;
    }

    /* Frame “HP” */
    .phone{
      width:360px;
      max-width:100vw;
      background:#fff;
      border-radius:10px;
      border:1px solid #e3e9ef;
      box-shadow:0 10px 30px rgba(0,0,0,.08);
      overflow:hidden;
    }

    /* Hero (banner biru + foto gedung) */
    .hero{
      position:relative;
      height:180px;
      overflow:hidden;
    }
    .hero img{
      position:absolute;
      inset:0;
      width:100%;
      height:100%;
      object-fit:cover;
    }
    .hero-overlay{
      position:absolute;
      inset:0;
      background:linear-gradient(180deg,rgba(11,58,126,.8),rgba(11,58,126,.9));
    }
    .hero-logo{
      position:absolute;
      left:22px;
      top:28px;
      color:#fff;
    }
    .hero-logo img{
      height:40px;
      display:block;
    }

    /* Kartu login */
    .login-card{
      margin-top:-18px;
      border-top-left-radius:22px!important;
      border-top-right-radius:22px!important;
      border:none;
      box-shadow:0 -6px 18px rgba(0,0,0,.06);
    }

    .login-title{
      font-weight:800;
      color:#183153;
    }
    .login-underline{
      width:40px;
      height:3px;
      background:#e2e8f0;
      border-radius:99px;
      margin:.15rem auto 0;
    }

    .form-control{
      border-radius:12px;
      border-color:#e5e7eb;
      padding-top:.7rem;
      padding-bottom:.7rem;
    }
    .form-control::placeholder{
      color:#9aa6b2;
      opacity:1;
      font-weight:600;
    }
    .form-control:focus{
      border-color:var(--brand-blue-400);
      box-shadow:0 0 0 .2rem rgba(43,120,228,.18);
    }

    .input-group .btn-eye{
      border-radius:0 12px 12px 0;
      border-color:#e5e7eb;
    }
    .input-group .btn-eye:hover{
      background:#f8fafc;
    }

    .btn-login{
      background:var(--brand-blue-700);
      border-color:var(--brand-blue-700);
      border-radius:12px;
      font-weight:800;
    }
    .btn-login:hover{
      filter:brightness(1.05);
    }

    .small-link{
      font-size:13px;
    }
    .version-text{
      color:#c4cbd3;
      font-size:11px;
    }
  </style>
</head>
<body>

  <main class="phone">
    <!-- HERO -->
    <section class="hero">
      <!-- ganti src ini dengan gambar kamu sendiri kalau perlu -->
      <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1200&auto=format&fit=crop" alt="">
      <div class="hero-overlay"></div>

      <div class="hero-logo">
        <!-- kalau punya logo putih sendiri -->
        <!-- <img src="img/myits-sarpras-white.png" alt="myITS"> -->

        <!-- fallback teks logo -->
        <div class="text-white lh-sm">
          <div class="fw-bold" style="font-size:34px;letter-spacing:.5px;">myITS</div>
          <div class="fw-semibold" style="font-size:11px;margin-top:-3px;">Sarana Pra-Sarana</div>
        </div>
      </div>
    </section>

    <!-- CARD LOGIN -->
    <div class="card login-card">
      <div class="card-body px-4 pt-4 pb-3">
        <div class="text-center mb-3">
          <div class="login-title fs-4 mb-1">Login</div>
          <div class="login-underline"></div>
        </div>

        <form class="needs-validation" novalidate>
          <!-- Email -->
          <div class="mb-3">
            <input type="email" class="form-control" id="email"
                   placeholder="Alamat Email" required>
            <div class="invalid-feedback">Masukkan alamat email yang valid.</div>
          </div>

          <!-- Password -->
          <div class="mb-4">
            <div class="input-group">
              <input type="password" class="form-control" id="password"
                     placeholder="Password" required>
              <button type="button" class="btn btn-outline-secondary btn-eye"
                      data-toggle-pass="#password" aria-label="Tampilkan/Sembunyikan password">
                <i class="bi bi-eye-slash"></i>
              </button>
              <div class="invalid-feedback">Password wajib diisi.</div>
            </div>
          </div>

          <!-- Button Masuk -->
          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-login py-2">Masuk</button>
          </div>

          <!-- Link daftar -->
          <p class="text-center small-link mb-1">
            Belum punya akun?
            <a href="#" class="fw-bold text-decoration-underline text-primary">Daftar Sekarang</a>
          </p>
        </form>
      </div>

      <div class="text-center py-3">
        <span class="version-text">MyITSsarpras Versi 1.0.0</span>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Validasi Bootstrap
    (function () {
      'use strict';
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

    // Toggle show/hide password
    document.querySelectorAll('[data-toggle-pass]').forEach(btn => {
      btn.addEventListener('click', () => {
        const input = document.querySelector(btn.getAttribute('data-toggle-pass'));
        const icon  = btn.querySelector('i');
        if (!input) return;

        if (input.type === 'password') {
          input.type = 'text';
          icon.classList.replace('bi-eye-slash','bi-eye');
        } else {
          input.type = 'password';
          icon.classList.replace('bi-eye','bi-eye-slash');
        }
      });
    });
  </script>
</body>
</html>
