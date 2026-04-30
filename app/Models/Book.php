<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Book.php
class Book extends Model
{
    protected $fillable = [
        'judul', 'pengarang', 'penerbit', 'kategori',
        'tahun_terbit', 'isbn', 'stok', 'stok_tersedia',
        'deskripsi', 'cover'
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}