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

## 👥 Struktur Tim

| Nama | NRP | Peran Utama |
|------|-----|-------------|
| **Alisha Rafimalia** | 5026231202 | Frontend Developer & Testing Engineer |
| **Sultan Alamsyah** | 5026231188 | Backend Developer & Database Engineer |
| **Astrid Meilendra** | 5026231183 | Frontend Developer & Testing Engineer |

### Pembagian Tanggung Jawab

**Alisha Rafimalia**
- DevOps: Konfigurasi GitHub Actions workflow (CI/CD pipeline), Dockerfile, push-pull image ke ACR, Azure App Service, Health Check, Rollback otomatis, monitoring via Azure Monitor & App Insights
- Fitur: Integrasi sistem Frontend-Backend, endpoint `GET /health` untuk verifikasi server

**Sultan Alamsyah**
- DevOps: Manajemen DB Migration (`php artisan migrate`) di Azure Cloud, unit testing backend API via PEST PHP
- Fitur: Arsitektur database PostgreSQL (ruangan, user, reservasi), logika bisnis Laravel (pencegahan double booking, API endpoints)

**Astrid Meilendra**
- DevOps: Jaring pengaman pertama di Local Developer, skenario pengujian fungsional PEST PHP, testing manual di VS Code
- Fitur: UI/UX dengan Blade Template + Tailwind, form pengajuan peminjaman, halaman riwayat, dashboard civitas akademika

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

## 🔧 Konfigurasi Environment

Salin `.env.example` ke `.env` dan isi variabel berikut:

```env
APP_NAME=MyITS-Sarpras
APP_ENV=local
APP_KEY=                        # Di-generate otomatis dengan php artisan key:generate
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database (PostgreSQL untuk production, SQLite untuk testing)
DB_CONNECTION=pgsql
DB_HOST=<azure-postgresql-host>
DB_PORT=5432
DB_DATABASE=myitssarpras
DB_USERNAME=<username>
DB_PASSWORD=<password>

# Supabase Storage
SUPABASE_URL=<supabase-project-url>
SUPABASE_KEY=<supabase-anon-key>

# Cache & Session
CACHE_STORE=database
SESSION_DRIVER=database
```

> **⚠️ Catatan:** Jangan commit file `.env` ke repository. Semua kredensial sensitif disimpan di **GitHub Secrets** untuk keperluan CI/CD.

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

### Hasil Testing

```
Tests:  23 passed (34 assertions)
Duration: 117s
```

### Test Suites yang Tersedia

| Suite | Cakupan |
|-------|---------|
| `Unit\PeminjamanTest` | Validasi model Peminjaman (fillable, primary key, nama tabel) |
| `Unit\RuanganTest` | Validasi model Ruangan (fillable, primary key, parsing fasilitas) |
| `Feature\LoginTest` | Autentikasi user dan admin, validasi input login |
| `Feature\PeminjamanTest` | Alur peminjaman, validasi input, cek ketersediaan ruangan |

### Contoh Test Cases

| No | Test Case | Expected Output | Status |
|----|-----------|-----------------|--------|
| 1 | Peminjaman memiliki fillable yang benar | `['userid', 'keterangan', 'dokumen']` | ✅ Passed |
| 9 | Halaman login dapat diakses | HTTP 200 | ✅ Passed |
| 12 | Login berhasil sebagai user biasa | Redirect ke home | ✅ Passed |
| 13 | Login berhasil sebagai admin | Redirect ke admin.dashboard | ✅ Passed |
| 16 | Peminjaman gagal — user belum login | HTTP 401 | ✅ Passed |
| 17 | Peminjaman gagal — ruangan tidak ada | HTTP 422 | ✅ Passed |
| 20 | Cek ketersediaan ruangan berhasil | `available: true` | ✅ Passed |

---

## 🔄 Alur CI/CD Pipeline

