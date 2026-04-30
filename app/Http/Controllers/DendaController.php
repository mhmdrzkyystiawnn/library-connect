<?php
// app/Http/Controllers/DendaController.php
namespace App\Http\Controllers;

use App\Models\Denda;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    // app/Http/Controllers/DendaController.php — update method index()
public function index()
{
    $query = Denda::with(['peminjaman.siswa', 'peminjaman.book']);

    // ⭐ Tambahan: filter by status bayar
    if (request()->filled('status')) {
        $query->where('status_bayar', request('status'));
    }

    $denda = $query->orderBy('status_bayar')
                   ->orderByDesc('total_denda')
                   ->paginate(15);

    $totalBelumBayar = Denda::where('status_bayar', 'belum')->sum('total_denda');

    return view('denda.index', compact('denda', 'totalBelumBayar'));
}

    // ⭐ Tandai denda sudah dibayar
    public function bayar(Denda $denda)
    {
        $denda->update([
            'status_bayar' => 'sudah',
            'dibayar_pada' => now(),
        ]);

        return back()->with('success',
            "Denda Rp" . number_format($denda->total_denda, 0, ',', '.') . " berhasil dicatat sebagai lunas."
        );
    }
}