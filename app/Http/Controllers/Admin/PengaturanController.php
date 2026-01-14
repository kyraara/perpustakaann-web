<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturans = Pengaturan::all();
        return view('admin.pengaturan.index', compact('pengaturans'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'lama_pinjam' => 'required|integer|min:1|max:30',
            'denda_per_hari' => 'required|integer|min:0',
            'max_pinjam' => 'required|integer|min:1|max:10',
            'durasi_opsi' => 'required|string|max:100',
            'nama_sekolah' => 'required|string|max:255',
            'alamat_sekolah' => 'required|string|max:500',
        ]);

        foreach ($validated as $key => $value) {
            Pengaturan::setValue($key, $value);
        }


        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan berhasil disimpan!');
    }
}
