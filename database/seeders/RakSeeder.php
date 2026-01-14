<?php

namespace Database\Seeders;

use App\Models\Rak;
use Illuminate\Database\Seeder;

class RakSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $raks = [
            ['nama_rak' => 'Rak A1', 'lokasi' => 'Baris 1 Kiri'],
            ['nama_rak' => 'Rak A2', 'lokasi' => 'Baris 1 Tengah'],
            ['nama_rak' => 'Rak A3', 'lokasi' => 'Baris 1 Kanan'],
            ['nama_rak' => 'Rak B1', 'lokasi' => 'Baris 2 Kiri'],
            ['nama_rak' => 'Rak B2', 'lokasi' => 'Baris 2 Tengah'],
            ['nama_rak' => 'Rak B3', 'lokasi' => 'Baris 2 Kanan'],
            ['nama_rak' => 'Rak C1', 'lokasi' => 'Baris 3 Kiri'],
            ['nama_rak' => 'Rak C2', 'lokasi' => 'Baris 3 Tengah'],
        ];

        foreach ($raks as $rak) {
            Rak::create($rak);
        }
    }
}
