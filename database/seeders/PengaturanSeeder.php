<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'lama_pinjam',
                'value' => '7',
                'description' => 'Lama peminjaman buku dalam hari',
            ],
            [
                'key' => 'denda_per_hari',
                'value' => '500',
                'description' => 'Denda keterlambatan per hari (Rupiah)',
            ],
            [
                'key' => 'max_pinjam',
                'value' => '2',
                'description' => 'Maksimal buku yang dapat dipinjam per siswa',
            ],
            [
                'key' => 'nama_sekolah',
                'value' => 'SD Negeri 3 Prabumulih',
                'description' => 'Nama sekolah',
            ],
            [
                'key' => 'alamat_sekolah',
                'value' => 'Jl. Pendidikan No. 123, Prabumulih',
                'description' => 'Alamat sekolah',
            ],
        ];

        foreach ($settings as $setting) {
            Pengaturan::create($setting);
        }
    }
}
