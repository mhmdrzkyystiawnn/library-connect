{{-- resources/views/dashboard/siswa.blade.php --}}
@extends('layouts.app')
@section('title', 'Dashboard Saya')

@section('content')

  {{-- Greeting --}}
  <div class="mb-5">
    <h2 class="text-xl font-semibold text-gray-800">Halo, {{ $siswa->nama }}!</h2>
    <p class="text-sm text-gray-500">{{ $siswa->kelas }} · NIS {{ $siswa->nis }}</p>
  </div>

  {{-- Alert Terlambat --}}
  @if($peminjaman->where('status', 'terlambat')->count() > 0)
    <div class="bg-red-50 border border-red-200 rounded-2xl px-4 py-3 mb-5">
      <p class="text-red-700 text-sm font-medium">
        ⚠ Kamu punya {{ $peminjaman->where('status', 'terlambat')->count() }} buku terlambat dikembalikan.
        Denda terus bertambah setiap hari!
      </p>
    </div>
  @endif

  {{-- Stats --}}
  <div class="grid grid-cols-3 gap-3 mb-6">
    <div class="bg-white border border-gray-100 rounded-2xl p-4 text-center">
      <p class="text-xs text-gray-400 mb-1">Dipinjam</p>
      <p class="text-2xl font-semibold text-amber-500">
        {{ $peminjaman->whereIn('status', ['dipinjam','terlambat'])->count() }}
      </p>
    </div>
    <div class="bg-white border border-gray-100 rounded-2xl p-4 text-center">
      <p class="text-xs text-gray-400 mb-1">Terlambat</p>
      <p class="text-2xl font-semibold text-red-500">
        {{ $peminjaman->where('status', 'terlambat')->count() }}
      </p>
    </div>
    <div class="bg-white border border-gray-100 rounded-2xl p-4 text-center">
      <p class="text-xs text-gray-400 mb-1">Total Denda</p>
      <p class="text-lg font-semibold text-red-500">
        Rp{{ number_format($totalDenda, 0, ',', '.') }}
      </p>
    </div>
  </div>

  {{-- Quick Action --}}
  <div class="flex gap-3 mb-6 flex-wrap">
    <a href="{{ route('bookings.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2 px-4 rounded-xl transition text-sm flex items-center gap-2">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Booking Buku
    </a>
    <a href="{{ route('bookings.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-4 rounded-xl transition text-sm flex items-center gap-2">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
      </svg>
      Booking Saya
    </a>
  </div>

  {{-- Daftar Buku Dipinjam --}}
  <h3 class="text-sm font-semibold text-gray-700 mb-3">Buku Aktif Dipinjam</h3>

  @forelse($peminjaman->whereIn('status', ['dipinjam', 'terlambat']) as $p)
    <div class="bg-white border rounded-2xl p-4 mb-3
                {{ $p->status === 'terlambat' ? 'border-red-200' : 'border-gray-100' }}">
      <div class="flex justify-between items-start gap-3">
        <div class="flex-1 min-w-0">
          <p class="text-sm font-medium text-gray-800 truncate">{{ $p->book->judul }}</p>
          <p class="text-xs text-gray-400 mt-0.5">{{ $p->book->pengarang }}</p>
          <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
            <span>Pinjam: {{ $p->tanggal_pinjam->format('d M Y') }}</span>
            <span>·</span>
            <span class="{{ $p->status === 'terlambat' ? 'text-red-500 font-medium' : '' }}">
              Batas: {{ $p->tanggal_kembali_rencana->format('d M Y') }}
            </span>
          </div>
        </div>

        {{-- Info Denda --}}
        <div class="text-right flex-shrink-0">
          @if($p->status === 'terlambat')
            <p class="text-sm font-semibold text-red-500">
              Rp{{ number_format($p->total_denda, 0, ',', '.') }}
            </p>
            <p class="text-xs text-red-400">{{ $p->hari_terlambat }} hari terlambat</p>
            <span class="inline-block mt-1 bg-red-50 text-red-600 text-xs px-2 py-0.5 rounded-full">
              Terlambat
            </span>
          @else
            <p class="text-xs text-gray-400">
              {{ $p->tanggal_kembali_rencana->diffForHumans() }}
            </p>
            <span class="inline-block mt-1 bg-teal-50 text-teal-600 text-xs px-2 py-0.5 rounded-full">
              Tepat Waktu
            </span>
          @endif
        </div>
      </div>
    </div>
  @empty
    <div class="text-center py-10 text-gray-400 text-sm">
      Tidak ada buku yang sedang dipinjam.
      <a href="{{ route('books.index') }}" class="text-teal-600 underline block mt-2">Cari buku sekarang</a>
    </div>
  @endforelse

  {{-- Booking Menunggu Persetujuan --}}
  @php
    $bookingPending = $siswa->bookings()->where('status', 'pending')->with('book')->get();
  @endphp

  @if($bookingPending->count() > 0)
    <h3 class="text-sm font-semibold text-gray-700 mb-3 mt-6">Booking Menunggu Persetujuan</h3>
    
    @foreach($bookingPending as $booking)
      <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-3">
        <div class="flex justify-between items-start gap-3">
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-800 truncate">{{ $booking->book->judul }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ $booking->book->pengarang }}</p>
            <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
              <span>Di-booking: {{ $booking->tanggal_booking->format('d M Y') }}</span>
              <span>·</span>
              <span>Durasi minta: {{ $booking->durasi ?? '-' }} hari</span>
            </div>
          </div>

          <div class="text-right flex-shrink-0">
            <span class="inline-block bg-amber-100 text-amber-700 text-xs px-2 py-0.5 rounded-full font-medium">
              ⏳ Menunggu Admin
            </span>
            <p class="text-xs text-amber-600 mt-2">Tenggat kembali akan ditentukan setelah disetujui</p>
          </div>
        </div>
      </div>
    @endforeach
  @endif

  {{-- Booking Disetujui (Approved) --}}
  @php
    $bookingApproved = $siswa->bookings()->where('status', 'approved')->with('book')->get();
  @endphp

  @if($bookingApproved->count() > 0)
    <h3 class="text-sm font-semibold text-gray-700 mb-3 mt-6">Booking Disetujui</h3>
    
    @foreach($bookingApproved as $booking)
      <div class="bg-white border border-teal-200 rounded-2xl p-4 mb-3">
        <div class="flex justify-between items-start gap-3">
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-800 truncate">{{ $booking->book->judul }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ $booking->book->pengarang }}</p>
            <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
              <span>Disetujui: {{ $booking->tanggal_disetujui->format('d M Y') }}</span>
              <span>·</span>
              <span class="{{ $booking->is_terlambat ? 'text-red-500 font-medium' : 'text-teal-600' }}">
                Batas: {{ $booking->tanggal_rencana_kembali->format('d M Y') }}
              </span>
            </div>
          </div>

          <div class="text-right flex-shrink-0">
            @if($booking->is_terlambat)
              <p class="text-xs text-red-500 font-semibold mb-1">🔴 TERLAMBAT!</p>
              <span class="inline-block bg-red-50 text-red-600 text-xs px-2 py-0.5 rounded-full">
                {{ abs($booking->sisa_hari) }} hari
              </span>
            @else
              <p class="text-xs text-teal-600 font-semibold mb-1">{{ $booking->sisa_hari }} hari lagi</p>
              <span class="inline-block bg-teal-50 text-teal-600 text-xs px-2 py-0.5 rounded-full">
                Tepat Waktu
              </span>
            @endif
          </div>
        </div>
      </div>
    @endforeach
  @endif

  {{-- Riwayat --}}
  @if($peminjaman->where('status', 'dikembalikan')->count() > 0)
    <h3 class="text-sm font-semibold text-gray-700 mb-3 mt-6">Riwayat Pengembalian</h3>
    @foreach($peminjaman->where('status', 'dikembalikan') as $p)
      <div class="bg-gray-50 border border-gray-100 rounded-2xl p-4 mb-2 flex justify-between items-center">
        <div>
          <p class="text-sm text-gray-700">{{ $p->book->judul }}</p>
          <p class="text-xs text-gray-400 mt-0.5">
            Dikembalikan: {{ $p->tanggal_kembali_aktual->format('d M Y') }}
          </p>
        </div>
        @if($p->denda && $p->denda->total_denda > 0)
          <span class="text-xs {{ $p->denda->status_bayar === 'sudah' ? 'bg-teal-50 text-teal-600' : 'bg-red-50 text-red-500' }} px-2 py-1 rounded-full">
            {{ $p->denda->status_bayar === 'sudah' ? 'Lunas' : 'Belum Bayar' }}
          </span>
        @else
          <span class="text-xs bg-teal-50 text-teal-600 px-2 py-1 rounded-full">Tanpa Denda</span>
        @endif
      </div>
    @endforeach
  @endif

@endsection