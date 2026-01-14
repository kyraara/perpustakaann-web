<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Rak;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bukus = [
            [
                'kode_buku' => 'BK001',
                'judul' => 'Kisah Sang Kancil',
                'penulis' => 'Tim Penulis',
                'penerbit' => 'Erlangga Kids',
                'tahun' => 2020,
                'kategori' => 'Cerita Anak',
                'rak' => 'Rak A1',
                'stok' => 5,
            ],
            [
                'kode_buku' => 'BK002',
                'judul' => 'Matematika Dasar Kelas 5',
                'penulis' => 'Dr. Hendra',
                'penerbit' => 'Kemendikbud',
                'tahun' => 2022,
                'kategori' => 'Matematika',
                'rak' => 'Rak B1',
                'stok' => 10,
            ],
            [
                'kode_buku' => 'BK003',
                'judul' => 'Ensiklopedia Anak Pintar',
                'penulis' => 'Tim Ensiklopedia',
                'penerbit' => 'Gramedia',
                'tahun' => 2021,
                'kategori' => 'Ensiklopedia',
                'rak' => 'Rak C1',
                'stok' => 3,
            ],
            [
                'kode_buku' => 'BK004',
                'judul' => 'Bahasa Indonesia Kelas 6',
                'penulis' => 'Tim Penulis',
                'penerbit' => 'Kemendikbud',
                'tahun' => 2022,
                'kategori' => 'Bahasa Indonesia',
                'rak' => 'Rak A2',
                'stok' => 15,
            ],
            [
                'kode_buku' => 'BK005',
                'judul' => 'Sains untuk Anak',
                'penulis' => 'Prof. Sari',
                'penerbit' => 'Erlangga',
                'tahun' => 2021,
                'kategori' => 'Sains',
                'rak' => 'Rak B2',
                'stok' => 8,
            ],
            [
                'kode_buku' => 'BK006',
                'judul' => 'Cerita Nabi dan Rasul',
                'penulis' => 'Ustaz Ahmad',
                'penerbit' => 'Pustaka Anak',
                'tahun' => 2020,
                'kategori' => 'Agama',
                'rak' => 'Rak C2',
                'stok' => 6,
            ],
            [
                'kode_buku' => 'BK007',
                'judul' => 'English for Kids',
                'penulis' => 'Jane Smith',
                'penerbit' => 'Oxford Junior',
                'tahun' => 2022,
                'kategori' => 'Bahasa Inggris',
                'rak' => 'Rak A3',
                'stok' => 7,
            ],
            [
                'kode_buku' => 'BK008',
                'judul' => 'IPA Mudah Dipahami',
                'penulis' => 'Dr. Bambang',
                'penerbit' => 'Yudhistira',
                'tahun' => 2021,
                'kategori' => 'IPA',
                'rak' => 'Rak B3',
                'stok' => 12,
            ],
        ];

        foreach ($bukus as $buku) {
            $kategori = Kategori::where('nama_kategori', $buku['kategori'])->first();
            $rak = Rak::where('nama_rak', $buku['rak'])->first();

            if ($kategori && $rak) {
                Buku::create([
                    'kode_buku' => $buku['kode_buku'],
                    'judul' => $buku['judul'],
                    'penulis' => $buku['penulis'],
                    'penerbit' => $buku['penerbit'],
                    'tahun' => $buku['tahun'],
                    'kategori_id' => $kategori->id,
                    'rak_id' => $rak->id,
                    'stok' => $buku['stok'],
                ]);
            }
        }
    }
}
