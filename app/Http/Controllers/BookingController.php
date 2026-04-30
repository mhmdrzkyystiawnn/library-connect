<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Book;
use App\Models\Peminjaman;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    // ────── SISWA ──────

    /**
     * Tampilkan daftar booking siswa
     */
    public function index()
    {
        $siswa = Auth::user()->siswa;
        $bookings = $siswa->bookings()->with('book')->latest()->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Tampilkan form booking buku
     */
    public function create()
    {
        $books = Book::where('stok_tersedia', '>', 0)->get();
        return view('bookings.create', compact('books'));
    }

    /**
     * Simpan booking baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'durasi' => 'required|integer|min:1|max:30',
        ]);

        $siswa = Auth::user()->siswa;
        $book = Book::findOrFail($validated['book_id']);

        // ⭐ Validasi stok
        if ($book->stok_tersedia <= 0) {
            return back()->with('error', 'Stok buku tidak tersedia!');
        }

        // Cek apakah sudah pernah booking buku ini
        $existingBooking = Booking::where('siswa_id', $siswa->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingBooking) {
            return back()->with('error', 'Anda sudah melakukan booking untuk buku ini!');
        }

        // Buat booking baru (durasi disimpan untuk referensi admin)
        Booking::create([
            'siswa_id' => $siswa->id,
            'book_id' => $book->id,
            'durasi' => $validated['durasi'],
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking buku berhasil! Menunggu persetujuan admin.');
    }

    // ────── ADMIN ──────

    /**
     * Tampilkan semua booking untuk admin
     */
    public function adminIndex()
    {
        $bookings = Booking::with(['siswa', 'book'])
            ->latest()
            ->paginate(15);

        $pendingCount = Booking::pending()->count();

        return view('admin.bookings.index', compact('bookings', 'pendingCount'));
    }

    /**
     * Setujui booking (ubah status ke approved)
     * Admin bisa override durasi jika diperlukan
     */
    public function approve(Booking $booking, Request $request)
    {
        $validated = $request->validate([
            'durasi' => 'required|integer|min:1|max:30',
        ]);

        // Validasi stok lagi
        if ($booking->book->stok_tersedia <= 0) {
            return back()->with('error', 'Stok buku tidak tersedia lagi!');
        }

        $now = now();
        $tanggalKembali = $now->copy()->addDays((int) $validated['durasi']);

        // Update booking
        $booking->update([
            'status' => 'approved',
            'durasi' => $validated['durasi'],
            'tanggal_disetujui' => $now,
            'tanggal_rencana_kembali' => $tanggalKembali,
        ]);

        // Kurangi stok
        $booking->book->decrement('stok_tersedia');

        // Buat Peminjaman record (actual loan/borrow)
        Peminjaman::create([
            'siswa_id' => $booking->siswa_id,
'book_id' => $booking->book_id,
            'tanggal_pinjam' => $now,
            'tanggal_kembali_rencana' => $tanggalKembali,
            'status' => 'dipinjam',
        ]);

        return back()->with('success', 'Booking disetujui! Tenggat kembali: ' . $tanggalKembali->format('d M Y'));
    }

    /**
     * Tolak booking (ubah status ke rejected)
     */
    public function reject(Booking $booking, Request $request)
    {
        $validated = $request->validate([
            'keterangan' => 'required|string',
        ]);

        $booking->update([
            'status' => 'rejected',
            'keterangan' => $validated['keterangan'],
        ]);

        return back()->with('success', 'Booking ditolak!');
    }

    /**
     * Tandai booking sebagai completed (ketika siswa ambil bukunya)
     */
    public function complete(Booking $booking)
    {
        $booking->update(['status' => 'completed']);

        return back()->with('success', 'Booking selesai!');
    }

    // ────── QUICK BOOKING (dari books/show) ──────

    /**
     * Siswa membuat booking dari halaman detail buku
     * (Akan menjadi peminjaman setelah admin approve booking)
     */
    public function quickBook(Request $request, Book $book)
    {
        $request->validate([
            'durasi' => 'required|integer|min:1|max:30',
        ]);

        $siswa = Auth::user()->siswa;

        // Validasi stok
        if ($book->stok_tersedia < 1) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        // Cek apakah sudah booking/pinjam buku yang sama
        $existingBooking = Booking::where('siswa_id', $siswa->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingBooking) {
            return back()->with('error', 'Anda sudah melakukan booking untuk buku ini!');
        }

        // Buat booking (bukan peminjaman langsung)
        Booking::create([
            'siswa_id' => $siswa->id,
            'book_id' => $book->id,
            'durasi' => (int) $request->durasi,
            'status' => 'pending',
        ]);

        return redirect()->route('bookings.index')
            ->with('success', "Booking buku '{$book->judul}' berhasil! Menunggu persetujuan admin.");
    }
}
