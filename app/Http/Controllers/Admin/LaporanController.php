<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

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

        $peminjamans = $query->orderBy('tanggal_pinjam', 'desc')->get();

        return view('admin.laporan.peminjaman', compact('peminjamans'));
    }

    public function peminjamanExport(Request $request)
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

        $peminjamans = $query->orderBy('tanggal_pinjam', 'desc')->get();

        $pdf = Pdf::loadView('admin.laporan.pdf.peminjaman', compact('peminjamans'));
        return $pdf->download('laporan-peminjaman-' . now()->format('Y-m-d') . '.pdf');
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
                    ->whereColumn('tanggal_dikembalikan', '>', 'tanggal_kembali');
            })
            ->orderBy('tanggal_kembali', 'asc')
            ->get();

        return view('admin.laporan.keterlambatan', compact('peminjamans'));
    }

    public function keterlambatanExport()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])
            ->where(function ($query) {
                $query->where('status', 'dipinjam')
                    ->where('tanggal_kembali', '<', Carbon::now());
            })
            ->orWhere(function ($query) {
                $query->where('status', 'dikembalikan')
                    ->whereColumn('tanggal_dikembalikan', '>', 'tanggal_kembali');
            })
            ->orderBy('tanggal_kembali', 'asc')
            ->get();

        $pdf = Pdf::loadView('admin.laporan.pdf.keterlambatan', compact('peminjamans'));
        return $pdf->download('laporan-keterlambatan-' . now()->format('Y-m-d') . '.pdf');
    }

    public function stokBuku()
    {
        $bukus = Buku::with(['kategori', 'rak'])
            ->withCount(['peminjamans as dipinjam' => function ($q) {
                $q->where('status', 'dipinjam');
            }])
            ->orderBy('judul')
            ->get();

        return view('admin.laporan.stok-buku', compact('bukus'));
    }

    public function stokBukuExport()
    {
        $bukus = Buku::with(['kategori', 'rak'])
            ->withCount(['peminjamans as dipinjam' => function ($q) {
                $q->where('status', 'dipinjam');
            }])
            ->orderBy('judul')
            ->get();

        $pdf = Pdf::loadView('admin.laporan.pdf.stok-buku', compact('bukus'));
        return $pdf->download('laporan-stok-buku-' . now()->format('Y-m-d') . '.pdf');
    }

    public function siswaAktif()
    {
        $siswas = User::where('role', 'siswa')
            ->withCount('peminjamans')
            ->orderBy('peminjamans_count', 'desc')
            ->take(20)
            ->get();

        return view('admin.laporan.siswa-aktif', compact('siswas'));
    }

    public function siswaAktifExport()
    {
        $siswas = User::where('role', 'siswa')
            ->withCount('peminjamans')
            ->orderBy('peminjamans_count', 'desc')
            ->take(20)
            ->get();

        $pdf = Pdf::loadView('admin.laporan.pdf.siswa-aktif', compact('siswas'));
        return $pdf->download('laporan-siswa-aktif-' . now()->format('Y-m-d') . '.pdf');
    }
}
