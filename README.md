# 🎓 SIM Magang - Sistem Informasi Manajemen Magang

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP Version">
  <img src="https://img.shields.io/badge/TailwindCSS-4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge" alt="License">
</p>

## 📋 Deskripsi

**SIM Magang** adalah aplikasi web modern berbasis Laravel yang dirancang untuk mempermudah pengelolaan dan manajemen program magang mahasiswa. Sistem ini memungkinkan mahasiswa, dosen pembimbing, dan administrator untuk berinteraksi dalam ekosistem yang terintegrasi untuk mengelola seluruh proses magang dari pendaftaran hingga evaluasi.

## ✨ Fitur Utama

- 🔐 **Multi-role Authentication**
  - Admin (Pengelola sistem)
  - Mahasiswa (Peserta magang)
  - Dosen (Pembimbing magang)

- 🏢 **Manajemen Lowongan Magang**
  - Pencatatan lowongan dari mitra industri
  - Informasi detail posisi dan persyaratan
  - Sistem aplikasi dan tracking status

- 📝 **Pengelolaan Pengajuan Magang**
  - Pengajuan magang oleh mahasiswa
  - Review dan approval oleh dosen pembimbing
  - Tracking status pengajuan real-time

- 📊 **Logging Kegiatan Harian**
  - Pencatatan aktivitas magang harian
  - Upload dokumentasi dan laporan
  - Review dan feedback dari pembimbing

- 🎯 **Sistem Feedback & Evaluasi**
  - Evaluasi mahasiswa terhadap program magang
  - Penilaian dosen terhadap mahasiswa
  - Rating system dengan skala 1-10 dan 1-5 bintang

- 📈 **Dashboard & Reporting**
  - Statistik dan visualisasi data magang
  - Laporan progress mahasiswa
  - Analytics untuk admin dan dosen

- 🤝 **Manajemen Mitra**
  - Database perusahaan/instansi mitra
  - Informasi kontak dan kerjasama
  - Tracking lowongan per mitra

## 🚀 Instalasi

### Prasyarat
- PHP 8.1 atau lebih tinggi
- Composer
- Node.js & NPM
- Database MySQL/MariaDB

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone https://github.com/username/sistem-informasi-magang.git
   cd sistem-informasi-magang
   ```

2. **Instalasi Dependensi**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   Konfigurasikan database dan setting lainnya di file `.env`

4. **Migrasi Database**
   ```bash
   php artisan migrate --seed
   ```

5. **Kompilasi Asset**
   ```bash
   npm run dev
   ```

6. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```

   Akses aplikasi melalui browser: `http://localhost:8000`

## 👥 User Roles & Credentials

### Default Login

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | - |
| Dosen | dosen@example.com | - |
| Mahasiswa | mahasiswa@example.com | - |

## 📝 Panduan Penggunaan

### Mahasiswa
- Mencari dan melamar lowongan magang
- Mengajukan proposal magang
- Mencatat kegiatan harian magang
- Upload laporan dan dokumentasi
- Memberikan feedback evaluasi

### Dosen
- Melihat mahasiswa bimbingan
- Review dan approve pengajuan magang
- Monitoring kegiatan mahasiswa
- Memberikan penilaian dan feedback
- Melihat progress mahasiswa

### Admin
- Mengelola data master (pengguna, mitra, periode)
- Mengelola lowongan magang
- Monitoring seluruh pengajuan
- Mengelola sistem feedback
- Membuat laporan dan analytics

## 🔧 Tech Stack

- **Backend**: Laravel 10.x
- **Frontend**: Tailwind CSS 4.x, Preline UI
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Sanctum
- **Icons**: FontAwesome 6.x, Phosphor Icons
- **DataTables**: Yajra Laravel DataTables

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan ikuti langkah berikut:

1. Fork repository ini
2. Buat branch baru (`git checkout -b feature/amazing-feature`)
3. Commit perubahan Anda (`git commit -m 'Add some amazing feature'`)
4. Push ke branch (`git push origin feature/amazing-feature`)
5. Buat Pull Request

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## 📞 Kontak

Jika Anda memiliki pertanyaan atau masukan, silakan hubungi kami di [admin@sim-magang.com](mailto:admin@sim-magang.com)

---

<p align="center">
  Made with ❤️ for Indonesian Education
</p>
