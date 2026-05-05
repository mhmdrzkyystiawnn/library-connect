{{-- resources/views/books/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Koleksi Buku')

@section('content')
<style>
  /* ── HERO ── */
  .hero {
    background: linear-gradient(135deg, #0a5040 0%, #0D4F3C 55%, #0e6048 100%);
    border-radius: 28px;
    padding: 3.5rem 2rem 4.5rem;
    text-align: center;
    position: relative;
    overflow: hidden;
    margin-bottom: 0;
  }

  /* Soft glow blobs */
  .hero::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 280px; height: 280px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(184,150,62,0.12) 0%, transparent 70%);
    pointer-events: none;
  }

  .hero::after {
    content: '';
    position: absolute;
    bottom: -80px; left: -40px;
    width: 320px; height: 320px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(29,122,92,0.25) 0%, transparent 65%);
    pointer-events: none;
  }

  .hero-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 0.7rem;
    font-weight: 500;
    letter-spacing: 0.08em;
    color: var(--gold-lt);
    background: rgba(184,150,62,0.12);
    border: 1px solid rgba(184,150,62,0.25);
    padding: 5px 14px;
    border-radius: 20px;
    margin-bottom: 1.1rem;
    position: relative;
    z-index: 2;
  }

  .hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.9rem, 5vw, 2.8rem);
    font-weight: 400;
    color: var(--cream);
    line-height: 1.18;
    margin-bottom: 0.65rem;
    position: relative;
    z-index: 2;
  }

  .hero-title em {
    font-style: italic;
    color: var(--gold-lt);
  }

  .hero-subtitle {
    font-family: 'Lora', serif;
    font-size: 0.9rem;
    font-style: italic;
    color: rgba(247,243,236,0.5);
    position: relative;
    z-index: 2;
  }

  /* ── SEARCH FLOATING ── */
  .search-float {
    max-width: 580px;
    margin: -26px auto 2.25rem;
    position: relative;
    z-index: 20;
    padding: 0 1rem;
  }

  .search-box {
    display: flex;
    align-items: center;
    gap: 0;
    background: var(--white);
    border-radius: 18px;
    box-shadow: 0 10px 40px rgba(13,79,60,0.18), 0 2px 8px rgba(0,0,0,0.06);
    padding: 6px 6px 6px 18px;
    border: 1.5px solid rgba(13,79,60,0.08);
  }

  .search-input {
    flex: 1;
    min-width: 0;
    border: none;
    outline: none;
    font-family: 'Lora', serif;
    font-size: 0.88rem;
    font-style: italic;
    color: var(--ink);
    background: transparent;
    padding: 8px 0;
  }

  .search-input::placeholder { color: var(--ink-muted); }

  .search-btn {
    font-family: 'DM Sans', sans-serif;
    font-size: 0.82rem;
    font-weight: 600;
    background: var(--emerald);
    color: var(--cream);
    padding: 10px 22px;
    border-radius: 13px;
    border: none;
    cursor: pointer;
    flex-shrink: 0;
    transition: all 0.2s;
    white-space: nowrap;
  }

  .search-btn:hover {
    background: var(--emerald-lt);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(13,79,60,0.25);
  }

  /* ── FILTER SECTION ── */
  .filter-section {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 1.75rem;
    padding-bottom: 1.25rem;
    border-bottom: 1px solid var(--rule);
  }

  .filter-left { display: flex; flex-direction: column; gap: 8px; }

  .filter-label {
    font-size: 0.65rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--ink-muted);
  }

  .chips { display: flex; flex-wrap: wrap; gap: 7px; }

  .chip {
    font-size: 0.78rem;
    font-weight: 500;
    padding: 6px 16px;
    border-radius: 20px;
    border: 1.5px solid var(--rule);
    background: var(--white);
    color: var(--ink-muted);
    text-decoration: none;
    transition: all 0.15s;
    white-space: nowrap;
    cursor: pointer;
  }

  .chip:hover {
    border-color: var(--emerald);
    color: var(--emerald);
    background: rgba(13,79,60,0.04);
  }

  .chip.active {
    background: var(--emerald);
    border-color: var(--emerald);
    color: var(--white);
    box-shadow: 0 3px 10px rgba(13,79,60,0.2);
  }

  /* Toggle */
  .toggle-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    flex-shrink: 0;
    padding-top: 22px;
  }

  .toggle-track {
    width: 40px;
    height: 22px;
    border-radius: 11px;
    background: var(--rule);
    position: relative;
    transition: background 0.2s;
    cursor: pointer;
    flex-shrink: 0;
  }

  .toggle-track:hover {
    background: rgba(13, 79, 60, 0.15);
  }

  .toggle-track.on { 
    background: var(--emerald);
  }

  .toggle-track.on:hover {
    background: var(--emerald-lt);
  }

  .toggle-knob {
    position: absolute;
    top: 3px; left: 3px;
    width: 16px; height: 16px;
    background: #fff;
    border-radius: 50%;
    transition: transform 0.2s;
    box-shadow: 0 1px 4px rgba(0,0,0,0.18);
    cursor: pointer;
  }

  .toggle-knob.on { transform: translateX(18px); }

  .toggle-label {
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--ink-muted);
    user-select: none;
    cursor: pointer;
    transition: color 0.15s;
  }

  .toggle-label:hover {
    color: var(--emerald);
  }


  /* ── RESULT INFO ── */
  .result-info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
  }

  .result-count {
    font-family: 'Lora', serif;
    font-size: 0.84rem;
    font-style: italic;
    color: var(--ink-muted);
  }

  .result-count strong { font-style: normal; color: var(--ink); }
  .result-count .hi    { color: var(--emerald); font-style: normal; }

  .reset-link {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--ink-muted);
    text-decoration: none;
    transition: color 0.15s;
    padding: 4px 10px;
    border-radius: 8px;
    background: rgba(0,0,0,0.04);
  }

  .reset-link:hover { color: #B83232; background: rgba(184,50,50,0.06); }

  /* ── SECTION DIVIDER ── */
  .section-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 1.5rem;
  }

  .section-divider-line { flex: 1; height: 1px; background: var(--rule); }

  .section-divider-label {
    font-family: 'Playfair Display', serif;
    font-size: 0.78rem;
    font-style: italic;
    color: var(--ink-muted);
    white-space: nowrap;
  }

  /* ── BOOK GRID ── */
  .book-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
  }

  @media (min-width: 480px) { .book-grid { grid-template-columns: repeat(3, 1fr); } }
  @media (min-width: 640px) { .book-grid { grid-template-columns: repeat(4, 1fr); } }
  @media (min-width: 900px) { .book-grid { grid-template-columns: repeat(5, 1fr); } }

  /* ── BOOK CARD ── */
  .book-card {
    display: block;
    text-decoration: none;
    background: var(--white);
    border: 1.5px solid var(--rule);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.22s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    animation: cardRise 0.5s ease both;
  }

  @keyframes cardRise {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .book-grid .book-card:nth-child(1)  { animation-delay: 0.03s; }
  .book-grid .book-card:nth-child(2)  { animation-delay: 0.06s; }
  .book-grid .book-card:nth-child(3)  { animation-delay: 0.09s; }
  .book-grid .book-card:nth-child(4)  { animation-delay: 0.12s; }
  .book-grid .book-card:nth-child(5)  { animation-delay: 0.15s; }
  .book-grid .book-card:nth-child(6)  { animation-delay: 0.18s; }
  .book-grid .book-card:nth-child(7)  { animation-delay: 0.21s; }
  .book-grid .book-card:nth-child(8)  { animation-delay: 0.24s; }
  .book-grid .book-card:nth-child(9)  { animation-delay: 0.27s; }
  .book-grid .book-card:nth-child(10) { animation-delay: 0.30s; }
  .book-grid .book-card:nth-child(n+11) { animation-delay: 0.33s; }

  .book-card:hover {
    border-color: rgba(13,79,60,0.3);
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(13,79,60,0.13), 0 3px 10px rgba(0,0,0,0.06);
  }

  /* Cover */
  .book-cover {
    height: 130px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
  }

  .book-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.35s;
  }

  .book-card:hover .book-cover img { transform: scale(1.07); }

  .cover-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    width: 100%;
    height: 100%;
    justify-content: center;
  }

  .cover-category-label {
    font-size: 0.58rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    text-align: center;
    padding: 0 10px;
    line-height: 1.4;
    opacity: 0.6;
  }

  /* Sold out */
  .sold-out-overlay {
    position: absolute;
    inset: 0;
    background: rgba(28,26,20,0.42);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .sold-out-label {
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--white);
    background: rgba(28,26,20,0.55);
    padding: 4px 10px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,0.2);
  }

  /* Card body */
  .book-info {
    padding: 11px 13px 13px;
  }

  .book-title {
    font-family: 'Playfair Display', serif;
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--ink);
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 4px;
  }

  .book-author {
    font-family: 'Lora', serif;
    font-size: 0.68rem;
    font-style: italic;
    color: var(--ink-muted);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin-bottom: 9px;
  }

  .book-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .badge {
    font-size: 0.62rem;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 10px;
  }

  .badge-ada {
    background: rgba(13,79,60,0.08);
    color: var(--emerald);
  }

  .badge-habis {
    background: rgba(184,150,62,0.1);
    color: #8A6A10;
  }

  .stok-count {
    font-size: 0.62rem;
    color: var(--ink-muted);
    opacity: 0.75;
  }

  /* ── EMPTY STATE ── */
  .empty-state {
    text-align: center;
    padding: 5rem 2rem;
  }

  .empty-icon {
    width: 60px; height: 60px;
    background: var(--cream-dark);
    border: 1.5px solid var(--rule);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
  }

  .empty-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.25rem;
    font-weight: 400;
    color: var(--ink-light);
    margin-bottom: 0.5rem;
  }

  .empty-text {
    font-family: 'Lora', serif;
    font-size: 0.85rem;
    font-style: italic;
    color: var(--ink-muted);
    margin-bottom: 1.5rem;
  }

  .empty-link {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--white);
    background: var(--emerald);
    padding: 9px 22px;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.18s;
    display: inline-block;
  }

  .empty-link:hover {
    background: var(--emerald-lt);
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(13,79,60,0.25);
  }

  /* ── PAGINATION ── */
  .pagination-wrap {
    margin-top: 2.5rem;
    display: flex;
    justify-content: center;
  }

  nav[aria-label="Pagination"] {
    display: flex;
    align-items: center;
    gap: 5px;
    flex-wrap: wrap;
    justify-content: center;
  }

  nav[aria-label="Pagination"] span,
  nav[aria-label="Pagination"] a {
    font-size: 0.78rem;
    font-weight: 500;
    padding: 7px 13px;
    border-radius: 10px;
    border: 1.5px solid var(--rule);
    color: var(--ink-muted);
    background: var(--white);
    text-decoration: none;
    transition: all 0.15s;
    display: inline-flex;
    align-items: center;
    gap: 3px;
  }

  nav[aria-label="Pagination"] a:hover {
    background: rgba(13,79,60,0.06);
    border-color: var(--emerald);
    color: var(--emerald);
  }

  nav[aria-label="Pagination"] span[aria-current="page"] {
    background: var(--emerald);
    border-color: var(--emerald);
    color: var(--white);
    box-shadow: 0 3px 10px rgba(13,79,60,0.22);
  }

  nav[aria-label="Pagination"] svg { width: 13px; height: 13px; }
