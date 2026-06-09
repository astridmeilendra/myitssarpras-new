# myITS Sarpras (New) 🏛️💼

Sistem Informasi Manajemen Peminjaman Sarana dan Prasarana (Sarpras) Departemen Sistem Informasi, Institut Teknologi Sepuluh Nopember (ITS). Aplikasi ini dirancang untuk mempermudah civitas akademika dalam melakukan pencarian, pengecekan ketersediaan, serta pengajuan izin peminjaman ruangan dan fasilitas kampus secara efisien, transparan, dan terintegrasi.

---

## 🚀 Fitur Utama

Aplikasi myITS Sarpras dilengkapi dengan berbagai fitur interaktif untuk dua peran pengguna utama (User/Mahasiswa dan Admin):

### 🧑‍💻 Fitur Pengguna / Mahasiswa
* **Autentikasi Terintegrasi:** Fitur Sign In dan Sign Up yang aman untuk mengelola profil pengguna (`AppUser`).
* **Cari Ruangan & Filter Parsial:** Fitur pencarian ruangan secara real-time dengan panel filter aktif berdasarkan kapasitas, fasilitas, dan status ketersediaan.
* **Manajemen Peminjaman:** Alur pengajuan peminjaman sarpras yang dilengkapi dengan pengisian formulir detail agenda, penanggung jawab, serta unggah dokumen pendukung.
* **Riwayat Status Peminjaman:** Tracking status pengajuan peminjaman secara transparan melalui beberapa tahapan: *Konfirmasi, Dalam Proses, Selesai, Batal,* dan *Gagal*.
* **Pusat Bantuan & FAQ:** Menu interaktif untuk melihat daftar pertanyaan populer serta mengirim pertanyaan kustom langsung ke admin.

---

## 🛠️ Spesifikasi Teknologi

* **Backend Framework:** Laravel 12.61.1
* **Bahasa Pemrograman:** PHP 8.2.31
* **Database & Storage:** PostgreSQL terintegrasi dengan **Supabase** via custom `SupabaseHelper`.
* **Frontend Engine:** Blade Templates, Vite, Tailwind CSS / Bootstrap 5.
* **Testing Suite:** Pest / PHPUnit Testing.
* **Virtualization & Deployment:** Docker & Azure App Service (Linux-based Container).

---

## 💻 Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan project ini di lingkungan lokal (*local development*):

### Prasyarat (Prerequisites)
Pastikan perangkat Anda telah terinstal:
* PHP >= 8.2
* Composer
* Node.js & NPM
* Docker (Opsional, jika ingin menjalankan via container lokal)
