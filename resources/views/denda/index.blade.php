{{-- resources/views/denda/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Rekap Denda')

@section('content')
<style>
  .btn-primary {
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
  }
  .btn-primary:hover {
    background: #0a5a46;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(15,110,86,0.25);
  }
  .stat-card {
    background: #fff;
    border: 1.5px solid #f0f0f0;
    border-radius: 16px;
    padding: 16px 20px;
  }
  .stat-label { font-size: 0.72rem; color: #9ca3af; margin-bottom: 4px; }
  .stat-val   { font-size: 1.6rem; font-weight: 600; line-height: 1; }
  .denda-card {
    background: #fff;
    border: 1.5px solid #f0f0f0;
    border-radius: 18px;
    padding: 18px 20px;
    margin-bottom: 10px;
    transition: border-color 0.15s;
  }
  .denda-card.belum { border-color: #fde8e8; }
  .denda-card.belum:hover { border-color: #f7c1c1; }
  .denda-card.sudah { border-color: #f0f0f0; }
  .denda-card.sudah:hover { border-color: #9FE1CB; }
  .avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: #e8f5f0;
    color: #0F6E56;
    font-size: 0.8rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .btn-lunas {
    font-family: 'DM Sans', sans-serif;
    background: #0F6E56;
    color: #fff;
    font-weight: 600;
    font-size: 0.75rem;
    padding: 7px 16px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
  }
  .btn-lunas:hover {
    background: #0a5a46;
    box-shadow: 0 4px 12px rgba(15,110,86,0.25);
  }
  .pill-lunas {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #e8f5f0;
    color: #0F6E56;
    font-size: 0.72rem;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 20px;
  }
  .chip {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 500;
    border: 1.5px solid #e5e7eb;
    background: #fff;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.15s;
    text-decoration: none;
    white-space: nowrap;
    display: inline-block;
  }
  .chip:hover { border-color: #0F6E56; color: #0F6E56; background: #f0faf6; }
  .chip.active { background: #0F6E56; border-color: #0F6E56; color: #fff; }
  .empty-state { text-align: center; padding: 60px 20px; }
  .empty-icon {
    width: 56px; height: 56px;
    background: #f3f4f6;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
  }
  .progress-bar {
    height: 4px;
    border-radius: 4px;
    background: #f0f0f0;
    overflow: hidden;
    margin-top: 6px;
  }
  .progress-fill {
    height: 100%;
    border-radius: 4px;
    background: linear-gradient(90deg, #0F6E56, #1a8a6a);
    transition: width 0.6s ease;
  }
</style>

{{-- ══ HEADER ══ --}}
<div class="flex items-start justify-between flex-wrap gap-3 mb-6">
  <div>
    <h1 class="text-xl font-semibold" style="color: #1a1a1a;">Rekap Denda</h1>
    <p class="text-sm mt-0.5" style="color: #9ca3af;">Kelola pembayaran denda keterlambatan</p>
  </div>

  <div class="flex flex-col gap-2">

    {{-- Lihat Peminjaman - solid hijau --}}
    <a href="{{ route('admin.peminjaman.index') }}" class="btn-primary">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
             M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
      </svg>
      Lihat Peminjaman
    </a>

    {{-- Tambah Buku - outline hijau --}}
    <a href="{{ route('admin.buku.create') }}" class="btn-primary"
       style="background: #fff; color: #0F6E56; border: 1.5px solid #0F6E56;">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
             C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
             C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
             C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
      </svg>
      Tambah Buku
    </a>

    {{-- Kembali ke Dashboard - abu-abu --}}
    <a href="{{ route('admin.dashboard') }}" class="btn-primary"
       style="background: #f3f4f6; color: #6b7280; border: 1.5px solid #e5e7eb;">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10
             a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4
             a1 1 0 001 1m-6 0h6"/>
      </svg>
      Kembali ke Dashboard
    </a>

  </div>
</div>
{{-- ══ STAT CARDS ══ --}}
@php
  $totalBelum  = App\Models\Denda::where('status_bayar','belum')->sum('total_denda');
  $totalSudah  = App\Models\Denda::where('status_bayar','sudah')->sum('total_denda');
  $totalSemua  = $totalBelum + $totalSudah;
  $pctLunas    = $totalSemua > 0 ? round(($totalSudah / $totalSemua) * 100) : 0;
  $jmlBelum    = App\Models\Denda::where('status_bayar','belum')->count();
  $jmlSudah    = App\Models\Denda::where('status_bayar','sudah')->count();
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-6">

  {{-- Total Belum Lunas --}}
  <div class="stat-card" style="border-color: #fde8e8;">
    <p class="stat-label">Belum Lunas</p>
    <p class="stat-val" style="color: #A32D2D;">
      Rp{{ number_format($totalBelum, 0, ',', '.') }}
    </p>
    <p class="text-xs mt-1" style="color: #9ca3af;">{{ $jmlBelum }} transaksi</p>
  </div>

  {{-- Total Lunas --}}
  <div class="stat-card" style="border-color: #d1fae5;">
    <p class="stat-label">Sudah Lunas</p>
    <p class="stat-val" style="color: #0F6E56;">
      Rp{{ number_format($totalSudah, 0, ',', '.') }}
    </p>
    <p class="text-xs mt-1" style="color: #9ca3af;">{{ $jmlSudah }} transaksi</p>
  </div>

  {{-- Progress Pelunasan --}}
  <div class="stat-card">
    <p class="stat-label">Progress Pelunasan</p>
    <p class="stat-val" style="color: #1a1a1a;">{{ $pctLunas }}%</p>
    <div class="progress-bar mt-2">
      <div class="progress-fill" style="width: {{ $pctLunas }}%;"></div>
    </div>
    <p class="text-xs mt-1" style="color: #9ca3af;">
      {{ $jmlSudah }} dari {{ $jmlBelum + $jmlSudah }} denda lunas
    </p>
  </div>

</div>

{{-- ══ FILTER TAB ══ --}}
<div class="flex gap-2 mb-5 flex-wrap">
  @foreach(['' => 'Semua', 'belum' => 'Belum Lunas', 'sudah' => 'Lunas'] as $val => $label)
    <a href="{{ route('admin.denda.index', $val ? ['status' => $val] : []) }}"
       class="chip {{ request('status', '') === $val ? 'active' : '' }}">
      {{ $label }}
      @if($val === 'belum' && $jmlBelum > 0)
        <span class="ml-1 px-1.5 py-0.5 rounded-full text-xs"
              style="background: rgba(163,45,45,0.15); color: #A32D2D;">
          {{ $jmlBelum }}
        </span>
      @endif
    </a>
  @endforeach
</div>

{{-- ══ LIST DENDA ══ --}}
@forelse($denda as $d)
  <div class="denda-card {{ $d->status_bayar }}">
    <div class="flex items-start justify-between gap-4">

      {{-- Kiri: Info Siswa & Buku --}}
      <div class="flex items-start gap-3 flex-1 min-w-0">
        <div class="avatar">
          {{ strtoupper(substr($d->peminjaman->siswa->nama, 0, 1)) }}
        </div>
        <div class="flex-1 min-w-0">

          {{-- Nama & Kelas --}}
          <div class="flex items-center gap-2 flex-wrap">
            <p class="text-sm font-semibold" style="color: #1a1a1a;">
              {{ $d->peminjaman->siswa->nama }}
            </p>
            <span class="text-xs px-2 py-0.5 rounded-full"
                  style="background: #f3f4f6; color: #6b7280;">
              {{ $d->peminjaman->siswa->kelas }}
            </span>
          </div>
          <p class="text-xs mt-0.5" style="color: #9ca3af;">
            NIS {{ $d->peminjaman->siswa->nis }}
          </p>

          {{-- Judul Buku --}}
          <div class="flex items-center gap-1.5 mt-2">
            <svg class="w-3.5 h-3.5 flex-shrink-0" style="color: #9ca3af;"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                   C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                   C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
                   C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <p class="text-xs truncate" style="color: #374151;">
              {{ $d->peminjaman->book->judul }}
            </p>
          </div>

          {{-- Detail Denda --}}
          <div class="flex flex-wrap gap-3 mt-2">
            <span class="text-xs" style="color: #9ca3af;">
              Terlambat
              <strong style="color: #A32D2D;">{{ $d->hari_terlambat }} hari</strong>
            </span>
            <span style="color: #e5e7eb; font-size: 0.75rem;">·</span>
            <span class="text-xs" style="color: #9ca3af;">
              Rp{{ number_format($d->nominal_per_hari, 0, ',', '.') }}/hari
            </span>
            <span style="color: #e5e7eb; font-size: 0.75rem;">·</span>
            <span class="text-xs" style="color: #9ca3af;">
              Pinjam: {{ $d->peminjaman->tanggal_pinjam->format('d M Y') }}
            </span>
          </div>

        </div>
      </div>

      {{-- Kanan: Nominal & Aksi --}}
      <div class="text-right flex-shrink-0">
        <p class="text-xl font-bold"
           style="color: {{ $d->status_bayar === 'belum' ? '#A32D2D' : '#0F6E56' }};">
          Rp{{ number_format($d->total_denda, 0, ',', '.') }}
        </p>

        @if($d->status_bayar === 'belum')
          <form method="POST"
                action="{{ route('admin.denda.bayar', $d) }}"
                onsubmit="return confirm('Tandai denda Rp{{ number_format($d->total_denda, 0, ',', '.') }} sebagai lunas?')"
                class="mt-2">
            @csrf @method('PATCH')
            <button type="submit" class="btn-lunas">
              Tandai Lunas
            </button>
          </form>
        @else
          <div class="mt-2">
            <span class="pill-lunas">
              <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414
                     L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"/>
              </svg>
              Lunas
            </span>
            @if($d->dibayar_pada)
              <p class="text-xs mt-1" style="color: #9ca3af;">
                {{ \Carbon\Carbon::parse($d->dibayar_pada)->format('d M Y') }}
              </p>
            @endif
          </div>
        @endif
      </div>

    </div>
  </div>
@empty
  <div class="empty-state">
    <div class="empty-icon">
      <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
    </div>
    <p class="text-sm font-medium text-gray-500 mb-1">
      @if(request('status') === 'belum')
        Tidak ada denda yang belum lunas
      @elseif(request('status') === 'sudah')
        Belum ada denda yang dilunasi
      @else
        Tidak ada data denda
      @endif
    </p>
    <p class="text-xs text-gray-400">Semua peminjaman berjalan tepat waktu</p>
  </div>
@endforelse

{{-- ══ PAGINATION ══ --}}
@if($denda->hasPages())
  <div class="mt-6 flex justify-center">
    {{ $denda->links() }}
  </div>
@endif

@endsection