</style>

{{-- ── HERO ── --}}
<div class="hero">
  <div class="hero-eyebrow">
    <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20">
      <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
    </svg>
    {{ number_format(\App\Models\Book::count()) }} koleksi tersimpan
  </div>

  <h1 class="hero-title">
    Temukan Buku <em>Favoritmu</em>
  </h1>

  <p class="hero-subtitle">
    Perpustakaan SMK Amaliah 1 &amp; 2 — tempat setiap cerita menanti pembacanya
  </p>
</div>

{{-- ── SEARCH FLOATING ── --}}
<div class="search-float">
  <form method="GET" action="{{ route('books.index') }}" id="searchForm">
    <div class="search-box">
      <input
        type="text"
        name="q"
        id="searchInput"
        value="{{ request('q') }}"
        placeholder="Cari judul, pengarang, atau ISBN…"
        autocomplete="off"
        class="search-input"
      >
      @if(request('tersedia'))
        <input type="hidden" name="tersedia" value="1">
      @endif
      @if(request('kategori'))
        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
      @endif
      <button type="submit" class="search-btn">Telusuri</button>
    </div>
  </form>
</div>

{{-- ── FILTER BAR ── --}}
<div class="filter-section">
  <div class="filter-left">
    <span class="filter-label">Kategori</span>
    <div class="chips">
      <a href="{{ route('books.index', array_merge(request()->except(['kategori', 'page']), [])) }}"
         class="chip {{ !request('kategori') ? 'active' : '' }}">Semua</a>
      @foreach($kategori as $kat)
        <a href="{{ route('books.index', array_merge(request()->except('page'), ['kategori' => $kat])) }}"
           class="chip {{ request('kategori') === $kat ? 'active' : '' }}">{{ $kat }}</a>
      @endforeach
    </div>
  </div>

  {{-- <label class="toggle-wrapper">
    <input type="checkbox" id="tersediaToggle" style="display:none;" {{ request('tersedia') ? 'checked' : '' }}>
    <div class="toggle-track {{ request('tersedia') ? 'on' : '' }}" id="toggleTrack">
      <div class="toggle-knob {{ request('tersedia') ? 'on' : '' }}" id="toggleKnob"></div>
    </div>
    <span class="toggle-label" id="toggleLabel">Tersedia saja</span>
  </label> --}}
