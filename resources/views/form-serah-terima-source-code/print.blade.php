<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cetak - Berita Acara Serah Terima Source Code{{ isset($formulir) && $formulir->no_ref ? ' - ' . $formulir->no_ref : '' }}</title>
@php
    $formulir = $form ?? $form_serah_terima_source_code ?? null;
    if (!$formulir) {
        abort(404);
    }
    $jenisRaw = $formulir->jenis_serah_terima ?? [];
    $jenis = is_array($jenisRaw) ? $jenisRaw : (empty($jenisRaw) ? [] : [$jenisRaw]);
    $modulRaw = $formulir->modul_aplikasi ?? '';
    $modul = is_array($modulRaw) ? $modulRaw : preg_split('/\r\n|\n|\r/', (string) $modulRaw);
    $modul = array_values(array_filter($modul, fn($m) => trim((string) $m) !== ''));
    if (empty($modul)) {
        $modul = ['-'];
    }

    $namaPihakPertama = $formulir->pihak_pertama_diwakili ?? $formulir->pihak_pertama_nama ?? null;
    $jabatanPihakPertama = $formulir->pihak_pertama_jabatan ?? null;
    $namaPihakKedua = $formulir->pihak_kedua_diwakili ?? $formulir->pihak_kedua_diwakili_nama ?? $formulir->pihak_kedua_nama ?? null;
    $jabatanPihakKedua = $formulir->pihak_kedua_jabatan ?? $formulir->pihak_kedua_diwakili_jabatan ?? null;
    $databaseDigunakan = $formulir->database_digunakan ?? $formulir->database_yang_digunakan ?? null;
    $jenisLainnya = $formulir->jenis_serah_terima_lainnya ?? $formulir->jenis_serah_terima_lain ?? null;
    $hariSerah = $formulir->hari_serah_terima ?? $formulir->hari ?? null;
    $tanggalSerah = $formulir->tanggal_serah_terima ?? $formulir->tanggal_dibuat ?? $formulir->tanggal ?? null;

    $fmtDate = function ($date, $format = 'd F Y') {
        if (!$date) return '-';
        try {
            return \Carbon\Carbon::parse($date)->translatedFormat($format);
        } catch (\Throwable $e) {
            return $date;
        }
    };
    $val = fn($v) => ($v === null || $v === '') ? '-' : $v;
