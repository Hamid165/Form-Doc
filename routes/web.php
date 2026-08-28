<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FormCctv\FormCctvController;
use App\Http\Controllers\FormPencabutanHakAkses\FormPencabutanHakAksesController;
use App\Http\Controllers\FormCctv\MasterCctvController;
use App\Http\Controllers\FormCctv\MasterSignerController;
use App\Http\Controllers\FormPencabutanHakAkses\MasterPemohonController;
use App\Http\Controllers\FormPemeliharaan\FormPemeliharaanController;
use App\Http\Controllers\FormPemeliharaan\MasterPerangkatController;
use App\Http\Controllers\FormAvailability\FormAvailabilityController;
use App\Http\Controllers\FormBaStockOpname\BaStockOpnameController;
use App\Http\Controllers\FormBaStockOpname\MasterBAStockController;
use App\Http\Controllers\FormPemeliharaanAc\FormPemeliharaanAcController;
use App\Http\Controllers\FormPemeliharaanAc\MasterAcController;
use App\Http\Controllers\FormItBusinessRequest\FormItBusinessRequestController;
use App\Http\Controllers\FormSecureOperation\FormSecureOperationController;
use App\Http\Controllers\FormSecureOperation\MasterSignerSecureController; 

// ==============================================================
// ROUTES DASHBOARD (Data Dummy & Ringkasan)
// ==============================================================
Route::get('/', function () {
    $totalKategori = 1; // Dummy untuk saat ini
    $totalJenisFormulir = 9; // CCTV, Hak Akses, Pemeliharaan Jaringan, Stock Opname, AC, IT Business Request, Availability

    $totalFormulirBulanIni =
            \App\Models\FormCctv\FormCctv::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count()
            + \App\Models\FormPencabutanHakAkses\FormPencabutanHakAkses::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count()
            + \App\Models\FormPemeliharaan\FormPemeliharaan::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count()
            + \App\Models\FormBaStockOpname\BaStockOpname::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count()
            + \App\Models\FormPemeliharaanAc\FormPemeliharaanAc::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count()
            + \App\Models\FormItBusinessRequest\FormItBusinessRequest::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count()
            + \App\Models\FormSecureOperation\SecureOperationIncident::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count()
            + \App\Models\FormAvailability\FormAvailability::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->count();

    $totalPengguna = 2; // Dummy: Pitra, Hamid (sebelum ada auth)

    // PERBAIKAN: Memasukkan data BA Stock Opname, Pemeliharaan AC, dan IT Business Request ke aktivitas terbaru
    $recentForms = collect()
        ->concat(\App\Models\FormCctv\FormCctv::latest()->take(5)->get()->map(function($item) {
            $item->type = 'CCTV';
            $item->route = route('form-cctv.show', $item->id);
            $item->title = "Pemeliharaan CCTV - {$item->id_cctv}";
            return $item;
        }))
        ->concat(\App\Models\FormPencabutanHakAkses\FormPencabutanHakAkses::latest()->take(5)->get()->map(function($item) {
            $item->type = 'Pencabutan Hak Akses';
            $item->route = route('form-pencabutan-hak-akses.show', $item->id);
            $item->title = "Pencabutan Hak Akses - {$item->nama_pemohon}";
            return $item;
        }))
        ->concat(\App\Models\FormPemeliharaan\FormPemeliharaan::latest()->take(5)->get()->map(function($item) {
            $item->type = 'Pemeliharaan Perangkat';
            $item->route = route('form-pemeliharaan.show', $item->id);
            $item->title = "Pemeliharaan Perangkat - {$item->no_ref}";
            return $item;
        }))
        ->concat(\App\Models\FormBaStockOpname\BaStockOpname::latest()->take(5)->get()->map(function ($item) {
            $item->type = 'Berita Acara Stock Opname';
            $item->route = route('form-ba-stock-opname.show', $item->id);
            $item->title = "BA Stock Opname - {$item->no_ref}";
            return $item;
        }))
        ->concat(\App\Models\FormPemeliharaanAc\FormPemeliharaanAc::latest()->take(5)->get()->map(function ($item) {
            $item->type = 'Pemeliharaan AC';
            $item->route = route('form-pemeliharaan-ac.show', $item->id);
            $item->title = "Pemeliharaan AC - {$item->id_ac}";
            return $item;
        }))
        ->concat(\App\Models\FormItBusinessRequest\FormItBusinessRequest::latest()->take(5)->get()->map(function ($item) {
            $item->type = 'IT Business Request';
            $item->route = route('form-it-business-request.show', $item->id);
            $item->title = "IT Business Request - {$item->no_ref}";
            return $item;
        }))
        ->concat(\App\Models\FormAvailability\FormAvailability::latest()->take(5)->get()->map(function ($item) {
            $item->type = 'Availability System Ticketing';
            $item->route = route('form-availability.show', $item->id);
            $item->title = "Availability Ticketing - {$item->no_ref}";
            return $item;
        }))
        ->concat(\App\Models\FormSecureOperation\SecureOperationIncident::latest()->take(5)->get()->map(function ($item) {
            $item->type = 'Secure Operation Incident';
            $item->route = route('form-secure-operation.show', $item->id);
            $item->title = "Secure Operation Incident - {$item->no_ref}";
            return $item;
        }))

        ->sortByDesc('created_at')
        ->take(5);

    return view('dashboard', compact('totalKategori', 'totalJenisFormulir', 'totalFormulirBulanIni', 'totalPengguna', 'recentForms'));
})->name('dashboard');


