<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterSignerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $signers = [
            ['nama' => 'Budi Santoso', 'nipp' => '51324', 'jabatan' => 'Senior Manager Sistem Informasi'],
            ['nama' => 'Siti Aminah', 'nipp' => '48976', 'jabatan' => 'Manager IT Infrastructure & Security'],
            ['nama' => 'Andi Wijaya', 'nipp' => '45612', 'jabatan' => 'Assistant Manager IT Support'],
        ];

        foreach ($signers as $data) {
            \App\Models\FormCctv\MasterSigner::firstOrCreate(['nipp' => $data['nipp']], $data);
        }
    }
}
