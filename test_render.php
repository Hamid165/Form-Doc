<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = \Illuminate\Http\Request::create('/form-monitoring-cctv/1/edit', 'GET');
$response = app()->handle($request);
$html = $response->getContent();
preg_match_all('/items\[(\d+)\]\[nomor\]/', $html, $matches);
print_r(array_unique($matches[1]));
