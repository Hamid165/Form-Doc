<?php

namespace App\Http\Controllers\FormBaItServices;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormBaItServices\BaItService;
use App\Models\FormCctv\MasterSigner;

class BaItController extends Controller
{
    public function index()
    {
        $baItServices = BaItService::latest()->get();
        // Mengambil data signer untuk ditampilkan di card index
        $signers = MasterSigner::latest()->get(); 
        
        return view('form-ba-it-services.index', compact('baItServices', 'signers'));
    }

    public function create()
    {
        // TAMBAHAN: Kirim data signers ke halaman create
        $signers = MasterSigner::all();
        return view('form-ba-it-services.create', compact('signers'));
    }

    public function store(Request $request)
    {
        // 1. Validasi diperketat untuk mencegat data kosong
        $request->validate([
            'pemohon_nama'       => 'required|string|max:255',
            'pemohon_unit'       => 'required|string|max:255',
            'pemohon_kontak'     => 'required|string|max:255',
            'no_ref'             => 'required|string|max:100',
            'tgl_ref'            => 'required|date',
            'business_area'      => 'required|string|max:100',
            'no_inventaris_aset' => 'required|string|max:100',
            'ttd_staf_nipp'      => 'required',
            'ttd_mengetahui_nipp'=> 'required',
            'ttd_user_nipp'      => 'required',
        ], [
            // Pesan error custom agar lebih mudah dipahami (opsional)
            'required' => 'Pastikan Anda telah mengisi seluruh form yang wajib sebelum menyimpan.',
        ]);

        // Gabungkan tanggal dan jam mulai
        $waktuMulai = null;
        if ($request->waktu_mulai_tgl) {
            $jamMulai = $request->waktu_mulai_jam ?? '00:00';
            $waktuMulai = $request->waktu_mulai_tgl . ' ' . $jamMulai . ':00';
        }

        // Gabungkan tanggal dan jam selesai
        $waktuSelesai = null;
        if ($request->waktu_selesai_tgl) {
            $jamSelesai = $request->waktu_selesai_jam ?? '00:00';
            $waktuSelesai = $request->waktu_selesai_tgl . ' ' . $jamSelesai . ':00';
        }

        BaItService::create([
            'tanggal_dokumen'    => $request->tanggal_dokumen ?? '12 Oktober 2020',
            'no_dokumen'         => $request->no_dokumen ?? 'FR.SM/IT/011.005/10-2020',
            'versi'              => $request->versi ?? '002-2020',
            'pemohon_nama'       => $request->pemohon_nama,
            'pemohon_unit'       => $request->pemohon_unit,
            'pemohon_kontak'     => $request->pemohon_kontak,
            'no_ref'             => $request->no_ref,
            'tgl_ref'            => $request->tgl_ref,
            'business_area'      => $request->business_area,
            'waktu_mulai'        => $waktuMulai,
            'waktu_selesai'      => $waktuSelesai,
            'no_inventaris_aset' => $request->no_inventaris_aset,
            'detail_penanganan'  => $request->penanganan,
            'pihak_terkait'      => $request->pihak_terkait ?? '-', // Fallback jika kosong
            'ttd_staf_nipp'      => $request->ttd_staf_nipp,
            'ttd_mengetahui_nipp'=> $request->ttd_mengetahui_nipp,
            'ttd_user_nipp'      => $request->ttd_user_nipp,
            'status_terima'      => $request->status_terima ?? 'Diterima',
        ]);

        return redirect()->route('ba-it.index')->with('success', 'Data berhasil disimpan!');
    }

    public function show($id)
    {
        $baItService = BaItService::findOrFail($id);
        $signers = MasterSigner::all(); // Kirim juga untuk jaga-jaga
        return view('form-ba-it-services.show', compact('baItService', 'signers'));
    }

    public function edit($id)
    {
        $baItService = BaItService::findOrFail($id);
        // TAMBAHAN: Kirim data signers ke halaman edit
        $signers = MasterSigner::all();
        
        return view('form-ba-it-services.edit', compact('baItService', 'signers'));
    }

    public function update(Request $request, $id)
    {
        $baItService = BaItService::findOrFail($id);

        // Validasi juga wajib ditambahkan saat Update
        $request->validate([
            'pemohon_nama'       => 'required|string|max:255',
            'pemohon_unit'       => 'required|string|max:255',
            'pemohon_kontak'     => 'required|string|max:255',
            'no_ref'             => 'required|string|max:100',
            'tgl_ref'            => 'required|date',
            'business_area'      => 'required|string|max:100',
            'no_inventaris_aset' => 'required|string|max:100',
            'ttd_staf_nipp'      => 'required',
            'ttd_mengetahui_nipp'=> 'required',
            'ttd_user_nipp'      => 'required',
        ]);

        // Gabungkan tanggal dan jam mulai
        $waktuMulai = null;
        if ($request->waktu_mulai_tgl) {
            $jamMulai = $request->waktu_mulai_jam ?? '00:00';
            $waktuMulai = $request->waktu_mulai_tgl . ' ' . $jamMulai . ':00';
        }

        // Gabungkan tanggal dan jam selesai
        $waktuSelesai = null;
        if ($request->waktu_selesai_tgl) {
            $jamSelesai = $request->waktu_selesai_jam ?? '00:00';
            $waktuSelesai = $request->waktu_selesai_tgl . ' ' . $jamSelesai . ':00';
        }

        $data = $request->all();
        $data['waktu_mulai'] = $waktuMulai;
        $data['waktu_selesai'] = $waktuSelesai;
        $data['detail_penanganan'] = $request->penanganan;
        
        // Memastikan pihak terkait tidak null jika terlewat
        if(empty($data['pihak_terkait'])) {
            $data['pihak_terkait'] = '-';
        }

        $baItService->update($data);

        return redirect()->route('ba-it.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function exportPdf($id)
    {
        $baItService = BaItService::findOrFail($id);
        // TAMBAHAN: Kirim data signers untuk render tampilan cetak PDF
        $signers = MasterSigner::all();

        return view('form-ba-it-services.form', [
            'baItService' => $baItService,
            'signers'     => $signers,
            'mode'        => 'show'
        ]);
    }

    public function destroy($id)
    {
        $baItService = BaItService::findOrFail($id);
        $baItService->delete();

        return redirect()->route('ba-it.index')->with('success', 'Data berhasil dihapus!');
    }

    public function storeSigner(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nipp' => 'required|string|max:50',
            'jabatan' => 'nullable|string|max:100',
        ]);

        MasterSigner::create($request->all());

        return back()->with('success', 'Data Penandatangan berhasil ditambahkan!');
    }
}