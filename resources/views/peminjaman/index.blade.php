{{-- resources/views/peminjaman/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Data Peminjaman')

@section('content')
<style>
  .page-header { margin-bottom: 24px; }
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
  .table-wrap {
    background: #fff;
    border: 1.5px solid #f0f0f0;
    border-radius: 20px;
    overflow: hidden;
  }
  .table-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1.5px solid #f5f5f5;
    flex-wrap: wrap;
    gap: 10px;
  }
  .table-head h3 { font-size: 0.9rem; font-weight: 600; color: #1a1a1a; }
  .search-admin {
    font-family: 'DM Sans', sans-serif;
    padding: 7px 14px;
    border: 1.5px solid #f0f0f0;
    border-radius: 10px;
    font-size: 0.8rem;
    color: #1a1a1a;
    outline: none;
    transition: border-color 0.2s;
    width: 220px;
  }
  .search-admin:focus { border-color: #0F6E56; }
  table { width: 100%; border-collapse: collapse; }
  thead { background: #fafafa; }
  th {
    padding: 11px 16px;
    text-align: left;
    font-size: 0.72rem;
    font-weight: 600;
    color: #9ca3af;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    white-space: nowrap;
    border-bottom: 1.5px solid #f5f5f5;
  }
  td {
    padding: 13px 16px;
    font-size: 0.82rem;
    color: #374151;
    border-bottom: 1px solid #fafafa;
    vertical-align: middle;
  }
  tr:last-child td { border-bottom: none; }
  tr:hover td { background: #fdfffe; }
  .pill {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.7rem;
    font-weight: 600;
    white-space: nowrap;
  }
  .pill-terlambat  { background: #FCEBEB; color: #A32D2D; }
  .pill-dipinjam   { background: #FAEEDA; color: #854F0B; }
  .pill-dikembalikan { background: #e8f5f0; color: #0F6E56; }
  .btn-kembalikan {
    font-family: 'DM Sans', sans-serif;
    padding: 5px 12px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    background: transparent;
    font-size: 0.75rem;
    color: #374151;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
  }
  .btn-kembalikan:hover {
    background: #e8f5f0;
    border-color: #0F6E56;
    color: #0F6E56;
  }
  .avatar {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: #e8f5f0;
    color: #0F6E56;
    font-size: 0.72rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }
  .denda-val { font-weight: 600; color: #A32D2D; }
  .empty-state { text-align: center; padding: 60px 20px; }
  .empty-icon {
    width: 56px; height: 56px;
    background: #f3f4f6;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
  }
</style>


<div class="page-header flex items-start justify-between flex-wrap gap-3">
  <div>
    <h1 class="text-xl font-semibold" style="color: #1a1a1a;">Data Peminjaman</h1>
    <p class="text-sm mt-0.5" style="color: #9ca3af;">Kelola semua transaksi peminjaman buku</p>
  </div>

  {{-- Tombol Aksi --}}
  <div class="flex flex-col gap-2">

    {{-- Tambah Peminjaman - solid hijau --}}
    <a href="{{ route('admin.peminjaman.create') }}" class="btn-primary">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Tambah Peminjaman
    </a>

    {{-- Lihat Rekap Denda - outline hijau --}}
    <a href="{{ route('admin.denda.index') }}" class="btn-primary"
       style="background: #fff; color: #0F6E56; border: 1.5px solid #0F6E56;">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2
             m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1
             c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      Lihat Rekap Denda
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
<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
  <div class="stat-card">
    <p class="stat-label">Total Peminjaman</p>
    <p class="stat-val" style="color: #1a1a1a;">{{ $peminjaman->total() }}</p>
  </div>
  <div class="stat-card">
    <p class="stat-label">Sedang Dipinjam</p>
    <p class="stat-val" style="color: #854F0B;">
      {{ App\Models\Peminjaman::where('status','dipinjam')->count() }}
    </p>
  </div>
  <div class="stat-card">
    <p class="stat-label">Terlambat</p>
    <p class="stat-val" style="color: #A32D2D;">
      {{ App\Models\Peminjaman::where('status','terlambat')->count() }}
    </p>
  </div>
  <div class="stat-card">
    <p class="stat-label">Dikembalikan</p>
    <p class="stat-val" style="color: #0F6E56;">
      {{ App\Models\Peminjaman::where('status','dikembalikan')->count() }}
    </p>
  </div>
</div>

{{-- ══ FILTER STATUS ══ --}}
<div class="flex items-center gap-2 mb-4 flex-wrap">
  @foreach(['' => 'Semua', 'dipinjam' => 'Dipinjam', 'terlambat' => 'Terlambat', 'dikembalikan' => 'Dikembalikan'] as $val => $label)
    <a href="{{ route('admin.peminjaman.index', $val ? ['status' => $val] : []) }}"
       class="px-4 py-1.5 rounded-full text-xs font-medium border transition
              {{ request('status', '') === $val
                 ? 'bg-teal-700 text-white border-teal-700'
                 : 'bg-white text-gray-500 border-gray-200 hover:border-teal-500 hover:text-teal-600' }}">
      {{ $label }}
    </a>
  @endforeach
</div>

{{-- ══ TABEL ══ --}}
<div class="table-wrap">
  <div class="table-head">
    <h3>Daftar Peminjaman</h3>
    <form method="GET">
      @if(request('status'))
        <input type="hidden" name="status" value="{{ request('status') }}">
      @endif
      <input type="text" name="q" value="{{ request('q') }}"
             placeholder="Cari siswa atau buku..."
             class="search-admin">
    </form>
  </div>

  @if($peminjaman->isEmpty())
    <div class="empty-state">
      <div class="empty-icon">
        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
      </div>
      <p class="text-sm font-medium text-gray-500">Belum ada data peminjaman</p>
      <a href="{{ route('admin.peminjaman.create') }}"
         class="inline-block mt-3 text-sm text-teal-600 hover:text-teal-700 font-medium">
        + Tambah peminjaman pertama
      </a>
    </div>

  @else
    <div class="overflow-x-auto">
      <table>
        <thead>
          <tr>
            <th>Siswa</th>
            <th>Buku</th>
            <th>Tgl Pinjam</th>
            <th>Batas Kembali</th>
            <th>Status</th>
            <th>Denda</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($peminjaman as $p)
            <tr>
              {{-- Siswa --}}
              <td>
                <div class="flex items-center gap-2">
                  <div class="avatar">{{ strtoupper(substr($p->siswa->nama, 0, 1)) }}</div>
                  <div>
                    <p class="font-medium text-xs" style="color: #1a1a1a;">{{ $p->siswa->nama }}</p>
                    <p class="text-xs" style="color: #9ca3af;">{{ $p->siswa->kelas }}</p>
                  </div>
                </div>
              </td>

              {{-- Buku --}}
              <td>
                <p class="font-medium text-xs" style="color: #1a1a1a; max-width: 160px;"
                   title="{{ $p->book->judul }}">
                  {{ Str::limit($p->book->judul, 30) }}
                </p>
                <p class="text-xs" style="color: #9ca3af;">{{ $p->book->pengarang }}</p>
              </td>

              {{-- Tanggal Pinjam --}}
              <td class="text-xs" style="color: #6b7280; white-space: nowrap;">
                {{ $p->tanggal_pinjam->format('d M Y') }}
              </td>

              {{-- Batas Kembali --}}
              <td style="white-space: nowrap;">
                <span class="text-xs {{ $p->status === 'terlambat' ? 'font-semibold' : '' }}"
                      style="color: {{ $p->status === 'terlambat' ? '#A32D2D' : '#6b7280' }};">
                  {{ $p->tanggal_kembali_rencana->format('d M Y') }}
                </span>
                @if($p->status === 'terlambat')
                  <p class="text-xs" style="color: #A32D2D;">{{ $p->hari_terlambat }} hari lewat</p>
                @elseif($p->status === 'dipinjam')
                  <p class="text-xs" style="color: #9ca3af;">
                    {{ $p->tanggal_kembali_rencana->diffForHumans() }}
                  </p>
                @endif
              </td>

              {{-- Status --}}
              <td>
                <span class="pill pill-{{ $p->status }}">
                  {{ ucfirst($p->status) }}
                </span>
              </td>

              {{-- Denda --}}
              <td>
                @if($p->status === 'terlambat')
                  <p class="denda-val text-xs">Rp{{ number_format($p->total_denda, 0, ',', '.') }}</p>
                  <p class="text-xs" style="color: #9ca3af;">belum lunas</p>
                @elseif($p->denda && $p->denda->total_denda > 0)
                  <p class="text-xs" style="color: {{ $p->denda->status_bayar === 'sudah' ? '#0F6E56' : '#A32D2D' }}; font-weight: 600;">
                    Rp{{ number_format($p->denda->total_denda, 0, ',', '.') }}
                  </p>
                  <p class="text-xs" style="color: #9ca3af;">
                    {{ $p->denda->status_bayar === 'sudah' ? 'lunas' : 'belum lunas' }}
                  </p>
                @else
                  <span style="color: #d1d5db; font-size: 0.75rem;">—</span>
                @endif
              </td>

              {{-- Aksi --}}
              <td>
                @if($p->status !== 'dikembalikan')
                  <form method="POST"
                        action="{{ route('admin.peminjaman.kembalikan', $p) }}"
                        onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-kembalikan">
                      Kembalikan
                    </button>
                  </form>
                @else
                  <span style="color: #d1d5db; font-size: 0.75rem;">Selesai</span>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="px-5 py-4 border-t" style="border-color: #f5f5f5;">
      {{ $peminjaman->links() }}
    </div>
  @endif
</div>

@endsection