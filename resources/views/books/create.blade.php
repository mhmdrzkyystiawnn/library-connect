{{-- resources/views/books/create.blade.php --}}
@extends('layouts.app')
@section('title', isset($book) ? 'Edit Buku' : 'Tambah Buku')

@section('content')

  {{-- Header --}}
  <div class="flex items-center gap-3 mb-6">
    <a href="{{ route('books.index') }}"
       class="text-gray-400 hover:text-teal-600 transition">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <div>
      <h1 class="text-xl font-semibold text-gray-800">
        {{ isset($book) ? 'Edit Buku' : 'Tambah Buku Baru' }}
      </h1>
      <p class="text-xs text-gray-400 mt-0.5">Isi semua kolom yang diperlukan</p>
    </div>
  </div>

  <form method="POST"
        action="{{ isset($book) ? route('admin.buku.update', $book) : route('admin.buku.store') }}"
        enctype="multipart/form-data">
    @csrf
    @if(isset($book)) @method('PUT') @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      {{-- Kolom Kiri: Cover Upload --}}
      <div class="md:col-span-1">
        <div class="bg-white border border-gray-100 rounded-2xl p-5 sticky top-24">
          <p class="text-sm font-medium text-gray-700 mb-3">Cover Buku</p>

          {{-- Preview --}}
          <div id="coverPreview"
               class="w-full h-48 rounded-xl bg-gradient-to-br from-teal-50 to-teal-100
                      flex items-center justify-center mb-3 overflow-hidden">
            @if(isset($book) && $book->cover)
              <img src="{{ Storage::url($book->cover) }}"
                   class="w-full h-full object-cover" alt="Cover">
            @else
              <svg class="w-12 h-12 text-teal-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14
                     m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            @endif
          </div>

          <label class="block w-full text-center bg-gray-50 border border-dashed border-gray-200
                         rounded-xl py-2.5 text-xs text-gray-500 cursor-pointer
                         hover:bg-teal-50 hover:border-teal-300 hover:text-teal-600 transition">
            Upload Gambar
            <input type="file" name="cover" accept="image/*" class="hidden" id="coverInput">
          </label>
          <p class="text-xs text-gray-400 mt-2 text-center">JPG, PNG · Maks 2MB</p>
        </div>
      </div>

      {{-- Kolom Kanan: Form Fields --}}
      <div class="md:col-span-2 space-y-4">

        {{-- Judul --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-5">
          <p class="text-sm font-medium text-gray-700 mb-4">Informasi Buku</p>

          <div class="space-y-4">
            <div>
              <label class="block text-xs text-gray-500 mb-1.5">
                Judul Buku <span class="text-red-400">*</span>
              </label>
              <input type="text" name="judul"
                     value="{{ old('judul', $book->judul ?? '') }}"
                     placeholder="Contoh: Laskar Pelangi"
                     class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                            focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent
                            @error('judul') border-red-300 @enderror">
              @error('judul')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
              @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs text-gray-500 mb-1.5">
                  Pengarang <span class="text-red-400">*</span>
                </label>
                <input type="text" name="pengarang"
                       value="{{ old('pengarang', $book->pengarang ?? '') }}"
                       placeholder="Nama pengarang"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent
                              @error('pengarang') border-red-300 @enderror">
                @error('pengarang')
                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label class="block text-xs text-gray-500 mb-1.5">Penerbit</label>
                <input type="text" name="penerbit"
                       value="{{ old('penerbit', $book->penerbit ?? '') }}"
                       placeholder="Nama penerbit"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs text-gray-500 mb-1.5">
                  Kategori <span class="text-red-400">*</span>
                </label>
                <select name="kategori"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white
                               focus:outline-none focus:ring-2 focus:ring-teal-500
                               @error('kategori') border-red-300 @enderror">
                  <option value="">-- Pilih Kategori --</option>
                  @foreach(['Sains', 'Sejarah', 'Sastra', 'Matematika', 'Komputer',
                             'Sosial', 'Agama', 'Bahasa', 'Seni', 'Olahraga', 'Lainnya'] as $kat)
                    <option value="{{ $kat }}"
                      {{ old('kategori', $book->kategori ?? '') === $kat ? 'selected' : '' }}>
                      {{ $kat }}
                    </option>
                  @endforeach
                </select>
                @error('kategori')
                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label class="block text-xs text-gray-500 mb-1.5">Tahun Terbit</label>
                <input type="number" name="tahun_terbit"
                       value="{{ old('tahun_terbit', $book->tahun_terbit ?? '') }}"
                       placeholder="{{ date('Y') }}" min="1900" max="{{ date('Y') }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent">
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs text-gray-500 mb-1.5">ISBN</label>
                <input type="text" name="isbn"
                       value="{{ old('isbn', $book->isbn ?? '') }}"
                       placeholder="978-xxx-xxx-xxx-x"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent
                              @error('isbn') border-red-300 @enderror">
                @error('isbn')
                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label class="block text-xs text-gray-500 mb-1.5">
                  Jumlah Stok <span class="text-red-400">*</span>
                </label>
                <input type="number" name="stok"
                       value="{{ old('stok', $book->stok ?? 1) }}"
                       min="1" placeholder="1"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                              focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent
                              @error('stok') border-red-300 @enderror">
                @error('stok')
                  <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
              </div>
            </div>

            <div>
              <label class="block text-xs text-gray-500 mb-1.5">Deskripsi</label>
              <textarea name="deskripsi" rows="4"
                        placeholder="Sinopsis atau deskripsi singkat buku..."
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm
                               focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent
                               resize-none">{{ old('deskripsi', $book->deskripsi ?? '') }}</textarea>
            </div>
          </div>
        </div>

        {{-- Submit --}}
        <div class="flex gap-3">
          <button type="submit"
                  class="flex-1 bg-teal-700 text-white py-3 rounded-xl text-sm font-medium
                         hover:bg-teal-600 transition">
            {{ isset($book) ? 'Simpan Perubahan' : 'Tambah Buku' }}
          </button>
          <a href="{{ route('books.index') }}"
             class="px-6 py-3 border border-gray-200 rounded-xl text-sm text-gray-500
                    hover:bg-gray-50 transition text-center">
            Batal
          </a>
        </div>

      </div>
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
      document.getElementById('coverPreview').innerHTML =
        `<img src="${ev.target.result}" class="w-full h-full object-cover">`;
    };
    reader.readAsDataURL(file);
  });
</script>
@endpush