<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FormTemplate;

class FormTemplateController extends Controller
{
    public function update(Request $request, $id)
    {
        $template = FormTemplate::findOrFail($id);
        
        $validatedData = $request->validate([
            'no_dokumen' => 'nullable|string|max:255',
            'tanggal_dokumen' => 'nullable|string|max:255',
            'versi_dokumen' => 'nullable|string|max:255',
        ]);
        
        $template->update($validatedData);
        
        return redirect()->back()->with('success', 'Metadata Formulir berhasil diperbarui!');
    }
}
