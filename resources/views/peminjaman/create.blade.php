{{-- resources/views/peminjaman/create.blade.php --}}
@extends('layouts.app')
@section('title', 'Tambah Peminjaman')

@section('content')

  <div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.peminjaman.index') }}"
       class="text-gray-400 hover:text-teal-600 transition">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <div>
      <h1 class="text-xl font-semibold text-gray-800">Tambah Peminjaman</h1>
      <p class="text-xs text-gray-400 mt-0.5">Catat peminjaman buku baru</p>
    </div>
  </div>

  <div class="max-w-xl">
    <form method="POST" action="{{ route('admin.peminjaman.store') }}">
      @csrf

      <div class="bg-white border border-gray-100 rounded-2xl p-5 space-y-5">

        {{-- Pilih Siswa --}}
        <div>
          <label class="block text-xs text-gray-500 mb-1.5">
            Siswa <span class="text-red-400">*</span>
          </label>
          <select name="siswa_id"
                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white
                         focus:outline-none focus:ring-2 focus:ring-teal-500
                         @error('siswa_id') border-red-300 @enderror">
            <option value="">-- Pilih Siswa --</option>
            @foreach($siswa as $s)
              <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                {{ $s->nama }} — {{ $s->kelas }} ({{ $s->nis }})
              </option>
            @endforeach
          </select>
          @error('siswa_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Pilih Buku --}}
        <div>
          <label class="block text-xs text-gray-500 mb-1.5">
            Buku <span class="text-red-400">*</span>
          </label>
          <select name="book_id" id="bookSelect"
                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white
                         focus:outline-none focus:ring-2 focus:ring-teal-500
                         @error('book_id') border-red-300 @enderror">
            <option value="">-- Pilih Buku --</option>
            @foreach($books as $book)
              <option value="{{ $book->id }}"
                      data-stok="{{ $book->stok_tersedia }}"
                      {{ old('book_id') == $book->id ? 'selected' : '' }}>
                {{ $book->judul }} — {{ $book->pengarang }}
                (Stok: {{ $book->stok_tersedia }})
              </option>
            @endforeach
          </select>
          @error('book_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
          {{-- Info stok dinamis --}}
          <div id="stokInfo" class="hidden mt-2 text-xs px-3 py-2 rounded-lg"></div>
        </div>

        {{-- Durasi Pinjam --}}
        <div>
          <label class="block text-xs text-gray-500 mb-1.5">
            Durasi Peminjaman <span class="text-red-400">*</span>
          </label>
          <div class="flex gap-2 flex-wrap">
            @foreach([7 => '1 Minggu', 14 => '2 Minggu', 21 => '3 Minggu', 30 => '1 Bulan'] as $hari => $label)
              <label class="flex-1 min-w-0">
                <input type="radio" name="durasi" value="{{ $hari }}"
                       class="peer hidden"
                       {{ old('durasi', 7) == $hari ? 'checked' : '' }}>
                <span class="block text-center border border-gray-200 rounded-xl py-2.5 text-xs
                             cursor-pointer transition
                             peer-checked:bg-teal-700 peer-checked:text-white peer-checked:border-teal-700
                             hover:border-teal-400 hover:text-teal-600">
                  {{ $label }}<br>
                  <span class="text-gray-400 peer-checked:text-teal-200 text-xs">({{ $hari }} hari)</span>
                </span>
              </label>
            @endforeach
          </div>
          @error('durasi')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Estimasi Tanggal --}}
        <div class="bg-teal-50 rounded-xl p-4" id="estimasiBox">
          <p class="text-xs text-teal-600 font-medium mb-2">Estimasi Peminjaman</p>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <p class="text-xs text-teal-500">Tanggal Pinjam</p>
              <p class="text-sm font-medium text-teal-800">
                {{ now()->translatedFormat('d F Y') }}
              </p>
            </div>
            <div>
              <p class="text-xs text-teal-500">Batas Kembali</p>
              <p class="text-sm font-medium text-teal-800" id="estimasiKembali">
                {{ now()->addDays(7)->translatedFormat('d F Y') }}
              </p>
            </div>
          </div>
        </div>

        {{-- Info Denda --}}
        <div class="bg-amber-50 border border-amber-100 rounded-xl px-4 py-3">
          <p class="text-xs text-amber-700">
            ⚠ Denda keterlambatan <strong>Rp1.000 per hari</strong> dihitung otomatis
            jika buku tidak dikembalikan tepat waktu.
          </p>
        </div>

      </div>

      {{-- Tombol Submit --}}
      <div class="flex gap-3 mt-4">
        <button type="submit"
                class="flex-1 bg-teal-700 text-white py-3 rounded-xl text-sm font-medium
                       hover:bg-teal-600 transition">
          Catat Peminjaman
        </button>
        <a href="{{ route('admin.peminjaman.index') }}"
           class="px-6 py-3 border border-gray-200 rounded-xl text-sm text-gray-500
                  hover:bg-gray-50 transition text-center">
          Batal
        </a>
      </div>

    </form>
  </div>

@endsection

@push('scripts')
<script>
  // Update estimasi tanggal kembali sesuai durasi yang dipilih
  document.querySelectorAll('input[name="durasi"]').forEach(radio => {
    radio.addEventListener('change', function () {
      const hari = parseInt(this.value);
      const kembali = new Date();
      kembali.setDate(kembali.getDate() + hari);
      document.getElementById('estimasiKembali').textContent =
        kembali.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    });
  });

  // Tampilkan info stok saat buku dipilih
  document.getElementById('bookSelect').addEventListener('change', function () {
    const stok = this.options[this.selectedIndex]?.dataset?.stok;
    const infoEl = document.getElementById('stokInfo');
    if (!stok) { infoEl.classList.add('hidden'); return; }
    infoEl.classList.remove('hidden');
    if (parseInt(stok) > 0) {
      infoEl.className = 'mt-2 text-xs px-3 py-2 rounded-lg bg-teal-50 text-teal-700';
      infoEl.textContent = `✓ Stok tersedia: ${stok} eksemplar`;
    } else {
      infoEl.className = 'mt-2 text-xs px-3 py-2 rounded-lg bg-red-50 text-red-600';
      infoEl.textContent = '✕ Stok habis — buku sedang dipinjam semua';
    }
  });
</script>
@endpush