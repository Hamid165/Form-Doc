# Implementasi Fitur Laporan Availability System Ticketing

Fitur ini bertujuan untuk mendigitalkan "Formulir Availability System Ticketing" (FR.SM/TI/031.004/01-2019) ke dalam aplikasi web berbasis Laravel. Formulir ini digunakan untuk melaporkan ketersediaan perangkat ticketing di stasiun-stasiun setiap harinya.

## Pembagian Tugas (Job Desk untuk 2 Orang)

Untuk mempercepat pengembangan, fitur ini dibagi untuk 2 orang (Developer A dan Developer B).

### Developer A (Backend & Database)
Fokus pada struktur data, logika bisnis, dan integrasi backend.
- **Database & Migrations**: Membuat tabel `form_availabilities` (untuk data master laporan seperti Tanggal, DAOP/DIVRE, Total Stasiun, dan TTD Mengetahui) dan `form_availability_items` (untuk detail stasiun, RTS, jumlah perangkat, dan gangguan).
- **Models & Relationships**: Membuat model Eloquent `FormAvailability` dan `FormAvailabilityItem` beserta relasi `hasMany`, `belongsTo`, dan relasi ke `MasterSigner`.
- **Controllers & Routing**: Membuat `FormAvailabilityController` untuk menangani proses Create, Read, Update, Delete (CRUD).
- **Email Integration & Approval Flow**: Mengelola alur status (draft, dicetak, selesai/disetujui) dan mengirimkan laporan otomatis via email ke `it.helpdesk@kai.id` (misalnya setelah form di-ttd/disetujui).

### Developer B (Frontend & UI/UX)
Fokus pada tampilan antarmuka (User Interface) dan pengalaman pengguna saat mengisi form.
- **Konsistensi UI/UX**: Menggunakan **Tailwind CSS + Vite** dan **Alpine.js**, memastikan komponen, warna, dan sistem desain yang digunakan **sama dan konsisten** dengan form lainnya (merujuk pada `SYSTEM DESIGN.md`).
- **Blade Views (Form Input)**: Membuat halaman form input laporan (Create/Edit) yang rapi. Form detail stasiun dibuat dinamis (bisa `Add Row` / `Remove Row`).
- **Blade Views (Index & Show)**: Membuat halaman daftar laporan (tabel list laporan) dan halaman detail laporan untuk melihat form dan status persetujuannya (termasuk kolom ttd).
- **Form Validation (Client-Side)**: Menambahkan validasi form di sisi frontend (memastikan field wajib diisi, angka gangguan divalidasi).

---

## User Review (Feedback Terjawab)

> [!NOTE]
> 1. **Pembagian job desk:** Sudah sesuai.
> 2. **Tampilan (UI):** Dibuat sama seperti form lain menggunakan komponen yang ada (Tailwind CSS, Vite, Alpine.js) mengikuti pedoman `SYSTEM DESIGN.md`.
> 3. **Alur Persetujuan:** Membutuhkan TTD (Persetujuan) terlebih dahulu (oleh Senior Manager/Manager) sebelum dikirim, sehingga ditambahkan field `mengetahui_id` dan alur status.

---

## Proposed Changes

### Backend (Developer A)

#### [NEW] `database/migrations/xxxx_xx_xx_create_form_availabilities_table.php`
Tabel utama dengan field: `tanggal`, `daop_divre`, `total_stasiun`, `total_perangkat`, `mengetahui_id` (foreign key ke `master_signers`), dan `status` (enum: draft, dicetak, selesai).

#### [NEW] `database/migrations/xxxx_xx_xx_create_form_availability_items_table.php`
Tabel relasi (detail) menyimpan field: `form_availability_id`, `no`, `stasiun`, `rts`, `jumlah_perangkat`, `gangguan_jumlah`, `gangguan_menit`, `keterangan`.

#### [NEW] `app/Models/FormAvailability.php` & `app/Models/FormAvailabilityItem.php`
Model Eloquent untuk kedua tabel dengan namespace dan format penamaan yang sesuai dengan `SYSTEM DESIGN.md`.

#### [NEW] `app/Http/Controllers/FormAvailabilityController.php`
Logika untuk menyimpan dan mengelola data formulir, serta alur persetujuan dan pengiriman email.

#### [NEW] `app/Mail/AvailabilityReportMail.php`
Mailable class untuk mengirimkan laporan ke email `it.helpdesk@kai.id`.

### Frontend (Developer B)

#### [MODIFY] `routes/web.php`
Menambahkan rute-rute resource untuk `form-availability`. Update query pada route `/` (Dashboard) untuk mengakomodasi formulir baru.

#### [NEW] `resources/views/form-availability/index.blade.php`
Halaman daftar laporan dengan design konsisten (menyertakan badge status).

#### [NEW] `resources/views/form-availability/create.blade.php` & `edit.blade.php`
Halaman form wrapper yang memanggil `form.blade.php`.

#### [NEW] `resources/views/form-availability/form.blade.php`
Komponen form dinamis (Add/Remove Row) menggunakan Alpine.js dan input TomSelect yang di-custom.

#### [NEW] `resources/views/form-availability/show.blade.php`
Halaman detail untuk preview dokumen (menampilkan data laporan beserta form tanda tangan).

## Verification Plan

### Automated/Manual Tests
1. **Testing CRUD**: Memastikan data form beserta detail baris stasiun dan data TTD berhasil disimpan ke database.
2. **Testing UI Dinamis & Konsistensi**: Memastikan fitur "Tambah Stasiun" berjalan lancar dan tampilan 100% konsisten dengan standar di `SYSTEM DESIGN.md`.
3. **Testing Approval & Email**: Memastikan laporan hanya dikirim/bisa dicetak utuh jika sudah di-ttd/disetujui.
