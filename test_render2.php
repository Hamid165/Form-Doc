<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$monitoring = \App\Models\FormMonitoringCCTV\FormMonitoringCCTV::find(1);
echo "Items in DB: " . $monitoring->items->count() . "\n";