use App\Http\Controllers\FormTemplateController;

// ==============================================================
// ROUTES KATALOG FORMULIR & TEMPLATE
// ==============================================================
Route::put('/formulir/template/{id}', [FormTemplateController::class, 'update'])->name('formulir.template.update');

Route::get('/formulir', function (\Illuminate\Http\Request $request) {
    $kategori = $request->query('kategori', 'All');

    $templates = \App\Models\FormTemplate::all();

    $formulirs = collect();

    foreach ($templates as $template) {
        $total = 0;
        if ($template->nama === 'Pemeliharaan CCTV') {
            $total = \App\Models\FormCctv\FormCctv::count();

        } elseif ($template->nama === 'Permohonan Pencabutan Hak Akses') {
            $total = \App\Models\FormPencabutanHakAkses\FormPencabutanHakAkses::count();

        } elseif ($template->nama === 'Checklist Pemeliharaan Perangkat Jaringan') {
            $total = \App\Models\FormPemeliharaan\FormPemeliharaan::count();

        } elseif (
            $template->nama === 'Berita Acara Stock Opname'
            || str_contains($template->nama, 'Stock Opname')
        ) {
            $total = \App\Models\FormBaStockOpname\BaStockOpname::count();

        } elseif ($template->nama === 'Checklist Pemeliharaan AC') {
            $total = \App\Models\FormPemeliharaanAc\FormPemeliharaanAc::count();

        } elseif (
            $template->nama === 'Formulir IT Business Request'
            || str_contains($template->nama, 'Business Request')
        ) {
            $total = \App\Models\FormItBusinessRequest\FormItBusinessRequest::count();

        } elseif ($template->nama === 'Availability System Ticketing') {
            $total = \App\Models\FormAvailability\FormAvailability::count();
        
        } elseif ($template->nama === 'Secure Operation Incident') {
            $total = \App\Models\FormSecureOperation\SecureOperationIncident::count();
        }
        
        $formulirs->push([
            'id' => $template->id,
            'nama' => $template->nama,
            'kategori' => $template->kategori,
            'route' => route($template->route_name),
            'total' => $total,
            'no_dokumen' => $template->no_dokumen,
            'tanggal_dokumen' => $template->tanggal_dokumen,
            'versi_dokumen' => $template->versi_dokumen
        ]);
    }

    if ($kategori !== 'All') {
        $formulirs = $formulirs->where('kategori', $kategori);
    }

    $perPage = 10;
    $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
    $currentItems = $formulirs->slice(($currentPage - 1) * $perPage, $perPage)->all();

    $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
        $currentItems,
        $formulirs->count(),
        $perPage,
        $currentPage,
        ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
    );
    $paginated->appends(['kategori' => $kategori]);

    return view('formulir', [
        'formulirs' => $paginated,
        'activeTab' => $kategori
    ]);
})->name('formulir.index');


// ==============================================================
// ROUTES FORMULIR PEMELIHARAAN CCTV
// ==============================================================
Route::get('form-cctv/create-v2', [FormCctvController::class, 'createV2'])->name('form-cctv.create-v2');
Route::post('form-cctv/parse-excel', [FormCctvController::class, 'parseExcel'])->name('form-cctv.parse-excel');
Route::get('form-cctv/template-items', [FormCctvController::class, 'downloadTemplateItems'])->name('form-cctv.template-items');
Route::resource('form-cctv', FormCctvController::class);

Route::post('master-cctv/import', [MasterCctvController::class, 'import'])->name('master-cctv.import');
Route::get('master-cctv/template', [MasterCctvController::class, 'downloadTemplate'])->name('master-cctv.template');
Route::resource('master-cctv', MasterCctvController::class)->only(['store', 'update', 'destroy']);

// Master Data Penandatangan (Signer) CCTV
Route::post(
    'master-signer/import',
    [MasterSignerController::class, 'import']
)->name('master-signer.import');

Route::get(
    'master-signer/template',
    [MasterSignerController::class, 'downloadTemplate']
)->name('master-signer.template');

Route::resource(
    'master-signer',
    MasterSignerController::class
)->only(['store', 'update', 'destroy']);


