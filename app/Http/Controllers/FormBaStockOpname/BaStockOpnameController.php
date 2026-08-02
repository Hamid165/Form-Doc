<?php

namespace App\Http\Controllers\FormBaStockOpname;

use App\Http\Controllers\Controller;
use App\Models\FormBaStockOpname\BaStockOpname;
use App\Models\FormBaStockOpname\MasterBaStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\FormBaStockOpname\BaStockTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

class BaStockOpnameController extends Controller
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
        $forms = BaStockOpname::orderBy('created_at', 'desc')->paginate(10);
        $masterSigners = MasterBaStock::paginate(5, ['*'], 'signer_page');
        return view('form-ba-stock-opname.index', compact('forms', 'masterSigners'));
    }

    public function create()
    {
        $form = new BaStockOpname();
        $masterSigners = MasterBaStock::all();
        return view('form-ba-stock-opname.create', compact('form', 'masterSigners'));
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $form = new BaStockOpname();
            $form->no_ref               = $request->input('no_ref');
            $form->tanggal_ref          = $this->parseDateSafe($request->input('tanggal_ref'));
            $form->business_area        = $request->input('business_area');
            $form->tanggal_stock_opname = $this->parseDateSafe($request->input('tanggal_stock_opname'));
            $form->unit_kerja           = $request->input('unit_kerja');
            $form->tempat_kedudukan     = $request->input('tempat_kedudukan');
            $form->analisa              = $request->input('analisa');
            $form->tindak_lanjut        = $request->input('tindak_lanjut');

            $form->pimpinan_unit_kerja  = $request->input('pimpinan_unit_kerja');
            $form->nipp_pimpinan_unit_kerja = $request->input('nipp_pimpinan_unit_kerja');
            $form->tempat_ttd           = $request->input('tempat_ttd');
            $form->tanggal_ttd          = $this->parseDateSafe($request->input('tanggal_ttd'));
            $form->pimpinan_it          = $request->input('pimpinan_it');
            $form->nipp_pimpinan_it     = $request->input('nipp_pimpinan_it');
            $form->petugas_it           = $request->input('petugas_it');
            $form->nipp_petugas_it      = $request->input('nipp_petugas_it');
            $form->save();

            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    if (array_filter($item)) $form->details()->create($item);
                }
            }
        });
        return redirect()->route('form-ba-stock-opname.index')->with('success', 'Berhasil disimpan!');
    }

    public function show($id)
    {
        $form = BaStockOpname::with('details')->findOrFail($id);
        $tgl_ttd = $form->tanggal_ttd ? Carbon::parse($form->tanggal_ttd)->locale('id')->translatedFormat('d F Y') : null;
        $masterSigners = MasterBaStock::all();
        return view('form-ba-stock-opname.show', compact('form', 'tgl_ttd', 'masterSigners'));
    }

    public function edit($id)
    {
        $form = BaStockOpname::with('details')->findOrFail($id);
        $items = $form->details->toArray();
        $masterSigners = MasterBaStock::all();
        return view('form-ba-stock-opname.edit', compact('form', 'items', 'masterSigners'));
    }

    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $form = BaStockOpname::findOrFail($id);
            $form->no_ref               = $request->input('no_ref');
            $form->tanggal_ref          = $this->parseDateSafe($request->input('tanggal_ref'));
            $form->business_area        = $request->input('business_area');
            $form->tanggal_stock_opname = $this->parseDateSafe($request->input('tanggal_stock_opname'));
            $form->unit_kerja           = $request->input('unit_kerja');
            $form->tempat_kedudukan     = $request->input('tempat_kedudukan');
            $form->analisa              = $request->input('analisa');
            $form->tindak_lanjut        = $request->input('tindak_lanjut');

            $form->pimpinan_unit_kerja  = $request->input('pimpinan_unit_kerja');
            $form->nipp_pimpinan_unit_kerja = $request->input('nipp_pimpinan_unit_kerja');
            $form->tempat_ttd           = $request->input('tempat_ttd');
            $form->tanggal_ttd          = $this->parseDateSafe($request->input('tanggal_ttd'));
            $form->pimpinan_it          = $request->input('pimpinan_it');
            $form->nipp_pimpinan_it     = $request->input('nipp_pimpinan_it');
            $form->petugas_it           = $request->input('petugas_it');
            $form->nipp_petugas_it      = $request->input('nipp_petugas_it');
            $form->save();

            $form->details()->delete();
            if ($request->has('items')) {
                foreach ($request->input('items') as $item) {
                    if (array_filter($item)) $form->details()->create($item);
                }
            }
        });
        return redirect()->route('form-ba-stock-opname.index')->with('success', 'Berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $form = BaStockOpname::findOrFail($id);
        $form->delete();
        return redirect()->route('form-ba-stock-opname.index')->with('success', 'Berhasil dihapus!');
    }

    public function downloadTemplate()
    {
        return Excel::download(new BaStockTemplateExport, 'Template_Stock_Opname.xlsx');
    }
}