</div>

{{-- Result info --}}
@if(request('q') || request('kategori'))
  <div class="result-info">
    <p class="result-count">
      <strong>{{ $books->total() }}</strong> buku ditemukan
      @if(request('q'))
        untuk &ldquo;<span class="hi">{{ request('q') }}</span>&rdquo;
      @endif
      @if(request('kategori'))
        · <span class="hi">{{ request('kategori') }}</span>
      @endif
    </p>
    <a href="{{ route('books.index') }}" class="reset-link">
      <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
      </svg>
      Reset
    </a>
  </div>
@endif

{{-- Section label --}}
<div class="section-divider">
  <div class="section-divider-line"></div>
  <span class="section-divider-label">Koleksi Buku</span>
  <div class="section-divider-line"></div>
</div>

{{-- ── GRID ── --}}
@if($books->isEmpty())
  <div class="empty-state">
    <div class="empty-icon">
      <svg width="24" height="24" fill="none" stroke="#8B8070" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
      </svg>
    </div>
    <h2 class="empty-title">Tiada hasil ditemukan</h2>
    <p class="empty-text">Coba kata kunci yang berbeda, atau jelajahi semua koleksi kami.</p>
    <a href="{{ route('books.index') }}" class="empty-link">Lihat semua buku</a>
  </div>