@endphp
<style>
    * { box-sizing: border-box; }

    html, body {
        margin: 0;
        padding: 0;
        background: #f1f2f4;
        font-family: Arial, Helvetica, sans-serif;
    }

    .print-toolbar {
        width: 210mm;
        margin: 16px auto;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .form-back-link {
        width: 210mm;
        margin: 24px auto 16px;
    }
    .btn {
        font-family: Arial, sans-serif;
        font-size: 13px;
        padding: 8px 16px;
        border-radius: 6px;
        border: 1px solid #d0d3d9;
        background: #fff;
        cursor: pointer;
        text-decoration: none;
        color: #334155;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-primary {
        background: #1a56db;
        border-color: #1a56db;
        color: #fff;
    }

    .kai-doc {
        width: 210mm;
        min-height: 297mm;
        margin: 0 auto 24px;
        background: #fff;
        padding: 15mm 18mm;
        box-shadow: 0 0 12px rgba(0,0,0,.15);
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        color: #000;
        line-height: 1.5;
    }

    .doc-header {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 6mm;
        table-layout: fixed;
        page-break-after: avoid;
    }
    .doc-header td {
        border: 1px solid #000;
        padding: 4px 8px;
        vertical-align: middle;
    }
    .logo-cell {
        width: 15%;
        text-align: center;
        vertical-align: middle;
    }
    .logo-cell img {
        display: block;
        max-width: 100%;
        max-height: 50px;
        margin: 0 auto;
    }
    .terbatas-cell {
        width: 15%;
        text-align: center;
        vertical-align: middle;
    }
    .terbatas-box {
        display: inline-block;
        border: 2px solid #fffb24;
        color: #fffb24;
        padding: 6px 14px;
        font-weight: bold;
        font-size: 11px;
        text-align: center;
        border-radius: 2px;
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
    }
    .title-cell {
        text-align: center;
        font-weight: 700;
        font-size: 11px;
        line-height: 1.35;
    }
    .label-cell {
        width: 18%;
        font-weight: 600;
    }
    .value-cell {
        width: 22%;
    }

     .ref-table {
        width: 35%;
        border-collapse: collapse;
        margin-bottom: 20px;
        font-size: 11px;
    }
    .ref-table td {
        border: 1px solid #000;
        padding: 4px;
    }
    .ref-table td:first-child { border-right: none; }
    .ref-table td:last-child { border-left: none; }
    .ref-label { width: 40%; }
.static-field {
    display: inline-block;
    min-width: 55px;
    border-bottom: 1px dotted #444;
    padding: 1px 6px;
}
.static-field.w-sm { min-width: 35px; }
.static-field.w-lg { min-width: 170px; }

    p {
        margin: 0 0 4px;
        text-align: justify;
        font-size: 11px;
    }

    .party-block {
        margin-bottom: 6px;
        font-size: 11px;
    }

    p.field-line {
    text-align: left; 
}

    .party-block .roman {
        font-weight: 700;
    }
    ol.pasal {
        margin: 0 0 10px 0;
        padding-left: 20px;
        font-size: 11px;
    }
    ol.pasal > li {
        margin-bottom: 8px;
        text-align: justify;
    }
    ol.pasal > li.page-two {
        break-before: page;
        page-break-before: always;
    }
    ol.abjad {
        margin: 4px 0 0 0;
        padding-left: 18px;
        list-style: lower-alpha;
        font-size: 11px;
    }
    ol.abjad > li {
        margin-bottom: 6px;
        text-align: justify;
    }

     table.detail-table {
        width: 100%;
        border-collapse: collapse;
        margin: 6px 0 12px;
        font-size: 10.5pt;
    }
    table.detail-table td {
        border: 1px solid #000;
        padding: 6px 8px;
        vertical-align: top;
    }
    table.detail-table td.label {
        width: 32%;
        white-space: nowrap;
    }
    table.detail-table td.colon {
        width: 14px;
        text-align: center;
    }

    .checkbox-line-static {
        display: flex;
        align-items: flex-start;
        gap: 6px;
        margin-bottom: 4px;
    }
    .checkbox-line-static .chk {
        font-size: 13px;
        line-height: 1.2;
        flex: 0 0 auto;
    }

    ol.modul-list-static {
        margin: 0;
        padding-left: 18px;
    }
    ol.modul-list-static > li {
        margin-bottom: 3px;
    }

    .ttd-wrap {
        display: flex;
        justify-content: space-between;
        margin-top: 24px;
    }
    .ttd-col {
        width: 45%;
        text-align: center;
    }
    .ttd-col .peran {
        font-weight: 700;
        margin-bottom: 70px;
    }
    .ttd-col .garis {
        border-bottom: 1px dotted #000;
        margin-bottom: 4px;
        min-height: 15px;
    }
    .ttd-col .ket {
        font-size: 9.5pt;
    }

    .footnote {
        font-style: italic;
        font-size: 9.5pt;
        margin-top: 20px;
    }

    @media print {
        * { margin: 0; padding: 0; }
        html, body { 
            background: #fff !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .print-toolbar { display: none !important; }
        .form-back-link { display: none !important; }
        .kai-doc { 
            box-shadow: none !important;
            width: 100% !important;
            min-height: 0 !important;
            margin: 0 !important;
            padding: 15mm 18mm !important;
            page-break-after: always;
        }
    }

    @page { 
        size: A4 portrait;
        margin: 0mm;
    }
</style>
</head>
<body>

    <div class="form-back-link">
        <a href="{{ route('form-serah-terima-source-code.index') }}" style="display:inline-flex; align-items:center; gap:8px; color:#64748b; font-family:Arial, sans-serif; font-size:14px; font-weight:600; text-decoration:none;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Berita Acara Serah Terima Source Code
        </a>
    </div>

    <div class="kai-doc">
        <table class="doc-header">
            <tr>
                <td class="logo-cell" rowspan="2">
                    <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI">
                </td>
                <td rowspan="2" class="title-cell" style="width: 38%;">
                    PT KERETA API INDONESIA (PERSERO)<br>
                    SISTEM INFORMASI
                </td>
                <td class="label-cell">Nomor</td>
                <td class="value-cell">: {{ $val($formulir->nomor_dokumen ?? 'FR.SM/TI/020.009/07-2021') }}</td>
            </tr>
            <tr>
                <td class="label-cell">Tanggal Terbit</td>
                <td class="value-cell">: {{ $fmtDate($formulir->tanggal_terbit) }}</td>
            </tr>
            <tr>
                <td class="terbatas-cell" rowspan="2">
                    <div class="terbatas-box">TERBATAS</div>
                </td>
                <td rowspan="2" class="title-cell" style="width: 38%;">
                    BERITA ACARA SERAH TERIMA<br>
                    <span style="font-style: italic;">SOURCE CODE</span> APLIKASI
                </td>
                <td class="label-cell">Versi</td>
                <td class="value-cell">: {{ $val($formulir->versi_dokumen ?? '01-2021') }}</td>
            </tr>
            <tr>
                <td class="label-cell">Halaman</td>
                <td class="value-cell">: {{ $val($formulir->halaman_dokumen ?? '1 dari 2') }}</td>
            </tr>
        </table>

<table class="ref-table">
    <tr>
        <td>No. Ref</td>
        <td>: {{ $val($formulir->no_ref) }}</td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>: {{ $fmtDate($formulir->tanggal) }}</td>
    </tr>
    <tr>
        <td>Business Area</td>
        <td>: {{ $val($formulir->business_area) }}</td>
    </tr>
</table>

    <p class="field-line">
        Berita Acara Serah Terima ini dibuat pada hari
        <span class="static-field w-sm">{{ $val($hariSerah) }}</span>
        tanggal
        <span class="static-field">{{ $fmtDate($tanggalSerah, 'd') }}</span>
        bulan
        <span class="static-field">{{ $val($formulir->bulan) }}</span>
        tahun
        <span class="static-field">{{ $val($formulir->tahun) }}</span>
        , oleh dan antara:
    </p>
    <div class="party-block">
            <span class="roman">I.</span>
            <strong>PT KERETA API INDONESIA (PERSERO)</strong>, Perseroan Terbatas, yang berkedudukan di Bandung,
            beralamat di Jalan Perintis Kemerdekaan Nomor 1, yang dalam hal ini diwakili oleh
            <span class="static-field w-lg">{{ $val($namaPihakPertama) }}</span>,
            selaku
            <span class="static-field w-lg">{{ $val($jabatanPihakPertama) }}</span>
            , selanjutnya disebut <strong>PIHAK PERTAMA</strong>.
    </div>

    <div class="party-block">
        <span class="roman">II.</span>
        <span class="static-field w-lg">{{ $val($formulir->pihak_kedua_nama) }}</span>,
        berkedudukan dan berkantor pusat di
        <span class="static-field w-lg">{{ $val($formulir->pihak_kedua_alamat) }}</span>,
        yang dalam hal ini diwakili oleh
        <span class="static-field w-lg">{{ $val($namaPihakKedua) }}</span>,
        selaku
        <span class="static-field w-lg">{{ $val($jabatanPihakKedua) }}</span>
        , selanjutnya disebut <strong>PIHAK KEDUA.</strong>
    </div>

<p><strong>Menyatakan bahwa :</strong></p>

        <ol class="pasal">
            <li>
                PIHAK PERTAMA menyerahkan kepada PIHAK KEDUA dan PIHAK KEDUA telah menerima
                <i>Source Code</i> Aplikasi sebagai berikut:

                <table class="detail-table">
                    <tr>
                        <td class="label">Jenis Serah Terima :</td>
                        <td>
                            <div class="checkbox-line-static">
                                <span class="chk">{{ in_array('aplikasi_source_code_struktur_db', $jenis) ? '☑' : '☐' }}</span>
                                <span>Aplikasi termasuk <i>source code</i> dan struktur database</span>
                            </div>
                            <div class="checkbox-line-static">
                                <span class="chk">{{ in_array('source_code_modul_fungsi', $jenis) ? '☑' : '☐' }}</span>
                                <span><i>Source code</i> aplikasi/modul atau fungsi/services</span>
                            </div>
                            <div class="checkbox-line-static">
                                <span class="chk">{{ in_array('lain_lain', $jenis) ? '☑' : '☐' }}</span>
                                <span>Lain – lain : <span class="static-field">{{ $val($jenisLainnya) }}</span></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Nama Aplikasi :</td>
                        <td> {{ $val($formulir->nama_aplikasi) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Versi Aplikasi :</td>
                        <td> {{ $val($formulir->versi_aplikasi) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Deskripsi Aplikasi :</td>
                        <td> {{ $val($formulir->deskripsi_aplikasi) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Modul dalam Aplikasi :</td>
                        <td>
                            <ol class="modul-list-static">
                                @foreach($modul as $m)
                                    <li>{{ $m }}</li>
                                @endforeach
                            </ol>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Bahasa Pemrograman :</td>
                        <td> {{ $val($formulir->bahasa_pemrograman) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Database yang digunakan :</td>
                        <td> {{ $val($databaseDigunakan) }}</td>
                    </tr>
                    <tr>
                        <td class="label"><i>Development Platform :</i></td>
                        <td> {{ $val($formulir->development_platform) }}</td>
                    </tr>
                </table>
            </li>

            <li>PIHAK PERTAMA memiliki Hak Cipta atas <i>source code</i> aplikasi sebagaimana dimaksud pada nomor 1 (satu).</li>

            <li>
                PIHAK KEDUA sepakat memiliki tanggung jawab sebagai berikut:
                <ol class="abjad">
                    <li>menjaga dan memelihara atas <i>source code</i> aplikasi sebagaimana dimaksud pada nomor 1 (satu);</li>
                    <li>pengembangan terkait <i>source code</i> aplikasi sebagaimana yang dimaksud pada nomor 1 (satu) dapat disesuaikan dengan kebutuhan Proses bisnis Perusahaannya;</li>
                    <li>pengembangan <i>source code</i> wajib dilakukan oleh pegawai, bukan oleh pegawai kontrak/pegawai <i>outsource/subcon</i> pihak ketiga lainnya;</li>
                    <li>dilarang untuk memperdagangkan atau menyerahkan kepada pihak lain atas <i>source code</i> aplikasi sebagaimana yang dimaksud pada nomor 1 (satu).</li>
                </ol>
            </li>

            <li class="page-two">Hal-hal lainnya yang belum diatur/tertuang dalam berita acara ini akan dituangkan dalam perjanjian kerja sama atau dokumen tersendiri yang disetujui oleh kedua belah pihak.</li>
        </ol>

        <p>Demikian Berita Acara Serah Terima ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

        <div class="ttd-wrap">
            <div class="ttd-col">
                <div class="peran">PIHAK PERTAMA</div>
                <div class="garis">{{ $val($formulir->nama_ttd_pihak_pertama) }}</div>
                <div class="ket">Nama dan Tanda Tangan</div>
            </div>
            <div class="ttd-col">
                <div class="peran">PIHAK KEDUA</div>
                <div class="garis">{{ $val($formulir->nama_ttd_pihak_kedua) }}</div>
                <div class="ket">Nama dan Tanda Tangan</div>
            </div>
        </div>

        <div class="footnote">*rincian terlampir (jika ada)</div>
    </div>

    <script>
        window.addEventListener('load', function () {
            window.print();
        });
    </script>
</body>
</html>