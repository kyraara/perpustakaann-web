<?php

namespace App\Http\Controllers\KepalaSekolah;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku']);

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->orderBy('tanggal_pinjam', 'desc')->paginate(15)->withQueryString();

        return view('kepala-sekolah.laporan.peminjaman', compact('peminjamans'));
    }

    public function stokBuku()
    {
        $bukus = Buku::with(['kategori', 'rak'])
            ->withCount(['peminjamans as dipinjam' => function ($q) {
                $q->where('status', 'dipinjam');
            }])
            ->orderBy('judul')
            ->paginate(15);

        return view('kepala-sekolah.laporan.stok-buku', compact('bukus'));
    }

    public function siswaAktif()
    {
        $siswas = User::where('role', 'siswa')
            ->withCount('peminjamans')
            ->orderBy('peminjamans_count', 'desc')
            ->paginate(15);

        return view('kepala-sekolah.laporan.siswa-aktif', compact('siswas'));
    }

    public function keterlambatan()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])
            ->where(function ($query) {
                $query->where('status', 'dipinjam')
                    ->where('tanggal_kembali', '<', Carbon::now());
            })
            ->orWhere(function ($query) {
                $query->where('status', 'dikembalikan')
                    ->where('denda', '>', 0);
            })
            ->orderBy('tanggal_kembali', 'asc')
            ->paginate(15);

        return view('kepala-sekolah.laporan.keterlambatan', compact('peminjamans'));
    }
}
