@php
    $checklistValues = $item->checklist ?? [];
@endphp
<tr>
    <td class="ef-row-number">{{ $idx + 1 }}</td>
    <td class="ef-data-left">
        <input type="text" name="items[{{ $idx }}][nama_aset]" value="{{ old("items.$idx.nama_aset", $item->nama_aset ?? '') }}" placeholder="Contoh: PC Loket 1">
    </td>
    <td class="ef-data-left">
        <input type="text" name="items[{{ $idx }}][id_aset]" value="{{ old("items.$idx.id_aset", $item->id_aset ?? '') }}" placeholder="ID aset">
    </td>
    <td class="ef-data-left">
        <input type="text" name="items[{{ $idx }}][nipp]" value="{{ old("items.$idx.nipp", $item->nipp ?? '') }}" placeholder="NIPP">
    </td>
    @foreach ($checklistItems as $key => $label)
        @php $current = old("items.$idx.checklist.$key", $checklistValues[$key] ?? 'na'); @endphp
        <td>
            <select name="items[{{ $idx }}][checklist][{{ $key }}]" class="ef-chk-select opt-{{ $current }}" onchange="this.className='ef-chk-select opt-' + this.value" title="{{ $label }}">
                <option value="na" {{ $current === 'na' ? 'selected' : '' }}>&ndash;</option>
                <option value="ok" {{ $current === 'ok' ? 'selected' : '' }}>&#10003;</option>
                <option value="tidak" {{ $current === 'tidak' ? 'selected' : '' }}>&#10007;</option>
            </select>
        </td>
    @endforeach
    <td class="ef-data-left">
        <input type="text" name="items[{{ $idx }}][paraf]" value="{{ old("items.$idx.paraf", $item->paraf ?? '') }}" placeholder="Paraf">
    </td>
    <td><button type="button" class="ef-remove-btn" onclick="removeItemRow(this)" title="Hapus baris">&#10005;</button></td>
</tr>