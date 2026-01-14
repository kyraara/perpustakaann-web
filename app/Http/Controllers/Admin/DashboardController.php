<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic Stats
        $totalBuku = Buku::count();
        $totalSiswa = User::where('role', 'siswa')->count();
        $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $bukuTersedia = Buku::sum('stok') - $bukuDipinjam;
        
        $peminjamanTerlambat = Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', Carbon::now())
            ->count();

        $peminjamanTerbaru = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        $bukuPopuler = Buku::withCount('peminjamans')
            ->orderBy('peminjamans_count', 'desc')
            ->take(5)
            ->get();

        // Chart Data: Tren Peminjaman 6 Bulan Terakhir
        $trenPeminjaman = $this->getTrenPeminjaman();

        // Chart Data: Distribusi Kategori
        $distribusiKategori = $this->getDistribusiKategori();

        // Chart Data: Statistik Keterlambatan
        $statistikKeterlambatan = $this->getStatistikKeterlambatan();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalSiswa',
            'bukuDipinjam',
            'bukuTersedia',
            'peminjamanTerlambat',
            'peminjamanTerbaru',
            'bukuPopuler',
            'trenPeminjaman',
            'distribusiKategori',
            'statistikKeterlambatan'
        ));
    }

    private function getTrenPeminjaman()
    {
        $labels = [];
        $data = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->translatedFormat('M Y');
            $data[] = Peminjaman::whereYear('tanggal_pinjam', $month->year)
                ->whereMonth('tanggal_pinjam', $month->month)
                ->count();
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    private function getDistribusiKategori()
    {
        $kategoris = Kategori::withCount(['bukus as peminjaman_count' => function ($query) {
            $query->join('peminjamans', 'bukus.id', '=', 'peminjamans.buku_id');
        }])->orderBy('peminjaman_count', 'desc')->take(6)->get();

        return [
            'labels' => $kategoris->pluck('nama_kategori')->toArray(),
            'data' => $kategoris->pluck('peminjaman_count')->toArray()
        ];
    }

    private function getStatistikKeterlambatan()
    {
        $now = Carbon::now();
        
        // Tepat waktu (dikembalikan sebelum/pas deadline)
        $tepatWaktu = Peminjaman::where('status', 'dikembalikan')
            ->whereColumn('tanggal_dikembalikan', '<=', 'tanggal_kembali')
            ->count();

        // Terlambat dan sudah dikembalikan
        $terlambatDikembalikan = Peminjaman::where('status', 'dikembalikan')
            ->whereColumn('tanggal_dikembalikan', '>', 'tanggal_kembali')
            ->count();

        // Masih dipinjam tapi sudah lewat deadline
        $terlambatBelumKembali = Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', $now)
            ->count();

        return [
            'labels' => ['Tepat Waktu', 'Terlambat (Dikembalikan)', 'Terlambat (Belum Kembali)'],
            'data' => [$tepatWaktu, $terlambatDikembalikan, $terlambatBelumKembali],
            'colors' => ['#10B981', '#F59E0B', '#EF4444']
        ];
    }
}
