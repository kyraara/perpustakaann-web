<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $peminjamanAktif = Peminjaman::with('buku')
            ->where('user_id', $user->id)
            ->where('status', 'dipinjam')
            ->get();

        $jumlahDipinjam = $peminjamanAktif->count();

        $peminjamanTerlambat = $peminjamanAktif->filter(function ($p) {
            return Carbon::now()->gt($p->tanggal_kembali);
        });

        $totalPeminjaman = Peminjaman::where('user_id', $user->id)->count();

        // Hitung sisa kuota pinjaman
        $maxPinjam = (int) Pengaturan::getValue('max_pinjam', 3);
        $sisaKuota = max(0, $maxPinjam - $jumlahDipinjam);

        // Get latest books for recommendation
        $bukuTerbaru = Buku::with('kategori')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('siswa.dashboard', compact(
            'peminjamanAktif',
            'jumlahDipinjam',
            'peminjamanTerlambat',
            'totalPeminjaman',
            'sisaKuota',
            'bukuTerbaru'
        ));
    }
}
