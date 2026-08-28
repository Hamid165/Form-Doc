# Modul Formulir Pengujian Infrastruktur

Modul baru untuk aplikasi Form-Doc, dibuat mengikuti pola modul yang sudah ada
(`form-cctv`, `form-it-business-request`, dst) dan sesuai template pada
`FR.SM/TI/025.002/10-2020 - FORMULIR PENGUJIAN INFRASTRUKTUR`.

## Cara Instalasi

1. **Salin file** ke dalam folder project Laravel Anda, pertahankan struktur
   folder berikut:
   - `app/Models/FormPengujianInfrastruktur/` (2 file)
   - `app/Http/Controllers/FormPengujianInfrastruktur/` (1 file)
   - `database/migrations/` (2 file migrasi baru)
   - `resources/views/form-pengujian-infrastruktur/` (5 file blade)

2. **Gabungkan (merge) manual** dua file berikut, karena isinya adalah versi
   project Anda yang sudah ditambah kode untuk modul baru — jangan langsung
   menimpa (overwrite) begitu saja jika Anda sudah mengubah kedua file ini
   sejak upload terakhir:
   - `routes/web.php` — ditambahkan: import controller, resource route
     `form-pengujian-infrastruktur`, penghitungan dashboard & katalog formulir.
   - `database/seeders/DatabaseSeeder.php` — ditambahkan entri `FormTemplate`
     baru supaya formulir muncul di halaman Katalog Formulir.

3. **Jalankan migrasi:**
   ```bash
   php artisan migrate
   ```

4. **Jalankan seeder** supaya formulir muncul di Katalog Formulir:
   ```bash
   php artisan db:seed
   ```
   (atau jalankan ulang `php artisan db:seed --class=DatabaseSeeder` bila
   seeder lain tidak perlu diulang)

5. Buka `/formulir` — kartu **Formulir Pengujian Infrastruktur** akan
   muncul di kategori **Terbatas** (silakan ubah ke `Umum`/`Lainnya` di
   seeder atau lewat fitur edit metadata jika kategori yang dimaksud
   berbeda).

## Struktur Data

**Tabel `form_pengujian_infrastrukturs`** (header formulir):
- `no_ref`, `tanggal`, `business_area`
- `tanggal_pengujian`, `objek_pengujian`, `pelaksana_pengujian`
- `deskripsi_pengujian` (bagian I)
- `analisa_kesimpulan` (bagian "Analisa Hasil dan Kesimpulan")
- `kota_tanggal`, `mengetahui_nama`, `mengetahui_jabatan` (blok tanda tangan)

**Tabel `form_pengujian_infrastruktur_items`** (baris tabel "Analisa & Tindak
Lanjut", relasi `hasMany` ke header):
- `no`, `rencana_pengujian`, `hasil` (`OK` / `Not OK`), `keterangan`

## Fitur

- CRUD lengkap (index, create, edit, show, delete) mengikuti pola & gaya
  visual modul lain (kop surat KAI, kategori berwarna, tombol aksi, dsb).
- Tabel "Rencana Pengujian" dengan baris dinamis (tambah/hapus baris via
  tombol **+ Tambah Baris**), mengikuti pola yang dipakai pada modul CCTV.
- Halaman *show* menggunakan ulang `form.blade.php` dalam mode baca-saja
  (read-only), sama seperti modul IT Business Request.

## Catatan / Asumsi

- Kategori formulir di-set ke **Terbatas** secara default (nomor dokumen,
  tanggal, dan versi mengikuti data pada template gambar Anda:
  `FR.SM/TI/025.002/10-2020`, 12 Oktober 2020, versi 002-2020). Silakan
  sesuaikan bila kategori aslinya berbeda.
- Field "Pelaksana Pengujian" digunakan baik pada bagian atas formulir
  maupun pada blok tanda tangan bawah (nama yang sama).
