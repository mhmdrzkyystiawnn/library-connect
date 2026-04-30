<?php
// database/seeders/PeminjamanSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\Denda;
use App\Models\Siswa;
use App\Models\Book;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $siswa = Siswa::all();
        $books = Book::all();

        $skenario = [

            // ─── SKENARIO 1: Terlambat parah (15 hari) ───────────────────
            [
                'siswa_id'                => $siswa[0]->id,  // Budi
                'book_id'                 => $books[0]->id,  // Laskar Pelangi
                'tanggal_pinjam'          => Carbon::now()->subDays(22),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(15),
                'tanggal_kembali_aktual'  => null,
                'status'                  => 'terlambat',
                'denda_hari'              => 15,
            ],

            // ─── SKENARIO 2: Terlambat ringan (3 hari) ───────────────────
            [
                'siswa_id'                => $siswa[1]->id,  // Siti
                'book_id'                 => $books[5]->id,  // A Brief History of Time
                'tanggal_pinjam'          => Carbon::now()->subDays(10),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(3),
                'tanggal_kembali_aktual'  => null,
                'status'                  => 'terlambat',
                'denda_hari'              => 3,
            ],

            // ─── SKENARIO 3: Masih aktif, belum terlambat ────────────────
            [
                'siswa_id'                => $siswa[2]->id,  // Ahmad
                'book_id'                 => $books[10]->id, // Matematika SMA
                'tanggal_pinjam'          => Carbon::now()->subDays(5),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(9),
                'tanggal_kembali_aktual'  => null,
                'status'                  => 'dipinjam',
                'denda_hari'              => 0,
            ],

            // ─── SKENARIO 4: Mau jatuh tempo besok ───────────────────────
            [
                'siswa_id'                => $siswa[3]->id,  // Dewi
                'book_id'                 => $books[3]->id,  // Dilan 1990
                'tanggal_pinjam'          => Carbon::now()->subDays(13),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(1),
                'tanggal_kembali_aktual'  => null,
                'status'                  => 'dipinjam',
                'denda_hari'              => 0,
            ],

            // ─── SKENARIO 5: Sudah dikembalikan tepat waktu ──────────────
            [
                'siswa_id'                => $siswa[4]->id,  // Rizky
                'book_id'                 => $books[6]->id,  // Sapiens
                'tanggal_pinjam'          => Carbon::now()->subDays(20),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(6),
                'tanggal_kembali_aktual'  => Carbon::now()->subDays(7), // balik sehari lebih cepat
                'status'                  => 'dikembalikan',
                'denda_hari'              => 0,
            ],

            // ─── SKENARIO 6: Dikembalikan terlambat, denda LUNAS ─────────
            [
                'siswa_id'                => $siswa[5]->id,  // Nurul
                'book_id'                 => $books[15]->id, // Clean Code
                'tanggal_pinjam'          => Carbon::now()->subDays(30),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(16),
                'tanggal_kembali_aktual'  => Carbon::now()->subDays(9), // terlambat 7 hari
                'status'                  => 'dikembalikan',
                'denda_hari'              => 7,
                'denda_lunas'             => true,
            ],

            // ─── SKENARIO 7: Dikembalikan terlambat, denda BELUM BAYAR ───
            [
                'siswa_id'                => $siswa[6]->id,  // Fajar
                'book_id'                 => $books[1]->id,  // Bumi Manusia
                'tanggal_pinjam'          => Carbon::now()->subDays(25),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(11),
                'tanggal_kembali_aktual'  => Carbon::now()->subDays(5), // terlambat 6 hari
                'status'                  => 'dikembalikan',
                'denda_hari'              => 6,
                'denda_lunas'             => false,
            ],

            // ─── SKENARIO 8: Siswa pinjam 2 buku sekaligus ───────────────
            [
                'siswa_id'                => $siswa[0]->id,  // Budi (2 buku)
                'book_id'                 => $books[16]->id, // The Pragmatic Programmer
                'tanggal_pinjam'          => Carbon::now()->subDays(3),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(11),
                'tanggal_kembali_aktual'  => null,
                'status'                  => 'dipinjam',
                'denda_hari'              => 0,
            ],

            // ─── SKENARIO 9: Terlambat sangat lama (30 hari) ─────────────
            [
                'siswa_id'                => $siswa[7]->id,  // Anisa
                'book_id'                 => $books[13]->id, // Soekarno Biografi
                'tanggal_pinjam'          => Carbon::now()->subDays(44),
                'tanggal_kembali_rencana' => Carbon::now()->subDays(30),
                'tanggal_kembali_aktual'  => null,
                'status'                  => 'terlambat',
                'denda_hari'              => 30,
            ],

            // ─── SKENARIO 10: Baru pinjam hari ini ───────────────────────
            [
                'siswa_id'                => $siswa[8]->id,  // Dimas
                'book_id'                 => $books[17]->id, // Informatika SMA
                'tanggal_pinjam'          => Carbon::now(),
                'tanggal_kembali_rencana' => Carbon::now()->addDays(14),
                'tanggal_kembali_aktual'  => null,
                'status'                  => 'dipinjam',
                'denda_hari'              => 0,
            ],
        ];

        $nominalPerHari = 1000;

        foreach ($skenario as $s) {
            // Buat record peminjaman
            $peminjaman = Peminjaman::create([
                'siswa_id'                => $s['siswa_id'],
                'book_id'                 => $s['book_id'],
                'tanggal_pinjam'          => $s['tanggal_pinjam'],
                'tanggal_kembali_rencana' => $s['tanggal_kembali_rencana'],
                'tanggal_kembali_aktual'  => $s['tanggal_kembali_aktual'],
                'status'                  => $s['status'],
            ]);

            // Kurangi stok untuk yang masih dipinjam / terlambat
            if (in_array($s['status'], ['dipinjam', 'terlambat'])) {
                $peminjaman->book->decrement('stok_tersedia');
            }

            // Buat record denda jika ada
            if ($s['denda_hari'] > 0) {
                Denda::create([
                    'peminjaman_id'    => $peminjaman->id,
                    'hari_terlambat'   => $s['denda_hari'],
                    'nominal_per_hari' => $nominalPerHari,
                    'total_denda'      => $s['denda_hari'] * $nominalPerHari,
                    'status_bayar'     => isset($s['denda_lunas']) && $s['denda_lunas'] ? 'sudah' : 'belum',
                    'dibayar_pada'     => isset($s['denda_lunas']) && $s['denda_lunas'] ? now() : null,
                ]);
            }
        }
    }
}