```
┌─────────────────────────────────────────────────────────────────────┐
│                         DEVELOPER                                    │
│  Tulis kode → Run Testing Lokal → Git Commit & Push ke branch main  │
└──────────────────────────────┬──────────────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────────────┐
│                    GITHUB ACTIONS — CI                               │
│                                                                      │
│  1. Trigger: push ke branch main                                     │
│  2. Run PEST Tests (SQLite in-memory)                                │
│     ├── ✅ Test Pass → lanjut ke Docker Build                        │
│     └── ❌ Test Fail → Notifikasi ke Dev Team (Discord/Slack)        │
│  3. Docker Build & Push ke Azure Container Registry (ACR)            │
│     ├── ✅ Build Success → lanjut ke CD                              │
│     └── ❌ Build Fail → Notifikasi ke Dev Team                       │
└──────────────────────────────┬──────────────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────────────┐
│                    GITHUB ACTIONS — CD                               │
│                                                                      │
│  4. Deploy Container ke Azure App Service                            │
│  5. Health Check endpoint GET /health                                │
│     ├── ✅ Healthy → Deployment selesai, aplikasi live               │
│     └── ❌ Unhealthy → Automatic Rollback ke versi sebelumnya        │
└──────────────────────────────┬──────────────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────────────┐
│                  OPERATION & MONITORING                              │
│                                                                      │
│  6. Performance & Error Monitoring (Azure Monitor + App Insights)    │
│  7. Feedback / Laporan Bug ke Tim                                    │
│  8. Iterasi Sprint Baru                                              │
└─────────────────────────────────────────────────────────────────────┘
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

## 🔐 Workflow GitHub Actions

### Setup GitHub Secrets

Sebelum pipeline bisa berjalan, tambahkan secrets berikut di **Settings → Secrets and Variables → Actions**:

| Secret | Keterangan |
|--------|------------|
| `ACR_USERNAME` | Username Azure Container Registry |
| `ACR_PASSWORD` | Password Azure Container Registry |
| `AZURE_WEBAPP_NAME` | Nama Azure App Service |
| `APP_KEY` | Laravel application key |
| `APP_ENV` | Environment (`production`) |
| `APP_URL` | URL aplikasi live |
| `DB_CONNECTION` | Jenis koneksi database |
| `DB_HOST` | Host Azure PostgreSQL |
| `DB_DATABASE` | Nama database |
| `DB_USERNAME` | Username database |
| `DB_PASSWORD` | Password database |
| `CACHE_STORE` | Driver cache |

### File `.github/workflows/deploy.yml`

```yaml
name: CI/CD Pipeline MyITS Sarpras

on:
  push:
    branches:
      - main

jobs:
  # ─── STAGE 1: Run PEST Tests ───────────────────────────────────────
  test:
    name: Run Pest Tests
    runs-on: ubuntu-latest

    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
          extensions: pdo, pdo_sqlite, sqlite3

      - name: Install Composer dependencies
        run: composer install --no-interaction --prefer-dist --optimize-autoloader

      - name: Copy .env for testing
        run: |
          cp .env.example .env
          php artisan key:generate

      - name: Run PEST Tests
        run: ./vendor/bin/pest --no-coverage

  # ─── STAGE 2: Build & Push Docker Image ───────────────────────────
  build-and-push:
    name: Build and Push Docker Image
    runs-on: ubuntu-latest
    needs: test

    steps:
      - name: Checkout code
        uses: actions/checkout@v4

      - name: Login to Azure Container Registry
        uses: docker/login-action@v3
        with:
          registry: myitssarprasregistry.azurecr.io
          username: ${{ secrets.ACR_USERNAME }}
          password: ${{ secrets.ACR_PASSWORD }}

      - name: Build Docker image
        run: |
          docker build -t myitssarprasregistry.azurecr.io/myits-sarpras:${{ github.sha }} .
          docker tag myitssarprasregistry.azurecr.io/myits-sarpras:${{ github.sha }} \
                     myitssarprasregistry.azurecr.io/myits-sarpras:latest

      - name: Push Docker image to ACR
        run: |
          docker push myitssarprasregistry.azurecr.io/myits-sarpras:${{ github.sha }}
          docker push myitssarprasregistry.azurecr.io/myits-sarpras:latest

  # ─── STAGE 3: Deploy to Azure App Service ─────────────────────────
  deploy:
    name: Deploy to Azure App Service
    runs-on: ubuntu-latest
    needs: build-and-push

    steps:
      - name: Deploy container to Azure App Service
        uses: azure/webapps-deploy@v3
        with:
          app-name: ${{ secrets.AZURE_WEBAPP_NAME }}
          images: myitssarprasregistry.azurecr.io/myits-sarpras:${{ github.sha }}

      - name: Health Check
        run: |
          sleep 30
          STATUS=$(curl -s -o /dev/null -w "%{http_code}" ${{ secrets.APP_URL }}/health)
          if [ "$STATUS" != "200" ]; then
            echo "Health check failed with status $STATUS"
            exit 1
          fi
          echo "Health check passed!"
```

### Dockerfile

```dockerfile
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    nodejs \
    npm \
    postgresql-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql gd zip bcmath

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction
RUN npm ci && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
```

---

## 📊 Monitoring

Setelah deployment, performa dan error aplikasi dipantau menggunakan:

- **Azure Monitor** — Memantau ketersediaan, latensi, dan resource usage
- **Azure Application Insights** — Tracking error, request, dan dependency secara detail

Dashboard monitoring dapat diakses melalui [Azure Portal](https://portal.azure.com) → Resource Group `rg-myitssarpras` → `monitor-myitssarpras`.

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

| Nama | NRP | GitHub |
|------|-----|--------|
| Alisha Rafimalia | 5026231202 | [@alisha](https://github.com) |
| Sultan Alamsyah | 5026231188 | [@sultan](https://github.com) |
| Astrid Meilendra | 5026231183 | [@astrid](https://github.com) |

---

> **Pengembangan Sistem dan Operasi C — Institut Teknologi Sepuluh Nopember (ITS)**  
> Group 4 · 2026
