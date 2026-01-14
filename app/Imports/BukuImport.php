<?php

namespace App\Imports;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Rak;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class BukuImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $kategori = Kategori::firstOrCreate(['nama_kategori' => $row['kategori']]);
        $rak = Rak::firstOrCreate(['nama_rak' => $row['rak']]);

        return new Buku([
            'kode_buku' => $row['kode_buku'],
            'judul' => $row['judul'],
            'penulis' => $row['penulis'],
            'penerbit' => $row['penerbit'],
            'tahun' => $row['tahun'],
            'kategori_id' => $kategori->id,
            'rak_id' => $rak->id,
            'stok' => $row['stok'] ?? 1,
            'deskripsi' => $row['deskripsi'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'kode_buku' => 'required|string|unique:bukus,kode_buku',
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'penerbit' => 'required|string',
            'tahun' => 'required|integer',
            'kategori' => 'required|string',
            'rak' => 'required|string',
        ];
    }
}
