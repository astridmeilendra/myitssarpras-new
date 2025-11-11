<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>myITS Sarpres — Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --brand-blue-700: #0b3a7e;
      --brand-blue-500: #2b78e4;
      --muted: #9aa8b6;
      --divider: #eef2f6;
    }

    body {
      background: #eef2f7;
      min-height: 100vh;
      display: grid;
      place-items: center;
      font-family: 'Inter', system-ui, sans-serif;
    }

    .phone {
      width: 390px;
      height: 844px;
      background: #fff;
      border-radius: 16px;
      border: 1px solid #e3e9ef;
      box-shadow: 0 8px 28px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .profile-section {
      padding: 60px 24px 16px;
      text-align: center;
    }

    .avatar {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: linear-gradient(135deg, #6aa8ff, #6f58ff);
      display: grid;
      place-items: center;
      color: #fff;
      font-size: 36px;
      margin: 0 auto 14px;
    }

    .email {
      font-size: 12px;
      color: #9aa8b6;
    }

    .name {
      font-weight: 800;
      color: var(--brand-blue-700);
      font-size: 18px;
      margin-top: 2px;
    }

    .menu-section {
      flex: 1;
      padding: 8px 16px;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }

    .tile {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 12px 8px;
      border-bottom: 1px solid var(--divider);
    }

    .tile-icon {
      width: 42px;
      height: 42px;
      border-radius: 10px;
      background: #f7f9fc;
      display: grid;
      place-items: center;
      margin-right: 10px;
      color: #1b2a49;
      font-size: 20px;
    }

    .tile-text {
      flex: 1;
      line-height: 1.2;
    }

    .tile-text p {
      margin: 0;
    }

    .tile-title {
      font-weight: 700;
      color: #122b4a;
      font-size: 15px;
    }

    .tile-subtitle {
      color: #97a4b5;
      font-size: 12px;
    }

    .bottom-section {
      flex-shrink: 0;
      border-top: 1px solid #e8eef4;
      background: #fff;
    }

    .bottom-gradient {
      height: 60px;
      background: linear-gradient(180deg, rgba(11,58,126,0) 0%, rgba(11,58,126,0.06) 100%);
    }

    .bottom-nav {
      display: flex;
      justify-content: space-around;
      align-items: center;
      height: 70px;
    }

    .nav-item {
      text-align: center;
      font-size: 12px;
      color: #9aa8b6;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .nav-item i {
      font-size: 18px;
      margin-bottom: 2px;
    }

    .nav-item.active {
      color: var(--brand-blue-700);
      font-weight: 700;
    }
  </style>
</head>
<body>
  <main class="phone">
    <div>
      <div class="profile-section">
        <div class="avatar"><i class="bi bi-person-fill"></i></div>
        <div class="email">5026221191@student.its.ac.id</div>
        <div class="name">Ezra Bimantara</div>
      </div>

      <div class="menu-section">
        <div class="tile">
          <div class="d-flex align-items-center flex-grow-1">
            <div class="tile-icon"><i class="bi bi-person"></i></div>
            <div class="tile-text">
              <p class="tile-title">Akun</p>
              <p class="tile-subtitle">Ganti Password, Edit Data Akun</p>
            </div>
          </div>
          <i class="bi bi-chevron-right text-secondary"></i>
        </div>

        <div class="tile">
          <div class="d-flex align-items-center flex-grow-1">
            <div class="tile-icon"><i class="bi bi-clock-history"></i></div>
            <div class="tile-text">
              <p class="tile-title">Riwayat Peminjaman</p>
              <p class="tile-subtitle">Lihat peminjaman yang sudah selesai</p>
            </div>
          </div>
          <i class="bi bi-chevron-right text-secondary"></i>
        </div>

        <div class="tile border-0">
          <div class="d-flex align-items-center flex-grow-1">
            <div class="tile-icon"><i class="bi bi-door-open"></i></div>
            <div class="tile-text">
              <p class="tile-title">Keluar</p>
              <p class="tile-subtitle">Keluar dari akun</p>
            </div>
          </div>
          <i class="bi bi-chevron-right text-secondary"></i>
        </div>
      </div>
    </div>

    <div class="bottom-section">
      <div class="bottom-gradient"></div>
      <div class="bottom-nav">
        <div class="nav-item"><i class="bi bi-house"></i>Home</div>
        <div class="nav-item"><i class="bi bi-clock-history"></i>Riwayat</div>
        <div class="nav-item"><i class="bi bi-search"></i>Search</div>
        <div class="nav-item active"><i class="bi bi-person-circle"></i>Profile</div>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