// ==============================================================
// ROUTES FORMULIR PENCABUTAN HAK AKSES
// ==============================================================
Route::resource('form-pencabutan-hak-akses', FormPencabutanHakAksesController::class);
Route::post('master-pemohon/import', [MasterPemohonController::class, 'import'])->name('master-pemohon.import');
Route::get('master-pemohon/template', [MasterPemohonController::class, 'downloadTemplate'])->name('master-pemohon.template');
Route::post('master-pemohon', [MasterPemohonController::class, 'store'])->name('master-pemohon.store');
Route::put('master-pemohon/{id}', [MasterPemohonController::class, 'update'])->name('master-pemohon.update');
Route::delete('master-pemohon/{id}', [MasterPemohonController::class, 'destroy'])->name('master-pemohon.destroy');


// ==============================================================
// ROUTES FORMULIR CHECKLIST PEMELIHARAAN PERANGKAT JARINGAN
// ==============================================================
Route::patch('form-pemeliharaan/{form_pemeliharaan}/confirm', [FormPemeliharaanController::class, 'confirm'])->name('form-pemeliharaan.confirm');
Route::resource('form-pemeliharaan', FormPemeliharaanController::class);
Route::post('master-perangkat/import', [MasterPerangkatController::class, 'import'])->name('master-perangkat.import');
Route::get('master-perangkat/template', [MasterPerangkatController::class, 'downloadTemplate'])->name('master-perangkat.template');
Route::get('master-perangkat/{master_perangkat}/info', [MasterPerangkatController::class, 'getInfo'])->name('master-perangkat.info');
Route::resource('master-perangkat', MasterPerangkatController::class)->only(['store', 'update', 'destroy']);


// ==============================================================
// ROUTES FORMULIR BERITA ACARA STOCK OPNAME
// ==============================================================

// PERBAIKAN: Memindahkan Route Template ke ATAS Route Resource agar tidak terjadi 404
Route::get('form-ba-stock-opname/template', [BaStockOpnameController::class, 'downloadTemplate'])->name('form-ba-stock-opname.template');

Route::resource('form-ba-stock-opname', BaStockOpnameController::class);
Route::resource('master-bastock', MasterBAStockController::class)->only(['store', 'update', 'destroy']);


// ==============================================================
// ROUTES FORMULIR CHECKLIST PEMELIHARAAN AC
// ==============================================================
Route::post('form-pemeliharaan-ac/parse-excel', [FormPemeliharaanAcController::class, 'parseExcel'])->name('form-pemeliharaan-ac.parse-excel');
Route::get('form-pemeliharaan-ac/template-items', [FormPemeliharaanAcController::class, 'downloadTemplateItems'])->name('form-pemeliharaan-ac.template-items');
Route::resource('form-pemeliharaan-ac', FormPemeliharaanAcController::class);

Route::post('master-ac/import', [MasterAcController::class, 'import'])->name('master-ac.import');
Route::get('master-ac/template', [MasterAcController::class, 'downloadTemplate'])->name('master-ac.template');
Route::resource('master-ac', MasterAcController::class)->only(['store', 'update', 'destroy']);

// ==============================================================
// ROUTES FORMULIR IT BUSINESS REQUEST
// ==============================================================
Route::resource('form-it-business-request', FormItBusinessRequestController::class);



// ==============================================================
// ROUTES FORMULIR AVAILABILITY SYSTEM TICKETING
// ==============================================================

Route::post(
    'master-business-area',
    [FormAvailabilityController::class, 'storeBusinessArea']
)->name('master-business-area.store');

Route::put(
    'master-business-area/{masterBusinessArea}',
    [FormAvailabilityController::class, 'updateBusinessArea']
)->name('master-business-area.update');

Route::delete(
    'master-business-area/{masterBusinessArea}',
    [FormAvailabilityController::class, 'destroyBusinessArea']
)->name('master-business-area.destroy');

Route::get(
    'api/business-areas',
    [FormAvailabilityController::class, 'getBusinessAreas']
)->name('api.business-areas');

Route::patch(
    'form-availability/{form_availability}/confirm',
    [FormAvailabilityController::class, 'confirm']
)->name('form-availability.confirm');

Route::get(
    'form-availability/{form_availability}/excel',
    [FormAvailabilityController::class, 'exportExcel']
)->name('form-availability.excel');

Route::resource(
    'form-availability',
    FormAvailabilityController::class
);

// ==============================================================
// ROUTES FORMULIR SECURE OPERATION INCIDENT
// ==============================================================
Route::resource('form-secure-operation', \App\Http\Controllers\FormSecureOperation\FormSecureOperationController::class);

// ==============================================================
// JALUR BYPASS UNTUK MASTER SIGNER (MURNI POST)
// ==============================================================
Route::post('/data-penandatangan/simpan', [App\Http\Controllers\FormSecureOperation\MasterSignerSecureController::class, 'store'])->name('signer.baru');

Route::post('/data-penandatangan/ubah/{id}', [App\Http\Controllers\FormSecureOperation\MasterSignerSecureController::class, 'update'])->name('signer.ubah');

Route::post('/data-penandatangan/buang/{id}', [App\Http\Controllers\FormSecureOperation\MasterSignerSecureController::class, 'destroy'])->name('signer.buang');