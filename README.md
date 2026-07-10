# Sistem Manajemen Formulir KAI

Sistem Manajemen Formulir berbasis web yang dibangun menggunakan **Laravel 13**. Repository ini berisi berbagai macam modul formulir (seperti Formulir Pencabutan Hak Akses, Formulir Pemeliharaan CCTV, dll) beserta fitur export data, sinkronisasi otomatis, dan manajemen data.

## Persyaratan Sistem

Sebelum memulai, pastikan komputer Anda telah terinstal perangkat lunak berikut:

- [PHP](https://www.php.net/downloads) (PHP Versi ≥ 8.3)
- [Composer](https://getcomposer.org/download/)
- [Node.js &amp; npm](https://nodejs.org/en/download/)
- Git

---

## Panduan Instalasi (Step-by-Step)

Ikuti langkah-langkah di bawah ini untuk menjalankan *project* ini di komputer lokal Anda:

### 1. Clone Repository

Buka Terminal / Command Prompt / Git Bash, lalu jalankan perintah berikut untuk mengunduh kode dari GitHub:

```bash
git clone https://github.com/Hamid165/formulir-kai.git
```

### 2. Masuk ke Folder Project

Arahkan terminal ke dalam folder *project* yang baru saja diunduh:

```bash
cd formulir-kai
```

### 3. Install Dependencies PHP (Composer)

Jalankan perintah ini untuk menginstal semua *library* PHP yang dibutuhkan Laravel:

```bash
composer install
```

### 4. Install Dependencies Node.js (NPM)

Jalankan perintah ini untuk menginstal semua *library* frontend (seperti TailwindCSS, AlpineJS, dll):

```bash
npm install
```

### 5. Setup File Environment (.env)

*Project* Laravel membutuhkan file `.env` untuk menyimpan konfigurasi (seperti koneksi database). Salin file bawaan `.env.example` dan ubah namanya menjadi `.env`.

Jika Anda menggunakan Windows (Command Prompt / PowerShell), jalankan:

```bash
copy .env.example .env
```

*(Untuk Mac/Linux, gunakan perintah `cp .env.example .env`)*

### 6. Generate Application Key

Jalankan perintah ini untuk menghasilkan kunci keamanan unik untuk aplikasi Anda:

```bash
php artisan key:generate
```

### 7. Konfigurasi Database (Opsional/Jika Diperlukan)

Buka file `.env` yang baru dibuat di *code editor* (seperti VS Code).
Secara default, Laravel menggunakan database `sqlite` atau `mysql`. Jika Anda menggunakan XAMPP/MySQL, pastikan pengaturan database Anda sudah benar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```

*(Jangan lupa buat database kosong dengan nama yang sesuai di phpMyAdmin sebelum lanjut ke langkah 8)*

### 8. Jalankan Migrasi Database

Jalankan perintah ini untuk membuat tabel-tabel yang dibutuhkan di dalam database:

```bash
php artisan migrate
```

*(Tambahkan `--seed` jika Anda memiliki data awalan/dummy: `php artisan migrate --seed`)*

---

## Menjalankan Aplikasi

Untuk menjalankan aplikasi ini secara lokal, Anda perlu **membuka 2 terminal yang berbeda** (karena backend PHP dan frontend aset berjalan secara bersamaan).

**Terminal 1 (Menjalankan Server PHP):**
Pastikan Anda berada di folder `formulir-kai`, lalu jalankan:

```bash
php artisan serve
```

*Aplikasi bisa diakses melalui browser di alamat: `http://127.0.0.1:8000`*

**Terminal 2 (Menjalankan Vite/Frontend):**
Buka tab terminal baru (pastikan juga berada di folder `formulir-kai`), lalu jalankan:

```bash
npm run dev
```

*Proses ini wajib dibiarkan berjalan agar CSS (Tailwind) dan JavaScript Anda ter-compile dengan baik setiap ada perubahan.*

---

🎉 **Selesai!** Aplikasi sudah siap digunakan dan dikembangkan lebih lanjut.
