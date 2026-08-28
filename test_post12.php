<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$items = [];
for($i=1; $i<=12; $i++){
    $items[$i] = ['nomor' => $i, 'nama_titik_cctv' => 'CCTV '.$i, 'm1_berfungsi' => 'V', 'note' => ''];
}

$request = \Illuminate\Http\Request::create('/form-monitoring-cctv/1', 'PUT', [
    'tanggal' => '2026-08-01',
    'business_area' => 'BA 1',
    'bulan' => 'AGUSTUS',
    'items' => $items
]);

$controller = app()->make(\App\Http\Controllers\FormMonitoringCCTV\FormMonitoringCCTVController::class);

try {
    $monitoring = \App\Models\FormMonitoringCCTV\FormMonitoringCCTV::first();
    $response = $controller->update($request, $monitoring->id);
    echo "Saved! Items count: " . $monitoring->items()->count() . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
