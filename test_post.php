<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = \Illuminate\Http\Request::create('/form-monitoring-cctv/1', 'PUT', [
    'tanggal' => '2026-08-01',
    'business_area' => 'BA 1',
    'bulan' => 'AGUSTUS',
    'items' => [
        1 => ['nomor' => '1', 'nama_titik_cctv' => 'CCTV 1', 'm1_berfungsi' => 'V', 'note' => ''],
        2 => ['nomor' => '2', 'nama_titik_cctv' => 'CCTV 2', 'm1_berfungsi' => 'V', 'note' => ''],
        3 => ['nomor' => '3', 'nama_titik_cctv' => 'CCTV 3', 'm1_berfungsi' => 'V', 'note' => 'test added row'],
    ]
]);

$controller = app()->make(\App\Http\Controllers\FormMonitoringCCTV\FormMonitoringCCTVController::class);

try {
    $monitoring = \App\Models\FormMonitoringCCTV\FormMonitoringCCTV::first();
    if(!$monitoring) {
        $monitoring = \App\Models\FormMonitoringCCTV\FormMonitoringCCTV::create([
            'no_ref' => 'TEST/001',
            'business_area' => 'BA TEST',
            'tanggal' => '2026-08-01',
            'bulan' => 'AGUSTUS',
            'status' => 'draft'
        ]);
    }
    
    $response = $controller->update($request, $monitoring->id);
    
    echo "Saved! Items count: " . $monitoring->items()->count() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
