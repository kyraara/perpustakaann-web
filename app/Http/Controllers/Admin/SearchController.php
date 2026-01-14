<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        $results = [
            'buku' => [],
            'siswa' => [],
            'peminjaman' => [],
        ];

        if (strlen($query) >= 2) {
            // Search Buku
            $results['buku'] = Buku::with(['kategori', 'rak'])
                ->where('judul', 'like', "%{$query}%")
                ->orWhere('penulis', 'like', "%{$query}%")
                ->orWhere('kode_buku', 'like', "%{$query}%")
                ->limit(10)
                ->get();

            // Search Siswa
            $results['siswa'] = User::where('role', 'siswa')
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('nisn', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%");
                })
                ->limit(10)
                ->get();

            // Search Peminjaman
            $results['peminjaman'] = Peminjaman::with(['user', 'buku'])
                ->whereHas('user', function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->orWhereHas('buku', function ($q) use ($query) {
                    $q->where('judul', 'like', "%{$query}%");
                })
                ->limit(10)
                ->get();
        }

        $totalResults = count($results['buku']) + count($results['siswa']) + count($results['peminjaman']);

        return view('admin.search.index', compact('query', 'results', 'totalResults'));
    }
}