@else
  @php
    $palettes = [
      ['from' => '#E5F4EC', 'to' => '#C4E8D4', 'icon' => '#1D6B44'],
      ['from' => '#E6EEF8', 'to' => '#C2D5F0', 'icon' => '#2A4880'],
      ['from' => '#F6F0E0', 'to' => '#EAD89A', 'icon' => '#9A7A2A'],
      ['from' => '#F4E8F2', 'to' => '#E2B8D8', 'icon' => '#7A2550'],
      ['from' => '#E6F2E8', 'to' => '#C0DBC6', 'icon' => '#2A6038'],
      ['from' => '#EDEAF6', 'to' => '#CCC8EE', 'icon' => '#3E3498'],
      ['from' => '#F4EDE6', 'to' => '#E0C8B0', 'icon' => '#6A3A20'],
    ];
  @endphp

  <div class="book-grid">
    @foreach($books as $book)
      @php $p = $palettes[$loop->index % count($palettes)]; @endphp

      <a href="{{ route('books.show', $book) }}" class="book-card">
        <div class="book-cover"
             style="background: linear-gradient(155deg, {{ $p['from'] }}, {{ $p['to'] }});">
          @if($book->cover)
            <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->judul }}" loading="lazy">
          @else
            <div class="cover-placeholder">
              <svg width="30" height="30" fill="none" stroke="{{ $p['icon'] }}" stroke-width="1.5"
                   viewBox="0 0 24 24" style="opacity:0.45;">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                     C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                     C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
                     C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
              </svg>
              <span class="cover-category-label" style="color:{{ $p['icon'] }};">
                {{ $book->kategori }}
              </span>
            </div>
          @endif

          @if($book->stok_tersedia === 0)
            <div class="sold-out-overlay">
              <span class="sold-out-label">Habis</span>
            </div>
          @endif
        </div>

        <div class="book-info">
          <p class="book-title">{{ $book->judul }}</p>
          <p class="book-author">{{ $book->pengarang }}</p>
          <div class="book-footer">
            <span class="{{ $book->stok_tersedia > 0 ? 'badge badge-ada' : 'badge badge-habis' }}">
              {{ $book->stok_tersedia > 0 ? '✓ Ada' : '✗ Habis' }}
            </span>
            @if($book->stok_tersedia > 0)
              <span class="stok-count">{{ $book->stok_tersedia }} eks</span>
            @endif
          </div>
        </div>
      </a>
    @endforeach
  </div>

  <div class="pagination-wrap">
    {{ $books->links() }}
  </div>
@endif

@endsection

@push('scripts')
<script>
  const toggle  = document.getElementById('tersediaToggle');
  const track   = document.getElementById('toggleTrack');
  const knob    = document.getElementById('toggleKnob');
  const label   = document.getElementById('toggleLabel');

  function updateToggleState(isChecked) {
    const url = new URL(window.location.href);
    if (isChecked) {
      url.searchParams.set('tersedia', '1');
      track.classList.add('on');
      knob.classList.add('on');
      toggle.checked = true;
    } else {
      url.searchParams.delete('tersedia');
      track.classList.remove('on');
      knob.classList.remove('on');
      toggle.checked = false;
    }
    window.location.href = url.toString();
  }

  // Event listener pada checkbox
  toggle?.addEventListener('change', function () {
    updateToggleState(this.checked);
  });

  // Event listener pada toggle track (clickable)
  track?.addEventListener('click', function () {
    toggle.checked = !toggle.checked;
    updateToggleState(toggle.checked);
  });

  // Event listener pada toggle knob (clickable)
  knob?.addEventListener('click', function (e) {
    e.stopPropagation();
    toggle.checked = !toggle.checked;
    updateToggleState(toggle.checked);
  });

  // Event listener pada label (clickable)
  label?.addEventListener('click', function () {
    toggle.checked = !toggle.checked;
    updateToggleState(toggle.checked);
  });

  // Focus pada search input di desktop
  if (window.innerWidth >= 768) {
    document.getElementById('searchInput')?.focus();
  }
</script>
@endpush