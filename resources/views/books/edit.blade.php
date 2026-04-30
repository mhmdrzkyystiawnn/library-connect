{{-- resources/views/books/edit.blade.php --}}
@extends('layouts.app')
@section('title', 'Edit Buku')

@section('content')
<style>
  .btn-solid {
    background: #0F6E56;
    color: #fff;
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    font-size: 0.8rem;
    padding: 9px 18px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
    width: 100%;
    justify-content: center;
  }
  .btn-solid:hover {
    background: #0a5a46;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(15,110,86,0.25);
  }
  .btn-outline {
    background: #fff;
    color: #6b7280;
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    font-size: 0.8rem;
    padding: 9px 18px;
    border-radius: 10px;
    border: 1.5px solid #e5e7eb;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
    width: 100%;
    justify-content: center;
  }
  .btn-outline:hover {
    background: #f3f4f6;
    transform: translateY(-1px);
  }
  .btn-danger {
    background: #fff;
    color: #A32D2D;
    font-family: 'DM Sans', sans-serif;
    font-weight: 600;
    font-size: 0.8rem;
    padding: 9px 18px;
    border-radius: 10px;
    border: 1.5px solid #f7c1c1;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
    width: 100%;
    justify-content: center;
  }
  .btn-danger:hover {
    background: #FCEBEB;
    border-color: #f09595;
    transform: translateY(-1px);
  }
  .form-card {
    background: #fff;
    border: 1.5px solid #f0f0f0;
    border-radius: 20px;
    padding: 24px;
  }
  .form-label {
    display: block;
    font-size: 0.78rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 6px;
  }
  .form-label span { color: #A32D2D; }
  .form-input {
    font-family: 'DM Sans', sans-serif;
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.85rem;
    color: #1a1a1a;
    background: #fff;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .form-input:focus {
    border-color: #0F6E56;
    box-shadow: 0 0 0 3px rgba(15,110,86,0.08);
  }
  .form-input.error { border-color: #f09595; }
  .form-select {
    font-family: 'DM Sans', sans-serif;
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.85rem;
    color: #1a1a1a;
    background: #fff;
    outline: none;
    transition: border-color 0.2s;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px;
    padding-right: 36px;
  }
  .form-select:focus {
    border-color: #0F6E56;
    box-shadow: 0 0 0 3px rgba(15,110,86,0.08);
  }
  .form-textarea {
    font-family: 'DM Sans', sans-serif;
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.85rem;
    color: #1a1a1a;
    background: #fff;
    outline: none;
    transition: border-color 0.2s;
    resize: none;
    line-height: 1.6;
  }
  .form-textarea:focus {
    border-color: #0F6E56;
    box-shadow: 0 0 0 3px rgba(15,110,86,0.08);
  }
  .error-msg {
    font-size: 0.72rem;
    color: #A32D2D;
    margin-top: 4px;
    display: flex;
    align-items: center;
    gap: 4px;
  }
  .cover-upload {
    border: 2px dashed #e5e7eb;
    border-radius: 14px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
  }
  .cover-upload:hover {
    border-color: #0F6E56;
    background: #f0faf6;
  }
  .cover-preview {
    width: 100%;
    height: 200px;
    border-radius: 12px;
    overflow: hidden;
    background: linear-gradient(145deg, #e8f5f0, #9FE1CB);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
  }
  .cover-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .section-title {
    font-size: 0.8rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 16px;
    padding-bottom: 10px;
    border-bottom: 1.5px solid #f5f5f5;
  }
  .info-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #f0faf6;
    color: #0F6E56;
    font-size: 0.72rem;
    font-weight: 500;
    padding: 4px 10px;
    border-radius: 20px;
    border: 1px solid #9FE1CB;
  }
</style>

{{-- ══ BREADCRUMB ══ --}}
<div class="flex items-center gap-2 mb-5 text-xs" style="color: #9ca3af;">
  <a href="{{ route('books.index') }}" class="hover:text-teal-600 transition">Koleksi Buku</a>
  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
  </svg>
  <a href="{{ route('books.show', $book) }}" class="hover:text-teal-600 transition truncate max-w-xs">
    {{ $book->judul }}
  </a>
  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
  </svg>
  <span style="color: #374151;">Edit</span>
</div>

{{-- ══ HEADER ══ --}}
<div class="flex items-start justify-between flex-wrap gap-3 mb-6">
  <div>
    <h1 class="text-xl font-semibold" style="color: #1a1a1a;">Edit Buku</h1>
    <p class="text-sm mt-0.5" style="color: #9ca3af;">Perbarui informasi buku di koleksi perpustakaan</p>
  </div>
  <div class="info-badge">
    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd"
        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
        clip-rule="evenodd"/>
    </svg>
    ID Buku #{{ $book->id }}
  </div>
</div>

<form method="POST" action="{{ route('admin.buku.update', $book) }}" enctype="multipart/form-data">
  @csrf
  @method('PUT')

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- ══ KOLOM KIRI: Cover ══ --}}
    <div class="md:col-span-1 space-y-4">

      <div class="form-card">
        <p class="section-title">Cover Buku</p>

        {{-- Preview --}}
        <div class="cover-preview" id="coverPreview">
          @if($book->cover)
            <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->judul }}" id="previewImg">
          @else
            <div class="text-center" id="placeholderIcon">
              <svg class="w-12 h-12 mx-auto mb-2" style="color: #9FE1CB;"
                   fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0
                     L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
              <p class="text-xs" style="color: #9FE1CB;">Belum ada cover</p>
            </div>
          @endif
        </div>

        {{-- Upload Area --}}
        <label class="cover-upload block" for="coverInput">
          <svg class="w-6 h-6 mx-auto mb-2" style="color: #9ca3af;"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
          </svg>
          <p class="text-xs font-medium" style="color: #374151;">Klik untuk upload cover baru</p>
          <p class="text-xs mt-1" style="color: #9ca3af;">JPG, PNG · Maks 2MB</p>
          <input type="file" name="cover" id="coverInput" accept="image/*" class="hidden">
        </label>

        @if($book->cover)
          <p class="text-xs text-center mt-2" style="color: #9ca3af;">
            Biarkan kosong jika tidak ingin mengganti cover
          </p>
        @endif
      </div>

      {{-- Info Stok --}}
      <div class="form-card">
        <p class="section-title">Info Stok</p>
        <div class="space-y-3">
          <div class="flex justify-between items-center">
            <span class="text-xs" style="color: #9ca3af;">Stok Total</span>
            <span class="text-sm font-semibold" style="color: #1a1a1a;">{{ $book->stok }} eksemplar</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-xs" style="color: #9ca3af;">Tersedia</span>
            <span class="text-sm font-semibold" style="color: #0F6E56;">{{ $book->stok_tersedia }} eksemplar</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-xs" style="color: #9ca3af;">Dipinjam</span>
            <span class="text-sm font-semibold" style="color: #854F0B;">
              {{ $book->stok - $book->stok_tersedia }} eksemplar
            </span>
          </div>
          {{-- Progress stok --}}
          <div class="w-full rounded-full" style="height: 6px; background: #f0f0f0;">
            @php $pct = $book->stok > 0 ? ($book->stok_tersedia / $book->stok) * 100 : 0; @endphp
            <div class="rounded-full" style="height: 6px; width: {{ $pct }}%; background: #0F6E56; transition: width 0.4s;"></div>
          </div>
          <p class="text-xs" style="color: #9ca3af;">{{ round($pct) }}% stok tersedia</p>
        </div>
      </div>

      {{-- Tombol Aksi --}}
      <div class="space-y-2">
        <button type="submit" class="btn-solid">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 13l4 4L19 7"/>
          </svg>
          Simpan Perubahan
        </button>
        <a href="{{ route('books.show', $book) }}" class="btn-outline">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
          Batal
        </a>
      </div>

    </div>

    {{-- ══ KOLOM KANAN: Form Fields ══ --}}
    <div class="md:col-span-2 space-y-4">

      {{-- Informasi Utama --}}
      <div class="form-card">
        <p class="section-title">Informasi Utama</p>
        <div class="space-y-4">

          {{-- Judul --}}
          <div>
            <label class="form-label" for="judul">
              Judul Buku <span>*</span>
            </label>
            <input type="text" id="judul" name="judul"
                   value="{{ old('judul', $book->judul) }}"
                   placeholder="Contoh: Laskar Pelangi"
                   class="form-input @error('judul') error @enderror">
            @error('judul')
              <p class="error-msg">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
              </p>
            @enderror
          </div>

          {{-- Pengarang & Penerbit --}}
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="form-label" for="pengarang">
                Pengarang <span>*</span>
              </label>
              <input type="text" id="pengarang" name="pengarang"
                     value="{{ old('pengarang', $book->pengarang) }}"
                     placeholder="Nama pengarang"
                     class="form-input @error('pengarang') error @enderror">
              @error('pengarang')
                <p class="error-msg">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <label class="form-label" for="penerbit">Penerbit</label>
              <input type="text" id="penerbit" name="penerbit"
                     value="{{ old('penerbit', $book->penerbit) }}"
                     placeholder="Nama penerbit"
                     class="form-input">
            </div>
          </div>

          {{-- Kategori & Tahun --}}
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="form-label" for="kategori">
                Kategori <span>*</span>
              </label>
              <select id="kategori" name="kategori"
                      class="form-select @error('kategori') error @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach(['Sains','Sejarah','Sastra','Matematika','Komputer','Sosial','Agama','Bahasa','Seni','Olahraga','Lainnya'] as $kat)
                  <option value="{{ $kat }}"
                    {{ old('kategori', $book->kategori) === $kat ? 'selected' : '' }}>
                    {{ $kat }}
                  </option>
                @endforeach
              </select>
              @error('kategori')
                <p class="error-msg">{{ $message }}</p>
              @enderror
            </div>
            <div>
              <label class="form-label" for="tahun_terbit">Tahun Terbit</label>
              <input type="number" id="tahun_terbit" name="tahun_terbit"
                     value="{{ old('tahun_terbit', $book->tahun_terbit) }}"
                     placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') }}"
                     class="form-input">
            </div>
          </div>

        </div>
      </div>

      {{-- Identitas & Stok --}}
      <div class="form-card">
        <p class="section-title">Identitas & Stok</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="form-label" for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn"
                   value="{{ old('isbn', $book->isbn) }}"
                   placeholder="978-xxx-xxx-xxx-x"
                   class="form-input @error('isbn') error @enderror">
            @error('isbn')
              <p class="error-msg">{{ $message }}</p>
            @enderror
          </div>
          <div>
            <label class="form-label" for="stok">
              Jumlah Stok <span>*</span>
            </label>
            <input type="number" id="stok" name="stok"
                   value="{{ old('stok', $book->stok) }}"
                   min="1" placeholder="1"
                   class="form-input @error('stok') error @enderror">
            @error('stok')
              <p class="error-msg">{{ $message }}</p>
            @enderror
            <p class="text-xs mt-1" style="color: #9ca3af;">
              Stok tersedia saat ini: {{ $book->stok_tersedia }} · sedang dipinjam: {{ $book->stok - $book->stok_tersedia }}
            </p>
          </div>
        </div>
      </div>

      {{-- Deskripsi --}}
      <div class="form-card">
        <p class="section-title">Deskripsi</p>
        <textarea id="deskripsi" name="deskripsi" rows="5"
                  placeholder="Sinopsis atau deskripsi singkat buku..."
                  class="form-textarea">{{ old('deskripsi', $book->deskripsi) }}</textarea>
      </div>

    </div>
  </div>
</form>

{{-- ══ FORM DELETE (TERPISAH) ══ --}}
<form method="POST" action="{{ route('admin.buku.destroy', $book) }}" id="deleteBookForm" class="mt-4"
      onsubmit="return confirm('Hapus buku \'{{ addslashes($book->judul) }}\' secara permanen?')">
  @csrf @method('DELETE')
  <div class="md:col-span-1">
    <button type="submit" class="btn-danger" style="width: 100%; md:max-width: 250px;">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
             m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
      </svg>
      Hapus Buku
    </button>
  </div>
</form>

@endsection

@push('scripts')
<script>
  // Preview cover sebelum upload
  document.getElementById('coverInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (ev) => {
      const preview = document.getElementById('coverPreview');
      preview.innerHTML = `<img src="${ev.target.result}"
        style="width:100%; height:100%; object-fit:cover;" alt="Preview">`;
    };
    reader.readAsDataURL(file);
  });
</script>
@endpush