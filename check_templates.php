<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$count = App\Models\FormTemplate::count();
echo "Total form templates: {$count}\n\n";

$templates = App\Models\FormTemplate::all(['id', 'nama', 'kategori', 'route_name']);
foreach ($templates as $template) {
    echo "ID: {$template->id}, Nama: {$template->nama}, Kategori: {$template->kategori}, Route: {$template->route_name}\n";
}

echo "\n";
$dcDrcTemplate = App\Models\FormTemplate::where('nama', 'Keluar/Masuk Barang DC/DRC')->first();
if ($dcDrcTemplate) {
    echo "Keluar/Masuk Barang DC/DRC template FOUND:\n";
    echo "ID: {$dcDrcTemplate->id}, Nama: {$dcDrcTemplate->nama}, Kategori: {$dcDrcTemplate->kategori}, Route: {$dcDrcTemplate->route_name}\n";
} else {
    echo "Keluar/Masuk Barang DC/DRC template NOT FOUND in database.\n";
}
