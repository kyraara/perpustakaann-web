<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $siswas = $query->withCount(['peminjamans as active_loans' => function ($q) {
            $q->where('status', 'dipinjam');
        }])->paginate(10)->withQueryString();

        $kelasList = User::where('role', 'siswa')
            ->whereNotNull('kelas')
            ->distinct()
            ->pluck('kelas')
            ->sort();

        return view('admin.siswa.index', compact('siswas', 'kelasList'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nisn' => 'required|string|max:20|unique:users,nisn',
            'kelas' => 'required|string|max:10',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'siswa';

        $siswa = User::create($validated);
        

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function edit(User $siswa)
    {
        return view('admin.siswa.edit', compact('siswa'));
    }

    public function update(Request $request, User $siswa)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $siswa->id,
            'nisn' => 'required|string|max:20|unique:users,nisn,' . $siswa->id,
            'kelas' => 'required|string|max:10',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($validated['password']) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $siswa->update($validated);
        

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy(User $siswa)
    {
        if ($siswa->peminjamans()->where('status', 'dipinjam')->count() > 0) {
            return redirect()->route('admin.siswa.index')
                ->with('error', 'Siswa tidak dapat dihapus karena masih memiliki peminjaman aktif!');
        }

        $nama = $siswa->name;
        $nisn = $siswa->nisn;
        $id = $siswa->id;
        $siswa->delete();
        

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Siswa berhasil dihapus!');
    }
}
