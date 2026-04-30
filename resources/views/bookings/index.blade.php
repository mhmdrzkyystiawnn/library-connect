{{-- resources/views/bookings/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Daftar Booking Saya')

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

  .pill-pending   { background: #FEF3C7; color: #854F0B; }
  .pill-approved  { background: #DBEAFE; color: #0C4A6E; }
  .pill-rejected  { background: #FCEBEB; color: #A32D2D; }
  .pill-completed { background: #e8f5f0; color: #0F6E56; }

  .empty-state { text-align: center; padding: 60px 20px; }
  
  .empty-icon {
    width: 56px; height: 56px;
    background: #f3f4f6;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
  }

  .empty-icon svg { color: #9ca3af; }

  .empty-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 6px;
  }

  .empty-desc {
    font-size: 0.8rem;
    color: #9ca3af;
    margin-bottom: 16px;
  }

  .btn-empty {
    background: #0F6E56;
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    border: none;
    font-weight: 600;
    font-size: 0.8rem;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s;
  }

  .btn-empty:hover {
    background: #0a5a46;
    transform: translateY(-1px);
  }

  .alert {
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .alert-success {
    background: #e8f5f0;
    border-left: 4px solid #0F6E56;
    color: #0F6E56;
  }

  .alert-error {
    background: #FCEBEB;
    border-left: 4px solid #A32D2D;
    color: #A32D2D;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 12px;
    margin-bottom: 24px;
  }
</style>

<div class="page-header flex items-start justify-between flex-wrap gap-3">
  <div>
    <h1 class="text-xl font-semibold" style="color: #1a1a1a;">Booking Saya</h1>
    <p class="text-sm mt-0.5" style="color: #9ca3af;">Kelola pesanan buku Anda</p>
  </div>

  <a href="{{ route('bookings.create') }}" class="btn-primary">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Booking Buku
  </a>
</div>

@if (session('success'))
  <div class="alert alert-success">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    {{ session('success') }}
  </div>
@endif

@if (session('error'))
  <div class="alert alert-error">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
    </svg>
    {{ session('error') }}
  </div>
@endif

<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-label">Total Booking</div>
    <div class="stat-val">{{ $bookings->total() }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Menunggu Persetujuan</div>
    <div class="stat-val">{{ $bookings->where('status', 'pending')->count() }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Disetujui</div>
    <div class="stat-val">{{ $bookings->where('status', 'approved')->count() }}</div>
  </div>
  <div class="stat-card">
    <div class="stat-label">Selesai</div>
    <div class="stat-val">{{ $bookings->where('status', 'completed')->count() }}</div>
  </div>
</div>

@if ($bookings->count() > 0)
  <div class="table-wrap">
    <div class="table-head">
      <h3>Daftar Booking</h3>
    </div>

    <table>
      <thead>
        <tr>
          <th>Judul Buku</th>
          <th>Pengarang</th>
          <th>Tanggal Booking</th>
          <th>Durasi</th>
          <th>Status</th>
          <th>Tenggat Kembali</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($bookings as $booking)
          <tr>
            <td style="font-weight: 500;">{{ $booking->book->judul }}</td>
            <td>{{ $booking->book->pengarang }}</td>
            <td>{{ $booking->tanggal_booking->format('d M Y') }}</td>
            <td>
              @if ($booking->durasi)
                <small>{{ $booking->durasi }} hari</small>
              @else
                <small style="color: #d1d5db;">-</small>
              @endif
            </td>
            <td>
              @if ($booking->status === 'pending')
                <span class="pill pill-pending">⏳ Menunggu Persetujuan</span>
              @elseif ($booking->status === 'approved')
                <span class="pill pill-approved">✓ Disetujui</span>
              @elseif ($booking->status === 'rejected')
                <span class="pill pill-rejected">✗ Ditolak</span>
              @elseif ($booking->status === 'completed')
                <span class="pill pill-completed">✓ Selesai</span>
              @endif
            </td>
            <td>
              @if ($booking->status === 'pending')
                <small style="color: #d1d5db;">Menunggu konfirmasi</small>
              @elseif ($booking->status === 'approved' && $booking->tanggal_rencana_kembali)
                <div>
                  <small style="display: block; color: #374151; font-weight: 500;">
                    {{ $booking->tanggal_rencana_kembali->format('d M Y') }}
                  </small>
                  @if ($booking->is_terlambat)
                    <small style="color: #A32D2D;">🔴 Terlambat {{ abs($booking->sisa_hari) }} hari</small>
                  @else
                    <small style="color: #0F6E56;">Sisa {{ $booking->sisa_hari }} hari</small>
                  @endif
                </div>
              @elseif ($booking->status === 'rejected' && $booking->keterangan)
                <small style="color: #A32D2D;">{{ $booking->keterangan }}</small>
              @else
                <small style="color: #d1d5db;">-</small>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  <div class="mt-6">
    {{ $bookings->links() }}
  </div>
@else
  <div class="table-wrap">
    <div class="empty-state">
      <div class="empty-icon">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
               C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
               C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
               C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
      </div>
      <div class="empty-title">Belum ada booking</div>
      <p class="empty-desc">Mulai booking buku favorit Anda sekarang</p>
      <a href="{{ route('bookings.create') }}" class="btn-empty">Booking Buku</a>
    </div>
  </div>
@endif
@endsection
