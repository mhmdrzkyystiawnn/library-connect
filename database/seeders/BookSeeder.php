<?php
// database/seeders/BookSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            // Sastra
            ['judul' => 'Laskar Pelangi',            'pengarang' => 'Andrea Hirata',        'penerbit' => 'Bentang Pustaka',  'kategori' => 'Sastra',      'tahun_terbit' => 2005, 'isbn' => '978-979-1227-24-5', 'stok' => 3],
            ['judul' => 'Bumi Manusia',               'pengarang' => 'Pramoedya Ananta Toer', 'penerbit' => 'Lentera Dipantara','kategori' => 'Sastra',      'tahun_terbit' => 1980, 'isbn' => '978-979-97312-0-6', 'stok' => 2],
            ['judul' => 'Tenggelamnya Kapal Van Der', 'pengarang' => 'Buya Hamka',            'penerbit' => 'Bulan Bintang',    'kategori' => 'Sastra',      'tahun_terbit' => 1939, 'isbn' => '978-979-418-214-3', 'stok' => 2],
            ['judul' => 'Dilan 1990',                 'pengarang' => 'Pidi Baiq',             'penerbit' => 'Pastel Books',     'kategori' => 'Sastra',      'tahun_terbit' => 2014, 'isbn' => '978-602-7870-47-6', 'stok' => 4],
            ['judul' => 'Negeri 5 Menara',            'pengarang' => 'Ahmad Fuadi',           'penerbit' => 'Gramedia',         'kategori' => 'Sastra',      'tahun_terbit' => 2009, 'isbn' => '978-979-22-4434-9', 'stok' => 3],

            // Sains
            ['judul' => 'A Brief History of Time',   'pengarang' => 'Stephen Hawking',       'penerbit' => 'Bantam Books',     'kategori' => 'Sains',       'tahun_terbit' => 1988, 'isbn' => '978-0-553-38016-3', 'stok' => 2],
            ['judul' => 'Sapiens',                   'pengarang' => 'Yuval Noah Harari',     'penerbit' => 'Harvill Secker',   'kategori' => 'Sejarah',     'tahun_terbit' => 2011, 'isbn' => '978-0-06-231609-7', 'stok' => 3],
            ['judul' => 'The Selfish Gene',          'pengarang' => 'Richard Dawkins',       'penerbit' => 'Oxford Univ Press','kategori' => 'Sains',       'tahun_terbit' => 1976, 'isbn' => '978-0-19-929115-1', 'stok' => 1],
            ['judul' => 'Cosmos',                    'pengarang' => 'Carl Sagan',            'penerbit' => 'Random House',     'kategori' => 'Sains',       'tahun_terbit' => 1980, 'isbn' => '978-0-394-50294-6', 'stok' => 2],
            ['judul' => 'Biologi SMA Kelas XII',     'pengarang' => 'Irnaningtyas',          'penerbit' => 'Erlangga',         'kategori' => 'Sains',       'tahun_terbit' => 2020, 'isbn' => '978-602-298-500-1', 'stok' => 5],

            // Matematika
            ['judul' => 'Matematika SMA Kelas XI',   'pengarang' => 'Sukino',                'penerbit' => 'Erlangga',         'kategori' => 'Matematika',  'tahun_terbit' => 2021, 'isbn' => '978-602-298-600-8', 'stok' => 5],
            ['judul' => 'Kalkulus Jilid 1',          'pengarang' => 'James Stewart',         'penerbit' => 'Cengage Learning', 'kategori' => 'Matematika',  'tahun_terbit' => 2016, 'isbn' => '978-1-285-74062-1', 'stok' => 2],

            // Sejarah
            ['judul' => 'Sejarah Indonesia Modern',  'pengarang' => 'M.C. Ricklefs',        'penerbit' => 'Serambi',          'kategori' => 'Sejarah',     'tahun_terbit' => 2008, 'isbn' => '978-979-1275-11-0', 'stok' => 2],
            ['judul' => 'Soekarno: Biografi',        'pengarang' => 'Peter Kasenda',         'penerbit' => 'Kompas',           'kategori' => 'Sejarah',     'tahun_terbit' => 2014, 'isbn' => '978-979-709-771-5', 'stok' => 2],
            ['judul' => '1965: Tragedi Bangsa',      'pengarang' => 'Asvi Warman Adam',     'penerbit' => 'Galang Press',     'kategori' => 'Sejarah',     'tahun_terbit' => 2009, 'isbn' => '978-979-9341-91-6', 'stok' => 1],

            // Komputer
            ['judul' => 'Clean Code',                'pengarang' => 'Robert C. Martin',     'penerbit' => 'Prentice Hall',    'kategori' => 'Komputer',    'tahun_terbit' => 2008, 'isbn' => '978-0-13-235088-4', 'stok' => 2],
            ['judul' => 'The Pragmatic Programmer',  'pengarang' => 'David Thomas',         'penerbit' => 'Addison-Wesley',   'kategori' => 'Komputer',    'tahun_terbit' => 2019, 'isbn' => '978-0-13-595705-9', 'stok' => 2],
            ['judul' => 'Informatika SMA Kelas X',   'pengarang' => 'Eko Rizky Istiawan',   'penerbit' => 'Kemendikbud',      'kategori' => 'Komputer',    'tahun_terbit' => 2021, 'isbn' => '978-602-427-869-3', 'stok' => 5],

            // Bahasa
            ['judul' => 'Kamus Besar Bahasa Indonesia','pengarang' => 'Tim Redaksi KBBI',   'penerbit' => 'Balai Pustaka',    'kategori' => 'Bahasa',      'tahun_terbit' => 2016, 'isbn' => '978-979-407-182-9', 'stok' => 3],
            ['judul' => 'English Grammar in Use',    'pengarang' => 'Raymond Murphy',       'penerbit' => 'Cambridge Univ',   'kategori' => 'Bahasa',      'tahun_terbit' => 2019, 'isbn' => '978-1-108-45765-7', 'stok' => 3],
        ];

        foreach ($books as $book) {
            Book::create(array_merge($book, [
                'stok_tersedia' => $book['stok'], // awalnya stok tersedia = stok penuh
            ]));
        }
    }
}