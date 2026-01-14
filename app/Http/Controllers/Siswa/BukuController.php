<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

use App\Models\Pengaturan;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with(['kategori', 'rak']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $bukus = $query->paginate(12)->withQueryString();
        $kategoris = Kategori::all();

        return view('siswa.buku.index', compact('bukus', 'kategoris'));
    }

    public function show(Buku $buku)
    {
        $buku->load(['kategori', 'rak']);
        $stokTersedia = $buku->stokTersedia();
        
        // Get durasi options from settings
        $durasiOpsiStr = Pengaturan::getValue('durasi_opsi', '3,5,7');
        $durasiOpsi = array_map('intval', explode(',', $durasiOpsiStr));
        sort($durasiOpsi);
        
        return view('siswa.buku.show', compact('buku', 'stokTersedia', 'durasiOpsi'));
    }
}
