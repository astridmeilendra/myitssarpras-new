edit

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>myITS Sarpres — Edit Akun</title>
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root{
      --brand-700:#0b3a7e; /* deep blue */
      --brand-600:#153e90;
      --brand-500:#2b78e4; /* primary */
      --brand-400:#6f58ff; /* accent */
      --muted:#94a3b8;
    }
    body{background:#eef2f7;min-height:100vh;display:grid;place-items:center;font-family:system-ui,-apple-system,Segoe UI,Inter,Roboto,Helvetica,Arial}
    .phone{width:360px;max-width:100vw;background:#fff;border:1px solid #e6edf5;border-radius:12px;box-shadow:0 10px 28px rgba(0,0,0,.06);overflow:hidden}

    .page-title{color:#7b8794;font-weight:700;background:#f1f5f9;padding:.55rem 1rem;border-bottom:1px solid #e6edf5}
    .back-link{color:#9aa8b6;text-decoration:none}

    .section{padding:22px 18px}

    .avatar-wrap{display:grid;place-items:center;margin-top:4px;margin-bottom:14px}
    .avatar{width:74px;height:74px;border-radius:50%;background:linear-gradient(135deg,#5fa8ff,#6f58ff);display:grid;place-items:center;color:#fff;font-size:36px}
    .btn-outline-lightblue{--bs-btn-border-color:#d7e4ff;--bs-btn-color:#1853c4;--bs-btn-hover-bg:#f4f7ff;--bs-btn-hover-border-color:#cfe0ff}
    .btn-outline-lightblue{padding:.3rem .7rem;border-radius:999px;font-size:.8rem}

    .label{font-weight:700;color:#112b4a;margin-bottom:6px}

    .form-control{border-radius:10px;border-color:#e6edf5;padding:.7rem .9rem}
    .form-control:focus{border-color:#2b78e4;box-shadow:0 0 0 .2rem rgba(43,120,228,.15)}

    /* Gradient readonly tiles for NRP/Email/Phone */
    .tile-input{border:none;border-radius:10px;padding:0;overflow:hidden}
    .tile-row{display:flex;align-items:center;gap:10px;padding:.85rem .9rem}
    .tile-row .lead-icon{font-size:18px}
    .tile-row .text{flex:1;font-weight:700;color:#fff}
    .tile-row .locker{color:#ffffffcc}
    .tile-nrp{background:linear-gradient(90deg,#5fa8ff,#6f58ff)}
    .tile-phone{background:linear-gradient(90deg,#6f58ff,#5fa8ff)}

    .btn-save{background:var(--brand-700);border-color:var(--brand-700);border-radius:10px;font-weight:700}
    .btn-save:hover{filter:brightness(1.05)}
    .btn-disabled{background:#e9ecef;border-color:#e9ecef;color:#a5b1bd;border-radius:10px}
  </style>
</head>
<body>
  <main class="phone">
    <!-- Thin gray page title strip like prototype -->
    <div class="page-title">Profile Page – Edit Akun</div>

    <div class="section">
      <a href="#" class="back-link d-inline-flex align-items-center mb-2"><i class="bi bi-chevron-left me-1"></i> Kembali</a>

      <div class="avatar-wrap text-center">
        <div class="avatar"><i class="bi bi-person-fill"></i></div>
        <button class="btn btn-outline-lightblue mt-2">Ganti Foto</button>
      </div>

      <!-- Nama Lengkap (editable) -->
      <div class="mb-3">
        <div class="label">Nama Lengkap</div>
        <div class="input-group">
          <span class="input-group-text bg-white border-end-0"><i class="bi bi-person"></i></span>
          <input type="text" class="form-control border-start-0" value="Ezra Bimantara Emanateko Putra" placeholder="Nama lengkap">
        </div>
      </div>

      <!-- NRP (locked) -->
      <div class="mb-3">
        <div class="label">NRP</div>
        <div class="tile-input tile-nrp">
          <div class="tile-row text-white">
            <i class="bi bi-badge-sd lead-icon"></i>
            <div class="text">5026221191</div>
            <i class="bi bi-lock locker"></i>
          </div>
        </div>
      </div>

      <!-- Email (locked) -->
      <div class="mb-3">
        <div class="label">Email ITS</div>
        <div class="tile-input tile-nrp">
          <div class="tile-row text-white">
            <i class="bi bi-envelope lead-icon"></i>
            <div class="text">5026221191@student.its.ac.id</div>
            <i class="bi bi-lock locker"></i>
          </div>
        </div>
      </div>

      <!-- Nomor Telepon (editable gradient like prototype) -->
      <div class="mb-4">
        <div class="label">Nomor Telepon</div>
        <div class="tile-input tile-phone">
          <div class="tile-row text-white">
            <i class="bi bi-telephone lead-icon"></i>
            <input type="tel" class="form-control form-control-sm bg-transparent text-white border-0 p-0" value="08123456789" placeholder="08xxxxxxxxxx" style="font-weight:700;">
          </div>
        </div>
      </div>

      <div class="d-grid gap-3">
        <button class="btn btn-save py-2">Simpan Perubahan</button>
        <button class="btn btn-disabled py-2" disabled>Hapus Akun</button>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
