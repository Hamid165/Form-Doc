# Implementasi Fitur Laporan Availability System Ticketing

Fitur ini bertujuan untuk mendigitalkan "Formulir Availability System Ticketing" (FR.SM/TI/031.004/01-2019) ke dalam aplikasi web berbasis Laravel. Formulir ini digunakan untuk melaporkan ketersediaan perangkat ticketing di stasiun-stasiun setiap harinya.

## Pembagian Tugas (Job Desk untuk 2 Orang)

Untuk mempercepat pengembangan, fitur ini dibagi untuk 2 orang (Developer A dan Developer B).

### Developer A (Backend & Database)
Fokus pada struktur data, logika bisnis, dan integrasi backend.
- **Database & Migrations**: Membuat tabel `availability_reports` (untuk data master laporan seperti Tanggal, DAOP/DIVRE, Total Stasiun, dsb) dan `availability_report_details` (untuk detail stasiun, RTS, jumlah perangkat, dan gangguan).
- **Models & Relationships**: Membuat model Eloquent `AvailabilityReport` dan `AvailabilityReportDetail` beserta relasi `hasMany` dan `belongsTo`.
- **Controllers & Routing**: Membuat `AvailabilityReportController` untuk menangani proses Create, Read, Update, Delete (CRUD).
- **Email Integration / Schedulers**: Membuat fitur agar laporan otomatis dikirimkan via email ke `it.helpdesk@kai.id` (misalnya menggunakan Laravel Mail dan cron job / task scheduling harian jam 10.00).
- **API (Opsional)**: Menyediakan endpoint API jika frontend akan menggunakan Vue/React atau AJAX.

### Developer B (Frontend & UI/UX)
Fokus pada tampilan antarmuka (User Interface) dan pengalaman pengguna saat mengisi form.
- **Blade Views (Form Input)**: Membuat halaman form input laporan (Create/Edit) menggunakan Blade (HTML/CSS/JS) yang rapi dan responsif. Form detail stasiun dibuat dinamis (bisa `Add Row` / `Remove Row`).
- **Blade Views (Index & Show)**: Membuat halaman daftar laporan (tabel list laporan) dan halaman detail laporan untuk melihat laporan yang sudah disubmit.
- **Form Validation (Client-Side)**: Menambahkan validasi form di sisi frontend (memastikan field wajib diisi, angka gangguan divalidasi).
- **Export to PDF/Excel (Opsional)**: Mengatur layout cetak/export agar menyerupai format asli formulir fisik jika ingin didownload atau dicetak.

---

## User Review Required

> [!IMPORTANT]
> Mohon konfirmasinya untuk beberapa hal berikut sebelum eksekusi dimulai:
> 1. Apakah pembagian job desk (Backend dan Frontend) di atas sudah sesuai dengan kemampuan tim Anda? Atau Anda ingin membaginya berdasarkan modul (misal: Dev A mengerjakan modul Input, Dev B mengerjakan modul Export & Email)?
> 2. Untuk tampilan (UI), apakah menggunakan framework CSS tertentu seperti Bootstrap, Tailwind CSS, atau custom Vanilla CSS?
> 3. Apakah laporan ini perlu proses persetujuan (approval/mengetahui) secara digital oleh "Senior Manager/Manager" (seperti di form fisik) sebelum bisa dikirim ke email?

## Proposed Changes

### Backend (Developer A)

#### [NEW] `database/migrations/xxxx_xx_xx_create_availability_reports_table.php`
Tabel utama menyimpan field: `tanggal`, `daop_divre`, `total_stasiun`, `total_perangkat`, `created_by`, dll.

#### [NEW] `database/migrations/xxxx_xx_xx_create_availability_report_details_table.php`
Tabel relasi (detail) menyimpan field: `report_id`, `stasiun`, `rts`, `jumlah_perangkat`, `gangguan_jumlah`, `gangguan_menit`, `keterangan`.

#### [NEW] `app/Models/AvailabilityReport.php` & `app/Models/AvailabilityReportDetail.php`
Model Eloquent untuk kedua tabel.

#### [NEW] `app/Http/Controllers/AvailabilityReportController.php`
Logika untuk menyimpan dan mengelola data formulir.

#### [NEW] `app/Mail/AvailabilityReportMail.php`
Mailable class untuk mengirimkan laporan ke email `it.helpdesk@kai.id`.

### Frontend (Developer B)

#### [MODIFY] `routes/web.php`
Menambahkan rute-rute resource untuk `availability-reports`.

#### [NEW] `resources/views/availability_reports/index.blade.php`
Halaman daftar laporan.

#### [NEW] `resources/views/availability_reports/create.blade.php` & `edit.blade.php`
Halaman form input yang dinamis (bisa tambah baris untuk detail stasiun).

#### [NEW] `resources/views/availability_reports/show.blade.php`
Halaman untuk melihat detail data per-laporan yang menyerupai form aslinya.

## Verification Plan

### Automated/Manual Tests
1. **Testing CRUD**: Memastikan data form beserta detail baris stasiun berhasil disimpan ke database dan ditampilkan kembali dengan benar.
2. **Testing UI Dinamis**: Memastikan fitur "Tambah Stasiun" (Add Row) pada form berjalan dengan lancar tanpa error Javascript.
3. **Testing Email**: Mengirimkan email dummy untuk mensimulasikan cron job / pengiriman laporan ke `it.helpdesk@kai.id`.
