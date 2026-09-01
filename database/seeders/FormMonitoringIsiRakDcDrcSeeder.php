<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormMonitoringIsiRakDcDrc\FormMonitoringIsiRakDcDrc;
use App\Models\FormTemplate;

class FormMonitoringIsiRakDcDrcSeeder extends Seeder
{
    public function run(): void
    {
        if (!FormTemplate::where('nama', 'Monitoring Isi Rak DC / DRC')->exists()) {
            FormTemplate::create([
                'nama' => 'Monitoring Isi Rak DC / DRC',
                'kategori' => 'Terbatas',
                'route_name' => 'form-monitoring-isi-rak-dc-drc.index',
                'no_dokumen' => 'FR.SM/TI/015.024/10-2020',
                'tanggal_dokumen' => '12 Oktober 2020',
                'versi_dokumen' => '002-2020',
            ]);
        }

        if (FormMonitoringIsiRakDcDrc::count() === 0) {
            $form = FormMonitoringIsiRakDcDrc::create([
                'no_ref' => '001/DC-RAK/2026',
                'tanggal' => '2026-07-22',
                'business_area' => 'BANDUNG',
                'nomor_rak' => 'RAK-01',
                'last_update' => '22 Juli 2026',
                'kode_rak' => 'DC-RK-01',
                'ukuran_rak' => '42U',
                'lokasi' => 'Data Center Gedung D',
                'lantai' => 'Lantai 2',
                'alamat' => 'Jl. Perintis Kemerdekaan No. 1, Bandung',
                'mengetahui_nama' => 'Budi Santoso',
                'mengetahui_nipp' => '67890',
            ]);

            $sampleItems = [
                [
                    'no' => 1,
                    'cable' => 'Cat6A',
                    'pp' => 'PP-A01',
                    'id_machine' => 'SRV-DB-01',
                    'id_server_name_server' => 'db-primary.kai.id',
                    'pic' => 'Ahmad',
                    'nic' => 'Dual 10G',
                    'power_a' => '4.2',
                    'weight_kg' => '22',
                    'capacity_storage_gb' => '4000',
                    'capacity_memory_gb' => '128',
                    'ip_address_local' => '10.10.1.15',
                    'ip_address_public' => '202.158.12.10',
                    'status' => 'Active',
                    'note' => 'Primary Database Server',
                ],
                [
                    'no' => 2,
                    'cable' => 'Cat6A',
                    'pp' => 'PP-A02',
                    'id_machine' => 'SRV-APP-01',
                    'id_server_name_server' => 'app-web01.kai.id',
                    'pic' => 'Hamid',
                    'nic' => 'Dual 1G',
                    'power_a' => '2.5',
                    'weight_kg' => '18',
                    'capacity_storage_gb' => '1000',
                    'capacity_memory_gb' => '64',
                    'ip_address_local' => '10.10.1.20',
                    'ip_address_public' => '202.158.12.11',
                    'status' => 'Active',
                    'note' => 'Web App Production',
                ],
                [
                    'no' => 3,
                    'cable' => 'Fiber LC',
                    'pp' => 'PP-F01',
                    'id_machine' => 'SW-CORE-01',
                    'id_server_name_server' => 'core-sw-dc01',
                    'pic' => 'Pitra',
                    'nic' => '24 Port SFP+',
                    'power_a' => '3.0',
                    'weight_kg' => '12',
                    'capacity_storage_gb' => '128',
                    'capacity_memory_gb' => '16',
                    'ip_address_local' => '10.10.0.1',
                    'ip_address_public' => '-',
                    'status' => 'Active',
                    'note' => 'Core Switch Data Center',
                ]
            ];

            foreach ($sampleItems as $item) {
                $form->items()->create($item);
            }
        }
    }
}
