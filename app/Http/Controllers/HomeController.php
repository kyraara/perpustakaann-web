<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Redirect logic if logged in
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isSiswa()) {
                return redirect()->route('siswa.dashboard');
            } elseif ($user->isKepalaSekolah()) {
                return redirect()->route('kepala-sekolah.dashboard');
            }
        }

        // Fetch Statistics
        $totalBuku = Buku::count();
        $totalPeminjaman = Peminjaman::count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalKategori = Kategori::count();

        // Fetch Popular Books (Top 6 most borrowed)
        $bukuPopuler = Buku::with('kategori')
            ->withCount('peminjamans')
            ->orderBy('peminjamans_count', 'desc')
            ->take(6)
            ->get();

        $pilihanKategori = Kategori::take(8)->get();

        return view('welcome', compact('totalBuku', 'totalPeminjaman', 'totalSiswa', 'totalKategori', 'bukuPopuler', 'pilihanKategori'));
    }
}
