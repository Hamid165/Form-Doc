@php
    $formulir = $form ?? new \App\Models\FormSerahTerimaSourceCode\FormSerahTerimaSourceCode();
    $isEdit = !empty($formulir->id);
    $jenisRaw = old('jenis_serah_terima', $formulir->jenis_serah_terima ?? []);
    $jenis = is_array($jenisRaw) ? $jenisRaw : (empty($jenisRaw) ? [] : [$jenisRaw]);
    $modulRaw = old('modul_aplikasi', $formulir->modul_aplikasi ?? '');
    $modul = is_array($modulRaw) ? $modulRaw : preg_split('/\r\n|\n|\r/', (string) $modulRaw);
    if (empty($modul)) {
        $modul = [''];
    }
@endphp

<style>
    * { box-sizing: border-box; }

    body {
        margin: 0;
        padding: 24px 0 60px;
        background: #f1f2f4;
        font-family: 'Instrument Sans', sans-serif;
    }

    .page-toolbar {
        width: 210mm;
        margin: 0 auto 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .form-back-link {
        width: 210mm;
        margin: 0 auto 16px;
    }

    .page-toolbar h1 {
        margin: 0;
        font-size: 18px;
        font-family: Arial, sans-serif;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-family: Arial, sans-serif;
        font-size: 13px;
        padding: 0 16px;
        min-height: 40px;
        font-weight: 600;
        border-radius: 6px;
        border: 1px solid #d0d3d9;
        background: #fff;
        cursor: pointer;
    }

    .page-toolbar > a {
        box-sizing: border-box;
        font-family: 'Instrument Sans', sans-serif !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        line-height: 1.5 !important;
        text-decoration: none !important;
    }

    .btn-primary {
        background: #1a56db;
        border-color: #1a56db;
        color: #fff;
    }

    .kai-doc {
        width: 210mm;
        min-height: 297mm;
        margin: 0 auto;
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

    .form-input-line {
        width: 100%;
        border: none;
        border-bottom: 1px solid #000;
        background: transparent;
        font-family: inherit;
        font-size: inherit;
        padding: 2px 4px;
    }

    .form-input-line:focus {
        outline: none;
        border-bottom: 1px solid #1a56db;
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

   .inline-field {
    display: inline-block;
    min-width: 90px;   
    font-size: 11px;
    }

    .inline-field.w-sm { min-width: 55px; }
    .inline-field.w-lg { min-width: 170px; }  

   p {
    margin: 0 0 4px;
    text-align: justify;   /* default: teks biasa tetap justify */
    font-size: 11px;
    }

    .party-block,
    p.field-line {
        text-align: left;   /* paragraf yang ada field-nya: left */
    }
    .kai-doc input[type=text],
    .kai-doc input[type=date],
    .kai-doc textarea {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        border: none;
        border-bottom: 1px dotted #444;
        background: transparent;
        padding: 1px 2px;
        width: 100%;
    }

    .kai-doc input[type=text]:focus,
    .kai-doc input[type=date]:focus,
    .kai-doc textarea:focus {
        outline: none;
        border-bottom: 1px solid #1a56db;
        background: #f5f8ff;
    }

    .kai-doc textarea {
        resize: vertical;
        border: 1px dotted #444;
    }

    p {
        margin: 0 0 8px;
        text-align: justify;
        font-size: 11px;
    }

    .party-block {
        margin-bottom: 10px;
        font-size: 11px;
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

    .checkbox-line {
        display: flex;
        align-items: flex-start;
        gap: 6px;
        margin-bottom: 4px;
    }

    .checkbox-line input[type=checkbox] {
        margin-top: 3px;
        width: 13px;
        height: 13px;
    }

    .checkbox-line-cont {
    padding-left: 14px;
    }
    .colon-inline {
    flex: 0 0 auto;
    }

    .modul-row {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 4px;
    }

    .modul-row span.no {
        width: 18px;
        flex: 0 0 auto;
    }

    .modul-row .remove-modul {
        border: none;
        background: none;
        color: #c1121f;
        cursor: pointer;
        font-size: 14px;
        line-height: 1;
    }

    .add-modul-btn {
        font-family: Arial, sans-serif;
        font-size: 10.5pt;
        border: 1px dashed #1a56db;
        color: #1a56db;
        background: #f5f8ff;
        border-radius: 4px;
        padding: 3px 10px;
        cursor: pointer;
        margin-top: 2px;
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
        body { background: #fff; padding: 0; }
        .page-toolbar { display: none; }
        .kai-doc { box-shadow: none; width: auto; min-height: 0; margin: 0; padding: 10mm 15mm; }
        .kai-doc input, .kai-doc textarea { border-bottom: 1px solid #000 !important; }
    }

    @media screen and (max-width: 900px) {
        .form-back-link {
            width: 100%;
        }
    }

    @page { size: A4; margin: 10mm; }
</style>

<div class="form-back-link">
    <a href="{{ route('form-serah-terima-source-code.index') }}" class="inline-flex items-center gap-2 text-[14px] font-semibold text-slate-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Daftar Berita Acara Serah Terima Source Code
    </a>
</div>

<div class="page-toolbar">
    <h1>{{ $isEdit ? 'Edit' : 'Buat' }} Formulir Serah Terima Source Code</h1>
    <div class="flex items-center gap-2">
        @if($isEdit)
        <a href="#"
           onclick="event.preventDefault(); document.getElementById('formSerahTerima').requestSubmit();"
           class="inline-flex items-center justify-center px-4 h-[40px] bg-green-600 hover:bg-green-700 text-white rounded-lg text-[13px] font-semibold transition-colors">
            Perbarui Formulir
        </a>
        @else
        <a href="#"
           onclick="event.preventDefault(); document.getElementById('formSerahTerima').requestSubmit();"
           class="inline-flex items-center justify-center px-4 h-[40px] bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-[13px] font-semibold transition-colors">
            Simpan Formulir
        </a>
        @endif
    </div>
</div>

<form id="formSerahTerima"
      action="{{ $action ?? ($isEdit ? route('form-serah-terima-source-code.update', $formulir->id) : route('form-serah-terima-source-code.store')) }}"
      method="POST">
    @csrf
    @if($isEdit) @method('PUT') @endif

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
                <td class="value-cell">: <input type="text" name="nomor_dokumen" value="{{ old('nomor_dokumen', $formulir->nomor_dokumen ?? 'FR.SM/TI/020.009/07-2021') }}" class="form-input-line" style="border-bottom:none; padding:0; width:100%"></td>
            </tr>
            <tr>
                <td class="label-cell">Tanggal Terbit</td>
                <td class="value-cell">: <input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', optional($formulir->tanggal_terbit)->format('Y-m-d')) }}" class="form-input-line" style="border-bottom:none; padding:0; width:100%"></td>
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
                <td class="value-cell">: <input type="text" name="versi_dokumen" value="{{ old('versi_dokumen', $formulir->versi_dokumen ?? '01-2021') }}" class="form-input-line" style="border-bottom:none; padding:0; width:100%"></td>
            </tr>
            <tr>
                <td class="label-cell">Halaman</td>
                <td class="value-cell">: <input type="text" name="halaman_dokumen" value="{{ old('halaman_dokumen', $formulir->halaman_dokumen ?? '1 dari 2') }}" class="form-input-line" style="border-bottom:none; padding:0; width:100%"></td>
            </tr>
        </table>

<table class="ref-table">
    <tr>
        <td>No. Ref</td>
        <td>: <input type="text" name="no_ref" value="{{ old('no_ref', $formulir->no_ref) }}" placeholder="__/__/____" style="border-bottom:none; padding:0;"></td>
    </tr>
    <tr>
        <td>Tanggal</td>
        <td>: <input type="date" name="tanggal" value="{{ old('tanggal', optional($formulir->tanggal)->format('Y-m-d')) }}" style="border-bottom:none; padding:0;"></td>
    </tr>
    <tr>
        <td>Business Area</td>
        <td>: <input type="text" name="business_area" value="{{ old('business_area', $formulir->business_area) }}" style="border-bottom:none; padding:0;"></td>
    </tr>
</table>

      <p class="field-line">
   Berita Acara Serah Terima ini dibuat pada hari
    <span class="inline-field w-sm"><input type="text" name="hari" value="{{ old('hari', $formulir->hari) }}" placeholder="....."></span>
    tanggal
    <span class="inline-field"><input type="date" name="tanggal_serah_terima" value="{{ old('tanggal_serah_terima', optional($formulir->tanggal_serah_terima ?? $formulir->tanggal_dibuat ?? $formulir->tanggal)->format('Y-m-d')) }}"></span>
    ,bulan
    <span class="inline-field"><input type="text" name="bulan" value="{{ old('bulan', $formulir->bulan ?? '') }}" placeholder="______________"></span>
    ,tahun
    <span class="inline-field"><input type="text" name="tahun" value="{{ old('tahun', $formulir->tahun ?? '') }}"></span>
    ,oleh dan antara:
</p>

<div class="party-block">
    <span class="roman">I.</span>
    <strong>PT KERETA API INDONESIA (PERSERO)</strong>, Perseroan Terbatas, yang berkedudukan di Bandung, beralamat di Jalan Perintis Kemerdekaan Nomor 1, yang dalam hal ini diwakili oleh
    <span class="inline-field w-lg"><input type="text" name="pihak_pertama_diwakili" value="{{ old('pihak_pertama_diwakili', $formulir->pihak_pertama_diwakili) }}" placeholder="Nama"></span>,
    selaku
    <span class="inline-field w-lg"><input type="text" name="pihak_pertama_jabatan" value="{{ old('pihak_pertama_jabatan', $formulir->pihak_pertama_jabatan) }}" placeholder="Jabatan"></span>
    , selanjutnya disebut <strong>PIHAK PERTAMA</strong>.
</div>

<div class="party-block">
    <span class="roman">II.</span>
    <span class="inline-field w-lg"><input type="text" name="pihak_kedua_nama" value="{{ old('pihak_kedua_nama', $formulir->pihak_kedua_nama) }}" placeholder="Nama Perusahaan/Instansi"></span>,
    berkedudukan dan berkantor pusat di
    <span class="inline-field w-lg"><input type="text" name="pihak_kedua_alamat" value="{{ old('pihak_kedua_alamat', $formulir->pihak_kedua_alamat) }}" placeholder="Alamat"></span>,
    yang dalam hal ini diwakili oleh
    <span class="inline-field w-lg"><input type="text" name="pihak_kedua_diwakili" value="{{ old('pihak_kedua_diwakili', $formulir->pihak_kedua_diwakili) }}" placeholder="Nama"></span>,
    selaku
    <span class="inline-field w-lg"><input type="text" name="pihak_kedua_jabatan" value="{{ old('pihak_kedua_jabatan', $formulir->pihak_kedua_jabatan) }}" placeholder="Jabatan"></span>
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
                        <div class="checkbox-line">
                            <input type="checkbox" id="jenis1" name="jenis_serah_terima[]" value="aplikasi_source_code_struktur_db" {{ in_array('aplikasi_source_code_struktur_db', $jenis) ? 'checked' : '' }}>
                            <label for="jenis1">Aplikasi termasuk <i>source code</i> dan struktur database</label>
                        </div>
                        <div class="checkbox-line">
                            <input type="checkbox" id="jenis2" name="jenis_serah_terima[]" value="source_code_modul_fungsi" {{ in_array('source_code_modul_fungsi', $jenis) ? 'checked' : '' }}>
                            <label for="jenis2"><i>Source code</i> aplikasi/modul atau fungsi/services</label>
                        </div>
                        <div class="checkbox-line">
                            <input type="checkbox" id="jenis3" name="jenis_serah_terima[]" value="lain_lain" {{ in_array('lain_lain', $jenis) ? 'checked' : '' }}>
                            <label for="jenis3">Lain – lain :</label>
                            <input type="text" name="jenis_serah_terima_lainnya" style="flex:1;" value="{{ old('jenis_serah_terima_lainnya', $formulir->jenis_serah_terima_lainnya) }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="label">Nama Aplikasi :</td>
                    <td><input type="text" name="nama_aplikasi" value="{{ old('nama_aplikasi', $formulir->nama_aplikasi) }}"></td>
                </tr>
                <tr>
                    <td class="label">Versi Aplikasi :</td>
                    <td><input type="text" name="versi_aplikasi" value="{{ old('versi_aplikasi', $formulir->versi_aplikasi) }}"></td>
                </tr>
                <tr>
                    <td class="label">Deskripsi Aplikasi :</td>
                    <td><textarea name="deskripsi_aplikasi" rows="2">{{ old('deskripsi_aplikasi', $formulir->deskripsi_aplikasi) }}</textarea></td>
                </tr>
                <tr>
                    <td class="label">Modul dalam Aplikasi :</td>
                    <td>
                        <div id="modulList">
                            @foreach($modul as $i => $m)
                                <div class="modul-row">
                                    <span class="no">{{ $i + 1 }}.</span>
                                    <input type="text" name="modul_aplikasi[]" value="{{ $m }}">
                                    <button type="button" class="remove-modul" onclick="removeModulRow(this)">&times;</button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="add-modul-btn" onclick="addModulRow()">+ Tambah Modul</button>
                    </td>
                </tr>
                <tr>
                    <td class="label">Bahasa Pemrograman :</td>
                    <td><input type="text" name="bahasa_pemrograman" value="{{ old('bahasa_pemrograman', $formulir->bahasa_pemrograman) }}"></td>
                </tr>
                <tr>
                    <td class="label">Database yang digunakan :</td>
                    <td><input type="text" name="database_digunakan" value="{{ old('database_digunakan', $formulir->database_digunakan) }}"></td>
                </tr>
                <tr>
                    <td class="label"><i>Development Platform</i> :</td>
                    <td><input type="text" name="development_platform" value="{{ old('development_platform', $formulir->development_platform) }}"></td>
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

            <li>Hal-hal lainnya yang belum diatur/tertuang dalam berita acara ini akan dituangkan dalam perjanjian kerja sama atau dokumen tersendiri yang disetujui oleh kedua belah pihak.</li>
        </ol>

        <p>Demikian Berita Acara Serah Terima ini dibuat untuk dipergunakan sebagaimana mestinya.</p>

        <div class="ttd-wrap">
            <div class="ttd-col">
                <div class="peran">PIHAK PERTAMA</div>
                <div class="garis">
                    <input type="text" name="nama_ttd_pihak_pertama" style="text-align:center;" value="{{ old('nama_ttd_pihak_pertama', $formulir->nama_ttd_pihak_pertama) }}">
                </div>
                <div class="ket">Nama dan Tanda Tangan</div>
            </div>
            <div class="ttd-col">
                <div class="peran">PIHAK KEDUA</div>
                <div class="garis">
                    <input type="text" name="nama_ttd_pihak_kedua" style="text-align:center;" value="{{ old('nama_ttd_pihak_kedua', $formulir->nama_ttd_pihak_kedua) }}">
                </div>
                <div class="ket">Nama dan Tanda Tangan</div>
            </div>
        </div>

        <div class="footnote">*rincian terlampir (jika ada)</div>
    </div>
</form>

<script>
    function addModulRow() {
        const wrap = document.getElementById('modulList');
        const idx = wrap.children.length + 1;
        const row = document.createElement('div');
        row.className = 'modul-row';
        row.innerHTML = `<span class="no">${idx}.</span>
            <input type="text" name="modul_aplikasi[]" value="">
            <button type="button" class="remove-modul" onclick="removeModulRow(this)">&times;</button>`;
        wrap.appendChild(row);
    }

    function removeModulRow(btn) {
        const wrap = document.getElementById('modulList');
        if (wrap.children.length <= 1) {
            btn.closest('.modul-row').querySelector('input').value = '';
            return;
        }
        btn.closest('.modul-row').remove();
        [...wrap.children].forEach((row, i) => row.querySelector('.no').textContent = (i + 1) + '.');
    }
</script>