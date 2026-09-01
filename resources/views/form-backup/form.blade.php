<style>
    .a4-wrapper {
        display: flex;
        justify-content: center;
        padding: 20px 0;
        background-color: #f3f4f6;
    }

    .a4-container {
        width: 210mm;
        min-height: 297mm;
        padding: 12mm;
        box-sizing: border-box;
        position: relative;
        background: #ffffff;
        color: #000000;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
    }

    .a4-container table {
        border-collapse: collapse;
    }

    .header-table,
    .main-table {
        width: 100%;
    }

    .header-table {
        table-layout: fixed;
    }

    .header-table td {
        border: 1px solid #000000;
        vertical-align: middle;
        box-sizing: border-box;
    }

    .header-logo {
        width: 18%;
        height: 75px;
        padding: 6px;
        text-align: center;
    }

    .header-logo img {
        display: block;
        width: 130px;
        max-width: 100%;
        height: auto;
        margin: 0 auto;
    }

    .header-company {
        width: 42%;
        height: 75px;
        padding: 8px;
        text-align: center;
        font-size: 12px;
        font-weight: bold;
        line-height: 1.45;
        white-space: nowrap;
    }

    .header-status {
        width: 18%;
        height: 70px;
        padding: 10px !important;
        overflow: hidden;
        text-align: center;
        vertical-align: middle;
    }

    .terbatas-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        max-width: 112px;
        min-width: 0;
        padding: 7px 5px;
        box-sizing: border-box;
        border: 2px solid #d4a017;
        color: #d4a017;
        font-size: 13px;
        font-weight: bold;
        line-height: 1;
        white-space: nowrap;
    }

    .header-title {
        width: 42%;
        height: 70px;
        padding: 8px;
        text-align: center;
        font-size: 15px;
        font-weight: bold;
    }

    .header-label {
        width: 14%;
        padding: 8px 10px;
        font-size: 12px;
        white-space: nowrap;
    }

    .header-value {
        width: 26%;
        padding: 8px 10px;
        overflow: hidden;
        font-size: 11px;
    }

    .header-value-row {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .header-value input {
        width: 100%;
        padding: 0;
        border: none;
        outline: none;
        background: transparent;
        font-family: inherit;
        font-size: inherit;
    }

    .info-table {
        width: 35%;
        margin-top: 25px;
        margin-bottom: 15px;
    }

    .info-table td {
        padding: 6px 8px !important;
        border: 1px solid #000000 !important;
    }

    .flex-row {
        display: flex;
        align-items: center;
    }

    .label-col {
        display: inline-block;
        width: 85px;
        flex-shrink: 0;
    }

    .desc-text {
        margin: 0 40px 15px;
        text-align: justify;
        line-height: 1.5;
    }

    .footer-note {
        margin: 15px 40px 0;
        text-align: justify;
        font-size: 10px;
        font-style: italic;
        line-height: 1.4;
    }

    .main-table th,
    .main-table td {
        padding: 4px;
        border: 1px solid #000000;
    }

    .main-table th {
        padding: 6px;
        background-color: #f2f2f2;
        text-align: center;
    }

    .text-center {
        text-align: center;
    }

    .clearfix::after {
        display: table;
        clear: both;
        content: "";
    }

    .footer-section {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    .signature-box {
        width: 260px;
        text-align: center;
        font-size: 11px;
    }

    .input-transparent {
        width: 100%;
        padding: 2px 0;
        border: none;
        border-bottom: 1px dashed #999999;
        outline: none;
        background: transparent;
        font-family: inherit;
        font-size: inherit;
    }

    .input-transparent:focus {
        border-bottom-color: #2563eb;
        background-color: #f8fafc;
    }

    select.input-transparent {
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
    }

    /* Hanya isi tabel input yang rata kiri */
    .input-table {
        width: 100%;
        padding: 2px 4px;
        box-sizing: border-box;
        border: none;
        outline: none;
        background: transparent;
        font-family: inherit;
        font-size: inherit;
        text-align: left;
    }

    .input-table:focus {
        background-color: #eff6ff;
    }

    select.input-table {
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
    }

    .ref-input {
        width: 40px;
        border: none;
        border-bottom: 1px dashed #999999;
        outline: none;
        background: transparent;
        font-family: inherit;
        font-size: inherit;
        text-align: center;
    }

    .ref-input:focus {
        border-bottom-color: #2563eb;
        background-color: #f8fafc;
    }

    @media print {
        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        .a4-wrapper {
            padding: 0;
            background: #ffffff;
        }

        .a4-container {
            width: 100%;
            min-height: auto;
            padding: 0;
            box-shadow: none;
        }

        .header-table {
            width: 100%;
        }

        .max-w-4xl,
        #add-row,
        .remove-row {
            display: none !important;
        }
    }
</style>

<form action="{{ $action }}" method="POST">
    @csrf
    @if (isset($method) && $method === 'PUT')
        @method('PUT')
    @endif

    <div class="max-w-4xl mx-auto mb-4 flex justify-end gap-3 mt-4">
        <a href="{{ route('form-backup.index') }}"
            class="bg-white text-gray-700 px-4 py-2 border border-gray-300 rounded shadow-sm text-sm hover:bg-gray-50 transition">Batal</a>
        <button type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded shadow-sm text-sm font-medium hover:bg-blue-700 transition">Simpan
            Dokumen</button>
    </div>

    <div class="a4-wrapper">
        <div class="a4-container">

            <table class="header-table">
                <tr>
                    <td class="header-logo" rowspan="2">
                        <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI">
                    </td>

                    <td class="header-company" rowspan="2">
                        PT KERETA API INDONESIA (PERSERO)<br>
                        SISTEM INFORMASI
                    </td>

                    <td class="header-label">No. Dokumen</td>
                    <td class="header-value">
                        <div class="header-value-row">
                            <input type="text" name="doc_nomor"
                                value="{{ old('doc_nomor', $form->doc_nomor ?? 'DK.SM/TI/012.002/02-2023') }}">
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="header-label">Tanggal</td>
                    <td class="header-value">
                        <div class="header-value-row">
                            <input type="date" name="doc_tanggal"
                                value="{{ old('doc_tanggal', isset($form->doc_tanggal) ? \Carbon\Carbon::parse($form->doc_tanggal)->format('Y-m-d') : '2023-02-13') }}">
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="header-status" rowspan="2">
                        <div class="terbatas-box">TERBATAS</div>
                    </td>

                    <td class="header-title" rowspan="2">
                        LAPORAN BACKUP
                    </td>

                    <td class="header-label">Versi</td>
                    <td class="header-value">
                        <div class="header-value-row">
                            <input type="text" name="doc_versi"
                                value="{{ old('doc_versi', $form->doc_versi ?? '001-2023') }}">
                        </div>
                    </td>
                </tr>

                <tr>
                    <td class="header-label">Halaman</td>
                    <td class="header-value"><span id="page-number">1 dari 1</span></td>
                </tr>
            </table>

            <!-- Memecah no_ref dari database/old input -->
            @php
                $no_ref_parts = explode('/', old('no_ref', $form->no_ref ?? ''));
                $ref_1 = $no_ref_parts[0] ?? '';
                $ref_2 = $no_ref_parts[1] ?? '';
                $ref_3 = $no_ref_parts[2] ?? '';
            @endphp

            <table class="info-table">
                <tr>
                    <td>
                        <div class="flex-row">
                            <span class="label-col">No. Ref</span><span>: </span>
                            <input type="text" id="ref_1" value="{{ $ref_1 }}" class="ref-input"
                                style="margin-left: 5px;"> /
                            <input type="text" id="ref_2" value="{{ $ref_2 }}" class="ref-input"> /
                            <input type="text" id="ref_3" value="{{ $ref_3 }}" class="ref-input"
                                style="width: 60px;">
                            <input type="hidden" name="no_ref" id="real_no_ref"
                                value="{{ old('no_ref', $form->no_ref) }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="flex-row">
                            <span class="label-col">Tanggal</span><span>: </span>
                            <input type="date" name="tanggal" id="tanggal"
                                value="{{ old('tanggal', $form->getRawOriginal('tanggal')) }}"
                                onchange="updateTandaTangan()" required class="input-transparent"
                                style="border:none; margin-left:5px; width:130px;">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="flex-row">
                            <span class="label-col">Business Area</span><span>: </span>
                            <select name="business_area" id="business_area" onchange="updateTandaTangan()" required
                                class="input-transparent" style="border:none; margin-left:5px; width:130px;">
                                <option value="">-- Pilih BA --</option>
                                @foreach ($masterBusinessAreas as $ba)
                                    <option value="{{ $ba->nama }}" data-kota="{{ $ba->jabatan }}"
                                        {{ old('business_area', $form->business_area) == $ba->nama ? 'selected' : '' }}>
                                        {{ $ba->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                </tr>
            </table>

            <p class="desc-text">
                Informasi yang dianggap kritikal bagi berlangsungnya proses bisnis PT Kereta Api Indonesia (persero)
                harus memiliki backup. Proses backup dilakukan secara berkala sesuai dengan tingkat risiko yang dapat
                terjadi jika informasi rusak atau hilang. Informasi yang harus di-backup adalah seperti tercantum dalam
                tabel sebagai berikut.
            </p>

            <table class="main-table" id="table-items">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 25%;">Nama Informasi</th>
                        <th style="width: 15%;">Metode Backup</th>
                        <th style="width: 20%;">Periode Backup</th>
                        <th style="width: 15%;">Retensi</th>
                        <th style="width: 15%;">Status</th>

                        <!-- Header 'Hapus' dihilangkan jika sedang dalam mode EDIT (Tersimpan) -->
                        @if (!isset($method) || $method !== 'PUT')
                            <th style="width: 5%; border: none; background: transparent;"></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php $items = old('items', $form->items ?? []); @endphp
                    @forelse($items as $index => $item)
                        <tr>
                            <td class="text-center row-no">
                                {{ $index + 1 }}
                                <input type="hidden" name="items[{{ $index }}][no]"
                                    value="{{ $index + 1 }}">
                            </td>
                            <td><input type="text" name="items[{{ $index }}][nama_informasi]"
                                    value="{{ data_get($item, 'nama_informasi', '') }}"
                                    class="input-table input-table-left"
                                    {{ isset($method) && $method === 'PUT' ? 'readonly' : '' }}></td>
                            <td>
                                <select name="items[{{ $index }}][metode_backup]" class="input-table"
                                    {{ isset($method) && $method === 'PUT' ? 'disabled' : '' }}>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($masterMetodes as $metode)
                                        <option value="{{ $metode->nama }}"
                                            {{ data_get($item, 'metode_backup') == $metode->nama ? 'selected' : '' }}>
                                            {{ $metode->nama }}</option>
                                    @endforeach
                                </select>
                                <!-- Menambahkan hidden input jika disable, supaya datanya tetap terkirim saat edit save -->
                                @if (isset($method) && $method === 'PUT')
                                    <input type="hidden" name="items[{{ $index }}][metode_backup]"
                                        value="{{ data_get($item, 'metode_backup') }}">
                                @endif
                            </td>
                            <td>
                                <select name="items[{{ $index }}][periode_backup]" class="input-table"
                                    {{ isset($method) && $method === 'PUT' ? 'disabled' : '' }}>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($masterPeriodes as $periode)
                                        <option value="{{ $periode->nama }}"
                                            {{ data_get($item, 'periode_backup') == $periode->nama ? 'selected' : '' }}>
                                            {{ $periode->nama }}</option>
                                    @endforeach
                                </select>
                                @if (isset($method) && $method === 'PUT')
                                    <input type="hidden" name="items[{{ $index }}][periode_backup]"
                                        value="{{ data_get($item, 'periode_backup') }}">
                                @endif
                            </td>
                            <td>
                                <select name="items[{{ $index }}][retensi]" class="input-table"
                                    {{ isset($method) && $method === 'PUT' ? 'disabled' : '' }}>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($masterRetensis as $retensi)
                                        <option value="{{ $retensi->nama }}"
                                            {{ data_get($item, 'retensi') == $retensi->nama ? 'selected' : '' }}>
                                            {{ $retensi->nama }}</option>
                                    @endforeach
                                </select>
                                @if (isset($method) && $method === 'PUT')
                                    <input type="hidden" name="items[{{ $index }}][retensi]"
                                        value="{{ data_get($item, 'retensi') }}">
                                @endif
                            </td>
                            <td>
                                <select name="items[{{ $index }}][status]" class="input-table"
                                    {{ isset($method) && $method === 'PUT' ? 'disabled' : '' }}>
                                    <option value="">-- Pilih --</option>
                                    @foreach ($masterStatuses as $status)
                                        <option value="{{ $status->nama }}"
                                            {{ data_get($item, 'status') == $status->nama ? 'selected' : '' }}>
                                            {{ $status->nama }}</option>
                                    @endforeach
                                </select>
                                @if (isset($method) && $method === 'PUT')
                                    <input type="hidden" name="items[{{ $index }}][status]"
                                        value="{{ data_get($item, 'status') }}">
                                @endif
                            </td>

                            <!-- Tombol Hapus Baris dihilangkan jika dalam mode EDIT -->
                            @if (!isset($method) || $method !== 'PUT')
                                <td style="border: none;"><button type="button"
                                        class="text-red-500 hover:text-red-700 remove-row"
                                        style="cursor: pointer; background:none; border:none; padding:4px;">✕</button>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center row-no">
                                1
                                <input type="hidden" name="items[0][no]" value="1">
                            </td>
                            <td><input type="text" name="items[0][nama_informasi]"
                                    class="input-table input-table-left"></td>
                            <td>
                                <select name="items[0][metode_backup]" class="input-table">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($masterMetodes as $metode)
                                        <option value="{{ $metode->nama }}">{{ $metode->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="items[0][periode_backup]" class="input-table">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($masterPeriodes as $periode)
                                        <option value="{{ $periode->nama }}">{{ $periode->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="items[0][retensi]" class="input-table">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($masterRetensis as $retensi)
                                        <option value="{{ $retensi->nama }}">{{ $retensi->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="items[0][status]" class="input-table">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($masterStatuses as $status)
                                        <option value="{{ $status->nama }}">{{ $status->nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            @if (!isset($method) || $method !== 'PUT')
                                <td style="border: none;"><button type="button"
                                        class="text-red-500 hover:text-red-700 remove-row"
                                        style="cursor: pointer; background:none; border:none; padding:4px;">✕</button>
                                </td>
                            @endif
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Jika CREATE: Muncul tombol Tambah Baris -->
            @if (!isset($method) || $method !== 'PUT')
                <button type="button" id="add-row"
                    style="padding: 6px 12px; background: #e5e7eb; border: 1px solid #d1d5db; border-radius: 4px; font-size: 11px; cursor: pointer; margin-bottom: 20px; margin-top: 5px;">+
                    Tambah Baris</button>
            @else
                <!-- Jika EDIT: Muncul EOF untuk pertanda tabel terkunci -->
                <div
                    style="text-align: center; font-weight: bold; margin-top: 10px; margin-bottom: 20px; font-size: 11px; letter-spacing: 0.5px;">
                    ===== End Of File =====
                </div>
            @endif

            <!-- Keterangan Full BOLD dan menjorok -->
            <p class="footer-note">
                <strong>Ket: Backup untuk informasi lain di luar tabel tersebut dapat dilakukan sesuai dengan diskresi
                    Pemilik Informasi dengan tetap memperhatikan langkah-langkah pengamanan informasi sesuai kebijakan
                    dan prosedur.</strong>
            </p>

            <!-- Tanda Tangan Normal Text (Bukan Bold) -->
            <div class="footer-section clearfix">
                <div class="signature-box">

                    <div style="display: flex; justify-content: center; align-items: center; gap: 5px;">
                        <input type="text" name="kota_tanggal" id="kota_tanggal"
                            value="{{ old('kota_tanggal', $form->kota_tanggal) }}" class="input-transparent"
                            style="width: 100%; text-align: center; border:none; font-weight: normal; pointer-events:none;"
                            placeholder="Kota, Tanggal" readonly>
                    </div>

                    <!-- Dropdown Pimpinan -->
                    <select id="signer-select" class="input-transparent"
                        style="margin-top: 5px; text-align: center; border-bottom: 1px solid #000; font-weight: normal;">
                        <option value="">Pimpinan Masing-Masing Unit</option>
                        @foreach ($masterPimpinans as $pimpinan)
                            <!-- Tambahkan data-nipp -->
                            <option value="{{ $pimpinan->jabatan }}" data-nama="{{ $pimpinan->nama }}"
                                data-nipp="{{ $pimpinan->nipp ?? '' }}"
                                {{ old('mengetahui_jabatan', $form->mengetahui_jabatan) == $pimpinan->jabatan ? 'selected' : '' }}>
                                {{ $pimpinan->jabatan }}
                            </option>
                        @endforeach
                    </select>

                    <input type="hidden" name="mengetahui_jabatan" id="mengetahui_jabatan"
                        value="{{ old('mengetahui_jabatan', $form->mengetahui_jabatan) }}">
                    <input type="hidden" name="mengetahui_nama" id="mengetahui_nama"
                        value="{{ old('mengetahui_nama', $form->mengetahui_nama) }}">
                    <input type="hidden" name="mengetahui_nipp" id="mengetahui_nipp"
                        value="{{ old('mengetahui_nipp', $form->mengetahui_nipp) }}">

                    <div style="height: 60px;"></div>

                    <!-- Tampilan Nama dan NIPP di Form -->
                    <p style="text-decoration: underline; margin-bottom: 2px;">
                        <strong
                            id="display_nama">{{ old('mengetahui_nama', $form->mengetahui_nama) ?: '(..................................................)' }}</strong>
                    </p>
                    <p style="margin-top: 0;">
                        NIPP. <span
                            id="display_nipp">{{ old('mengetahui_nipp', $form->mengetahui_nipp) ?: '....................' }}</span>
                    </p>

                </div>
            </div>

        </div>
    </div>
</form>

<script>
    const metodeOptions =
        `@foreach ($masterMetodes as $m)<option value="{{ $m->nama }}">{{ $m->nama }}</option>@endforeach`;
    const periodeOptions =
        `@foreach ($masterPeriodes as $p)<option value="{{ $p->nama }}">{{ $p->nama }}</option>@endforeach`;
    const retensiOptions =
        `@foreach ($masterRetensis as $r)<option value="{{ $r->nama }}">{{ $r->nama }}</option>@endforeach`;
    const statusOptions =
        `@foreach ($masterStatuses as $s)<option value="{{ $s->nama }}">{{ $s->nama }}</option>@endforeach`;

    // Menghitung jumlah halaman A4 secara otomatis
    function updatePageCount() {
        const container = document.querySelector('.a4-container');
        const pageNumber = document.getElementById('page-number');

        if (!container || !pageNumber) {
            return;
        }

        const onePageHeight = container.clientHeight;

        const totalPages = Math.max(
            1,
            Math.ceil((container.scrollHeight - 10) / onePageHeight)
        );

        pageNumber.textContent = `1 dari ${totalPages}`;
    }

    // Update Kota & Tanggal di Tanda Tangan
    function updateTandaTangan() {
        const tglInput = document.getElementById('tanggal').value;
        const baSelect = document.getElementById('business_area');
        const selectedBa = baSelect.options[baSelect.selectedIndex];

        let kota = selectedBa ? selectedBa.getAttribute('data-kota') : '';
        let kotaTanggalField = document.getElementById('kota_tanggal');

        if (tglInput && kota) {
            const dateObj = new Date(tglInput);
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                "Oktober", "November", "Desember"
            ];
            const tglIndo = `${dateObj.getDate()} ${months[dateObj.getMonth()]} ${dateObj.getFullYear()}`;

            kotaTanggalField.value = `${kota}, ${tglIndo}`;
        } else if (!tglInput && !kota) {
            kotaTanggalField.value = '';
        }
    }

    window.addEventListener('load', function() {
        updatePageCount();
        updateTandaTangan();
    });
    window.addEventListener('resize', updatePageCount);
    window.addEventListener('beforeprint', updatePageCount);

    // Menangani Input Ref
    const ref1 = document.getElementById('ref_1');
    const ref2 = document.getElementById('ref_2');
    const ref3 = document.getElementById('ref_3');
    const noRefHidden = document.getElementById('real_no_ref');

    function updateRef() {
        noRefHidden.value = ref1.value + '/' + ref2.value + '/' + ref3.value;
    }

    [ref1, ref2, ref3].forEach((el, index, arr) => {
        el.addEventListener('input', updateRef);
        el.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === 'ArrowRight') {
                e.preventDefault();
                if (index < arr.length - 1) arr[index + 1].focus();
            } else if (e.key === 'ArrowLeft') {
                e.preventDefault();
                if (index > 0) arr[index - 1].focus();
            }
        });
    });

    // Fungsi Tambah Baris Dinamis (Murni Kosong)
    const addRowBtn = document.getElementById('add-row');
    if (addRowBtn) {
        addRowBtn.addEventListener('click', function() {
            let tbody = document.querySelector('#table-items tbody');
            let rows = tbody.querySelectorAll('tr');
            let index = rows.length;

            let newRow = `
            <tr>
                <td class="text-center row-no">
                    ${index + 1}
                    <input type="hidden" name="items[${index}][no]" value="${index + 1}">
                </td>
                <td><input type="text" name="items[${index}][nama_informasi]" value="" class="input-table input-table-left"></td>
                <td><select name="items[${index}][metode_backup]" class="input-table"><option value="">-- Pilih --</option>${metodeOptions}</select></td>
                <td><select name="items[${index}][periode_backup]" class="input-table"><option value="">-- Pilih --</option>${periodeOptions}</select></td>
                <td><select name="items[${index}][retensi]" class="input-table"><option value="">-- Pilih --</option>${retensiOptions}</select></td>
                <td><select name="items[${index}][status]" class="input-table"><option value="">-- Pilih --</option>${statusOptions}</select></td>
                <td style="border: none;"><button type="button" class="text-red-500 hover:text-red-700 remove-row" style="cursor: pointer; background:none; border:none; padding:4px;">✕</button></td>
            </tr>`;

            tbody.insertAdjacentHTML('beforeend', newRow);
            updatePageCount();
        });
    }

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
            document.querySelectorAll('#table-items tbody tr').forEach((row, idx) => {
                row.querySelector('.row-no').childNodes[0].textContent = idx + 1;
                row.querySelector('input[name$="[no]"]').value = idx + 1;
                row.querySelectorAll('input, select').forEach(input => {
                    input.name = input.name.replace(/\[\d+\]/, '[' + idx + ']');
                });
            });
            updatePageCount();
        }
    });

    // Script Update Pimpinan dari Dropdown yang berisi Jabatan
    document.getElementById('signer-select').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];

        let jabatan = selected.value;
        let nama = selected.getAttribute('data-nama') || '';
        let nipp = selected.getAttribute('data-nipp') || '';

        document.getElementById('mengetahui_jabatan').value = jabatan;
        document.getElementById('mengetahui_nama').value = nama;
        document.getElementById('mengetahui_nipp').value = nipp;

        // Update tampilan teks
        document.getElementById('display_nama').innerText = nama ? nama :
            '(..................................................)';
        document.getElementById('display_nipp').innerText = nipp ? nipp : '....................';
    });
</script>
