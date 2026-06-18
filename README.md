# 🏛️ MyITS Sarpras — CI/CD Pipeline

> Platform manajemen peminjaman fasilitas dan ruangan Institut Teknologi Sepuluh Nopember (ITS) berbasis web, dilengkapi pipeline CI/CD otomatis menggunakan GitHub Actions + Azure.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white)
![Azure](https://img.shields.io/badge/Azure-0078D4?style=for-the-badge&logo=microsoft-azure&logoColor=white)
![GitHub Actions](https://img.shields.io/badge/GitHub_Actions-2088FF?style=for-the-badge&logo=github-actions&logoColor=white)

---

## 📋 Daftar Isi

- [Tentang Aplikasi](#-tentang-aplikasi)
- [Fitur](#-fitur)
- [Tech Stack](#-tech-stack)
- [Struktur Tim](#-struktur-tim)
- [Prasyarat](#-prasyarat)
- [Instalasi Lokal](#-instalasi-lokal)
- [Konfigurasi Environment](#-konfigurasi-environment)
- [Menjalankan Testing](#-menjalankan-testing)
- [Alur CI/CD Pipeline](#-alur-cicd-pipeline)
- [Azure Setup](#-azure-setup)
- [Workflow GitHub Actions](#-workflow-github-actions)
- [Monitoring](#-monitoring)

---

## 🏠 Tentang Aplikasi

**MyITS Sarpras** adalah platform berbasis web untuk mempermudah dan memusatkan proses peminjaman fasilitas serta ruangan di ITS. Sistem ini memungkinkan pengguna melakukan:

- Reservasi ruangan secara online
- Pengajuan izin digital (paperless)
- Pemantauan status peminjaman secara real-time

Sehingga proses administrasi menjadi lebih **efisien**, **transparan**, dan terhindar dari **double booking**.

---

## ✨ Fitur

| No | Fitur | Deskripsi |
|----|-------|-----------|
| 01 | **Search & Filter Ruangan** | Cari ruangan berdasarkan nama, tanggal, dan waktu yang tersedia |
| 02 | **All-in-One Pemesanan Ruangan** | Form lengkap peminjaman ruangan dalam satu halaman |
| 03 | **Tracking Status Peminjaman** | Pantau status pengajuan secara real-time (Menunggu / Disetujui / Dibatalkan) |
| 04 | **Pusat Informasi** | FAQ, alur peminjaman, dan fitur kirim pertanyaan ke admin |
| 05 | **Generator Surat Peminjaman** | Generate dan download surat permohonan otomatis dalam format PDF |

---

## 🛠️ Tech Stack

### Framework & Language
| Teknologi | Kegunaan |
|-----------|----------|
| **PHP + Laravel** | Bahasa & framework utama untuk logika bisnis dan routing |
| **Blade Template** | Engine templating Laravel untuk tampilan dinamis sisi server |
| **JavaScript** | Interaktivitas antarmuka pengguna di sisi client |

### Frontend
| Teknologi | Kegunaan |
|-----------|----------|
| **Tailwind CSS** | Framework CSS utility-first, responsif dan mobile-friendly |

### Database
| Teknologi | Kegunaan |
|-----------|----------|
| **Azure Database for PostgreSQL** | Database relasional cloud untuk data peminjaman |
| **Supabase Storage** | Penyimpanan objek cloud untuk file dan foto profil pengguna |

### DevOps & Deployment
| Teknologi | Kegunaan |
|-----------|----------|
| **Git + GitHub** | Version control dan kolaborasi tim |
| **GitHub Actions** | Otomatisasi CI/CD pipeline |
| **Docker** | Containerisasi aplikasi |
| **Azure Container Registry (ACR)** | Penyimpanan dan distribusi Docker image |
| **Azure App Service** | Hosting dan deployment aplikasi web production |

### Tools Pendukung
| Teknologi | Kegunaan |
|-----------|----------|
| **VS Code** | Code editor utama |
| **Composer** | Package manager PHP |
| **PEST PHP** | Framework testing untuk unit dan feature test |

---

## ⚙️ Prasyarat

Pastikan sistem kamu sudah memiliki:

- **PHP** >= 8.2
- **Composer** >= 2.x
- **Node.js** >= 18.x & npm
- **Docker** (untuk build image)
- **Git**
- Akun **Azure** (untuk deployment)
- **PostgreSQL** (lokal, atau gunakan SQLite untuk testing)

---

## 🚀 Instalasi Lokal

### 1. Clone Repository

```bash
git clone https://github.com/<username>/myits-sarpras.git
cd myits-sarpras
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Install Dependensi Frontend

```bash
npm install
npm run build
```

### 4. Salin File Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env` sesuai konfigurasi database lokal kamu (lihat bagian [Konfigurasi Environment](#-konfigurasi-environment)), lalu jalankan migrasi:

```bash
php artisan migrate
```

### 6. Jalankan Server Lokal

```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`.

---

## 🧪 Menjalankan Testing

Proyek ini menggunakan **PEST PHP** dengan database **SQLite in-memory** agar pengujian berjalan terisolasi tanpa bergantung pada Azure PostgreSQL.

### Jalankan Semua Test

```bash
php artisan test
```

atau menggunakan PEST secara langsung:

```bash
./vendor/bin/pest
```

---

## ☁️ Azure Setup

### 1. Azure Container Registry (ACR)

Repository untuk menyimpan dan mendistribusikan Docker Container Image.

```bash
# Login ke ACR
docker login myitssarprasregistry.azurecr.io \
  -u <ACR_USERNAME> \
  -p <ACR_PASSWORD>

# Build image
docker build -t myitssarprasregistry.azurecr.io/myits-sarpras:latest .

# Push image
docker push myitssarprasregistry.azurecr.io/myits-sarpras:latest
```

| Setting | Value |
|---------|-------|
| Registry Name | `myitssarprasregistry` |
| Resource Group | `rg-myitssarpras` |
| Autentikasi | Access Keys |

### 2. Azure App Service

Platform cloud tempat aplikasi web berjalan secara live.

| Setting | Value |
|---------|-------|
| Nama Web App | `myitssarpras-app` |
| Runtime | Docker Container |
| Source | Azure Container Registry |

### 3. Azure Database for PostgreSQL

| Setting | Value |
|---------|-------|
| Database Name | `myitssarpras` |
| Koneksi | SSL (wajib) |
| Data | User, ruangan, peminjaman, riwayat status |

### 4. Azure Environment Variables

Semua konfigurasi aplikasi (kredensial database, app key, dsb.) disimpan sebagai **Environment Variables** di Azure App Service — bukan di file `.env` yang di-push ke repo.

---

## 📁 Struktur Proyek (Ringkas)

```
myits-sarpras/
├── .github/
│   └── workflows/
│       └── deploy.yml          # GitHub Actions CI/CD pipeline
├── app/
│   ├── Http/Controllers/       # Controller Laravel
│   └── Models/                 # Model Eloquent (Peminjaman, Ruangan, User)
├── database/
│   └── migrations/             # Migrasi database
├── resources/
│   └── views/                  # Blade templates + Tailwind CSS
├── routes/
│   └── web.php                 # Routing aplikasi
├── tests/
│   ├── Unit/
│   │   ├── PeminjamanTest.php
│   │   └── RuanganTest.php
│   └── Feature/
│       ├── LoginTest.php
│       └── PeminjamanTest.php
├── Dockerfile
├── .env.example
└── README.md
```

---

## 👨‍💻 Kontributor

| Nama | NRP |
|------|-----|
| Alisha Rafimalia | 5026231202 |
| Sultan Alamsyah | 5026231188 |
| Astrid Meilendra | 5026231183 |

---

> **Pengembangan Sistem dan Operasi C — Institut Teknologi Sepuluh Nopember (ITS)**  
> Group 4 · 2026
