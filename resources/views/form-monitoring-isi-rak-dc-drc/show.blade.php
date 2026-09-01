<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Isi Rak DC / DRC - {{ $form->no_ref ?: 'Detail' }}</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #e2e8f0; margin: 0; padding: 20px; display: flex; flex-direction: column; align-items: center; }
        .a4-container { background-color: white; width: 297mm; min-height: 210mm; padding: 12mm 15mm; box-shadow: 0 10px 25px rgba(0,0,0,0.1); box-sizing: border-box; color: #000; position: relative; margin-bottom: 20px; font-size: 11px; }
        .kop-table { width: 100%; border-collapse: collapse; font-size: 11px; }
        .kop-table td { border: 1px solid #000; padding: 4px 6px; vertical-align: middle; }
        
        .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 10px; text-align: center; }
        .data-table th, .data-table td { border: 1px solid #000; padding: 4px 3px; position: relative; vertical-align: middle; }
        .data-table th { background-color: #7b94b0; color: #000; font-weight: bold; }
        
        .form-input-line { width: 100%; border: none; border-bottom: 1px solid black; outline: none; background: transparent; font-family: inherit; font-size: inherit; padding: 2px 4px; box-sizing: border-box; text-align: center; }

        .btn-print { padding: 8px 18px; background-color: #16a34a; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; }
        .btn-kembali { padding: 8px 18px; background-color: #64748b; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; }
        .btn-edit { padding: 8px 18px; background-color: #d97706; color: white; border: none; cursor: pointer; border-radius: 6px; font-weight: bold; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; }

        @page { size: A4 landscape; margin: 8mm 10mm; }
        @media print {
            body { margin: 0; padding: 0; background-color: white; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .a4-container { box-shadow: none; padding: 0; margin: 0; width: 100%; min-height: auto; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="width: 297mm; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('form-monitoring-isi-rak-dc-drc.index') }}" class="btn-kembali">
            &larr; Kembali ke Daftar
        </a>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('form-monitoring-isi-rak-dc-drc.edit', $form->id) }}" class="btn-edit">
                Edit Formulir
            </a>
            <button onclick="window.print()" class="btn-print">
                Cetak PDF
            </button>
        </div>
    </div>

    <div class="a4-container">
        <!-- Header Kop Table -->
        <table class="kop-table">
            <tr>
                <td rowspan="2" style="width: 18%; text-align: center; vertical-align: middle;">
                    <img src="{{ asset('images/logo-kai.svg') }}" alt="Logo KAI" style="width: 100%; max-width: 90px; height: auto; display: block; margin: 0 auto 6px auto;">
                    <div style="border: 2px solid #eadc04; color: #eadc04; font-weight: bold; font-size: 11px; padding: 2px 8px; display: inline-block;">TERBATAS</div>
                </td>
                <td rowspan="2" style="width: 54%; text-align: center; font-weight: bold; font-size: 12px; line-height: 1.4;">
                    PT. KERETA API INDONESIA (PERSERO)<br>
                    <span style="font-size: 11px; font-weight: normal;">Sistem Informasi</span><br>
                    FORMULIR<br>
                    MONITORING ISI RAK DC / DRC
                </td>
                <td style="width: 10%;">Nomor</td>
                <td style="width: 18%;">: {{ $formTemplate->no_dokumen ?? 'FR.SM/TI/015.024/10-2020' }}</td>
            </tr>
            <tr>
                <td>Tanggal Terbit</td>
                <td>: {{ $formTemplate->tanggal_dokumen ?? '12 Oktober 2020' }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;"></td>
                <td>Versi</td>
                <td>: {{ $formTemplate->versi_dokumen ?? '002-2020' }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;"></td>
                <td>Halaman</td>
                <td>: 1 dari 1</td>
            </tr>
        </table>

        <!-- Header Meta Information -->
        <table style="border-collapse: collapse; width: 250px; font-size: 11px; margin-top: 15px;">
            <tr>
                <td style="border: 1px solid black; padding: 3px 6px; width: 90px;">No Ref</td>
                <td style="border: 1px solid black; padding: 3px 6px; width: 10px; border-right: none;">:</td>
                <td style="border: 1px solid black; padding: 3px 6px; border-left: none; font-weight: bold;">
                    {{ $form->no_ref ?: '___/___/___' }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 3px 6px;">Tanggal</td>
                <td style="border: 1px solid black; padding: 3px 6px; border-right: none;">:</td>
                <td style="border: 1px solid black; padding: 3px 6px; border-left: none;">
                    {{ $form->tanggal ? \Carbon\Carbon::parse($form->tanggal)->format('d / m / Y') : '___/___/___' }}
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid black; padding: 3px 6px;">Business Area</td>
                <td style="border: 1px solid black; padding: 3px 6px; border-right: none;">:</td>
                <td style="border: 1px solid black; padding: 3px 6px; border-left: none;">
                    {{ $form->business_area ?: '_______' }}
                </td>
            </tr>
        </table>

        <!-- Rack Details -->
        <div style="font-size: 11px; margin-top: 15px; width: 350px;">
            <table style="width: 100%; border-collapse: collapse; font-size: 11px;">
                <tr>
                    <td style="width: 100px; padding: 2px 0; font-weight: bold;">Nomor Rak</td>
                    <td style="width: 15px;">:</td>
                    <td style="font-weight: bold;">{{ $form->nomor_rak ?: '' }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px 0; font-weight: bold;">Last Update</td>
                    <td>:</td>
                    <td>{{ $form->last_update ?: '' }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px 0; font-weight: bold;">Kode Rak</td>
                    <td>:</td>
                    <td>{{ $form->kode_rak ?: '' }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px 0; font-weight: bold;">Ukuran Rak</td>
                    <td>:</td>
                    <td>{{ $form->ukuran_rak ?: '' }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px 0; font-weight: bold;">Lokasi</td>
                    <td>:</td>
                    <td>{{ $form->lokasi ?: '' }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px 0; font-weight: bold;">Lantai</td>
                    <td>:</td>
                    <td>{{ $form->lantai ?: '' }}</td>
                </tr>
                <tr>
                    <td style="padding: 2px 0; font-weight: bold;">Alamat</td>
                    <td>:</td>
                    <td>{{ $form->alamat ?: '' }}</td>
                </tr>
            </table>
        </div>

        <!-- Data Grid Table -->
        <table class="data-table">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 30px;">No</th>
                    <th rowspan="2" style="width: 65px;">Cable</th>
                    <th rowspan="2" style="width: 50px;">PP</th>
                    <th rowspan="2" style="width: 75px;">ID Machine</th>
                    <th rowspan="2" style="width: 120px;">ID Server/Name Server</th>
                    <th rowspan="2" style="width: 65px;">PIC</th>
                    <th rowspan="2" style="width: 55px;">NIC</th>
                    <th rowspan="2" style="width: 60px;">Power (A)</th>
                    <th rowspan="2" style="width: 65px;">Weight (kg)</th>
                    <th colspan="2">Capacity</th>
                    <th colspan="2">IP Addres</th>
                    <th rowspan="2" style="width: 70px;">Status</th>
                    <th rowspan="2">Note</th>
                </tr>
                <tr>
                    <th style="width: 65px;">Storage (GB)</th>
                    <th style="width: 65px;">Memory (GB)</th>
                    <th style="width: 80px;">local</th>
                    <th style="width: 80px;">Public</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $displayItems = $form->items;
                    // Make sure at least 15 rows display visually like the original printed template
                    $totalRows = max(15, count($displayItems));
                @endphp
                @for ($i = 0; $i < $totalRows; $i++)
                    @php
                        $item = $displayItems[$i] ?? null;
                    @endphp
                    <tr>
                        <td style="font-weight: bold;">{{ $i + 1 }}</td>
                        <td>{{ $item->cable ?? '' }}</td>
                        <td>{{ $item->pp ?? '' }}</td>
                        <td>{{ $item->id_machine ?? '' }}</td>
                        <td style="text-align: left;">{{ $item->id_server_name_server ?? '' }}</td>
                        <td>{{ $item->pic ?? '' }}</td>
                        <td>{{ $item->nic ?? '' }}</td>
                        <td>{{ $item->power_a ?? '' }}</td>
                        <td>{{ $item->weight_kg ?? '' }}</td>
                        <td>{{ $item->capacity_storage_gb ?? '' }}</td>
                        <td>{{ $item->capacity_memory_gb ?? '' }}</td>
                        <td>{{ $item->ip_address_local ?? '' }}</td>
                        <td>{{ $item->ip_address_public ?? '' }}</td>
                        <td>{{ $item->status ?? '' }}</td>
                        <td style="text-align: left;">{{ $item->note ?? '' }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>

        <!-- Signature Block -->
        <div style="margin-top: 30px; display: flex; justify-content: flex-end;">
            <div style="width: 250px; text-align: center; font-size: 11px;">
                <div style="margin-bottom: 50px;">Mengetahui</div>
                <div style="font-weight: bold; text-decoration: underline;">
                    {{ $form->mengetahui_nama ?: '....................................' }}
                </div>
                <div style="margin-top: 4px;">
                    NIPP. {{ $form->mengetahui_nipp ?: '...................' }}
                </div>
            </div>
        </div>
    </div>

    @if(request()->has('print'))
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
    @endif
</body>
</html>
