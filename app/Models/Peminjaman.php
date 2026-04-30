<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Peminjaman.php
class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = [
        'siswa_id', 'book_id', 'tanggal_pinjam',
        'tanggal_kembali_rencana', 'tanggal_kembali_aktual', 'status'
    ];

    protected $casts = [
        'tanggal_pinjam'           => 'date',
        'tanggal_kembali_rencana'  => 'date',
        'tanggal_kembali_aktual'   => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function denda()
    {
        return $this->hasOne(Denda::class);
    }

    // ⭐ Hitung hari terlambat secara otomatis
    public function getHariTerlambatAttribute(): int
    {
        $batas = $this->tanggal_kembali_rencana;
        $sekarang = $this->tanggal_kembali_aktual ?? now()->startOfDay();

        return $batas->isPast()
            ? (int) $batas->diffInDays($sekarang)
            : 0;
    }

    // ⭐ Hitung nominal denda otomatis
    public function getTotalDendaAttribute(): int
    {
        return $this->hari_terlambat * 1000; // Rp1.000/hari
    }

    public function isTerlambat(): bool
    {
        return $this->tanggal_kembali_rencana->isPast()
            && $this->status !== 'dikembalikan';
    }
}