<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Petugas & Pengguna Sistem</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 3px 0 0 0; font-size: 11px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px 10px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .role-badge { display: inline-block; padding: 2px 6px; border-radius: 4px; font-weight: bold; font-size: 10px; text-transform: uppercase; }
        .petugas { background: #e0f2fe; color: #0369a1; }
        .pimpinan { background: #fef3c7; color: #b45309; }
        .admin { background: #f3e8ff; color: #6b21a8; }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #ea580c; color: #fff; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">
            🖨️ Cetak / Download PDF
        </button>
    </div>

    <div class="header">
        <h2>PT KERETA API INDONESIA (PERSERO)</h2>
        <h3>DAFTAR PETUGAS & PENGGUNA SISTEM FORMULIR</h3>
        <p>Dicetak pada: {{ date('d F Y H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">#</th>
                <th>Nama Lengkap</th>
                <th>Email Akses</th>
                <th>Peran (Role)</th>
                <th>NIPKWT / NIPP</th>
                <th>Unit Kerja / Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $u)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $u->name }}</strong></td>
                    <td>{{ $u->email }}</td>
                    <td>
                        <span class="role-badge {{ $u->role }}">{{ $u->role }}</span>
                    </td>
                    <td>{{ $u->nip_kwt ?: '-' }}</td>
                    <td>{{ $u->unit_kerja ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
