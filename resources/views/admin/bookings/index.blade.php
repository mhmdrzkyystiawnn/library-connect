{{-- resources/views/admin/bookings/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Manajemen Booking Buku')

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

  .pill-pending   { background: #FEF3C7; color: #854F0B; }
  .pill-approved  { background: #DBEAFE; color: #0C4A6E; }
  .pill-rejected  { background: #FCEBEB; color: #A32D2D; }
  .pill-completed { background: #e8f5f0; color: #0F6E56; }

  .action-group {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
  }

  .btn-action {
    font-family: 'DM Sans', sans-serif;
    padding: 5px 10px;
    border: 1.5px solid #e5e7eb;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.15s;
    white-space: nowrap;
  }

  .btn-approve {
    background: #e8f5f0;
    color: #0F6E56;
    border-color: #0F6E56;
  }

  .btn-approve:hover {
    background: #0F6E56;
    color: white;
  }

  .btn-reject {
    background: #FCEBEB;
    color: #A32D2D;
    border-color: #A32D2D;
  }

  .btn-reject:hover {
    background: #A32D2D;
    color: white;
  }

  .btn-complete {
    background: #DBEAFE;
    color: #0C4A6E;
    border-color: #0C4A6E;
  }

  .btn-complete:hover {
    background: #0C4A6E;
    color: white;
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
    margin-bottom: 14px;
  }

  .form-label {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 6px;
  }

  .form-input {
    width: 100%;
    padding: 10px 12px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.85rem;
    font-family: 'DM Sans', sans-serif;
  }

  .form-input:focus {
    outline: none;
    border-color: #0F6E56;
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
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
  }

  .btn-submit-reject {
    background: #A32D2D;
  }

  .btn-submit-reject:hover {
    background: #8B2424;
  }

  .nav-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1.5px solid #e5e7eb;
    background: #fff;
    color: #6b7280;
    text-decoration: none;
    transition: all 0.15s;
    white-space: nowrap;
  }

  .nav-tab:hover {
    border-color: #0F6E56;
    color: #0F6E56;
    background: #f0faf6;
  }

  .nav-tab.active {
    background: #0F6E56;
    border-color: #0F6E56;
    color: #fff;
  }
</style>

<div class="page-header flex items-start justify-between flex-wrap gap-3">
  <div>
    <h1 class="text-xl font-semibold" style="color: #1a1a1a;">Manajemen Booking Buku</h1>
    <p class="text-sm mt-0.5" style="color: #9ca3af;">Setujui atau tolak permintaan booking siswa</p>
  </div>
</div>

{{-- ══ NAV TABS ══ --}}
<div class="flex gap-2 mb-5 flex-wrap">
  <a href="{{ route('admin.dashboard') }}" class="nav-tab">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10
           a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4
           a1 1 0 001 1m-6 0h6"/>
    </svg>
    Dashboard
  </a>
  <a href="{{ route('admin.peminjaman.index') }}" class="nav-tab">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
           M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    Peminjaman
  </a>
  <a href="{{ route('admin.booking.index') }}" class="nav-tab active">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
           C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
           C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
           C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
    </svg>
    Booking Buku
  </a>
  <a href="{{ route('admin.denda.index') }}" class="nav-tab">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2
           m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1
           c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    Rekap Denda
  </a>
  <a href="{{ route('books.index') }}" class="nav-tab">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>
    Cari Buku
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
    <div class="stat-val" style="color: #854F0B;">{{ $pendingCount }}</div>
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
          <th>Siswa</th>
          <th>Judul Buku</th>
          <th>Tanggal Booking</th>
          <th>Durasi Req</th>
          <th>Status</th>
          <th>Tenggat Kembali</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($bookings as $booking)
          <tr>
            <td>
              <div style="display: flex; align-items: center; gap: 8px;">
                <div class="avatar">{{ strtoupper(substr($booking->siswa->nama, 0, 1)) }}</div>
                <div>
                  <div style="font-weight: 500;">{{ $booking->siswa->nama }}</div>
                  <div style="font-size: 0.7rem; color: #9ca3af;">{{ $booking->siswa->nis }}</div>
                </div>
              </div>
            </td>
            <td style="font-weight: 500;">{{ $booking->book->judul }}</td>
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
                <span class="pill pill-pending">⏳ Menunggu</span>
              @elseif ($booking->status === 'approved')
                <span class="pill pill-approved">✓ Disetujui</span>
              @elseif ($booking->status === 'rejected')
                <span class="pill pill-rejected">✗ Ditolak</span>
              @elseif ($booking->status === 'completed')
                <span class="pill pill-completed">✓ Selesai</span>
              @endif
            </td>
            <td>
              @if ($booking->tanggal_rencana_kembali)
                <small style="font-weight: 500;">{{ $booking->tanggal_rencana_kembali->format('d M Y') }}</small>
              @else
                <small style="color: #d1d5db;">-</small>
              @endif
            </td>
            <td>
              <div class="action-group">
                @if ($booking->status === 'pending')
                  <button class="btn-action btn-approve"
                          onclick="openApproveModal({{ $booking->id }}, '{{ addslashes($booking->siswa->nama) }}', '{{ addslashes($booking->book->judul) }}', {{ $booking->durasi ?? 7 }})">
                    Setujui
                  </button>

                  <button class="btn-action btn-reject"
                          onclick="openRejectModal({{ $booking->id }}, '{{ addslashes($booking->book->judul) }}')">
                    Tolak
                  </button>
                @elseif ($booking->status === 'approved')
                  <form action="{{ route('admin.booking.complete', $booking) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-action btn-complete">Selesai</button>
                  </form>
                @else
                  <span style="font-size: 0.75rem; color: #9ca3af;">Tidak ada aksi</span>
                @endif
              </div>
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
      <div class="empty-title">Tidak ada booking</div>
      <p style="color: #9ca3af; font-size: 0.85rem;">Tunggu siswa melakukan booking buku</p>
    </div>
  </div>
@endif

<!-- Modal Setujui Booking -->
<div id="approveModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">Setujui Booking</div>

    <form id="approveForm" method="POST" style="display: contents;">
      @csrf
      @method('PATCH')
      <div class="modal-body">
        <div class="form-group">
          <label class="form-label">Siswa</label>
          <div id="approveSiswaName" style="font-weight: 500; color: #1a1a1a;"></div>
        </div>

        <div class="form-group">
          <label class="form-label">Judul Buku</label>
          <div id="approveBookTitle" style="font-weight: 500; color: #1a1a1a;"></div>
        </div>

        <div style="margin: 14px 0; padding: 12px; background: #e8f5f0; border-left: 4px solid #0F6E56; border-radius: 6px; font-size: 0.85rem; color: #1a1a1a;">
          <strong>Info:</strong> Tentukan durasi peminjaman. Tenggat kembali akan dihitung dari hari persetujuan.
        </div>

        <div class="form-group">
          <label class="form-label">Durasi Peminjaman (hari)</label>
          <div style="display: flex; gap: 8px; margin-bottom: 10px;">
            <button type="button" class="quick-btn-approve" onclick="setApproveDurasi(this, 3)">3</button>
            <button type="button" class="quick-btn-approve" onclick="setApproveDurasi(this, 7)">7</button>
            <button type="button" class="quick-btn-approve" onclick="setApproveDurasi(this, 14)">14</button>
            <button type="button" class="quick-btn-approve" onclick="setApproveDurasi(this, 21)">21</button>
          </div>
          <input type="number" id="approveDurasiInput" name="durasi" 
                 min="1" max="30" value="7" required
                 style="width: 100%; padding: 10px 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.9rem;">
          <small style="color: #9ca3af; display: block; margin-top: 6px;">Min 1 hari, Max 30 hari</small>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn-cancel" onclick="closeApproveModal()">Batal</button>
        <button type="submit" class="btn-submit" style="background: #0F6E56;">Setujui Booking</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Tolak Booking -->
<div id="rejectModal" class="modal">
  <div class="modal-content">
    <div class="modal-header">Tolak Booking</div>

    <form id="rejectForm" method="POST" style="display: contents;">
      @csrf
      @method('PATCH')

      <div class="modal-body">
        <div class="form-group">
          <label class="form-label">Judul Buku</label>
          <div id="rejectBookTitle" style="font-weight: 500; color: #1a1a1a;"></div>
        </div>

        <div class="form-group">
          <label class="form-label">Alasan Penolakan</label>
          <textarea class="form-input" name="keterangan" required 
                    placeholder="Jelaskan alasan menolak booking ini..." rows="3"></textarea>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn-cancel" onclick="closeRejectModal()">Batal</button>
        <button type="submit" class="btn-submit btn-submit-reject">Tolak Booking</button>
      </div>
    </form>
  </div>
</div>

<style>
  .quick-btn-approve {
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

  .quick-btn-approve:hover,
  .quick-btn-approve.active {
    background: #0F6E56;
    color: white;
  }
</style>

<script>
function openApproveModal(bookingId, siswaName, bookTitle, durasiDefault = 7) {
  document.getElementById('approveSiswaName').textContent = siswaName;
  document.getElementById('approveBookTitle').textContent = bookTitle;
  document.getElementById('approveForm').action = `/admin/booking/${bookingId}/approve`;
  document.getElementById('approveDurasiInput').value = durasiDefault;
  
  document.querySelectorAll('.quick-btn-approve').forEach(b => b.classList.remove('active'));
  const defaultBtn = Array.from(document.querySelectorAll('.quick-btn-approve')).find(b => b.textContent == durasiDefault);
  if (defaultBtn) defaultBtn.classList.add('active');
  
  document.getElementById('approveModal').classList.add('show');
}

function closeApproveModal() {
  document.getElementById('approveModal').classList.remove('show');
}

function setApproveDurasi(btn, days) {
  document.getElementById('approveDurasiInput').value = days;
  document.querySelectorAll('.quick-btn-approve').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}

function openRejectModal(bookingId, bookTitle) {
  document.getElementById('rejectBookTitle').textContent = bookTitle;
  document.getElementById('rejectForm').action = `/admin/booking/${bookingId}/reject`;
  document.getElementById('rejectModal').classList.add('show');
  document.querySelector('textarea[name="keterangan"]').value = '';
}

function closeRejectModal() {
  document.getElementById('rejectModal').classList.remove('show');
}

// Close modal when clicking outside
document.getElementById('approveModal')?.addEventListener('click', function (e) {
  if (e.target === this) closeApproveModal();
});

document.getElementById('rejectModal')?.addEventListener('click', function (e) {
  if (e.target === this) closeRejectModal();
});
</script>
@endsection
