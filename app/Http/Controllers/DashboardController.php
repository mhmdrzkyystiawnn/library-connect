<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Book;
use App\Models\Denda;

class DashboardController extends Controller
{
    public function siswa()
    {
        $user  = auth()->user();
        $siswa = $user->siswa;

        if (!$siswa) {
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            abort(403, 'Profil siswa tidak ditemukan.');
        }

        $peminjaman = Peminjaman::with(['book', 'denda'])
            ->where('siswa_id', $siswa->id)
            ->orderByDesc('tanggal_pinjam')
            ->get();

        foreach ($peminjaman as $p) {
            if ($p->isTerlambat() && $p->status !== 'terlambat') {
                $p->update(['status' => 'terlambat']);
                $this->syncDenda($p);
            }
        }

        $totalDenda = $peminjaman
            ->where('status', 'terlambat')
            ->sum('total_denda');

        return view('dashboard.siswa', compact('peminjaman', 'totalDenda', 'siswa'));
    }

    public function admin()
    {
        $semuaTerlambat = Peminjaman::with(['denda'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->whereDate('tanggal_kembali_rencana', '<', now())
            ->get();

        foreach ($semuaTerlambat as $p) {
            $p->update(['status' => 'terlambat']);
            $this->syncDenda($p);
        }

        $stats = [
            'total_buku'      => Book::count(),
            'dipinjam'        => Peminjaman::where('status', 'dipinjam')->count(),
            'terlambat'       => Peminjaman::where('status', 'terlambat')->count(),
            'denda_bulan_ini' => Denda::whereMonth('created_at', now()->month)->sum('total_denda'),
        ];

        $peminjaman = Peminjaman::with(['siswa', 'book', 'denda'])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('dashboard.admin', compact('stats', 'peminjaman'));
    }

    private function syncDenda(Peminjaman $p): void
    {
        $hari    = $p->hari_terlambat;
        $nominal = 1000;
        $total   = $hari * $nominal;

        Denda::updateOrCreate(
            ['peminjaman_id' => $p->id],
            [
                'hari_terlambat'   => $hari,
                'nominal_per_hari' => $nominal,
                'total_denda'      => $total,
                'status_bayar'     => 'belum',
            ]
        );
    }
}