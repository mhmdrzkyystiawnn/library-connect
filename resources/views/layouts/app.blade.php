<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title ?? 'LibraryConnect' }} — SMK Amaliah 1 & 2</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="icon" type="image/x-icon" href="{{ asset('logo.png') }}">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Lora:ital,wght@0,400;0,500;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    :root {
      --cream:       #F7F3EC;
      --cream-dark:  #EEE6D6;
      --ink:         #1C1A14;
      --ink-light:   #4A4538;
      --ink-muted:   #8B8070;
      --emerald:     #0D4F3C;
      --emerald-mid: #155C47;
      --emerald-lt:  #1D7A5C;
      --gold:        #B8963E;
      --gold-lt:     #D4AE5C;
      --rule:        #DDD5C4;
      --white:       #FFFFFF;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background-color: var(--cream);
      color: var(--ink);
      min-height: 100vh;
    }

    .font-display { font-family: 'Playfair Display', Georgia, serif; }
    .font-serif   { font-family: 'Lora', Georgia, serif; }

    /* ── NAVBAR ── */
    .navbar {
      background: var(--emerald);
      position: sticky;
      top: 0;
      z-index: 50;
      box-shadow: 0 2px 24px rgba(13,79,60,0.2);
    }

    .navbar-inner {
      max-width: 72rem;
      margin: 0 auto;
      padding: 0 1.5rem;
      height: 58px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .brand {
      display: flex;
      align-items: center;
      gap: 12px;
      text-decoration: none;
    }

    .brand-icon {
      width: 36px;
      height: 36px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(255,255,255,0.12);
      border: 1.5px solid rgba(212,174,92,0.35);
      flex-shrink: 0;
      transition: background 0.2s;
    }

    .brand:hover .brand-icon { background: rgba(255,255,255,0.18); }

    .brand-text-main {
      font-family: 'Playfair Display', serif;
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--cream);
      line-height: 1.1;
    }

    .brand-text-main em { font-style: italic; color: var(--gold-lt); }

    .brand-text-sub {
      font-size: 0.58rem;
      color: rgba(255,255,255,0.3);
      letter-spacing: 0.1em;
      text-transform: uppercase;
    }

    .nav-desktop {
      display: none;
      align-items: center;
      gap: 2px;
    }

    @media (min-width: 768px) { .nav-desktop { display: flex; } }

    .nav-link {
      font-size: 0.8rem;
      font-weight: 500;
      color: rgba(247,243,236,0.65);
      padding: 7px 14px;
      border-radius: 10px;
      text-decoration: none;
      transition: all 0.18s;
    }

    .nav-link:hover { color: var(--cream); background: rgba(255,255,255,0.1); }
    .nav-link.active { color: var(--cream); background: rgba(255,255,255,0.14); }

    .nav-divider { width: 1px; height: 20px; background: rgba(255,255,255,0.12); margin: 0 8px; }

    .user-badge { display: flex; align-items: center; gap: 8px; }

    .user-avatar {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: rgba(184,150,62,0.25);
      border: 1.5px solid rgba(212,174,92,0.4);
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Playfair Display', serif;
      font-size: 0.68rem;
      font-weight: 700;
      color: var(--gold-lt);
      flex-shrink: 0;
    }

    .user-name {
      font-size: 0.75rem;
      color: rgba(247,243,236,0.5);
      max-width: 96px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .btn-login {
      font-size: 0.8rem;
      font-weight: 600;
      background: var(--white);
      color: var(--emerald);
      padding: 7px 18px;
      border-radius: 20px;
      border: none;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.18s;
      margin-left: 6px;
    }

    .btn-login:hover {
      background: var(--cream);
      transform: translateY(-1px);
      box-shadow: 0 4px 14px rgba(0,0,0,0.15);
    }

    .btn-logout {
      font-size: 0.78rem;
      font-weight: 500;
      background: rgba(255,255,255,0.1);
      color: rgba(247,243,236,0.65);
      padding: 6px 14px;
      border-radius: 20px;
      border: 1px solid rgba(255,255,255,0.14);
      cursor: pointer;
      transition: all 0.18s;
      margin-left: 4px;
      font-family: 'DM Sans', sans-serif;
    }

    .btn-logout:hover {
      color: #ffbbbb;
      background: rgba(255,80,80,0.1);
      border-color: rgba(255,100,100,0.25);
    }

    .mobile-toggle {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 34px;
      height: 34px;
      background: rgba(255,255,255,0.08);
      border: 1px solid rgba(255,255,255,0.12);
      border-radius: 10px;
      cursor: pointer;
      color: rgba(247,243,236,0.7);
      transition: background 0.15s;
    }

    .mobile-toggle:hover { background: rgba(255,255,255,0.14); }

    @media (min-width: 768px) { .mobile-toggle { display: none; } }

    .mobile-menu {
      background: rgba(8, 52, 40, 0.98);
      border-top: 1px solid rgba(255,255,255,0.06);
      padding: 10px 1.5rem 14px;
      display: none;
    }

    .mobile-menu.open { display: block; }

    .mobile-link {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 11px 0;
      font-size: 0.85rem;
      font-weight: 500;
      color: rgba(247,243,236,0.65);
      text-decoration: none;
      border-bottom: 1px solid rgba(255,255,255,0.05);
      transition: color 0.15s;
    }

    .mobile-link:hover { color: var(--cream); }
    .mobile-link:last-child { border-bottom: none; }

    /* ── FLASH ── */
    .flash-wrap {
      max-width: 72rem;
      margin: 0 auto;
      padding: 1rem 1.5rem 0;
    }

    .flash {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      gap: 12px;
      padding: 12px 16px;
      border-radius: 14px;
      font-size: 0.84rem;
      margin-bottom: 8px;
      animation: flashSlide 0.3s cubic-bezier(0.34, 1.2, 0.64, 1);
    }

    @keyframes flashSlide {
      from { opacity: 0; transform: translateY(-10px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .flash-success { background: #EBF5F0; border: 1px solid #A8DCC4; color: var(--emerald); }
    .flash-warning { background: #FBF4E4; border: 1px solid #E8C87A; color: #7A5A10; }
    .flash-error   { background: #FBEBEB; border: 1px solid #EAB0B0; color: #8A2020; }

    .flash-inner { display: flex; align-items: center; gap: 8px; }

    .flash-close {
      background: none; border: none; cursor: pointer;
      opacity: 0.35; font-size: 1rem; line-height: 1;
      color: inherit; flex-shrink: 0; transition: opacity 0.15s;
    }

    .flash-close:hover { opacity: 0.7; }

    /* ── MAIN ── */
    main {
      max-width: 72rem;
      margin: 0 auto;
      padding: 2.5rem 1.5rem 3rem;
      animation: pageFade 0.4s ease;
    }

    @keyframes pageFade {
      from { opacity: 0; transform: translateY(8px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ── FOOTER ── */
    footer {
      border-top: 1px solid var(--rule);
      background: var(--cream-dark);
      margin-top: 4rem;
    }

    .footer-inner {
      max-width: 72rem;
      margin: 0 auto;
      padding: 2rem 1.5rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
    }

    @media (min-width: 768px) {
      .footer-inner { flex-direction: row; justify-content: space-between; }
    }

    .footer-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }

    .footer-brand-icon {
      width: 26px;
      height: 26px;
      background: var(--emerald);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .footer-brand-name {
      font-family: 'Playfair Display', serif;
      font-size: 0.95rem;
      font-weight: 600;
      color: var(--ink);
    }

    .footer-brand-name em { font-style: italic; color: var(--emerald); }

    .footer-copy { font-size: 0.72rem; color: var(--ink-muted); }

    .footer-links { display: flex; gap: 1.5rem; }

    .footer-links a {
      font-size: 0.72rem;
      font-weight: 500;
      color: var(--ink-muted);
      text-decoration: none;
      transition: color 0.15s;
    }

    .footer-links a:hover { color: var(--emerald); }

    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: var(--cream-dark); }
    ::-webkit-scrollbar-thumb { background: var(--emerald-mid); border-radius: 99px; }
  </style>
</head>
<body>

  {{-- ══ NAVBAR ══ --}}
  <nav class="navbar">
    <div class="navbar-inner">

      <a href="{{ route('books.index') }}" class="brand">
        <div class="brand-icon">
          <svg width="17" height="17" fill="none" stroke="#D4AE5C" stroke-width="1.6" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                 C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                 C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
                 C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
          </svg>
        </div>
        <div>
          <div class="brand-text-main">Library<em>Connect</em></div>
          <div class="brand-text-sub">SMK Amaliah 1 &amp; 2</div>
        </div>
      </a>

      <div class="nav-desktop">
        <a href="{{ route('books.index') }}"
           class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}">
          Koleksi Buku
        </a>
        @auth
          @if(auth()->user()->role === 'siswa')
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
              Dashboard
            </a>
          @endif
          @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
              Panel Admin
            </a>
          @endif
          <div class="nav-divider"></div>
          <div class="user-badge">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <span class="user-name">{{ auth()->user()->name }}</span>
          </div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn-logout">Keluar</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn-login">Masuk</a>
        @endauth
      </div>

      <div style="display:flex;align-items:center;gap:10px;">
        <button class="mobile-toggle" id="menuToggle" aria-label="Menu">
          <svg id="iconHamburger" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          <svg id="iconClose" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>

    <div class="mobile-menu" id="mobileMenu">
      <a href="{{ route('books.index') }}" class="mobile-link">
        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" opacity="0.5">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/>
        </svg>
        Koleksi Buku
      </a>
      @auth
        <a href="{{ route('dashboard') }}" class="mobile-link">
          <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" opacity="0.5">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
          Dashboard Saya
        </a>
        @if(auth()->user()->role === 'admin')
          <a href="{{ route('admin.dashboard') }}" class="mobile-link">
            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" opacity="0.5">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Panel Admin
          </a>
        @endif
        <form method="POST" action="{{ route('logout') }}" style="padding:8px 0 2px;">
          @csrf
          <button style="background:none;border:none;cursor:pointer;font-size:0.82rem;font-weight:500;color:rgba(255,120,120,0.75);padding:0;font-family:'DM Sans',sans-serif;">
            Keluar dari akun
          </button>
        </form>
      @else
        <a href="{{ route('login') }}" class="mobile-link" style="color:var(--gold-lt);font-weight:600;">
          Masuk ke akun
        </a>
      @endauth
    </div>
  </nav>

  {{-- ══ FLASH MESSAGES ══ --}}
  @if(session('success') || session('warning') || session('error'))
    <div class="flash-wrap">
      @if(session('success'))
        <div class="flash flash-success">
          <div class="flash-inner">
            <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20" style="flex-shrink:0;">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
          </div>
          <button class="flash-close" onclick="this.parentElement.remove()">✕</button>
        </div>
      @endif
      @if(session('warning'))
        <div class="flash flash-warning">
          <div class="flash-inner">
            <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20" style="flex-shrink:0;">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ session('warning') }}
          </div>
          <button class="flash-close" onclick="this.parentElement.remove()">✕</button>
        </div>
      @endif
      @if(session('error'))
        <div class="flash flash-error">
          <div class="flash-inner">
            <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20" style="flex-shrink:0;">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
          </div>
          <button class="flash-close" onclick="this.parentElement.remove()">✕</button>
        </div>
      @endif
    </div>
  @endif

  {{-- ══ MAIN CONTENT ══ --}}
  <main>
    @yield('content')
  </main>

  {{-- ══ FOOTER ══ --}}
  <footer>
    <div class="footer-inner">
      <a href="{{ route('books.index') }}" class="footer-brand">
        <div class="footer-brand-icon">
          <svg width="14" height="14" fill="none" stroke="white" stroke-width="1.6" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
                 C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
                 C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
                 C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
          </svg>
        </div>
        <span class="footer-brand-name">Library<em>Connect</em></span>
      </a>
      <p class="footer-copy">© {{ date('Y') }} SMK Amaliah 1 &amp; 2 · Sistem Manajemen Perpustakaan</p>
      <div class="footer-links">
        <a href="{{ route('books.index') }}">Koleksi Buku</a>
        @auth
          <a href="{{ route('dashboard') }}">Dashboard</a>
        @endauth
      </div>
    </div>
  </footer>

  <script>
    const toggle    = document.getElementById('menuToggle');
    const menu      = document.getElementById('mobileMenu');
    const iconOpen  = document.getElementById('iconHamburger');
    const iconClose = document.getElementById('iconClose');

    toggle.addEventListener('click', () => {
      const open = menu.classList.toggle('open');
      iconOpen.style.display  = open ? 'none' : '';
      iconClose.style.display = open ? ''     : 'none';
    });

    document.addEventListener('click', (e) => {
      if (!toggle.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove('open');
        iconOpen.style.display  = '';
        iconClose.style.display = 'none';
      }
    });

    setTimeout(() => {
      document.querySelectorAll('.flash').forEach(el => {
        el.style.transition = 'opacity 0.5s, transform 0.4s';
        el.style.opacity    = '0';
        el.style.transform  = 'translateY(-6px)';
        setTimeout(() => el.remove(), 500);
      });
    }, 4500);
  </script>

  @stack('scripts')
</body>
</html>