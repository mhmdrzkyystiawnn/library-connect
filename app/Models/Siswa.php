<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Siswa.php
class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = ['user_id', 'nis', 'nama', 'kelas', 'no_hp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function peminjamanAktif()
    {
        return $this->hasMany(Peminjaman::class)
                    ->whereIn('status', ['dipinjam', 'terlambat']);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
