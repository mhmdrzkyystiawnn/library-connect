<?php
// app/Http/Controllers/BookController.php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // ⭐ Pencarian buku (mobile-friendly, bisa dari HP)
    public function index(Request $request)
    {
        $query = Book::query();

        // Filter pencarian: judul, pengarang, atau kategori
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('judul', 'like', "%{$q}%")
                        ->orWhere('pengarang', 'like', "%{$q}%")
                        ->orWhere('isbn', 'like', "%{$q}%");
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter ketersediaan
        if ($request->filled('tersedia') && $request->tersedia == '1') {
            $query->where('stok_tersedia', '>', 0);
        }

        $books      = $query->orderBy('judul')->paginate(12)->withQueryString();
        $kategori   = Book::select('kategori')->distinct()->pluck('kategori');

        return view('books.index', compact('books', 'kategori'));
    }

    public function show(Book $book)
    {
        $book->load('peminjaman');
        return view('books.show', compact('book'));
    }

    // Admin: form tambah buku
    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'        => 'required|string|max:255',
            'pengarang'    => 'required|string|max:255',
            'penerbit'     => 'nullable|string|max:255',
            'kategori'     => 'required|string|max:100',
            'tahun_terbit' => 'nullable|integer|min:1900|max:' . date('Y'),
            'isbn'         => 'nullable|string|unique:books',
            'stok'         => 'required|integer|min:1',
            'deskripsi'    => 'nullable|string',
            'cover'        => 'nullable|image|max:2048',
        ]);

        $data['stok_tersedia'] = $data['stok'];

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'judul'        => 'required|string|max:255',
            'pengarang'    => 'required|string|max:255',
            'penerbit'     => 'nullable|string|max:255',
            'kategori'     => 'required|string|max:100',
            'tahun_terbit' => 'nullable|integer',
            'isbn'         => 'nullable|string|unique:books,isbn,' . $book->id,
            'stok'         => 'required|integer|min:1',
            'deskripsi'    => 'nullable|string',
            'cover'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // Jika stok diubah, sesuaikan stok_tersedia
        if ($data['stok'] != $book->stok) {
            $selisih = $data['stok'] - $book->stok;
            $data['stok_tersedia'] = $book->stok_tersedia + $selisih;
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku dihapus.');
    }
}