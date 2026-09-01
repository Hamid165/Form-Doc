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
use App\Http\Controllers\FormMonitoringGrounding\FormMonitoringGroundingController;
use App\Http\Controllers\FormPcLaptopChecking\FormPcLaptopCheckingController;
use App\Http\Controllers\FormPemeliharaanAc\FormPemeliharaanAcController;
use App\Http\Controllers\FormPemeliharaanAc\MasterAcController;
use App\Http\Controllers\FormItBusinessRequest\FormItBusinessRequestController;
use App\Http\Controllers\FormMonitoringIsiRakDcDrc\FormMonitoringIsiRakDcDrcController;
use App\Http\Controllers\FormSecureOperation\FormSecureOperationController;
use App\Http\Controllers\FormSecureOperation\MasterSignerSecureController; 
use App\Http\Controllers\FormApar\FormAparController;
use App\Http\Controllers\FormApar\MasterAparController;
use App\Http\Controllers\FormApar\MasterVendorController;
use App\Http\Controllers\FormApar\AparHistoryController;
use App\Http\Controllers\FormApar\MasterSignerController as MasterSignerAparController;
use App\Http\Controllers\FormPengujianInfrastruktur\FormPengujianInfrastrukturController;
use App\Http\Controllers\FormKeluarMasukBarangDcDrc\FormKeluarMasukBarangDcDrcController;
use App\Http\Controllers\FormKeluarMasukBarangDcDrc\MasterSignerFormKeluarMasukBarangDcDrcController;
use App\Http\Controllers\FormSerahTerimaUser\FormSerahTerimaUserController;
use App\Http\Controllers\FormSerahTerimaUser\MasterSerahTerimaUserController;
use App\Http\Controllers\FormPemeliharaanUps\FormPemeliharaanUpsController;
use App\Http\Controllers\FormPemeliharaanUps\MasterUpsController;
use App\Http\Controllers\FormTemplateController;
use App\Http\Controllers\FormBeritaAcaraSerahTerimaBarang\BeritaAcaraSerahTerimaBarangController;
use App\Http\Controllers\FormBeritaAcaraSerahTerimaBarang\MasterBeritaAcaraSerahTerimaBarangController;
use App\Http\Controllers\FormMonitoringCCTV\FormMonitoringCCTVController;
use App\Http\Controllers\FormChecklistPc\FormChecklistPcController;
// ==============================================================
// ROUTES DASHBOARD (Data Dummy & Ringkasan)
// ==============================================================
Route::get('/', function () {
    $totalKategori = 1; 
    $totalJenisFormulir = 15; // All modules + Secure Operation

    $totalFormulirBulanIni =
        \App\Models\FormCctv\FormCctv::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormPencabutanHakAkses\FormPencabutanHakAkses::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormPemeliharaan\FormPemeliharaan::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormBaStockOpname\BaStockOpname::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormPemeliharaanAc\FormPemeliharaanAc::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormItBusinessRequest\FormItBusinessRequest::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormAvailability\FormAvailability::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormSecureOperation\SecureOperationIncident::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormPengujianInfrastruktur\FormPengujianInfrastruktur::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormSerahTerimaUser\FormSerahTerimaUser::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormPemeliharaanUps\FormPemeliharaanUps::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormBeritaAcaraSerahTerimaBarang\BeritaAcaraSerahTerimaBarang::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormMonitoringCCTV\FormMonitoringCCTV::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormMonitoringGrounding\FormMonitoringGrounding::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormPcLaptopChecking\FormPcLaptopChecking::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count()
        + \App\Models\FormChecklistPc\FormChecklistPc::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();;

    $totalPengguna = 2; // Dummy: Pitra, Hamid (sebelum ada auth)

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
        ->concat(\App\Models\FormPengujianInfrastruktur\FormPengujianInfrastruktur::latest()->take(5)->get()->map(function($item) {
            $item->type = 'Pengujian Infrastruktur';
            $item->route = route('form-pengujian-infrastruktur.show', $item->id);
            $item->title = "Pengujian Infrastruktur - {$item->objek_pengujian}";
            return $item;
        }))
        ->concat(\App\Models\FormSerahTerimaUser\FormSerahTerimaUser::latest()->take(5)->get()->map(function($item) {
            $item->type = 'Serah Terima User Aplikasi';
            $item->route = route('form-serah-terima-user.show', $item->id);
            $item->title = "Serah Terima - {$item->nama_penerima}";
            return $item;
        }))
        ->concat(\App\Models\FormPemeliharaanUps\FormPemeliharaanUps::latest()->take(5)->get()->map(function($item) {
            $item->type = 'Checklist Pemeliharaan UPS';
            $item->route = route('form-pemeliharaan-ups.show', $item->id);
            $item->title = "Pemeliharaan UPS - {$item->nomor_inventaris}";
            return $item;
        }))
        ->concat(\App\Models\FormBeritaAcaraSerahTerimaBarang\BeritaAcaraSerahTerimaBarang::latest()->take(5)->get()->map(function($item) {
            $item->type = 'Berita Acara Serah Terima Barang';
            $item->route = route('form-berita-acara-serah-terima-barang.show', $item->id);
            $item->title = "Berita Acara Serah Terima Barang - {$item->no_ref}";
            return $item;
        }))
        ->concat(\App\Models\FormMonitoringCCTV\FormMonitoringCCTV::latest()->take(5)->get()->map(function($item) {
            $item->type = 'Monitoring CCTV';
            $item->route = route('form-monitoring-cctv.show', $item->id);
            $item->title = "Monitoring CCTV - {$item->no_ref}";
            return $item;
        }))
        ->concat(\App\Models\FormMonitoringGrounding\FormMonitoringGrounding::latest()->take(5)->get()->map(function($item) {
            $item->type = 'Monitoring Grounding';
            $item->route = route('form-monitoring-grounding.show', $item->id);
            $item->title = "Monitoring Grounding - {$item->no_ref}";
            return $item;
        }))
        ->concat(\App\Models\FormPcLaptopChecking\FormPcLaptopChecking::latest()->take(5)->get()->map(function($item) {
            $item->type = 'PC/Laptop Checking';
            $item->route = route('form-pc-laptop-checking.show', $item->id);
            $item->title = "PC/Laptop Checking - {$item->no_ref}";
            return $item;
        }))
        ->concat(\App\Models\FormChecklistPc\FormChecklistPc::latest()->take(5)->get()->map(function($item) {
            $item->type = 'Checklist PC-Notebook-Printer';
            $item->route = route('form-checklist-pc.show', $item->id);
            $item->title = "Checklist PC-Notebook-Printer - {$item->no_ref}";
            return $item;
        }))

        ->sortByDesc('created_at')
        ->take(5);

    return view('dashboard', compact('totalKategori', 'totalJenisFormulir', 'totalFormulirBulanIni', 'totalPengguna', 'recentForms'));
})->name('dashboard');


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
        } elseif ($template->nama === 'Keluar/Masuk Barang DC/DRC') {
            $total = \App\Models\FormKeluarMasukBarangDcDrc\FormKeluarMasukBarangDcDrc::count();
        } elseif ($template->nama === 'Formulir Checklist Pemantauan APAR') {
            $total = \App\Models\FormApar\FormApar::count();
        } elseif ($template->nama === 'Formulir Pengujian Infrastruktur' || str_contains($template->nama, 'Pengujian Infrastruktur')) {
            $total = \App\Models\FormPengujianInfrastruktur\FormPengujianInfrastruktur::count();
        } elseif ($template->nama === 'Berita Acara Serah Terima User Aplikasi' || str_contains($template->nama, 'Serah Terima User')) {
            $total = \App\Models\FormSerahTerimaUser\FormSerahTerimaUser::count();
        } elseif ($template->nama === 'Checklist Pemeliharaan UPS') {
            $total = \App\Models\FormPemeliharaanUps\FormPemeliharaanUps::count();
        } elseif ($template->nama === 'Berita Acara Serah Terima Barang' || str_contains($template->nama, 'Serah Terima')) {
            $total = \App\Models\FormBeritaAcaraSerahTerimaBarang\BeritaAcaraSerahTerimaBarang::count();
        } elseif ($template->nama === 'Formulir Monitoring CCTV') {
            $total = \App\Models\FormMonitoringCCTV\FormMonitoringCCTV::count();
        } elseif ($template->nama === 'Monitoring Grounding' || str_contains($template->nama, 'Monitoring Grounding')) {
            $total = \App\Models\FormMonitoringGrounding\FormMonitoringGrounding::count();
        } elseif ($template->nama === 'PC/Laptop Checking' || str_contains($template->nama, 'PC/Laptop Checking')) {
            $total = \App\Models\FormPcLaptopChecking\FormPcLaptopChecking::count();
        }elseif ($template->nama === 'Checklist Pemeliharaan PC-Notebook-Printer' || str_contains($template->nama, 'PC-Notebook-Printer')) {
            $total = \App\Models\FormChecklistPc\FormChecklistPc::count();
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
Route::post('master-signer/import', [MasterSignerController::class, 'import'])->name('master-signer.import');
Route::get('master-signer/template', [MasterSignerController::class, 'downloadTemplate'])->name('master-signer.template');
Route::resource('master-signer', MasterSignerController::class)->only(['store', 'update', 'destroy']);


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
Route::get('form-ba-stock-opname/template', [BaStockOpnameController::class, 'downloadTemplate'])->name('form-ba-stock-opname.template');
Route::resource('form-ba-stock-opname', BaStockOpnameController::class);
Route::resource('master-bastock', MasterBAStockController::class)->only(['store', 'update', 'destroy']);


// ==============================================================
// ROUTES FORMULIR RENCANA PELATIHAN PEGAWAI
// ==============================================================
Route::resource('form-rencana-pelatihan', \App\Http\Controllers\FormRencanaPelatihan\RencanaPelatihanController::class);
Route::resource('master-penandatangan-rencana', \App\Http\Controllers\FormRencanaPelatihan\MasterPenandatanganRencanaController::class);


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
Route::post('master-business-area', [FormAvailabilityController::class, 'storeBusinessArea'])->name('master-business-area.store');
Route::put('master-business-area/{masterBusinessArea}', [FormAvailabilityController::class, 'updateBusinessArea'])->name('master-business-area.update');
Route::delete('master-business-area/{masterBusinessArea}', [FormAvailabilityController::class, 'destroyBusinessArea'])->name('master-business-area.destroy');
Route::get('api/business-areas', [FormAvailabilityController::class, 'getBusinessAreas'])->name('api.business-areas');
Route::patch('form-availability/{form_availability}/confirm', [FormAvailabilityController::class, 'confirm'])->name('form-availability.confirm');
Route::get('form-availability/{form_availability}/excel', [FormAvailabilityController::class, 'exportExcel'])->name('form-availability.excel');
Route::resource('form-availability', FormAvailabilityController::class);


// =============================================================
// ROUTES FORMULIR CHECKLIST PEMANTAUAN APAR
// =============================================================
Route::patch('form-apar/{form_apar}/confirm', [FormAparController::class, 'confirm'])->name('form-apar.confirm');
Route::resource('form-apar', FormAparController::class);

// Master Data APAR
Route::post('master-apar/import', [MasterAparController::class, 'import'])->name('master-apar.import');
Route::get('master-apar/template', [MasterAparController::class, 'downloadTemplate'])->name('master-apar.template');
Route::get('master-apar/{master_apar}/info', [MasterAparController::class, 'getInfo'])->name('master-apar.info');
Route::post('master-apar/{master_apar}/ganti-tabung', [MasterAparController::class, 'replaceCylinder'])->name('master-apar.ganti-tabung');
Route::resource('master-apar', MasterAparController::class)->only(['store', 'update', 'destroy']);
Route::post('master-apar/{master_apar}/aktifkan', [MasterAparController::class, 'reactivate'])->name('master-apar.aktifkan');

// Master Vendor & History APAR
Route::resource('master-vendor', MasterVendorController::class)->only(['store', 'update', 'destroy']);
Route::resource('apar-history', AparHistoryController::class)->only(['store', 'update', 'destroy']);
Route::resource('master-signer', MasterSignerAparController::class)->only(['store', 'update', 'destroy']);


// ==============================================================
// ROUTES FORMULIR KELUAR MASUK BARANG DC DRC
// ==============================================================
Route::post('form-keluar-masuk-barang-dc-drc/parse-excel', [FormKeluarMasukBarangDcDrcController::class, 'parseExcel'])->name('form-keluar-masuk-barang-dc-drc.parse-excel');
Route::get('form-keluar-masuk-barang-dc-drc/template-items', [FormKeluarMasukBarangDcDrcController::class, 'downloadTemplateItems'])->name('form-keluar-masuk-barang-dc-drc.template-items');
Route::get('form-keluar-masuk-barang-dc-drc/download-template', [FormKeluarMasukBarangDcDrcController::class, 'downloadTemplateItems'])->name('form-keluar-masuk-barang-dc-drc.download-template');
Route::resource('form-keluar-masuk-barang-dc-drc', FormKeluarMasukBarangDcDrcController::class);

// Master Signer untuk Form Keluar Masuk Barang DC DRC
Route::post('form-keluar-masuk-barang-dc-drc/master-signer', [MasterSignerFormKeluarMasukBarangDcDrcController::class, 'store'])->name('form-keluar-masuk-barang-dc-drc.master-signer.store');
Route::put('form-keluar-masuk-barang-dc-drc/master-signer/{id}', [MasterSignerFormKeluarMasukBarangDcDrcController::class, 'update'])->name('form-keluar-masuk-barang-dc-drc.master-signer.update');
Route::delete('form-keluar-masuk-barang-dc-drc/master-signer/{id}', [MasterSignerFormKeluarMasukBarangDcDrcController::class, 'destroy'])->name('form-keluar-masuk-barang-dc-drc.master-signer.destroy');


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


// ==============================================================
// ROUTES FORMULIR PENGUJIAN INFRASTRUKTUR
// ==============================================================
Route::resource('form-pengujian-infrastruktur', FormPengujianInfrastrukturController::class);


// ==============================================================
// ROUTES FORMULIR BERITA ACARA SERAH TERIMA USER APLIKASI
// ==============================================================
Route::get('form-serah-terima-user/{form_serah_terima_user}/preview', [FormSerahTerimaUserController::class, 'preview'])->name('form-serah-terima-user.preview');
Route::resource('form-serah-terima-user', FormSerahTerimaUserController::class);
Route::resource('master-serah-terima-user', MasterSerahTerimaUserController::class)->only(['store', 'update', 'destroy']);


// ==============================================================
// ROUTES FORMULIR CHECKLIST PEMELIHARAAN UPS
// ==============================================================
Route::post('form-pemeliharaan-ups/parse-excel', [FormPemeliharaanUpsController::class, 'parseExcel'])
    ->name('form-pemeliharaan-ups.parse-excel');
Route::get('form-pemeliharaan-ups/template-items', [FormPemeliharaanUpsController::class, 'downloadTemplateItems'])
    ->name('form-pemeliharaan-ups.template-items');
Route::resource('form-pemeliharaan-ups', FormPemeliharaanUpsController::class);

Route::post('master-ups/import', [MasterUpsController::class, 'import'])->name('master-ups.import');
Route::get('master-ups/template', [MasterUpsController::class, 'downloadTemplate'])->name('master-ups.template');
Route::resource('master-ups', MasterUpsController::class)->only(['store', 'update', 'destroy']);


// ==============================================================
// ROUTES FORMULIR BERITA ACARA SERAH TERIMA BARANG
// ==============================================================
Route::resource('form-berita-acara-serah-terima-barang', BeritaAcaraSerahTerimaBarangController::class)->parameters([
    'form-berita-acara-serah-terima-barang' => 'barang'
]);
Route::resource('master-berita-acara-serah-terima-barang', MasterBeritaAcaraSerahTerimaBarangController::class)->only(['store', 'update', 'destroy'])->parameters([
    'master-berita-acara-serah-terima-barang' => 'master'
]);


// ==============================================================
// ROUTES FORMULIR MONITORING CCTV 
// ==============================================================
Route::resource('form-monitoring-cctv', FormMonitoringCCTVController::class);
Route::get('/form-monitoring-cctv/{id}/print', [FormMonitoringCCTVController::class, 'print'])->name('form-monitoring-cctv.print');
Route::post('/form-monitoring-cctv/petugas', [FormMonitoringCCTVController::class, 'storePetugas'])->name('form-monitoring-cctv.store-petugas');
Route::post('/form-monitoring-cctv/cctv', [FormMonitoringCCTVController::class, 'storeCctv'])->name('form-monitoring-cctv.store-cctv');
Route::put('/form-monitoring-cctv/cctv/{id}', [FormMonitoringCCTVController::class, 'updateCctv'])->name('form-monitoring-cctv.update-cctv');
Route::delete('/form-monitoring-cctv/cctv/{id}', [FormMonitoringCCTVController::class, 'destroyCctv'])->name('form-monitoring-cctv.destroy-cctv');
Route::post('/form-monitoring-cctv/penandatangan', [FormMonitoringCCTVController::class, 'storeSigner'])->name('form-monitoring-cctv.store-signer');
Route::put('/form-monitoring-cctv/petugas/{id}', [FormMonitoringCCTVController::class, 'updatePetugas'])->name('form-monitoring-cctv.update-petugas');
Route::delete('/form-monitoring-cctv/petugas/{id}', [FormMonitoringCCTVController::class, 'destroyPetugas'])->name('form-monitoring-cctv.destroy-petugas');
Route::put('/form-monitoring-cctv/signer/{id}', [FormMonitoringCCTVController::class, 'updateSigner'])->name('form-monitoring-cctv.update-signer');
Route::delete('/form-monitoring-cctv/signer/{id}', [FormMonitoringCCTVController::class, 'destroySigner'])->name('form-monitoring-cctv.destroy-signer');


// ==============================================================
// ROUTES FORMULIR MONITORING GROUNDING
// ==============================================================
Route::get('form-monitoring-grounding/{id}/export-excel', [FormMonitoringGroundingController::class, 'exportExcel'])->name('form-monitoring-grounding.export-excel');
Route::resource('form-monitoring-grounding', FormMonitoringGroundingController::class);

/// ==============================================================
// ROUTES FORMULIR PC/LAPTOP CHECKING
// ==============================================================
Route::get('form-pc-laptop-checking/{id}/export-excel', [FormPcLaptopCheckingController::class, 'exportExcel'])->name('form-pc-laptop-checking.export-excel');
Route::resource('form-pc-laptop-checking', FormPcLaptopCheckingController::class);

// ==============================================================
// ROUTES FORMULIR CHECKLIST PEMELIHARAAN PC-NOTEBOOK-PRINTER
// ==============================================================
Route::patch('form-checklist-pc/{form_checklist_pc}/confirm', [FormChecklistPcController::class, 'confirm'])->name('form-checklist-pc.confirm');
Route::get('form-checklist-pc/{form_checklist_pc}/pdf', [FormChecklistPcController::class, 'pdf'])->name('form-checklist-pc.pdf');
Route::resource('form-checklist-pc', FormChecklistPcController::class);

// ==============================================================
// ROUTES FORMULIR LAPORAN BACKUP
// ==============================================================
Route::resource('form-backup', \App\Http\Controllers\FormBackup\FormBackupController::class);
Route::post('/form-backup/master', [App\Http\Controllers\FormBackup\FormBackupController::class, 'storeMaster'])->name('form-backup.master.store');
Route::delete('/form-backup/master/{id}', [App\Http\Controllers\FormBackup\FormBackupController::class, 'destroyMaster'])->name('form-backup.master.destroy');
Route::put('/form-backup/master/{id}', [App\Http\Controllers\FormBackup\FormBackupController::class, 'updateMaster'])->name('form-backup.master.update');
use App\Http\Controllers\FormPemusnahan\FormPemusnahanController;
use App\Http\Controllers\FormPemusnahan\DataAsetController;
use App\Http\Controllers\FormPemusnahan\DataPemohonController;

Route::resource('form-pemusnahan', FormPemusnahanController::class);
Route::post('data-aset/import', [DataAsetController::class, 'import'])->name('data-aset.import');
Route::get('data-aset/template', [DataAsetController::class, 'downloadTemplate'])->name('data-aset.template');
Route::get('data-aset/{data_aset}/info', [DataAsetController::class, 'getInfo'])->name('data-aset.info');
Route::resource('data-aset', DataAsetController::class)->only(['store', 'update', 'destroy']);
Route::resource('data-pemohon', DataPemohonController::class)->only(['store', 'update', 'destroy']);

// ==============================================================
// ROUTES FORMULIR MONITORING ISI RAK DC / DRC
// ==============================================================
Route::resource('form-monitoring-isi-rak-dc-drc', FormMonitoringIsiRakDcDrcController::class);

