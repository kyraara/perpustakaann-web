<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BukuExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Buku::with(['kategori', 'rak'])->get();
    }

    public function headings(): array
    {
        return [
            'Kode Buku',
            'Judul',
            'Penulis',
            'Penerbit',
            'Tahun',
            'Kategori',
            'Rak',
            'Stok',
            'Deskripsi',
        ];
    }

    public function map($buku): array
    {
        return [
            $buku->kode_buku,
            $buku->judul,
            $buku->penulis,
            $buku->penerbit,
            $buku->tahun,
            $buku->kategori->nama_kategori ?? '',
            $buku->rak->nama_rak ?? '',
            $buku->stok,
            $buku->deskripsi,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
