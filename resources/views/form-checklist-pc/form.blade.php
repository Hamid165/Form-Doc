@php
    $form = $form_checklist_pc ?? null;
    $actionUrl = $isEdit
        ? route('form-checklist-pc.update', $form)
        : route('form-checklist-pc.store');
    $method = $isEdit ? 'PUT' : 'POST';
    $checklistItems = \App\Models\FormChecklistPc\FormChecklistPc::CHECKLIST_ITEMS;
    $checklistSymbols = ['ok' => '&#10003;', 'tidak' => '&#10007;', 'na' => '&ndash;'];
    $existingItems = $isEdit && $form ? $form->items : collect();
@endphp

<style>
    /* ==== Tampilan formulir editable, meniru layout kertas asli (show/pdf) ==== */
    .editform-wrapper { width: 100%; overflow-x: auto; padding-bottom: 10px; }
    .editform-sheet { width: 1587px; background: white; border: 1px solid #d1d5db; border-radius: 12px; padding: 24px; box-sizing: border-box; margin: 0 auto; box-shadow: 0 1px 3px rgba(0,0,0,0.08); }
    .editform-sheet table { border-collapse: collapse; width: 100%; }
    .editform-sheet input[type=text], .editform-sheet input[type=date], .editform-sheet textarea, .editform-sheet select {
        font-family: inherit; border: none; background: transparent; outline: none; width: 100%; padding: 1px 2px; box-sizing: border-box;
    }
    .editform-sheet input:focus, .editform-sheet textarea:focus, .editform-sheet select:focus { background-color: #eff6ff; border-radius: 3px; }

    .ef-header-table td { border: 1px solid black; padding: 4px 6px; vertical-align: middle; font-size: 10px; }
    .ef-title-text { font-size: 12px; font-weight: bold; text-align: center; }
    .ef-terbatas-box { border: 2px solid #eab308; color: #eab308; padding: 4px 14px; font-weight: bold; font-size: 13px; display: inline-block; }

    .ef-info-table { width: 32%; margin: 8px 0; }
    .ef-info-table td { border: 1px solid black; padding: 3px 6px; font-size: 10px; }
    .ef-info-table .ef-label { width: 110px; font-weight: bold; }
    .ef-info-table input { font-size: 10px; }

    .ef-main-table { table-layout: fixed; margin-top: 4px; }
    .ef-main-table th, .ef-main-table td { border: 1px solid black; padding: 2px 3px; font-size: 9px; vertical-align: middle; text-align: center; word-wrap: break-word; }
    .ef-main-table thead th { background-color: #b0c4de; font-weight: bold; }
    .ef-group-header { font-size: 10px; }
    .ef-vert-cell { height: 170px; padding: 0; vertical-align: bottom; }
    .ef-vert-clip { position: relative; width: 100%; height: 170px; overflow: hidden; }
    .ef-vert-cell .ef-vert-label { position: absolute; bottom: 4px; left: 50%; white-space: nowrap; font-size: 7px; font-weight: normal; transform: rotate(-90deg); transform-origin: left bottom; }
    .ef-num-row th { font-size: 9px; height: 16px; }
    .ef-col-no { width: 3%; }
    .ef-col-aset { width: 12%; }
    .ef-col-idaset { width: 7.5%; }
    .ef-col-nipp { width: 8%; }
    .ef-col-chk { width: 2.6%; }
    .ef-col-paraf { width: 7.5%; }
    .ef-col-aksi { width: 2.8%; }
    .ef-data-left input { text-align: left; font-size: 9px; }
    .ef-chk-select { font-size: 11px; text-align: center; text-align-last: center; cursor: pointer; }
    .ef-chk-select.opt-ok { color: #16a34a; font-weight: bold; }
    .ef-chk-select.opt-tidak { color: #dc2626; font-weight: bold; }
    .ef-chk-select.opt-na { color: #9ca3af; }
    .ef-remove-btn { border: none; background: none; color: #dc2626; cursor: pointer; font-size: 13px; line-height: 1; padding: 2px; }
    .ef-remove-btn:hover { color: #991b1b; }
    .ef-add-row-wrap { padding: 6px 0; text-align: left; }
    .ef-add-row-btn { font-size: 11px; color: #2563eb; border: 1px dashed #93c5fd; background: #eff6ff; padding: 4px 10px; border-radius: 6px; cursor: pointer; font-family: inherit; }
    .ef-add-row-btn:hover { background: #dbeafe; }

    .ef-bottom-section { display: flex; gap: 20px; margin-top: 10px; align-items: flex-start; }
    .ef-keterangan-box { flex: 1; font-size: 9px; line-height: 1.5; }
    .ef-keterangan-box ul { margin-left: 16px; }
    .ef-analisa-wrap { flex: 1; font-size: 10px; }
    .ef-analisa-wrap .ef-analisa-title { display: block; font-weight: bold; text-transform: uppercase; margin-bottom: 4px; }
    .ef-analisa-box { border: 1px solid black; padding: 6px; }
    .ef-analisa-box textarea { min-height: 80px; font-size: 10px; resize: vertical; }

    .ef-signature-table { width: 45%; margin-top: 20px; }
    .ef-signature-table td.ef-sig-cell { border: 1px solid black; padding: 6px; vertical-align: top; font-size: 10px; height: 90px; }
    .ef-signature-table .ef-sig-title { font-weight: bold; text-align: left; text-transform: uppercase; }
    .ef-signature-table .ef-sig-body { text-align: center; margin-top: 40px; }
    .ef-signature-table .ef-sig-name-input { border-bottom: 1px dotted black !important; text-align: center; font-weight: bold; min-width: 160px; display: inline-block; width: auto; }

    .ef-toolbar { position: sticky; top: 0; z-index: 20; background: #f8fafc; border-bottom: 1px solid #e5e7eb; padding: 10px 4px; margin-bottom: 14px; display: flex; justify-content: flex-end; gap: 10px; }
</style>

@if ($errors->any())
<div class="mb-6 bg-[#fef2f2] border border-[#fecaca] rounded-xl p-4 shadow-sm">
    <h4 class="text-sm font-bold text-red-700 mb-2">Terdapat kesalahan pada form:</h4>
    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ $actionUrl }}" id="checklist-pc-form">
    @csrf
    @method($method)

    <div class="ef-toolbar">
        <a href="{{ route('form-checklist-pc.index') }}" class="px-5 py-2.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors font-medium text-gray-700 bg-white">Batal</a>
        <button type="submit" class="px-5 py-2.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-semibold shadow-sm">
            {{ $isEdit ? 'Perbarui Formulir' : 'Simpan Formulir' }}
        </button>
    </div>

    <div class="editform-wrapper">
    <div class="editform-sheet">

        {{-- KOP SURAT (statis, sama seperti formulir resmi) --}}
        <table class="ef-header-table">
            <tr>
                <td rowspan="2" style="width:10%; text-align:center;">
                    <img src="{{ asset('images/logo-kai.svg') }}" alt="KAI" style="max-width:100%; max-height:50px;">
                </td>
                <td rowspan="2" class="ef-title-text" style="width:32%;">
                    PT. KERETA API INDONESIA (PERSERO)<br>SISTEM INFORMASI
                </td>
                <td style="width:10%;">No. Dokumen</td>
                <td style="width:18%;">: FR.SM/TI/015.002/10-2020</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: 12 Oktober 2020</td>
            </tr>
            <tr>
                <td rowspan="2" style="text-align:center;">
                    <div class="ef-terbatas-box">TERBATAS</div>
                </td>
                <td rowspan="2" class="ef-title-text">FORMULIR CHECKLIST PEMELIHARAAN PC-NOTEBOOK-PRINTER</td>
                <td>Versi</td>
                <td>: 003-2020</td>
            </tr>
            <tr>
                <td>Halaman</td>
                <td>: 1 dari 1</td>
            </tr>
        </table>

        {{-- INFO SECTION: langsung bisa diisi di tempat --}}
        <table class="ef-info-table">
            <tr>
                <td class="ef-label">No. Ref</td>
                <td>: <input type="text" name="no_ref" value="{{ old('no_ref', $form->no_ref ?? '') }}" placeholder="Contoh: 001/CHK-PC/VII/2026"></td>
            </tr>
            <tr>
                <td class="ef-label">Tanggal</td>
                <td>: <input type="date" name="tanggal" value="{{ old('tanggal', $form && $form->tanggal ? $form->tanggal->format('Y-m-d') : '') }}"></td>
            </tr>
            <tr>
                <td class="ef-label">Business Area</td>
                <td>: <input type="text" name="business_area" value="{{ old('business_area', $form->business_area ?? '') }}" placeholder="Contoh: DAOP 6 Yogyakarta"></td>
            </tr>
        </table>

        {{-- TABEL UTAMA: aset & checklist, langsung diisi baris per baris --}}
        <table class="ef-main-table">
            <thead>
                <tr>
                    <th rowspan="3" class="ef-col-no">No</th>
                    <th rowspan="3" class="ef-col-aset">Nama Aset</th>
                    <th rowspan="3" class="ef-col-idaset">ID Aset</th>
                    <th rowspan="3" class="ef-col-nipp">NIPP</th>
                    <th colspan="9" class="ef-group-header">Checklist Fungsional Sistem</th>
                    <th colspan="12" class="ef-group-header">Checklist Fungsional Fisik</th>
                    <th rowspan="3" class="ef-col-paraf">Paraf</th>
                    <th rowspan="3" class="ef-col-aksi"></th>
                </tr>
                <tr>
                    @foreach ($checklistItems as $key => $label)
                        <th class="ef-col-chk ef-vert-cell"><div class="ef-vert-clip"><span class="ef-vert-label">{{ $label }}</span></div></th>
                    @endforeach
                </tr>
                <tr class="ef-num-row">
                    @foreach ($checklistItems as $key => $label)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody id="items-tbody">
            @if ($isEdit && $existingItems->count() > 0)
                @foreach ($existingItems as $idx => $item)
                    @include('form-checklist-pc._item-row', ['idx' => $idx, 'item' => $item, 'checklistItems' => $checklistItems])
                @endforeach
            @else
                @include('form-checklist-pc._item-row', ['idx' => 0, 'item' => null, 'checklistItems' => $checklistItems])
            @endif
            </tbody>
        </table>
        <div class="ef-add-row-wrap">
            <button type="button" onclick="addItemRow()" class="ef-add-row-btn">+ Tambah Aset</button>
        </div>

        {{-- KETERANGAN & ANALISA --}}
        <div class="ef-bottom-section">
            <div class="ef-keterangan-box">
                <strong>Keterangan:</strong>
                <ul>
                    <li>point checklist 2 mencakup: .tmp, .chk, file dengan tanda ~</li>
                    <li>point checklist 3 mencakup: file .zip &amp; draft yg tidak lagi digunakan, konfirmasikan terlebih dahulu kepada pengguna</li>
                    <li>point checklist 4: lakukan defragment HDD hanya jika diperlukan</li>
                    <li>point checklist 14 mencakup: display port, HDMI port, USB port</li>
                    <li>point checklist 15 mencakup: keyboard, trackpad, numerik pads, panel kontrol</li>
                </ul>
            </div>
            <div class="ef-analisa-wrap">
                <span class="ef-analisa-title">Analisa dan Kesimpulan Hasil Pemeriksaan :</span>
                <div class="ef-analisa-box">
                    <textarea name="analisa_kesimpulan" placeholder="Uraian mengenai hasil analisa dari pemeriksaan aset, beserta kesimpulan">{{ old('analisa_kesimpulan', $form->analisa_kesimpulan ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- TANDA TANGAN --}}
        <table class="ef-signature-table">
            <tr>
                <td class="ef-sig-cell" style="width:62%;">
                    <div class="ef-sig-title">PELAKSANA PEMERIKSAAN</div>
                    <div class="ef-sig-body" style="margin-top:65px;">
                        (<input type="text" name="pelaksana_name" class="ef-sig-name-input" value="{{ old('pelaksana_name', $form->pelaksana_name ?? '') }}" placeholder="Nama pelaksana">)
                    </div>
                </td>
                <td class="ef-sig-cell" style="width:38%;">
                    <div class="ef-sig-title">TANGGAL PEMERIKSAAN</div>
                    <div class="ef-sig-body">
                        <input type="date" name="tanggal_pemeriksaan" class="ef-sig-name-input" value="{{ old('tanggal_pemeriksaan', $form && $form->tanggal_pemeriksaan ? $form->tanggal_pemeriksaan->format('Y-m-d') : '') }}">
                    </div>
                </td>
            </tr>
        </table>

    </div>
    </div>
</form>

@section('scripts')
<script>
    let rowIndex = {{ $isEdit && $existingItems->count() > 0 ? $existingItems->count() : 1 }};
    const checklistItemsJs = @json($checklistItems);

    function buildChecklistCells(idx) {
        let html = '';
        Object.keys(checklistItemsJs).forEach(function (key) {
            html += `
                <td>
                    <select name="items[${idx}][checklist][${key}]" class="ef-chk-select opt-na" onchange="this.className='ef-chk-select opt-' + this.value" title="${checklistItemsJs[key]}">
                        <option value="na" selected>&ndash;</option>
                        <option value="ok">&#10003;</option>
                        <option value="tidak">&#10007;</option>
                    </select>
                </td>`;
        });
        return html;
    }

    function getRowTemplate(idx) {
        return `<tr>
            <td class="ef-row-number">${idx + 1}</td>
            <td class="ef-data-left"><input type="text" name="items[${idx}][nama_aset]" placeholder="Contoh: PC Loket 1"></td>
            <td class="ef-data-left"><input type="text" name="items[${idx}][id_aset]" placeholder="ID aset"></td>
            <td class="ef-data-left"><input type="text" name="items[${idx}][nipp]" placeholder="NIPP"></td>
            ${buildChecklistCells(idx)}
            <td class="ef-data-left"><input type="text" name="items[${idx}][paraf]" placeholder="Paraf"></td>
            <td><button type="button" class="ef-remove-btn" onclick="removeItemRow(this)" title="Hapus baris">&#10005;</button></td>
        </tr>`;
    }

    function addItemRow() {
        const tbody = document.getElementById('items-tbody');
        const wrapper = document.createElement('tbody');
        wrapper.innerHTML = getRowTemplate(rowIndex++);
        tbody.appendChild(wrapper.firstElementChild);
        renumberRows();
    }

    function removeItemRow(btn) {
        const tbody = document.getElementById('items-tbody');
        if (tbody.querySelectorAll('tr').length > 1) {
            btn.closest('tr').remove();
            renumberRows();
        }
    }

    function renumberRows() {
        document.querySelectorAll('#items-tbody tr').forEach(function (tr, i) {
            const numCell = tr.querySelector('.ef-row-number');
            if (numCell) numCell.textContent = i + 1;
        });
    }
</script>
@endsection