<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_dikembalikan' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }

    public function isTerlambat(): bool
    {
        if ($this->status === 'dikembalikan') {
            return $this->tanggal_dikembalikan->gt($this->tanggal_kembali);
        }
        return Carbon::now()->gt($this->tanggal_kembali);
    }

    // Accessor untuk hari terlambat
    public function getHariTerlambatAttribute(): int
    {
        if ($this->status === 'dikembalikan') {
            $tanggalAcuan = $this->tanggal_dikembalikan;
        } else {
            $tanggalAcuan = Carbon::now();
        }

        if ($tanggalAcuan->gt($this->tanggal_kembali)) {
            return $tanggalAcuan->diffInDays($this->tanggal_kembali);
        }

        return 0;
    }
}
