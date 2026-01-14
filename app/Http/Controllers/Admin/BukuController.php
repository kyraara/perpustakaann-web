<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Rak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with(['kategori', 'rak']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('kode_buku', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $bukus = $query->paginate(10)->withQueryString();
        $kategoris = Kategori::all();
        $raks = Rak::all();

        return view('admin.buku.index', compact('bukus', 'kategoris', 'raks'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $raks = Rak::all();
        return view('admin.buku.create', compact('kategoris', 'raks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|string|max:50|unique:bukus,kode_buku',
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori_id' => 'required|exists:kategoris,id',
            'rak_id' => 'required|exists:raks,id',
            'stok' => 'required|integer|min:1',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku = Buku::create($validated);


        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Buku $buku)
    {
        $kategoris = Kategori::all();
        $raks = Rak::all();
        return view('admin.buku.edit', compact('buku', 'kategoris', 'raks'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'kode_buku' => 'required|string|max:50|unique:bukus,kode_buku,' . $buku->id,
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . date('Y'),
            'kategori_id' => 'required|exists:kategoris,id',
            'rak_id' => 'required|exists:raks,id',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($validated);


        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->peminjamans()->where('status', 'dipinjam')->count() > 0) {
            return redirect()->route('admin.buku.index')
                ->with('error', 'Buku tidak dapat dihapus karena masih ada peminjaman aktif!');
        }

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $judul = $buku->judul;
        $bukuId = $buku->id;
        $buku->delete();


        return redirect()->route('admin.buku.index')
            ->with('success', 'Buku berhasil dihapus!');
    }

    public function export()
    {

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\BukuExport, 'data-buku-' . date('Y-m-d') . '.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\BukuImport, $request->file('file'));
            

            return redirect()->route('admin.buku.index')
                ->with('success', 'Data buku berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('admin.buku.index')
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}

