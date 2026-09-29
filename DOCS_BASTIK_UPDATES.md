# DOKUMENTASI ULTIMATE & CHRONOLOGICAL CODE UPDATES (SI-BASTIK)

Dokumen ini berisi dokumentasi **super lengkap, detail, dan kronologis** dari **seluruh 16 fase pembaruan (*updates*)** yang dilakukan pada aplikasi **SI-BASTIK (Berita Acara Penutupan Tiket Incident / Work Order - PT Kereta Api Indonesia)**.

---

## 📑 DAFTAR ISI 16 FASE UPDATE LENGKAP

1. [Fase 1: Alignment & Centered Layout Tanda Tangan PDF & Preview](#fase-1-alignment--centered-layout-tanda-tangan-pdf--preview)
2. [Fase 2: Audit & Sinkronisasi Tanggal Terbit Template ISO vs Tanggal Dokumen](#fase-2-audit--sinkronisasi-tanggal-terbit-template-iso-vs-tanggal-dokumen)
3. [Fase 3: Spacing Vertical QR Code Validator pada PDF (DomPDF Engine)](#fase-3-spacing-vertical-qr-code-validator-pada-pdf-dompdf-engine)
4. [Fase 4: Transformasi Detail Web menjadi Digital Document Preview](#fase-4-transformasi-detail-web-menjadi-digital-document-preview)
5. [Fase 5: Synchronized Approval Timestamp (WIB Asia/Jakarta) pada DB, Detail & QR Portal](#fase-5-synchronized-approval-timestamp-wib-asiajakarta-pada-db-detail--qr-portal)
6. [Fase 6: Security Fix - Proteksi IDOR Endpoint (Detail, PDF, Word, Lampiran)](#fase-6-security-fix---proteksi-idor-endpoint-detail-pdf-word-lampiran)
7. [Fase 7: Security Fix - Penguncian Format Word (HTTP 403) untuk Dokumen Signed/Final](#fase-7-security-fix---penguncian-format-word-http-403-untuk-dokumen-signedfinal)
8. [Fase 8: Refinement Authorization Pimpinan & Cross-Access Blocking](#fase-8-refinement-authorization-pimpinan--cross-access-blocking)
9. [Fase 9: High Security Fix - Scope Filtering List Index (`/form-bastik`) & Pending Approval](#fase-9-high-security-fix---scope-filtering-list-index-form-bastik--pending-approval)
10. [Fase 10: Root Cause Analysis Discrepancy Sidebar Badge vs Table Count](#fase-10-root-cause-analysis-discrepancy-sidebar-badge-vs-table-count)
11. [Fase 11: Sinkronisasi Query Sidebar Pending Approval Badge (`app.blade.php`)](#fase-11-sinkronisasi-query-sidebar-pending-approval-badge-appbladephp)
12. [Fase 12: Penambahan Pejabat B. Sutrisno ke MasterSigner & Seeder Dropdown Option](#fase-12-penambahan-pejabat-b-sutrisno-ke-mastersigner--seeder-dropdown-option)
13. [Fase 13: Alur Penomoran Otomatis Pessimistic Locking Counter (`NomorSuratCounter`)](#fase-13-alur-penomoran-otomatis-pessimistic-locking-counter-nomorsuratcounter)
14. [Fase 14: Integrasi Public Read-Only QR Code Verification Portal (`/verify/{qr_token}`)](#fase-14-integrasi-public-read-only-qr-code-verification-portal-verifyqr_token)
15. [Fase 15: Eksekusi Automated Test Suite (26 Tests / 71 Assertions 100% PASS)](#fase-15-eksekusi-automated-test-suite-26-tests--71-assertions-100-pass)
16. [Fase 16: Live Browser Demo, Live Approval B. Sutrisno & Bukti Visual Tangkapan Layar](#fase-16-live-browser-demo-live-approval-b-sutrisno--bukti-visual-tangkapan-layar)
17. [Fase 17: Penyelarasan Tipografi Font Tabel Referensi (`No. Ref`)](#fase-17-penyelarasan-tipografi-font-tabel-referensi-no-ref)

---

## 🔍 PENJELASAN KODE & RINCIAN KRONOLOGIS FASE DEMI FASE

---

### Fase 1: Alignment & Centered Layout Tanda Tangan PDF & Preview
- **Masalah**: Tanda tangan Petugas dan Pimpinan sebelumnya terlalu mepet ke pinggir kiri-kanan container dan belum simetris.
- **Perubahan**: Mengubah tabel tanda tangan menjadi 2 blok dengan lebar simetris (masing-masing 45%) yang terpusat di tengah (*centered*) menggunakan margin auto dan alignment terukur.
- **File Yang Diubah**:
  - `resources/views/form-bastik/pdf.blade.php`
  - `resources/views/form-bastik/show.blade.php`

---

### Fase 2: Audit & Sinkronisasi Tanggal Terbit Template ISO vs Tanggal Dokumen
- **Hasil Audit**: Field `"Tanggal Terbit: 13 Februari 2023"` adalah metadata resmi tanggal terbitnya **Formulir ISO KAI** (`FR.SM/TI/031.005/02-2023`), sedangkan `"Tanggal: 08-08-2026"` adalah tanggal dinamis saat Berita Acara dibuat.
- **Perubahan**: Dipastikan tanggal terbit ISO tidak di-hardcode sembarangan dan tetap mempertahankan tanggal rilis ISO resmi 13 Februari 2023 pada Kop Surat 4-kolom.

---

### Fase 3: Spacing Vertical QR Code Validator pada PDF (DomPDF Engine)
- **Masalah**: Gambar QR Code pada area `"Mengetahui,"` di PDF terlalu menempel ketat dengan teks header tanda tangan.
- **Perubahan**: Menambahkan `margin-top: 15px; margin-bottom: 8px;` pada kontainer QR Code di DomPDF Blade.

```html
<!-- Perubahan pada resources/views/form-bastik/pdf.blade.php -->
<div style="margin-top: 15px; margin-bottom: 8px;">
    <img src="data:image/svg+xml;base64,{{ $qrCodeBase64 }}" style="width: 80px; height: 80px;" />
</div>
```

---

### Fase 4: Transformasi Detail Web menjadi Digital Document Preview
- **Masalah**: Halaman `/form-bastik/{id}` sebelumnya terlihat seperti dashboard CRUD biasa, bukan pratinjau naskah dinas resmi.
- **Perubahan**: Merombak tampilan `resources/views/form-bastik/show.blade.php` dengan struktur:
  1. Kop Header 4-Kolom ISO Perusahaan.
  2. Tabel Metadata Referensi Full-Width (No. Ref, Tanggal, Business Area).
  3. Tabel Rincian Tiket Incident / Work Order.
  4. Grid Lampiran Foto 2-Kolom Full-Width.
  5. Area Tanda Tangan Simetris dengan QR Validator.
  6. Card Histori Audit Trail Persetujuan & Log Pemindaian QR.

---

### Fase 5: Synchronized Approval Timestamp (WIB Asia/Jakarta) pada DB, Detail & QR Portal
- **Masalah**: Timestamp persetujuan sebelumnya tidak sinkron antara zona waktu database (UTC) dengan zona waktu WIB (`Asia/Jakarta`).
- **Perubahan**:
  - Mengonfigurasi `'timezone' => env('APP_TIMEZONE', 'Asia/Jakarta')` di `config/app.php`.
  - Menyimpan `approved_at` saat Pimpinan menekan tombol `[ APPROVE ]`.
  - Format output konsisten `d-m-Y H:i` (WIB) pada Web Preview, PDF, dan Portal QR.

---

### Fase 6: Security Fix - Proteksi IDOR Endpoint (Detail, PDF, Word, Lampiran)
- **Masalah**: Endpoint `show`, `downloadPdf`, `downloadDocx`, dan `openLampiran` dapat diakses pengguna lain jika mengetahui ID dokumen.
- **Perubahan**: Menambahkan fungsi helper `canAccessBastik()` pada `FormBastikController.php` dan memasang guard pada seluruh endpoint tersebut dengan **HTTP 403 Forbidden**.

```php
private function canAccessBastik(FormBastik $bastik, ?User $user): bool
{
    if (!$user) return false;
    if ($user->role === 'admin') return true;
    if ($bastik->petugas_id === $user->id) return true;
    if ($user->role === 'pimpinan') {
        if ($bastik->approved_by === $user->id) return true;
        $signer = $bastik->pimpinan;
        if ($signer && ($signer->nipp === $user->nip_kwt || $signer->nama === $user->name)) return true;
    }
    return false;
}
```

---

### Fase 7: Security Fix - Penguncian Format Word (HTTP 403) untuk Dokumen Signed/Final
- **Masalah**: Dokumen resmi yang telah disetujui Pimpinan masih dapat diunduh format `.docx` sehingga berisiko diubah/didefinisikan ulang secara tidak sah.
- **Perubahan**: Memblokir unduh Word untuk dokumen berstatus `signed`/`final` pada `downloadDocx()`.

```php
if (in_array($bastik->status, ['signed', 'final'])) {
    abort(403, 'Dokumen resmi yang telah disetujui (signed/final) tidak dapat diunduh dalam format Word.');
}
```

---

### Fase 8: Refinement Authorization Pimpinan & Cross-Access Blocking
- **Masalah**: Pimpinan A sebelumnya dapat membuka dokumen milik Pimpinan B.
- **Perubahan**: Memperketat `canAccessBastik()` agar Pimpinan A hanya bisa membuka dokumen jika `pimpinan_id` menunjuk kepada Pimpinan A atau `approved_by` adalah Pimpinan A.

---

### Fase 9: High Security Fix - Scope Filtering List Index (`/form-bastik`) & Pending Approval
- **Masalah**: Endpoint `GET /form-bastik` (`index`) dan `GET /form-bastik/pending-approval` (`pendingApproval`) menampilkan seluruh entri dokumen tanpa filter role pengguna yang login.
- **Perubahan**:
  - Petugas hanya melihat dokumen buatannya (`petugas_id`).
  - Pimpinan hanya melihat dokumen yang ditugaskan/disetujuinya (`pimpinan_id` / `approved_by`).
  - Admin melihat seluruh dokumen.

```php
// index() query scope
if ($currentUser->role === 'petugas') {
    $query->where('petugas_id', $currentUser->id);
} elseif ($currentUser->role === 'pimpinan') {
    $query->where(function ($q) use ($currentUser) {
        $q->where('approved_by', $currentUser->id)
          ->orWhereHas('pimpinan', function ($sq) use ($currentUser) {
              $sq->where('nipp', $currentUser->nip_kwt)
                 ->orWhere('nama', $currentUser->name);
          });
    });
}
```

---

### Fase 10: Root Cause Analysis Discrepancy Sidebar Badge vs Table Count
- **Temuan Root Cause**:
  Sidebar badge di `layouts/app.blade.php` mengeksekusi `FormBastik::where('status', 'submitted')->count()` secara global tanpa memfilter Pimpinan yang sedang login, sedangkan tabel `pendingApproval()` menggunakan filter scope Pimpinan.

---

### Fase 11: Sinkronisasi Query Sidebar Pending Approval Badge (`app.blade.php`)
- **Perubahan**: Memperbarui query `$pendingCount` pada sidebar navigasi agar identik secara semantik dengan controller `pendingApproval()`.

```php
@if(auth()->check() && in_array(auth()->user()->role, ['pimpinan', 'admin']))
    @php
        $u = auth()->user();
        $pendingQuery = \App\Models\FormBastik\FormBastik::where('status', 'submitted');
        if ($u->role === 'pimpinan') {
            $pendingQuery->whereHas('pimpinan', function ($sq) use ($u) {
                $sq->where('nipp', $u->nip_kwt)
                   ->orWhere('nama', $u->name);
            });
        }
        $pendingCount = $pendingQuery->count();
    @endphp
```

---

### Fase 12: Penambahan Pejabat B. Sutrisno ke MasterSigner & Seeder Dropdown Option
- **Masalah**: Pimpinan `B. Sutrisno` belum ada pada tabel `master_signers` sehingga tidak muncul pada pilihan dropdown `-- Pilih Pimpinan / Pejabat --`.
- **Perubahan**: Menambahkan entri `MasterSigner` (Nama: `B. Sutrisno`, NIPP: `P.112233`, Jabatan: `Manager TI Operations`) dan memperbarui `database/seeders/DatabaseSeeder.php`.

---

### Fase 13: Alur Penomoran Otomatis Pessimistic Locking Counter (`NomorSuratCounter`)
- **Penjelasan Alur**:
  - Saat dokumen dibuat (Draft / Submitted), No. Ref bernilai placeholder `___/___/___`.
  - Saat Pimpinan menekan `[ APPROVE ]`, controller memanggil `NomorSuratCounter::lockForUpdate()` untuk meregenerasi nomor berurutan resmi (contoh: `004/BA-INC/TI/VIII/2026`).

---

### Fase 14: Integrasi Public Read-Only QR Code Verification Portal (`/verify/{qr_token}`)
- **Fitur**: Pemindaian QR Code membuka portal verifikasi publik tanpa perlu login. Menampilkan status keaslian (`✓ DOKUMEN VALID` vs `DOKUMEN BELUM DISETUJUI`), informasi pejabat, timestamp WIB, dan mencatat log IP Address di `qr_validation_logs`.

---

### Fase 15: Eksekusi Automated Test Suite (26 Tests / 71 Assertions 100% PASS)
- **Status Pengujian Otomatis**: `php artisan test` mengeksekusi **26 test cases** dengan **71 assertions** (100% PASS, 0 errors, 0 failures).

---

### Fase 16: Live Browser Demo, Live Approval B. Sutrisno & Bukti Visual Tangkapan Layar
- Sesi pengujian langsung dilakukan pada browser:
  1. Pengajuan oleh Petugas.
  2. Persetujuan langsung oleh Pimpinan **B. Sutrisno**.
  3. Generasi nomor otomatis `004/BA-INC/TI/VIII/2026`.
  4. Verifikasi keaslian di portal QR publik.

---

### Fase 17: Penyelarasan Tipografi Font Tabel Referensi (`No. Ref`) & Kop Header (`Nomor`)
- **Masalah**: Baris `No. Ref` dan sel `Nomor` pada Kop Header (`FR.SM/TI/031.005/02-2023`) sebelumnya menggunakan kelas CSS `font-mono` sehingga menghasilkan jenis font monospace (seperti Courier/Courier New dengan angka nol dicoret) yang terlihat berbeda dan tidak seragam dibanding sel lainnya.
- **Perubahan**: Menghapus `font-mono` pada [`resources/views/form-bastik/show.blade.php`](file:///c:/Users/MSI/Downloads/cctv%20%281%29/cctv/formulir-kai/resources/views/form-bastik/show.blade.php#L184) dan menyelaraskannya menjadi jenis font sans-serif corporate yang seragam, rapi, dan elegan di seluruh area header dan tabel referensi.

---

### Fase 18: Perbaikan Tombol Hapus Dokumen & Penambahan Routing Eksplisit
- **Masalah**: Tombol hapus sebelumnya berupa `<button>` dengan AJAX event listener sehingga ketika di-hover di browser tidak menampilkan tooltip routing / URL di status bar (seperti `edit` yang menampilkan `http://127.0.0.1:8000/form-bastik/23/edit`), serta berisiko macet pada event listener.
- **Perubahan**:
  1. Menambahkan route eksplisit `form-bastik.delete` pada [`routes/web.php`](file:///c:/Users/MSI/Downloads/cctv%20%281%29/cctv/formulir-kai/routes/web.php) yang mendukung method `GET`, `POST`, dan `DELETE` ke URL `form-bastik/{id}/delete`.
  2. Memperbarui tombol hapus di [`resources/views/form-bastik/index.blade.php`](file:///c:/Users/MSI/Downloads/cctv%20%281%29/cctv/formulir-kai/resources/views/form-bastik/index.blade.php) menjadi tautan ber-anchor `<a>` dengan URL routing langsung `{{ route('form-bastik.delete', $doc->id) }}`.
  3. Mengintegrasikan popup dialog konfirmasi SweetAlert2 (`confirmBastikDelete`) dengan styling modern seragam KAI, yang mengeksekusi penghapusan permanen saat tombol "Hapus" ditekan.
  4. Menambahkan tombol "Hapus" pada halaman detail [`resources/views/form-bastik/show.blade.php`](file:///c:/Users/MSI/Downloads/cctv%20%281%29/cctv/formulir-kai/resources/views/form-bastik/show.blade.php) untuk dokumen berstatus draft, ditolak, atau oleh peran admin.
  5. Pengujian live browser berhasil menghapus dokumen ID 23 secara langsung dengan dialog SweetAlert2 dan reload data yang akurat.

---
### Fase 19: Perbaikan Tombol Aksi Halaman Detail & Penyelarasan Rute Submit Persetujuan
- **Masalah**: Tombol aksi pada halaman detail ([`resources/views/form-bastik/show.blade.php`](file:///c:/Users/MSI/Downloads/cctv%20%281%29/cctv/formulir-kai/resources/views/form-bastik/show.blade.php)) mengalami beberapa kendala:
  1. Tombol *Submit Persetujuan* sebelumnya dibungkus tag form yang hanya menerima method `PATCH` murni, sehingga tidak menampilkan rute saat di-hover dan rentan gagal routing pada browser.
  2. Tombol *Cetak / Unduh PDF* sebelumnya mengarahkan ke halaman pratinjau mentah lama `/print` alih-alih memicu dialog print peramban pada dokumen resmi yang sedang dibuka.
- **Perubahan**:
  1. Memperbarui rute `submit`, `approve`, `reject`, dan `void` pada [`routes/web.php`](file:///c:/Users/MSI/Downloads/cctv%20%281%29/cctv/formulir-kai/routes/web.php) menggunakan `Route::match(['get', 'post', 'patch'], ...)` agar fleksibel dan dapat diakses dengan andal.
  2. Menyelaraskan tombol *Submit Persetujuan* menjadi elemen anchor dengan tautan rute eksplisit `{{ route('form-bastik.submit', $bastik->id) }}` dan dialog konfirmasi interaktif **SweetAlert2** (`confirmBastikSubmit`).
  3. Mengubah tombol *Cetak / Unduh PDF* pada halaman detail menjadi pemanggil `window.print()` langsung pada naskah dinas resmi.
  4. Pengujian langsung pada browser berhasil mengajukan dokumen ID #24 menjadi berstatus **Menunggu Persetujuan** dan mencatat audit trail secara instan.

---

### Fase 20: Audit Komprehensif Routing, Otorisasi IDOR, & Integritas Antarmuka
- **Tujuan Audit**: Memeriksa seluruh route, controller, view, proteksi IDOR, dan kelayakan tombol aksi untuk memastikan tidak ada kesalahan routing (*wrong routing*), tombol mati (*dead button*), atau celah otorisasi.
- **Temuan & Perbaikan**:
  1. **Proteksi IDOR & Otorisasi Hak Akses (`canAccessBastik`)**:
     - *Temuan*: Pada pengujian fitur keamanan, fungsi `canAccessBastik` sempat mengembalikan nilai `true` untuk semua petugas dan pimpinan, menyebabkan petugas lain dapat mengunduh berkas PDF/Word dokumen rekannya, serta pimpinan yang tidak ditugaskan dapat membuka dokumen pimpinan lain.
     - *Perbaikan*: Memperketat otorisasi pada [`app/Http/Controllers/FormBastik/FormBastikController.php`](file:///c:/Users/MSI/Downloads/cctv%20%281%29/cctv/formulir-kai/app/Http/Controllers/FormBastik/FormBastikController.php):
       - Petugas hanya dapat mengakses dokumen yang ia buat sendiri (`petugas_id === user->id`).
       - Pimpinan hanya dapat mengakses dokumen yang ditugaskan kepadanya (`pimpinan->nipp === user->nip_kwt` atau `pimpinan->nama === user->name`), dokumen yang telah ia setujui (`approved_by === user->id`), atau yang ia buat sendiri.
       - Admin memiliki hak akses penuh ke seluruh dokumen.
       - Pengguna tidak terotorisasi secara konsisten menerima respon **HTTP 403 Forbidden**.
  2. **Proteksi Lampiran (`openLampiran`)**:
     - *Temuan*: Pengecekan file fisik di storage sempat dijalankan sebelum validasi otorisasi sehingga pengguna tidak berhak yang mengakses file fiktif mendapatkan respon 404 (Not Found) alih-alih 403 (Forbidden).
     - *Perbaikan*: Pengecekan `canAccessBastik` diposisikan di baris teratas sehingga percobaan akses tidak berhak langsung diblokir dengan HTTP 403.
  3. **Penyelarasan Tombol Unduh Word pada Dokumen Disahkan (`show.blade.php`)**:
     - *Temuan*: Backend memblokir unduh format Word untuk dokumen berstatus `signed` dan `final` (karena naskah resmi terkunci), namun tombol "Unduh Word" masih tampil pada tampilan naskah yang sudah disetujui, menyebabkan error 403 jika diklik pengguna.
     - *Perbaikan*: Menambahkan kondisi `@if(!in_array($bastik->status, ['signed', 'final', 'void']))` sehingga tombol Unduh Word hanya tampil pada naskah yang masih berstatus draft atau revisi.
  4. **Penyelarasan Tombol Edit & Hapus pada Indeks Tabel (`index.blade.php`)**:
     - Tombol edit (ikon pensil) kini hanya tampil untuk dokumen berstatus `draft` dan `rejected` (menghindari redirect penolakan pada dokumen yang sudah disetujui).
     - Tombol hapus (ikon tempat sampah) kini hanya tampil untuk dokumen berstatus `draft` dan `rejected`, atau bagi pengguna dengan peran `admin`.
  5. **Navigasi Tombol Kembali Terintegrasi (`back_button`)**:
     - Menambahkan `@section('back_button')` pada [`create.blade.php`](file:///c:/Users/MSI/Downloads/cctv%20%281%29/cctv/formulir-kai/resources/views/form-bastik/create.blade.php), [`edit.blade.php`](file:///c:/Users/MSI/Downloads/cctv%20%281%29/cctv/formulir-kai/resources/views/form-bastik/edit.blade.php), dan [`show.blade.php`](file:///c:/Users/MSI/Downloads/cctv%20%281%29/cctv/formulir-kai/resources/views/form-bastik/show.blade.php) sehingga tombol panah kembali di bilah atas berfungsi aktif dan konsisten.
  6. **Penyelarasan Teks Tombol Formulir (`form.blade.php`)**:
     - Mengubah teks tombol aksi formulir dari *"Terbitkan & Generate Nomor"* menjadi *"Submit Persetujuan"* dengan dialog konfirmasi yang sesuai alur kerja persetujuan Pimpinan.
- **Hasil Pengujian**:
  - **Automated Tests**: 100% PASS pada seluruh modul (27 test cases, 82 assertions, 0 failure).
  - **Live Browser Audit**: 0 JavaScript console errors, 0 broken routing, dan seluruh navigasi berjalan responsif.




