<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormPemeliharaan\MasterPerangkat;

class MasterPerangkatSeeder extends Seeder
{
    public function run(): void
    {
        $perangkats = [
            ['kode_aset' => 'SW-001', 'jenis_perangkat' => 'Switch',   'deskripsi' => 'Cisco Catalyst 2960-X 24-Port'],
            ['kode_aset' => 'SW-002', 'jenis_perangkat' => 'Switch',   'deskripsi' => 'HP ProCurve 2920-24G'],
            ['kode_aset' => 'RT-001', 'jenis_perangkat' => 'Router',   'deskripsi' => 'MikroTik RB750Gr3'],
            ['kode_aset' => 'RT-002', 'jenis_perangkat' => 'Router',   'deskripsi' => 'Cisco ISR 4331'],
            ['kode_aset' => 'FW-001', 'jenis_perangkat' => 'Firewall', 'deskripsi' => 'Fortinet FortiGate 60F'],
            ['kode_aset' => 'AP-001', 'jenis_perangkat' => 'Access Point', 'deskripsi' => 'Ubiquiti UniFi AP AC Lite'],
            ['kode_aset' => 'AP-002', 'jenis_perangkat' => 'Access Point', 'deskripsi' => 'Cisco Aironet 1815i'],
            ['kode_aset' => 'SV-001', 'jenis_perangkat' => 'Server',   'deskripsi' => 'Dell PowerEdge R440'],
            ['kode_aset' => 'NAS-001','jenis_perangkat' => 'NAS',      'deskripsi' => 'Synology DS920+'],
            ['kode_aset' => 'UPS-001','jenis_perangkat' => 'UPS',      'deskripsi' => 'APC Smart-UPS 1500VA'],
        ];

        foreach ($perangkats as $data) {
            MasterPerangkat::firstOrCreate(['kode_aset' => $data['kode_aset']], $data);
        }
    }
}
