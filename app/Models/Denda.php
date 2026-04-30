<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Denda.php
class Denda extends Model
{
    protected $table = 'denda';
    protected $fillable = [
        'peminjaman_id', 'hari_terlambat',
        'nominal_per_hari', 'total_denda', 'status_bayar', 'dibayar_pada'
    ];

     protected $casts = [
        'dibayar_pada' => 'datetime',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}