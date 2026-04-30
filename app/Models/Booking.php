<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'siswa_id',
        'book_id',
        'status',
        'durasi',
        'keterangan',
        'tanggal_booking',
        'tanggal_disetujui',
        'tanggal_rencana_kembali',
        'tanggal_kembali_aktual',
    ];

    protected $casts = [
        'tanggal_booking' => 'datetime',
        'tanggal_disetujui' => 'datetime',
        'tanggal_rencana_kembali' => 'datetime',
        'tanggal_kembali_aktual' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Scope untuk filter status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Hitung status display
     */
    public function getStatusDisplayAttribute(): string
    {
        return match ($this->status) {
            'pending' => '⏳ Menunggu Persetujuan',
            'approved' => '✓ Disetujui',
            'rejected' => '✗ Ditolak',
            'completed' => '✓ Selesai',
            default => 'Unknown'
        };
    }

    /**
     * Hitung sisa waktu kembali (hari)
     */
    public function getSisaHariAttribute(): ?int
    {
        if (!$this->tanggal_rencana_kembali) return null;
        
        $today = Carbon::today();
        $diff = $this->tanggal_rencana_kembali->diffInDays($today);
        
        if ($diff < 0) {
            return abs($diff); // Masih ada x hari
        } else {
            return -($diff); // Sudah terlambat x hari (negative)
        }
    }

    /**
     * Cek apakah sudah terlambat
     */
    public function getIsTerlambatAttribute(): bool
    {
        if (!$this->tanggal_rencana_kembali) return false;
        return $this->tanggal_rencana_kembali->isPast();
    }
}

