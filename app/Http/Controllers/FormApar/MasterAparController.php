<?php

namespace App\Http\Controllers\FormApar;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FormApar\MasterApar;
use App\Models\FormApar\AparHistory;

class MasterAparController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kode_aset'          => 'required|string|max:100|unique:master_apars,kode_aset',
            'merk'               => 'nullable|string|max:255',
            'tipe'               => 'nullable|string|max:255',
            'seri'               => 'nullable|string|max:255',
            'media'              => 'nullable|string|max:255',
            'jenis'              => 'nullable|string|max:255',
            'kapasitas'          => 'nullable|string|max:100',
            'lokasi'             => 'nullable|string|max:255',
            'sub_lokasi'         => 'nullable|string|max:255',
            'tanggal_isi_ulang'  => 'nullable|date',
            'tanggal_kadaluarsa' => 'nullable|date',
            'vendor_id'          => 'nullable|exists:master_vendors,id',
        ], [
            'kode_aset.unique' => 'Kode aset ini sudah terdaftar. Gunakan kode yang berbeda.',
        ]);

        $existingApar = MasterApar::where('seri', $request->seri)->first();
        // Jika nomor seri sudah dipakai APAR yang masih aktif
        if ($existingApar && $existingApar->status == 'Aktif') {
           

            return back()
                ->withInput()
                ->withErrors([
                    'seri' => 'Nomor seri tersebut sudah digunakan oleh APAR aktif.'
                ]);
        }
        

         // Jika nomor seri ditemukan tetapi APAR Non Aktif
        if ($existingApar && $existingApar->status == 'Non Aktif') {

    $existingApar->update([

        'merk'               => $request->merk,
        'tipe'               => $request->tipe,
        'seri'               => $request->seri,
        'media'              => $request->media,
        'jenis'              => $request->jenis,
        'kapasitas'          => $request->kapasitas,
        'lokasi'             => $request->lokasi,
        'sub_lokasi'         => $request->sub_lokasi,
        'tanggal_isi_ulang'  => $request->tanggal_isi_ulang,
        'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
        'vendor_id'          => $request->vendor_id,
        'status'             => 'Aktif',

    ]);

    AparHistory::create([

        'master_apar_id'    => $existingApar->id,
        'jenis_perubahan'   => 'Aktivasi APAR',
        'data_lama'         => 'Non Aktif',
        'data_baru'         => 'Aktif',
        'kode_aset_lama'    => $existingApar->kode_aset,
        'kode_aset_baru'    => $existingApar->kode_aset,
        'tanggal_perubahan' => now()->toDateString(),
        'keterangan'        => "{$existingApar->kode_aset} diaktifkan kembali melalui menu Tambah APAR.",

    ]);

    return back()->with(
        'success',
        "APAR {$existingApar->kode_aset} berhasil diaktifkan kembali."
    );

}


        $newApar = MasterApar::create([

    'kode_aset'          => $request->kode_aset,
    'merk'               => $request->merk,
    'tipe'               => $request->tipe,
    'seri'               => $request->seri,
    'media'              => $request->media,
    'jenis'              => $request->jenis,
    'kapasitas'          => $request->kapasitas,
    'lokasi'             => $request->lokasi,
    'sub_lokasi'         => $request->sub_lokasi,
    'tanggal_isi_ulang'  => $request->tanggal_isi_ulang,
    'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
    'vendor_id'          => $request->vendor_id,
    'status'             => 'Aktif',

]);

AparHistory::create([

    'master_apar_id'    => $newApar->id,
    'jenis_perubahan'   => 'Tambah APAR',
    'data_lama'         => '-',
    'data_baru'         => $newApar->kode_aset,
    'kode_aset_lama'    => '-',
    'kode_aset_baru'    => $newApar->kode_aset,
    'tanggal_perubahan' => now()->toDateString(),
    'keterangan'        => "{$newApar->kode_aset} ditambahkan sebagai APAR baru.",

]);

