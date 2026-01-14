<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengaturan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku']);

        if ($request->filled('status')) {
            if ($request->status === 'terlambat') {
                $query->where('status', 'dipinjam')
                    ->where('tanggal_kembali', '<', Carbon::now());
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('buku', function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%");
            });
        }

        $peminjamans = $query->latest()->paginate(10)->withQueryString();

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $siswas = User::where('role', 'siswa')->get();
        $bukus = Buku::whereRaw('stok > (SELECT COUNT(*) FROM peminjamans WHERE peminjamans.buku_id = bukus.id AND status = "dipinjam")')
            ->get();
        
        return view('admin.peminjaman.create', compact('siswas', 'bukus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:bukus,id',
        ]);

        $user = User::find($validated['user_id']);
        $buku = Buku::find($validated['buku_id']);
        $maxPinjam = Pengaturan::getValue('max_pinjam', 2);
        $lamaPinjam = Pengaturan::getValue('lama_pinjam', 7);

        // Check if user already has max loans
        if ($user->jumlahPeminjamanAktif() >= $maxPinjam) {
            return redirect()->back()
                ->with('error', "Siswa sudah mencapai batas maksimal peminjaman ({$maxPinjam} buku)!");
        }

        // Check if book is available
        if ($buku->stokTersedia() <= 0) {
            return redirect()->back()
                ->with('error', 'Buku tidak tersedia!');
        }

        // Check if user already borrowed this book
        $existingLoan = Peminjaman::where('user_id', $validated['user_id'])
            ->where('buku_id', $validated['buku_id'])
            ->where('status', 'dipinjam')
            ->exists();

        if ($existingLoan) {
            return redirect()->back()
                ->with('error', 'Siswa sudah meminjam buku ini!');
        }

        $peminjaman = Peminjaman::create([
            'user_id' => $validated['user_id'],
            'buku_id' => $validated['buku_id'],
            'tanggal_pinjam' => Carbon::now(),
            'tanggal_kembali' => Carbon::now()->addDays($lamaPinjam),
            'status' => 'dipinjam',
        ]);


        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil dicatat!');
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()
                ->with('error', 'Peminjaman sudah dikembalikan!');
        }

        $tanggalDikembalikan = Carbon::now();
        $denda = 0;

        if ($tanggalDikembalikan->gt($peminjaman->tanggal_kembali)) {
            $hariTerlambat = $tanggalDikembalikan->diffInDays($peminjaman->tanggal_kembali);
            $dendaPerHari = Pengaturan::getValue('denda_per_hari', 500);
            $denda = $hariTerlambat * $dendaPerHari;
        }

        $peminjaman->update([
            'tanggal_dikembalikan' => $tanggalDikembalikan,
            'denda' => $denda,
            'status' => 'dikembalikan',
        ]);

        $message = 'Buku berhasil dikembalikan!';
        if ($denda > 0) {
            $message .= ' Denda keterlambatan: Rp ' . number_format($denda, 0, ',', '.');
        }


        return redirect()->route('admin.peminjaman.index')
            ->with('success', $message);
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $id = $peminjaman->id;
        $desc = "Menghapus peminjaman ID#{$id}";
        $peminjaman->delete();


        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus!');
    }

    public function bulkReturn(Request $request)
    {
        $request->validate([
            'peminjaman_ids' => 'required|array|min:1',
            'peminjaman_ids.*' => 'exists:peminjamans,id',
        ]);

        $count = 0;
        $totalDenda = 0;
        $now = Carbon::now();
        $dendaPerHari = Pengaturan::getValue('denda_per_hari', 500);

        foreach ($request->peminjaman_ids as $id) {
            $peminjaman = Peminjaman::find($id);
            
            if ($peminjaman && $peminjaman->status === 'dipinjam') {
                $denda = 0;
                
                if ($now->gt($peminjaman->tanggal_kembali)) {
                    $hariTerlambat = $now->diffInDays($peminjaman->tanggal_kembali);
                    $denda = $hariTerlambat * $dendaPerHari;
                }

                $peminjaman->update([
                    'tanggal_dikembalikan' => $now,
                    'denda' => $denda,
                    'status' => 'dikembalikan',
                ]);

                $totalDenda += $denda;
                $count++;
            }
        }


        $message = "{$count} buku berhasil dikembalikan!";
        if ($totalDenda > 0) {
            $message .= " Total denda: Rp " . number_format($totalDenda, 0, ',', '.');
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success', $message);
    }
}
