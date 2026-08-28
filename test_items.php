<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$m = \App\Models\FormMonitoringCCTV\FormMonitoringCCTV::first();
if ($m) {
    echo "Form found: " . $m->id . "\n";
    echo "Items count: " . $m->items->count() . "\n";
} else {
    echo "No form found\n";
}
