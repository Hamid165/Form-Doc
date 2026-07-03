<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FormCctvController;

Route::get('/', function () {
    $totalKategori = 1; // Dummy untuk saat ini
    $totalJenisFormulir = 1; // Dummy: Baru ada CCTV
    
    $totalFormulirBulanIni = \App\Models\FormCctv::whereMonth('created_at', date('m'))
                                ->whereYear('created_at', date('Y'))
                                ->count();
                                
    $totalPengguna = 2; // Dummy: Pitra, Hamid (sebelum ada auth)

    $recentForms = \App\Models\FormCctv::latest()->take(5)->get();

    return view('dashboard', compact('totalKategori', 'totalJenisFormulir', 'totalFormulirBulanIni', 'totalPengguna', 'recentForms'));
})->name('dashboard');

Route::get('/formulir', function () {
    return view('formulir');
})->name('formulir.index');

Route::get('form-cctv/create-v2', [FormCctvController::class, 'createV2'])->name('form-cctv.create-v2');
Route::resource('form-cctv', FormCctvController::class);
