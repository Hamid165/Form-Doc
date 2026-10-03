<?php

namespace App\Http\Controllers\FormRencanaPelatihan;

use App\Http\Controllers\Controller;
use App\Models\FormRencanaPelatihan\RencanaPelatihan;
use App\Models\FormRencanaPelatihan\MasterPenandatanganRencana;
use Illuminate\Http\Request;

class RencanaPelatihanController extends Controller
{
    public function index()
    {
        $forms = RencanaPelatihan::latest()->paginate(10);
        $masterSigners = MasterPenandatanganRencana::all();
        return view('form-rencana-pelatihan.index', compact('forms', 'masterSigners'));
    }

    public function create()
    {
        $form = new RencanaPelatihan();
        $masterSigners = MasterPenandatanganRencana::all();
        $action = route('form-rencana-pelatihan.store');
        $method = 'POST';
        return view('form-rencana-pelatihan.create', compact('form', 'masterSigners', 'action', 'method'));
    }

    public function store(Request $request)
    {
        RencanaPelatihan::create($request->except(['_token', '_method']));
        return redirect()->route('form-rencana-pelatihan.index')->with('success', 'Formulir berhasil dibuat!');
    }

    public function show($id)
    {
        $form = RencanaPelatihan::findOrFail($id);
        return view('form-rencana-pelatihan.show', compact('form'));
    }

    public function edit($id)
    {
        $form = RencanaPelatihan::findOrFail($id);
        $masterSigners = MasterPenandatanganRencana::all();
        $action = route('form-rencana-pelatihan.update', $id);
        $method = 'PUT';
        return view('form-rencana-pelatihan.edit', compact('form', 'masterSigners', 'action', 'method'));
    }

    public function update(Request $request, $id)
    {
        $form = RencanaPelatihan::findOrFail($id);
        $form->update($request->except(['_token', '_method']));
        return redirect()->route('form-rencana-pelatihan.index')->with('success', 'Formulir berhasil diperbarui!');
    }

    public function destroy($id)
    {
        RencanaPelatihan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Formulir berhasil dihapus!');
    }
}
