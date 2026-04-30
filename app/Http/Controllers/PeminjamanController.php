<?php
// app/Http/Controllers/PeminjamanController.php
namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Book;
use App\Models\Siswa;
use App\Models\Denda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
{
    $query = Peminjaman::with(['siswa', 'book', 'denda'])
        ->orderByDesc('created_at');

    // Filter status
    if (request()->filled('status')) {
        $query->where('status', request('status'));
    }

    // Search siswa / buku
    if (request()->filled('q')) {
        $q = request('q');
        $query->whereHas('siswa', fn($s) => $s->where('nama', 'like', "%{$q}%"))
              ->orWhereHas('book', fn($b) => $b->where('judul', 'like', "%{$q}%"));
    }

    $peminjaman = $query->paginate(15)->withQueryString();

    return view('peminjaman.index', compact('peminjaman'));
}

    public function create()
    {
        $books = Book::where('stok_tersedia', '>', 0)->orderBy('judul')->get();
        $siswa = Siswa::orderBy('nama')->get();

        return view('peminjaman.create', compact('books', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'book_id'  => 'required|exists:books,id',
            'durasi'   => 'required|integer|min:1|max:30',
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stok_tersedia < 1) {
            return back()->withErrors(['book_id' => 'Stok buku tidak tersedia.']);
        }

        $sudahPinjam = Peminjaman::where('siswa_id', $request->siswa_id)
            ->where('book_id', $request->book_id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($sudahPinjam) {
            return back()->withErrors(['book_id' => 'Siswa ini masih meminjam buku yang sama.']);
        }

        $tanggalPinjam  = Carbon::today();
        $tanggalKembali = $tanggalPinjam->copy()->addDays((int) $request->durasi);

        Peminjaman::create([
            'siswa_id'                => $request->siswa_id,
            'book_id'                 => $request->book_id,
            'tanggal_pinjam'          => $tanggalPinjam,
            'tanggal_kembali_rencana' => $tanggalKembali,
            'status'                  => 'dipinjam',
        ]);

        $book->decrement('stok_tersedia');

        return redirect()->route('admin.dashboard')
            ->with('success', "Peminjaman berhasil! Batas kembali: {$tanggalKembali->format('d M Y')}");
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'dikembalikan') {
            return back()->withErrors(['msg' => 'Buku ini sudah dikembalikan.']);
        }

        $tanggalAktual = Carbon::today();
        $peminjaman->update([
            'tanggal_kembali_aktual' => $tanggalAktual,
            'status'                 => 'dikembalikan',
        ]);

        $peminjaman->book->increment('stok_tersedia');

        $batas         = $peminjaman->tanggal_kembali_rencana;
        $hariTerlambat = $batas->isPast()
            ? (int) $batas->diffInDays($tanggalAktual)
            : 0;

        if ($hariTerlambat > 0) {
            $total = $hariTerlambat * 1000;

            Denda::updateOrCreate(
                ['peminjaman_id' => $peminjaman->id],
                [
                    'hari_terlambat'   => $hariTerlambat,
                    'nominal_per_hari' => 1000,
                    'total_denda'      => $total,
                    'status_bayar'     => 'belum',
                ]
            );

            return redirect()->route('admin.dashboard')
                ->with('warning', "Terlambat {$hariTerlambat} hari. Denda: Rp" . number_format($total, 0, ',', '.'));
        }

        return redirect()->route('admin.dashboard')
            ->with('success', 'Buku berhasil dikembalikan tepat waktu!');
    }

    // ────── SISWA BORROW ──────

    /**
     * Siswa membuat booking dari halaman detail buku
     * (Akan menjadi peminjaman setelah admin approve)
     */
    public function quickBook(Request $request, Book $book)
    {
        $request->validate([
            'durasi' => 'required|integer|min:1|max:30',
        ]);

        $siswa = auth()->user()->siswa;

        // Validasi stok
        if ($book->stok_tersedia < 1) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        // Cek apakah sudah booking/pinjam buku yang sama
        $existingBooking = \App\Models\Booking::where('siswa_id', $siswa->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingBooking) {
            return back()->with('error', 'Anda sudah melakukan booking untuk buku ini!');
        }

        // Buat booking (bukan peminjaman langsung)
        \App\Models\Booking::create([
            'siswa_id' => $siswa->id,
            'book_id' => $book->id,
            'durasi' => (int) $request->durasi,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')
            ->with('success', "Booking buku '{$book->judul}' berhasil! Menunggu persetujuan admin.");
    }

    /**
     * Siswa meminjam buku langsung dari halaman detail buku (deprecated - gunakan booking)
     */
    public function quickBorrow(Request $request, Book $book)
    {
        $request->validate([
            'durasi' => 'required|integer|min:1|max:30',
        ]);

        $siswa = auth()->user()->siswa;

        // Validasi stok
        if ($book->stok_tersedia < 1) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        // Cek apakah sudah meminjam buku yang sama
        $sudahPinjam = Peminjaman::where('siswa_id', $siswa->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->exists();

        if ($sudahPinjam) {
            return back()->with('error', 'Anda masih meminjam buku ini.');
        }

        $tanggalPinjam  = Carbon::today();
        $tanggalKembali = $tanggalPinjam->copy()->addDays((int) $request->durasi);

        Peminjaman::create([
            'siswa_id'                => $siswa->id,
            'book_id'                 => $book->id,
            'tanggal_pinjam'          => $tanggalPinjam,
            'tanggal_kembali_rencana' => $tanggalKembali,
            'status'                  => 'dipinjam',
        ]);

        $book->decrement('stok_tersedia');

        return redirect()->route('dashboard')
            ->with('success', "Peminjaman buku '{$book->judul}' berhasil! Batas kembali: {$tanggalKembali->format('d M Y')}");
    }
}