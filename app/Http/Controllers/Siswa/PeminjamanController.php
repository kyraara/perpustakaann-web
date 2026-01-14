<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengaturan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->orderBy('tanggal_kembali', 'asc')
            ->get();

        return view('siswa.peminjaman.index', compact('peminjamans'));
    }

    public function histori()
    {
        $peminjamans = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('siswa.peminjaman.histori', compact('peminjamans'));
    }

    public function ajukan(Request $request, Buku $buku)
    {
        $user = Auth::user();
        $maxPinjam = (int) Pengaturan::getValue('max_pinjam', 2);
        $maxDurasi = (int) Pengaturan::getValue('lama_pinjam', 7);
        
        // Get duration from form, validate against max
        $durasi = min((int) $request->input('durasi', 7), $maxDurasi);
        $durasi = max($durasi, 1); // Minimum 1 day

        // Check max loans
        if ($user->jumlahPeminjamanAktif() >= $maxPinjam) {
            return redirect()->back()
                ->with('error', "Anda sudah mencapai batas maksimal peminjaman ({$maxPinjam} buku)!");
        }

        // Check stock
        if ($buku->stokTersedia() <= 0) {
            return redirect()->back()
                ->with('error', 'Maaf, buku ini sedang tidak tersedia!');
        }

        // Check if already borrowed
        $existingLoan = Peminjaman::where('user_id', $user->id)
            ->where('buku_id', $buku->id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($existingLoan) {
            return redirect()->back()
                ->with('error', 'Anda sudah meminjam buku ini!');
        }

        Peminjaman::create([
            'user_id' => $user->id,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => Carbon::now(),
            'tanggal_kembali' => Carbon::now()->addDays($durasi),
            'status' => 'dipinjam',
        ]);

        return redirect()->route('siswa.peminjaman.index')
            ->with('success', "Peminjaman berhasil! Buku harus dikembalikan dalam {$durasi} hari.");
    }
}
