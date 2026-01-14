<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index()
    {
        $raks = Rak::withCount('bukus')->paginate(10);
        return view('admin.rak.index', compact('raks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rak' => 'required|string|max:255|unique:raks,nama_rak',
            'lokasi' => 'nullable|string|max:255',
        ]);

        $rak = Rak::create($request->only(['nama_rak', 'lokasi']));
        

        return redirect()->route('admin.rak.index')
            ->with('success', 'Rak berhasil ditambahkan!');
    }

    public function update(Request $request, Rak $rak)
    {
        $request->validate([
            'nama_rak' => 'required|string|max:255|unique:raks,nama_rak,' . $rak->id,
            'lokasi' => 'nullable|string|max:255',
        ]);

        $rak->update($request->only(['nama_rak', 'lokasi']));
        

        return redirect()->route('admin.rak.index')
            ->with('success', 'Rak berhasil diupdate!');
    }

    public function destroy(Rak $rak)
    {
        if ($rak->bukus()->count() > 0) {
            return redirect()->route('admin.rak.index')
                ->with('error', 'Rak tidak dapat dihapus karena masih memiliki buku!');
        }

        $nama = $rak->nama_rak;
        $id = $rak->id;
        $rak->delete();
        

        return redirect()->route('admin.rak.index')
            ->with('success', 'Rak berhasil dihapus!');
    }
}