return back()->with(
    'success',
    "Aset APAR {$newApar->kode_aset} berhasil ditambahkan."
);
    }

    public function update(Request $request, MasterApar $master_apar)
    {
        $request->validate([
            'lokasi'             => 'nullable|string|max:255',
            'sub_lokasi'         => 'nullable|string|max:255',
            'tanggal_isi_ulang'  => 'nullable|date',
            'tanggal_kadaluarsa' => 'nullable|date',
            'vendor_id'          => 'nullable|exists:master_vendors,id',
        ]);

        $oldVendor = $master_apar->vendor?->nama_vendor ?: '-';
        $oldLokasi = $master_apar->lokasi ?: '-';
        $oldSubLokasi = $master_apar->sub_lokasi ?: '-';
        $oldIsiUlang = $master_apar->tanggal_isi_ulang ? $master_apar->tanggal_isi_ulang->format('d/m/Y') : '-';
        $oldKadaluarsa = $master_apar->tanggal_kadaluarsa ? $master_apar->tanggal_kadaluarsa->format('d/m/Y') : '-';

        $master_apar->update($request->only([
            'lokasi', 'sub_lokasi', 'tanggal_isi_ulang', 'tanggal_kadaluarsa', 'vendor_id'
        ]));

        $master_apar->refresh();

        $newVendor = $master_apar->vendor?->nama_vendor ?: '-';
        $newLokasi = $master_apar->lokasi ?: '-';
        $newSubLokasi = $master_apar->sub_lokasi ?: '-';
        $newIsiUlang = $master_apar->tanggal_isi_ulang ? $master_apar->tanggal_isi_ulang->format('d/m/Y') : '-';
        $newKadaluarsa = $master_apar->tanggal_kadaluarsa ? $master_apar->tanggal_kadaluarsa->format('d/m/Y') : '-';

        if ($oldLokasi !== $newLokasi) {
            AparHistory::create([
                'master_apar_id'    => $master_apar->id,
                'jenis_perubahan'   => 'Lokasi',
                'data_lama'         => $oldLokasi,
                'data_baru'         => $newLokasi,
                'tanggal_perubahan' => now()->toDateString(),
                'keterangan'        => 'Data lokasi diperbarui.',
            ]);
        }

        if ($oldSubLokasi !== $newSubLokasi) {
            AparHistory::create([
                'master_apar_id'    => $master_apar->id,
                'jenis_perubahan'   => 'Sub Lokasi',
                'data_lama'         => $oldSubLokasi,
                'data_baru'         => $newSubLokasi,
                'tanggal_perubahan' => now()->toDateString(),
                'keterangan'        => 'Data sub lokasi diperbarui.',
            ]);
        }

        if ($oldVendor !== $newVendor) {
            AparHistory::create([
                'master_apar_id'    => $master_apar->id,
                'jenis_perubahan'   => 'Vendor',
                'data_lama'         => $oldVendor,
                'data_baru'         => $newVendor,
                'tanggal_perubahan' => now()->toDateString(),
                'keterangan'        => 'Data vendor diperbarui.',
            ]);
        }

        if ($oldIsiUlang !== $newIsiUlang) {
            AparHistory::create([
                'master_apar_id'    => $master_apar->id,
                'jenis_perubahan'   => 'Tanggal Isi Ulang',
                'data_lama'         => $oldIsiUlang,
                'data_baru'         => $newIsiUlang,
                'tanggal_perubahan' => now()->toDateString(),
                'keterangan'        => 'Tanggal isi ulang diperbarui.',
            ]);
        }

        if ($oldKadaluarsa !== $newKadaluarsa) {
            AparHistory::create([
                'master_apar_id'    => $master_apar->id,
                'jenis_perubahan'   => 'Tanggal Kedaluwarsa',
                'data_lama'         => $oldKadaluarsa,
                'data_baru'         => $newKadaluarsa,
                'tanggal_perubahan' => now()->toDateString(),
                'keterangan'        => 'Tanggal kedaluwarsa diperbarui.',
            ]);
        }

        return back()->with('success', "Aset APAR {$master_apar->kode_aset} berhasil diperbarui.");
    }

    public function reactivate(Request $request, MasterApar $master_apar)
{
    $request->validate([
        'lokasi'             => 'required|string|max:255',
        'sub_lokasi'         => 'nullable|string|max:255',
        'tanggal_isi_ulang'  => 'required|date',
        'tanggal_kadaluarsa' => 'required|date',
        'vendor_id'          => 'required|exists:master_vendors,id',
    ]);

    // Simpan data lama untuk History
    $oldVendor = $master_apar->vendor?->nama_vendor ?: '-';
    $oldLokasi = $master_apar->lokasi ?: '-';
    $oldSubLokasi = $master_apar->sub_lokasi ?: '-';
    $oldIsiUlang = $master_apar->tanggal_isi_ulang
        ? $master_apar->tanggal_isi_ulang->format('d/m/Y')
        : '-';
    $oldKadaluarsa = $master_apar->tanggal_kadaluarsa
        ? $master_apar->tanggal_kadaluarsa->format('d/m/Y')
        : '-';

    // Aktifkan kembali APAR
    $master_apar->update([
        'status'             => 'Aktif',
        'lokasi'             => $request->lokasi,
        'sub_lokasi'         => $request->sub_lokasi,
        'tanggal_isi_ulang'  => $request->tanggal_isi_ulang,
        'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
        'vendor_id'          => $request->vendor_id,
    ]);

    $master_apar->refresh();

    // Data baru
    $newVendor = $master_apar->vendor?->nama_vendor ?: '-';
    $newLokasi = $master_apar->lokasi ?: '-';
    $newSubLokasi = $master_apar->sub_lokasi ?: '-';
    $newIsiUlang = $master_apar->tanggal_isi_ulang
        ? $master_apar->tanggal_isi_ulang->format('d/m/Y')
        : '-';
    $newKadaluarsa = $master_apar->tanggal_kadaluarsa
        ? $master_apar->tanggal_kadaluarsa->format('d/m/Y')
        : '-';

    // Catat perubahan lokasi
    if ($oldLokasi !== $newLokasi) {
        AparHistory::create([
            'master_apar_id'    => $master_apar->id,
            'jenis_perubahan'   => 'Lokasi',
            'data_lama'         => $oldLokasi,
            'data_baru'         => $newLokasi,
            'tanggal_perubahan' => now()->toDateString(),
            'keterangan'        => 'Lokasi diperbarui saat APAR diaktifkan kembali.',
        ]);
    }

    // Catat perubahan sub lokasi
    if ($oldSubLokasi !== $newSubLokasi) {
        AparHistory::create([
            'master_apar_id'    => $master_apar->id,
            'jenis_perubahan'   => 'Sub Lokasi',
            'data_lama'         => $oldSubLokasi,
            'data_baru'         => $newSubLokasi,
            'tanggal_perubahan' => now()->toDateString(),
            'keterangan'        => 'Sub lokasi diperbarui saat APAR diaktifkan kembali.',
        ]);
    }

    // Catat perubahan vendor
    if ($oldVendor !== $newVendor) {
        AparHistory::create([
            'master_apar_id'    => $master_apar->id,
            'jenis_perubahan'   => 'Vendor',
            'data_lama'         => $oldVendor,
            'data_baru'         => $newVendor,
            'tanggal_perubahan' => now()->toDateString(),
            'keterangan'        => 'Vendor diperbarui saat APAR diaktifkan kembali.',
        ]);
    }

    // Catat perubahan tanggal isi ulang
    if ($oldIsiUlang !== $newIsiUlang) {
        AparHistory::create([
            'master_apar_id'    => $master_apar->id,
            'jenis_perubahan'   => 'Tanggal Isi Ulang',
            'data_lama'         => $oldIsiUlang,
            'data_baru'         => $newIsiUlang,
            'tanggal_perubahan' => now()->toDateString(),
            'keterangan'        => 'Tanggal isi ulang diperbarui saat APAR diaktifkan kembali.',
        ]);
    }

    // Catat perubahan tanggal kedaluwarsa
    if ($oldKadaluarsa !== $newKadaluarsa) {
        AparHistory::create([
            'master_apar_id'    => $master_apar->id,
            'jenis_perubahan'   => 'Tanggal Kedaluwarsa',
            'data_lama'         => $oldKadaluarsa,
            'data_baru'         => $newKadaluarsa,
            'tanggal_perubahan' => now()->toDateString(),
            'keterangan'        => 'Tanggal kedaluwarsa diperbarui saat APAR diaktifkan kembali.',
        ]);
    }

    // Catat bahwa APAR diaktifkan kembali
    AparHistory::create([
        'master_apar_id'    => $master_apar->id,
        'jenis_perubahan'   => 'Aktivasi Kembali',
        'data_lama'         => 'Non Aktif',
        'data_baru'         => 'Aktif',
        'tanggal_perubahan' => now()->toDateString(),
        'keterangan'        => "Aset APAR {$master_apar->kode_aset} diaktifkan kembali.",
    ]);

    return back()->with(
        'success',
        "Aset APAR {$master_apar->kode_aset} berhasil diaktifkan kembali."
    );
}

    public function replaceCylinder(Request $request, MasterApar $master_apar)
    {
        $existingApar = MasterApar::where('seri', $request->seri)
            ->where('id', '!=', $master_apar->id)
            ->first();

        $rules = [
            'seri'               => 'required|string|max:255',
            'merk'               => 'required|string|max:255',
            'tipe'               => 'required|string|max:255',
            'media'              => 'required|string|max:255',
            'jenis'              => 'nullable|string|max:255',
            'kapasitas'          => 'required|string|max:100',
            'lokasi'             => 'required|string|max:255',
            'sub_lokasi'         => 'nullable|string|max:255',
            'tanggal_isi_ulang'  => 'required|date',
            'tanggal_kadaluarsa' => 'required|date',
            'vendor_id'          => 'required|exists:master_vendors,id',
        ];

        if (!$existingApar) {
            $rules['kode_aset'] = 'required|string|max:100|unique:master_apars,kode_aset';
        } else {
            $rules['kode_aset'] = 'required|string|max:100';
        }

        $request->validate($rules, [
            'kode_aset.unique' => 'Kode aset baru ini sudah terdaftar. Gunakan kode yang berbeda.',
        ]);

        // 1. Ubah status aset lama menjadi Non Aktif
        $master_apar->update(['status' => 'Non Aktif']);

        if ($existingApar) {
            // 2. Aktifkan kembali aset lama sesuai nomor seri
            $existingApar->update([
                'status'             => 'Aktif',
                'seri'               => $request->seri,
                'merk'               => $request->merk,
                'tipe'               => $request->tipe,
                'media'              => $request->media,
                'jenis'              => $request->jenis,
                'kapasitas'          => $request->kapasitas,
                'lokasi'             => $request->lokasi,
                'sub_lokasi'         => $request->sub_lokasi,
                'tanggal_isi_ulang'  => $request->tanggal_isi_ulang,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                'vendor_id'          => $request->vendor_id,
            ]);

            // 3. Catat di History
            AparHistory::create([
                'master_apar_id'    => $existingApar->id,
                'jenis_perubahan'   => 'Penggantian Aset APAR',
                'data_lama'         => $master_apar->kode_aset,
                'data_baru'         => $existingApar->kode_aset,
                'kode_aset_lama'    => $master_apar->kode_aset,
                'kode_aset_baru'    => $existingApar->kode_aset,
                'tanggal_perubahan' => now()->toDateString(),
                'keterangan'        => "{$existingApar->kode_aset} diaktifkan kembali sesuai Nomor Seri yang terdaftar, sedangkan {$master_apar->kode_aset} dinonaktifkan.",
            ]);

            return back()->with('success', "Proses penggantian aset APAR berhasil: mengaktifkan kembali {$existingApar->kode_aset} dan menonaktifkan {$master_apar->kode_aset}.");
        } else {
            // 2. Buat aset baru
            $newApar = MasterApar::create([
                'kode_aset'          => $request->kode_aset,
                'seri'               => $request->seri,
                'merk'               => $request->merk,
                'tipe'               => $request->tipe,
                'media'              => $request->media,
                'jenis'              => $request->jenis,
                'kapasitas'          => $request->kapasitas,
                'lokasi'             => $request->lokasi,
                'sub_lokasi'         => $request->sub_lokasi,
                'tanggal_isi_ulang'  => $request->tanggal_isi_ulang,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                'vendor_id'          => $request->vendor_id,
                'status'             => 'Aktif',
            ]);

            // 3. Catat di History
            AparHistory::create([
                'master_apar_id'    => $newApar->id,
                'jenis_perubahan'   => 'Penggantian Aset APAR',
                'data_lama'         => $master_apar->kode_aset,
                'data_baru'         => $newApar->kode_aset,
                'kode_aset_lama'    => $master_apar->kode_aset,
                'kode_aset_baru'    => $newApar->kode_aset,
                'tanggal_perubahan' => now()->toDateString(),
                'keterangan'        => "{$newApar->kode_aset} ditetapkan sebagai aset aktif sebagai pengganti, sedangkan {$master_apar->kode_aset} dinonaktifkan.",
            ]);

            return back()->with('success', "Proses penggantian aset APAR dari {$master_apar->kode_aset} ke {$newApar->kode_aset} berhasil disimpan.");
        }
    }

    public function destroy(MasterApar $master_apar)
    {
        $kode = $master_apar->kode_aset;
        $master_apar->delete();

        return back()->with('success', "Aset APAR {$kode} berhasil dihapus.");
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(
                new \App\Imports\FormApar\MasterAparImport,
                $request->file('file')
            );
            return back()->with('success', 'Data master APAR berhasil diimpor!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('APAR Import Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat impor data. Pastikan format file benar.');
        }
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\FormApar\MasterAparTemplateExport,
            'Template_Data_APAR.xlsx'
        );
    }

    public function getInfo(MasterApar $master_apar)
    {
        return response()->json([
            'id'                 => $master_apar->id,
            'kode_aset'          => $master_apar->kode_aset,
            'merk'               => $master_apar->merk,
            'tipe'               => $master_apar->tipe,
            'seri'               => $master_apar->seri,
            'media'              => $master_apar->media,
            'jenis'              => $master_apar->jenis,
            'kapasitas'          => $master_apar->kapasitas,
            'lokasi'             => $master_apar->lokasi,
            'sub_lokasi'         => $master_apar->sub_lokasi,
            'tanggal_isi_ulang'  => $master_apar->tanggal_isi_ulang ? $master_apar->tanggal_isi_ulang->format('Y-m-d') : '',
            'tanggal_kadaluarsa' => $master_apar->tanggal_kadaluarsa ? $master_apar->tanggal_kadaluarsa->format('Y-m-d') : '',
            'vendor_id'          => $master_apar->vendor_id,
        ]);
    }
}
