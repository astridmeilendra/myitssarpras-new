<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>myITS Sarpres — Sign Up (Prototype)</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Font Manrope -->
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root { --brand-blue-600:#0b3a7e; --brand-blue-500:#1159c3; --brand-blue-400:#2b78e4; }

    body{
      background:#f1f5f9;
      font-family:"Manrope",system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Noto Sans,Helvetica,Arial,"Apple Color Emoji","Segoe UI Emoji";
      min-height:100vh; display:grid; place-items:center;
    }

    /* Frame HP */
    .phone{
      width:390px; max-width:854px;
      background:#fff;
      border-radius:10px;
      box-shadow:0 10px 30px rgba(0,0,0,.08);
      overflow:hidden;
      border:1px solid #e9ecef;
    }

    /* HERO — pakai <img> supaya full */
    .hero{
      height:180px;
      position:relative;
      overflow:hidden;
    }
    .hero img{
      width:100%;
      height:100%;
      object-fit:cover;
      display:block;
    }
    .hero .myits-logo{
      position:absolute;
      inset:0;
      display:grid;
      place-items:center;
      color:#fff;
      text-align:center;
      line-height:1.05;
      background:linear-gradient(180deg,rgba(11,58,126,.55),rgba(11,58,126,.55));
    }
    .myits-logo .brand{font-weight:800;font-size:32px;letter-spacing:.5px}
    .myits-logo .sub{font-weight:600;font-size:12px;opacity:.95}

    /* Card */
    .sign-card{
      margin-top:-18px;
      border-top-left-radius:20px!important;
      border-top-right-radius:20px!important;
      border:none;
      box-shadow:0 -6px 18px rgba(0,0,0,.06);
    }

    /* Typography & elemen form */
    .title{font-weight:800;color:#183153;letter-spacing:.2px}
    .title-underline{width:44px;height:3px;background:var(--brand-blue-500);border-radius:99px;margin:.25rem auto 0}

    .form-label{font-weight:600;color:#6c7a89}
    .form-control{border-radius:12px;border-color:#e5e7eb;padding-top:.65rem;padding-bottom:.65rem}
    .form-control::placeholder{color:#9aa6b2;opacity:1;font-weight:600}
    .form-control:focus{border-color:var(--brand-blue-400);box-shadow:0 0 0 .2rem rgba(43,120,228,.15)}

    .input-group .btn-eye{border-color:#e5e7eb;font-weight:600}
    .input-group .btn-eye:hover{background:#f8fafc}

    .btn-primary{background:var(--brand-blue-600);border-color:var(--brand-blue-600);border-radius:10px;font-weight:800}
    .btn-primary:hover{filter:brightness(1.05)}

    .muted-link{font-size:12px}
    .app-version{color:#94a3b8;font-size:11px}
  </style>
</head>
<body>
  <main class="phone">
    <!-- Hero banner full -->
    <section class="hero">
      <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=1200&auto=format&fit=crop" alt="myITS banner">
      <div class="myits-logo">
        <div>
          <div class="brand">myITS</div>
          <div class="sub">Sarana Pra-Sarana</div>
        </div>
      </div>
    </section>

    <!-- Sign card -->
    <div class="card sign-card">
      <div class="card-body p-4">
        <div class="text-center mb-3">
          <h5 class="title mb-1">Sign Up</h5>
          <div class="title-underline"></div>
        </div>

        <form class="needs-validation" novalidate>
          <div class="mb-3">
            <label class="form-label small" for="name">Nama</label>
            <input type="text" class="form-control" id="name" placeholder="Nama" required>
            <div class="invalid-feedback">Harap isi nama.</div>
          </div>

          <div class="mb-3">
            <label class="form-label small" for="email">Alamat Email</label>
            <input type="email" class="form-control" id="email" placeholder="nama@its.ac.id" required>
            <div class="invalid-feedback">Harap masukkan email yang valid.</div>
          </div>

          <div class="mb-3">
            <label class="form-label small" for="password">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" placeholder="Password" required>
              <button class="btn btn-outline-secondary btn-eye" type="button" data-toggle-pass="#password" aria-label="Tampilkan/Sembunyikan password">
                <i class="bi bi-eye-slash"></i>
              </button>
              <div class="invalid-feedback">Password wajib diisi.</div>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label small" for="confirm">Ulangi Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="confirm" placeholder="Ulangi Password" required>
              <button class="btn btn-outline-secondary btn-eye" type="button" data-toggle-pass="#confirm" aria-label="Tampilkan/Sembunyikan password">
                <i class="bi bi-eye-slash"></i>
              </button>
              <div class="invalid-feedback">Harap ulangi password.</div>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label small" for="phone">Nomor Telepon</label>
            <input type="tel" class="form-control" id="phone" placeholder="08xxxxxxxxxx" pattern="[0-9]{9,16}" required>
            <div class="form-text">Gunakan angka saja, 9–16 digit.</div>
            <div class="invalid-feedback">Masukkan nomor telepon yang valid.</div>
          </div>

          <div class="d-grid gap-2 mb-2">
            <button type="submit" class="btn btn-primary py-2">Masuk</button>
          </div>

          <p class="text-center mt-2 muted-link">Sudah punya akun? <a href="#">Login</a></p>
        </form>
      </div>

      <div class="text-center py-3">
        <div class="app-version">myITS Sarpres Versi 1.0.0</div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Bootstrap validation
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
        const icon = btn.querySelector('i');
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
