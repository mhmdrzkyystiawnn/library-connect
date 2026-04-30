<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// ── Redirect root ke halaman buku ──
Route::get('/', function () {
    return redirect()->route('books.index');
});

// ── Public: pencarian buku tanpa login ──
Route::get('/buku', [BookController::class, 'index'])->name('books.index');
Route::get('/buku/{book}', [BookController::class, 'show'])->name('books.show');

// ── Dashboard siswa (ganti default breeze) ──
Route::get('/dashboard', [DashboardController::class, 'siswa'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ── Profile bawaan Breeze ──
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking siswa
    Route::get('/booking', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/booking/buat', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('bookings.store');

    // Quick booking dari books/show
    Route::post('/buku/{book}/pinjam', [BookingController::class, 'quickBook'])->name('buku.pinjam');

    // Siswa borrow book directly
    Route::post('/buku/{book}/pinjam-langsung', [PeminjamanController::class, 'quickBorrow'])->name('buku.pinjam-langsung');
});

// ── Admin: semua route admin ──
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard admin
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');

    // CRUD buku
    Route::get('/buku/create', [BookController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BookController::class, 'store'])->name('buku.store');
    Route::get('/buku/{book}/edit', [BookController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{book}', [BookController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{book}', [BookController::class, 'destroy'])->name('buku.destroy');

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/tambah', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::patch('/peminjaman/{peminjaman}/kembalikan', [PeminjamanController::class, 'kembalikan'])
         ->name('peminjaman.kembalikan');

    // Denda
    Route::get('/denda', [DendaController::class, 'index'])->name('denda.index');
    Route::patch('/denda/{denda}/bayar', [DendaController::class, 'bayar'])->name('denda.bayar');

    // Booking (admin)
    Route::get('/booking', [BookingController::class, 'adminIndex'])->name('booking.index');
    Route::patch('/booking/{booking}/approve', [BookingController::class, 'approve'])->name('booking.approve');
    Route::patch('/booking/{booking}/reject', [BookingController::class, 'reject'])->name('booking.reject');
    Route::patch('/booking/{booking}/complete', [BookingController::class, 'complete'])->name('booking.complete');
});

require __DIR__.'/auth.php';