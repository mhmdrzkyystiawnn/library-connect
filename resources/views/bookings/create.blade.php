{{-- resources/views/bookings/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Booking Buku')

@section('content')
<style>
  .hero {
    background: linear-gradient(135deg, #0a5040 0%, #0D4F3C 55%, #0e6048 100%);
    border-radius: 28px;
    padding: 3.5rem 2rem 4.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    margin-bottom: 3rem;
  }

  .hero h1 {
    color: #fff;
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
  }

  .hero p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1rem;
  }

  .books-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
  }

  .book-card {
    background: white;
    border: 1.5px solid #f0f0f0;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
  }

  .book-card:hover {
    border-color: #0F6E56;
    box-shadow: 0 8px 24px rgba(15, 110, 86, 0.12);
    transform: translateY(-4px);
  }

  .book-cover {
    height: 200px;
    background: linear-gradient(135deg, #e8f5f0 0%, #d4ebe5 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .book-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .book-info {
    padding: 14px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .book-title {
    font-size: 0.85rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 4px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .book-author {
    font-size: 0.75rem;
    color: #9ca3af;
    margin-bottom: 8px;
  }

  .stock-status {
    font-size: 0.7rem;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 6px;
    margin-bottom: 10px;
    text-align: center;
  }

  .stock-available {
    background: #e8f5f0;
    color: #0F6E56;
  }

  .stock-unavailable {
    background: #FCEBEB;
    color: #A32D2D;
  }

  .btn-book {
    background: #0F6E56;
    color: white;
    border: none;
    padding: 7px 12px;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    width: 100%;
    margin-top: auto;
  }

  .btn-book:hover:not(:disabled) {
    background: #0a5a46;
    transform: translateY(-1px);
  }

  .btn-book:disabled {
    background: #d1d5db;
    cursor: not-allowed;
  }

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

  .book-detail {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
  }

  .book-detail-img {
    width: 60px;
    height: 80px;
    background: #e8f5f0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .book-detail-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .book-detail-info {
    flex-grow: 1;
  }

  .book-detail-title {
    font-weight: 600;
    font-size: 0.9rem;
    color: #1a1a1a;
    margin-bottom: 2px;
  }

  .book-detail-author {
    font-size: 0.75rem;
    color: #9ca3af;
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

  .btn-confirm {
    flex: 1;
    padding: 10px;
    background: #0F6E56;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
  }

  .btn-confirm:hover {
    background: #0a5a46;
  }
</style>

<div class="hero">
  <h1>📚 Booking Buku</h1>
  <p>Pesan buku yang ingin Anda pinjam</p>
</div>

@if ($errors->any())
  <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
    <p class="text-sm font-semibold text-red-700">Terjadi kesalahan:</p>
    <ul class="list-disc list-inside text-sm text-red-600">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

@if (session('success'))
  <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded">
    <p class="text-sm font-semibold text-green-700">✓ {{ session('success') }}</p>
  </div>
@endif

@if (session('error'))
  <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
    <p class="text-sm font-semibold text-red-700">✗ {{ session('error') }}</p>
  </div>
@endif

<div class="mb-6">
  <a href="{{ route('bookings.index') }}" class="text-teal-600 hover:text-teal-700 text-sm font-medium">
    ← Kembali ke Daftar Booking
  </a>
</div>

<div class="books-grid">
  @forelse($books as $book)
    <div class="book-card">
      <div class="book-cover">
        @if ($book->cover)
          <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->judul }}">
        @else
          <svg class="w-12 h-12 text-teal-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                 C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                 C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
                 C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
          </svg>
        @endif
      </div>

      <div class="book-info">
        <div class="book-title">{{ $book->judul }}</div>
        <div class="book-author">{{ $book->pengarang }}</div>

        <div class="stock-status {{ $book->stok_tersedia > 0 ? 'stock-available' : 'stock-unavailable' }}">
          {{ $book->stok_tersedia > 0 ? 'Tersedia (' . $book->stok_tersedia . ')' : 'Tidak Tersedia' }}
        </div>

        <button class="btn-book" onclick="openModal({{ $book->id }}, '{{ $book->judul }}', '{{ $book->pengarang }}')"
                {{ $book->stok_tersedia <= 0 ? 'disabled' : '' }}>
          {{ $book->stok_tersedia > 0 ? 'Booking' : 'Tidak Bisa' }}
        </button>
      </div>
    </div>
  @empty
    <div style="grid-column: 1/-1; text-align: center; padding: 40px;">
      <p class="text-gray-500">Tidak ada buku yang tersedia untuk booking</p>
    </div>
  @endforelse
</div>

<!-- Modal Konfirmasi -->
<div id="confirmModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">Booking Buku</div>

    <form id="bookingForm" method="POST" action="{{ route('bookings.store') }}">
      @csrf
      <div class="modal-body">
        <div class="book-detail">
          <div class="book-detail-img" id="modalBookImg"></div>
          <div class="book-detail-info">
            <div class="book-detail-title" id="modalBookTitle"></div>
            <div class="book-detail-author" id="modalBookAuthor"></div>
          </div>
        </div>

        <div style="margin: 16px 0; padding: 12px; background: #f0faf8; border-radius: 8px;">
          <p style="font-size: 0.85rem; color: #6b7280; margin-bottom: 8px;">
            Berapa lama Anda ingin meminjam buku ini?
          </p>
        </div>

        <div class="form-group">
          <label class="form-label">Durasi Peminjaman (hari)</label>
          <div style="display: flex; gap: 8px; margin-bottom: 10px;">
            <button type="button" class="quick-btn" onclick="setDurasi(this, 3)">3</button>
            <button type="button" class="quick-btn" onclick="setDurasi(this, 7)">7</button>
            <button type="button" class="quick-btn" onclick="setDurasi(this, 14)">14</button>
            <button type="button" class="quick-btn" onclick="setDurasi(this, 21)">21</button>
          </div>
          <input type="number" id="durasiInput" name="durasi" 
                 min="1" max="30" value="7" required
                 style="width: 100%; padding: 10px 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.9rem;">
          <small style="color: #9ca3af; display: block; margin-top: 6px;">Min 1 hari, Max 30 hari</small>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
        <input type="hidden" id="bookIdInput" name="book_id">
        <button type="submit" class="btn-confirm">Booking Sekarang</button>
      </div>
    </form>
  </div>
</div>

<style>
  .form-group {
    margin-bottom: 16px;
  }

  .form-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 8px;
  }

  .quick-btn {
    flex: 1;
    padding: 8px;
    border: 1.5px solid #0F6E56;
    background: white;
    color: #0F6E56;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: pointer;
    transition: all 0.2s;
  }

  .quick-btn:hover,
  .quick-btn.active {
    background: #0F6E56;
    color: white;
  }
</style>

<script>
function openModal(bookId, bookTitle, bookAuthor) {
  document.getElementById('bookIdInput').value = bookId;
  document.getElementById('modalBookTitle').textContent = bookTitle;
  document.getElementById('modalBookAuthor').textContent = bookAuthor;
  document.getElementById('durasiInput').value = '7';
  document.querySelectorAll('.quick-btn').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.quick-btn')[1].classList.add('active'); // 7 hari default
  document.getElementById('confirmModal').classList.add('show');
}

function closeModal() {
  document.getElementById('confirmModal').classList.remove('show');
}

function setDurasi(btn, days) {
  document.getElementById('durasiInput').value = days;
  document.querySelectorAll('.quick-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}

// Close modal when clicking outside
document.getElementById('confirmModal')?.addEventListener('click', function (e) {
  if (e.target === this) closeModal();
});
</script>
@endsection
