@extends('layouts.app')
@section('title', $book->judul)

@section('content')
<style>
  .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 50;
    align-items: center;
    justify-content: center;
  }

  .modal.show {
    display: flex;
  }

  .modal-content {
    background: white;
    border-radius: 16px;
    padding: 24px;
    max-width: 400px;
    width: 90%;
  }

  .modal-header {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 16px;
    color: #1a1a1a;
  }

  .modal-body {
    margin-bottom: 20px;
  }

  .form-group {
    margin-bottom: 16px;
  }

  .form-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 6px;
  }

  .form-input {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.9rem;
    font-family: inherit;
  }

  .form-input:focus {
    outline: none;
    border-color: #0D8B5E;
  }

  .modal-footer {
    display: flex;
    gap: 10px;
  }

  .btn-cancel {
    flex: 1;
    padding: 10px;
    border: 1.5px solid #e5e7eb;
    background: white;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
  }

  .btn-cancel:hover {
    background: #f9fafb;
  }

  .btn-submit {
    flex: 1;
    padding: 10px;
    background: #0D8B5E;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
  }

  .btn-submit:hover {
    background: #0a6f4a;
  }

  .book-info {
    font-size: 0.9rem;
    color: #6b7280;
    margin-bottom: 12px;
  }
</style>

  <div class="flex items-center gap-3 mb-6">
    <a href="{{ route('books.index') }}"
       class="text-gray-400 hover:text-teal-600 transition">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <p class="text-xs text-gray-400">Detail Buku</p>
  </div>

  @if (session('success'))
    <div class="mb-4 p-4 bg-teal-50 border-l-4 border-teal-600 rounded">
      <p class="text-sm font-semibold text-teal-700">✓ {{ session('success') }}</p>
    </div>
  @endif

  @if (session('error'))
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-600 rounded">
      <p class="text-sm font-semibold text-red-700">✗ {{ session('error') }}</p>
    </div>
  @endif

  @if ($errors->any())
    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-600 rounded">
      <p class="text-sm font-semibold text-red-700 mb-2">Terjadi kesalahan:</p>
      <ul class="list-disc list-inside text-sm text-red-600">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Cover --}}
    <div class="md:col-span-1">
      <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-2xl w-full max-w-xs mx-auto aspect-[3/4.5] md:max-w-sm md:aspect-[2/3]\n                  flex items-center justify-center overflow-hidden shadow-lg">@if($book->cover)<img src="{{ Storage::url($book->cover) }}"\n               class="w-full h-full object-contain" alt="{{ $book->judul }}">@else<svg class="w-20 h-20 text-teal-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"\n              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13\n                 C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13\n                 C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13\n                 C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>@endif      </div>

      {{-- Status Stok --}}
      <div class="mt-4 bg-white border border-gray-100 rounded-2xl p-4">
        <div class="flex justify-between items-center mb-3">
          <span class="text-xs text-gray-500">Ketersediaan</span>
          <span class="text-xs font-medium px-3 py-1 rounded-full
                       {{ $book->stok_tersedia > 0 ? 'bg-teal-50 text-teal-700' : 'bg-red-50 text-red-500' }}">
            {{ $book->stok_tersedia > 0 ? 'Tersedia' : 'Sedang Dipinjam' }}
          </span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-2">
          <div class="bg-teal-500 h-2 rounded-full transition-all"
               style="width: {{ $book->stok > 0 ? ($book->stok_tersedia / $book->stok) * 100 : 0 }}%">
          </div>
        </div>
        <p class="text-xs text-gray-400 mt-2 text-right">
          {{ $book->stok_tersedia }} / {{ $book->stok }} tersedia
        </p>
      </div>
    </div>

    {{-- Detail --}}
    <div class="md:col-span-2">
      <h1 class="text-2xl font-semibold text-gray-800 mb-1">{{ $book->judul }}</h1>
      <p class="text-gray-500 text-sm mb-4">{{ $book->pengarang }}</p>

      <div class="flex flex-wrap gap-2 mb-5">
        <span class="bg-teal-50 text-teal-700 text-xs px-3 py-1 rounded-full">
          {{ $book->kategori }}
        </span>
        @if($book->tahun_terbit)
          <span class="bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full">
            {{ $book->tahun_terbit }}
          </span>
        @endif
      </div>

      {{-- Info Table --}}
      <div class="bg-white border border-gray-100 rounded-2xl p-5 mb-5">
        <table class="w-full text-sm">
          @foreach([
            'Pengarang'  => $book->pengarang,
            'Penerbit'   => $book->penerbit ?? '—',
            'Kategori'   => $book->kategori,
            'Tahun'      => $book->tahun_terbit ?? '—',
            'ISBN'       => $book->isbn ?? '—',
            'Stok Total' => $book->stok . ' eksemplar',
          ] as $label => $value)
            <tr class="border-b border-gray-50 last:border-0">
              <td class="py-2.5 text-xs text-gray-400 w-28">{{ $label }}</td>
              <td class="py-2.5 text-xs text-gray-700 font-medium">{{ $value }}</td>
            </tr>
          @endforeach
        </table>
      </div>

      @if($book->deskripsi)
        <div class="bg-white border border-gray-100 rounded-2xl p-5 mb-5">
          <p class="text-xs text-gray-400 mb-2">Deskripsi</p>
          <p class="text-sm text-gray-700 leading-relaxed">{{ $book->deskripsi }}</p>
        </div>
      @endif

      {{-- Aksi --}}
      <div class="flex gap-3">
        @auth
          @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.buku.edit', $book) }}"
               class="flex-1 text-center border border-teal-300 text-teal-700 py-3 rounded-xl
                      text-sm font-medium hover:bg-teal-50 transition">
              Edit Buku
            </a>
            <form method="POST" action="{{ route('admin.buku.destroy', $book) }}"
                  onsubmit="return confirm('Hapus buku ini permanen?')">
              @csrf @method('DELETE')
              <button class="px-5 py-3 border border-red-200 text-red-400 rounded-xl
                             text-sm hover:bg-red-50 transition">
                Hapus
              </button>
            </form>
          @elseif(auth()->user()->role === 'siswa')
            <button onclick="openBorrowModal({{ $book->id }}, '{{ addslashes($book->judul) }}')"
                    {{ $book->stok_tersedia <= 0 ? 'disabled' : '' }}
                    class="flex-1 text-center py-3 rounded-xl text-sm font-medium transition
                           {{ $book->stok_tersedia > 0 
                              ? 'bg-teal-600 text-white hover:bg-teal-700' 
                              : 'bg-gray-200 text-gray-400 cursor-not-allowed' }}">
              {{ $book->stok_tersedia > 0 ? '📚 Pinjam Buku' : 'Stok Habis' }}
            </button>
          @endif
        @else
          <a href="{{ route('login') }}"
             class="flex-1 text-center bg-teal-700 text-white py-3 rounded-xl
                    text-sm font-medium hover:bg-teal-600 transition">
            Login untuk Meminjam
          </a>
        @endauth
      </div>

    </div>
  </div>

  <!-- Modal Pinjam Buku -->
  <div id="borrowModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">Booking Buku</div>

      <form id="borrowForm" method="POST" style="display: contents;">
        @csrf
        <div class="modal-body">
          <div class="book-info">
            📚 <span id="modalBookTitle"></span>
          </div>

          <div style="background: #f0faf8; border-left: 4px solid #0D8B5E; padding: 10px 12px; border-radius: 6px; font-size: 0.85rem; color: #1a1a1a; margin-bottom: 12px;">
            <strong>Info:</strong> Booking ini akan menunggu persetujuan admin. Setelah disetujui, Anda bisa mengambil buku sesuai durasi yang diminta.
          </div>

          <div class="form-group">
            <label class="form-label">Durasi Peminjaman (hari)</label>
            <div style="display: flex; gap: 8px; margin-bottom: 8px;">
              <button type="button" class="px-3 py-2 border border-teal-600 text-teal-600 rounded-lg text-sm font-medium hover:bg-teal-50" onclick="setDurasi(this, 3)">3 hari</button>
              <button type="button" class="px-3 py-2 border border-teal-600 text-teal-600 rounded-lg text-sm font-medium hover:bg-teal-50" onclick="setDurasi(this, 7)">7 hari</button>
              <button type="button" class="px-3 py-2 border border-teal-600 text-teal-600 rounded-lg text-sm font-medium hover:bg-teal-50" onclick="setDurasi(this, 14)">14 hari</button>
            </div>
            <input type="number" id="durasiInput" name="durasi" class="form-input" 
                   min="1" max="30" required placeholder="Atau input durasi (hari)">
            <small style="color: #9ca3af; display: block; margin-top: 6px;">Min 1 hari, Max 30 hari</small>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn-cancel" onclick="closeBorrowModal()">Batal</button>
          <button type="submit" class="btn-submit">Booking Sekarang</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function openBorrowModal(bookId, bookTitle) {
      document.getElementById('modalBookTitle').textContent = bookTitle;
      document.getElementById('borrowForm').action = `/buku/${bookId}/pinjam`;
      document.getElementById('durasiInput').value = '7';
      document.getElementById('borrowModal').classList.add('show');
    }

    function closeBorrowModal() {
      document.getElementById('borrowModal').classList.remove('show');
    }

    function setDurasi(btn, days) {
      document.getElementById('durasiInput').value = days;
      
      // Visual feedback
      document.querySelectorAll('#borrowModal button[onclick*="setDurasi"]').forEach(b => {
        b.style.background = '';
        b.style.color = '';
      });
      btn.style.background = '#0D8B5E';
      btn.style.color = 'white';
    }

    // Close modal when clicking outside
    document.getElementById('borrowModal')?.addEventListener('click', function (e) {
      if (e.target === this) closeBorrowModal();
    });
  </script>

@endsection