<?php

namespace App\Http\Controllers\FormBeritaAcaraSerahTerimaBarang;

use App\Http\Controllers\Controller;
use App\Models\FormBeritaAcaraSerahTerimaBarang\BeritaAcaraSerahTerimaBarang;
use App\Models\FormBeritaAcaraSerahTerimaBarang\MasterBeritaAcaraSerahTerimaBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BeritaAcaraSerahTerimaBarangController extends Controller
{
    private function parseDateSafe($date)
    {
        if (!$date) return null;
        $months = ['Januari' => 'January', 'Februari' => 'February', 'Maret' => 'March', 'Mei' => 'May', 'Juni' => 'June', 'Juli' => 'July', 'Agustus' => 'August', 'Oktober' => 'October', 'Desember' => 'December'];
        $dateStr = strtr($date, $months);
        try { return Carbon::parse($dateStr)->format('Y-m-d'); } catch (\Exception $e) { return $date; }
    }

    public function index(Request $request)
    {
        $forms = BeritaAcaraSerahTerimaBarang::orderBy('created_at', 'desc')->paginate(10);
        $masterSigners = MasterBeritaAcaraSerahTerimaBarang::paginate(5, ['*'], 'signer_page');
        return view('form-berita-acara-serah-terima-barang.index', compact('forms', 'masterSigners'));
    }

    public function create()
    {
        $form = new BeritaAcaraSerahTerimaBarang();
        $masterSigners = MasterBeritaAcaraSerahTerimaBarang::all();
        return view('form-berita-acara-serah-terima-barang.create', compact('form', 'masterSigners'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $form = new BeritaAcaraSerahTerimaBarang();
            $form->no_ref                   = $request->input('no_ref');
            $form->tanggal_ref              = $this->parseDateSafe($request->input('tanggal_ref'));
            $form->business_area            = $request->input('business_area');
            $form->hari                     = $request->input('hari');
            $form->tanggal_serah_terima     = $this->parseDateSafe($request->input('tanggal_serah_terima'));

            // Penyerah
            $form->penyerah_nama            = $request->input('penyerah_nama');
            $form->penyerah_nipp            = $request->input('penyerah_nipp');
            $form->penyerah_jabatan         = $request->input('penyerah_jabatan');
            $form->penyerah_tempat_kedudukan = $request->input('penyerah_tempat_kedudukan');
            $form->penyerah_personal_area   = $request->input('penyerah_personal_area');

            // Penerima
            $form->penerima_nama            = $request->input('penerima_nama');
            $form->penerima_nipp            = $request->input('penerima_nipp');
            $form->penerima_jabatan         = $request->input('penerima_jabatan');
            $form->penerima_tempat_kedudukan = $request->input('penerima_tempat_kedudukan');
            $form->penerima_personal_area   = $request->input('penerima_personal_area');
            $form->penerima_owner_responsible = $request->input('penerima_owner_responsible');
            $form->penerima_custodian       = $request->input('penerima_custodian');

            // Keterangan penggunaan
            $form->nama_unit                = $request->input('nama_unit');
            $form->wilayah                  = $request->input('wilayah');

            // Tanda tangan
            $form->ttd_penyerah_nama        = $request->input('ttd_penyerah_nama');
            $form->ttd_penyerah_nipp        = $request->input('ttd_penyerah_nipp');
            $form->ttd_penerima_nama        = $request->input('ttd_penerima_nama');
            $form->ttd_penerima_nipp        = $request->input('ttd_penerima_nipp');
            $form->save();

            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    if (array_filter($item)) $form->items()->create($item);
                }
            }
        });
        return redirect()->route('form-berita-acara-serah-terima-barang.index')->with('success', 'Formulir Berita Acara Serah Terima Barang berhasil disimpan!');
    }

    public function show($id)
    {
        $form = BeritaAcaraSerahTerimaBarang::with('items')->findOrFail($id);
        $masterSigners = MasterBeritaAcaraSerahTerimaBarang::all();
        return view('form-berita-acara-serah-terima-barang.show', compact('form', 'masterSigners'));
    }

    public function edit($id)
    {
        $form = BeritaAcaraSerahTerimaBarang::with('items')->findOrFail($id);
        $items = $form->items->toArray();
        $masterSigners = MasterBeritaAcaraSerahTerimaBarang::all();
        return view('form-berita-acara-serah-terima-barang.edit', compact('form', 'items', 'masterSigners'));
    }

    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $form = BeritaAcaraSerahTerimaBarang::findOrFail($id);
            $form->no_ref                   = $request->input('no_ref');
            $form->tanggal_ref              = $this->parseDateSafe($request->input('tanggal_ref'));
            $form->business_area            = $request->input('business_area');
            $form->hari                     = $request->input('hari');
            $form->tanggal_serah_terima     = $this->parseDateSafe($request->input('tanggal_serah_terima'));

            // Penyerah
            $form->penyerah_nama            = $request->input('penyerah_nama');
            $form->penyerah_nipp            = $request->input('penyerah_nipp');
            $form->penyerah_jabatan         = $request->input('penyerah_jabatan');
            $form->penyerah_tempat_kedudukan = $request->input('penyerah_tempat_kedudukan');
            $form->penyerah_personal_area   = $request->input('penyerah_personal_area');

            // Penerima
            $form->penerima_nama            = $request->input('penerima_nama');
            $form->penerima_nipp            = $request->input('penerima_nipp');
            $form->penerima_jabatan         = $request->input('penerima_jabatan');
            $form->penerima_tempat_kedudukan = $request->input('penerima_tempat_kedudukan');
            $form->penerima_personal_area   = $request->input('penerima_personal_area');
            $form->penerima_owner_responsible = $request->input('penerima_owner_responsible');
            $form->penerima_custodian       = $request->input('penerima_custodian');

            // Keterangan penggunaan
            $form->nama_unit                = $request->input('nama_unit');
            $form->wilayah                  = $request->input('wilayah');

            // Tanda tangan
            $form->ttd_penyerah_nama        = $request->input('ttd_penyerah_nama');
            $form->ttd_penyerah_nipp        = $request->input('ttd_penyerah_nipp');
            $form->ttd_penerima_nama        = $request->input('ttd_penerima_nama');
            $form->ttd_penerima_nipp        = $request->input('ttd_penerima_nipp');
            $form->save();

            $form->items()->delete();
            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    if (array_filter($item)) $form->items()->create($item);
                }
            }
        });
        return redirect()->route('form-berita-acara-serah-terima-barang.index')->with('success', 'Formulir Berita Acara Serah Terima Barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $form = BeritaAcaraSerahTerimaBarang::findOrFail($id);
        $form->delete();
        return redirect()->route('form-berita-acara-serah-terima-barang.index')->with('success', 'Formulir Berita Acara Serah Terima Barang berhasil dihapus!');
    }
}
