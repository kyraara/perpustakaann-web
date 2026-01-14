<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalBuku = Buku::count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalPeminjaman = Peminjaman::count();
        $peminjamanBulanIni = Peminjaman::whereMonth('tanggal_pinjam', Carbon::now()->month)
            ->whereYear('tanggal_pinjam', Carbon::now()->year)
            ->count();

        // Monthly borrowing chart (last 6 months)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Peminjaman::whereMonth('tanggal_pinjam', $date->month)
                ->whereYear('tanggal_pinjam', $date->year)
                ->count();
            $chartData[] = [
                'bulan' => $date->translatedFormat('M Y'),
                'jumlah' => $count,
            ];
        }

        // Most borrowed books
        $bukuPopuler = Buku::withCount('peminjamans')
            ->orderBy('peminjamans_count', 'desc')
            ->take(5)
            ->get();

        // Most active students
        $siswaAktif = User::where('role', 'siswa')
            ->withCount('peminjamans')
            ->orderBy('peminjamans_count', 'desc')
            ->take(5)
            ->get();

        // Late returns
        $keterlambatan = Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', Carbon::now())
            ->count();

        return view('kepala-sekolah.dashboard', compact(
            'totalBuku',
            'totalSiswa',
            'totalPeminjaman',
            'peminjamanBulanIni',
            'chartData',
            'bukuPopuler',
            'siswaAktif',
            'keterlambatan'
        ));
    }
}
