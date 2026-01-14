<?php

use App\Http\Controllers\Admin\BukuController as AdminBukuController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\RakController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\KepalaSekolah\DashboardController as KepalaSekolahDashboardController;
use App\Http\Controllers\KepalaSekolah\LaporanController as KepalaSekolahLaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Siswa\BukuController as SiswaBukuController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\PeminjamanController as SiswaPeminjamanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Google OAuth Routes
Route::get('/auth/google', [App\Http\Controllers\Auth\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isSiswa()) {
        return redirect()->route('siswa.dashboard');
    } elseif ($user->isKepalaSekolah()) {
        return redirect()->route('kepala-sekolah.dashboard');
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    
    // Rak
    Route::get('/rak', [RakController::class, 'index'])->name('rak.index');
    Route::post('/rak', [RakController::class, 'store'])->name('rak.store');
    Route::put('/rak/{rak}', [RakController::class, 'update'])->name('rak.update');
    Route::delete('/rak/{rak}', [RakController::class, 'destroy'])->name('rak.destroy');
    
    // Buku
    Route::get('/buku', [AdminBukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/export', [AdminBukuController::class, 'export'])->name('buku.export');
    Route::post('/buku/import', [AdminBukuController::class, 'import'])->name('buku.import');
    Route::get('/buku/create', [AdminBukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [AdminBukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}/edit', [AdminBukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [AdminBukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [AdminBukuController::class, 'destroy'])->name('buku.destroy');
    
    // Siswa
    Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('/siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('/siswa', [SiswaController::class, 'store'])->name('siswa.store');
    Route::get('/siswa/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('/siswa/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
    
    // Peminjaman
    Route::get('/peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [AdminPeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [AdminPeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::post('/peminjaman/{peminjaman}/kembalikan', [AdminPeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::post('/peminjaman/bulk-return', [AdminPeminjamanController::class, 'bulkReturn'])->name('peminjaman.bulk-return');
    Route::delete('/peminjaman/{peminjaman}', [AdminPeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    
    // Pengaturan
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
    Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
    
    // Laporan
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/peminjaman', [AdminLaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/peminjaman/export', [AdminLaporanController::class, 'peminjamanExport'])->name('laporan.peminjaman.export');
    Route::get('/laporan/keterlambatan', [AdminLaporanController::class, 'keterlambatan'])->name('laporan.keterlambatan');
    Route::get('/laporan/keterlambatan/export', [AdminLaporanController::class, 'keterlambatanExport'])->name('laporan.keterlambatan.export');
    Route::get('/laporan/stok-buku', [AdminLaporanController::class, 'stokBuku'])->name('laporan.stok-buku');
    Route::get('/laporan/stok-buku/export', [AdminLaporanController::class, 'stokBukuExport'])->name('laporan.stok-buku.export');
    Route::get('/laporan/siswa-aktif', [AdminLaporanController::class, 'siswaAktif'])->name('laporan.siswa-aktif');
    Route::get('/laporan/siswa-aktif/export', [AdminLaporanController::class, 'siswaAktifExport'])->name('laporan.siswa-aktif.export');



    // Global Search
    Route::get('/search', [\App\Http\Controllers\Admin\SearchController::class, 'index'])->name('search.index');
});

// Siswa Routes
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    
    // Buku
    Route::get('/buku', [SiswaBukuController::class, 'index'])->name('buku.index');
    Route::get('/buku/{buku}', [SiswaBukuController::class, 'show'])->name('buku.show');
    
    // Peminjaman
    Route::get('/peminjaman', [SiswaPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/histori', [SiswaPeminjamanController::class, 'histori'])->name('peminjaman.histori');
    Route::post('/peminjaman/{buku}', [SiswaPeminjamanController::class, 'ajukan'])->name('peminjaman.ajukan');


});

// Kepala Sekolah Routes
Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepala-sekolah')->name('kepala-sekolah.')->group(function () {
    Route::get('/dashboard', [KepalaSekolahDashboardController::class, 'index'])->name('dashboard');
    
    // Laporan
    Route::get('/laporan/peminjaman', [KepalaSekolahLaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/stok-buku', [KepalaSekolahLaporanController::class, 'stokBuku'])->name('laporan.stok-buku');
    Route::get('/laporan/siswa-aktif', [KepalaSekolahLaporanController::class, 'siswaAktif'])->name('laporan.siswa-aktif');
    Route::get('/laporan/keterlambatan', [KepalaSekolahLaporanController::class, 'keterlambatan'])->name('laporan.keterlambatan');
});

require __DIR__.'/auth.php';
