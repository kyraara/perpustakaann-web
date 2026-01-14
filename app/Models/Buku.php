<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'bukus';

    protected $fillable = [
        'kode_buku',
        'judul',
        'penulis',
        'penerbit',
        'tahun',
        'kategori_id',
        'rak_id',
        'stok',
        'cover',
        'deskripsi',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function rak(): BelongsTo
    {
        return $this->belongsTo(Rak::class);
    }

    public function peminjamans(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function stokTersedia(): int
    {
        $dipinjam = $this->peminjamans()->where('status', 'dipinjam')->count();
        return max(0, $this->stok - $dipinjam);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorit', 'buku_id', 'user_id')->withTimestamps();
    }
}
