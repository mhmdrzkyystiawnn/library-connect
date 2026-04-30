<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk — LibraryConnect</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DM Sans', sans-serif;
      min-height: 100vh;
      background: #f7f8f7;
      display: flex;
      flex-direction: column;
    }
    .font-serif { font-family: 'Instrument Serif', serif; }

    /* Split layout */
    .login-wrapper {
      flex: 1;
      display: flex;
      min-height: 100vh;
    }

    /* Left panel — dekorasi */
    .login-left {
      display: none;
      flex: 1;
      background: #0a3d2e;
      position: relative;
      overflow: hidden;
      padding: 48px;
      flex-direction: column;
      justify-content: space-between;
    }
    @media (min-width: 1024px) { .login-left { display: flex; } }

    .left-pattern {
      position: absolute;
      inset: 0;
      opacity: 0.04;
      background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0);
      background-size: 28px 28px;
    }
    .left-circle-1 {
      position: absolute;
      width: 400px; height: 400px;
      border-radius: 50%;
      background: rgba(29,158,117,0.15);
      top: -100px; right: -100px;
    }
    .left-circle-2 {
      position: absolute;
      width: 300px; height: 300px;
      border-radius: 50%;
      background: rgba(29,158,117,0.08);
      bottom: -80px; left: -80px;
    }
    .left-brand {
      display: flex;
      align-items: center;
      gap: 12px;
      position: relative;
      z-index: 1;
    }
    .left-brand-icon {
      width: 42px; height: 42px;
      border-radius: 12px;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.15);
      display: flex; align-items: center; justify-content: center;
    }
    .left-content {
      position: relative;
      z-index: 1;
    }
    .left-tagline {
      font-size: 2.2rem;
      font-weight: 500;
      color: #fff;
      line-height: 1.2;
      margin-bottom: 16px;
    }
    .left-desc {
      font-size: 0.9rem;
      color: rgba(255,255,255,0.5);
      line-height: 1.7;
      max-width: 320px;
    }
    .left-features {
      position: relative;
      z-index: 1;
      display: flex;
      flex-direction: column;
      gap: 12px;
    }
    .left-feature {
      display: flex;
      align-items: center;
      gap: 10px;
      color: rgba(255,255,255,0.6);
      font-size: 0.82rem;
    }
    .left-feature-dot {
      width: 6px; height: 6px;
      border-radius: 50%;
      background: #1D9E75;
      flex-shrink: 0;
    }

    /* Right panel — form */
    .login-right {
      width: 100%;
      max-width: 480px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 40px 32px;
    }
    @media (min-width: 1024px) {
      .login-right {
        width: 480px;
        flex-shrink: 0;
        margin: 0;
        padding: 48px 56px;
      }
    }

    /* Form header */
    .form-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 36px;
      text-decoration: none;
    }
    .form-logo-icon {
      width: 36px; height: 36px;
      border-radius: 10px;
      background: #0a3d2e;
      display: flex; align-items: center; justify-content: center;
    }
    .form-logo-name {
      font-size: 1rem;
      font-weight: 600;
      color: #1a1a1a;
    }
    .form-title {
      font-size: 1.6rem;
      font-weight: 600;
      color: #1a1a1a;
      margin-bottom: 6px;
      line-height: 1.2;
    }
    .form-subtitle {
      font-size: 0.875rem;
      color: #9ca3af;
      margin-bottom: 32px;
    }

    /* Input */
    .input-group { margin-bottom: 18px; }
    .input-label {
      display: block;
      font-size: 0.78rem;
      font-weight: 500;
      color: #374151;
      margin-bottom: 6px;
    }
    .input-field {
      font-family: 'DM Sans', sans-serif;
      width: 100%;
      padding: 11px 14px;
      border: 1.5px solid #e5e7eb;
      border-radius: 10px;
      font-size: 0.875rem;
      color: #1a1a1a;
      background: #fff;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .input-field:focus {
      border-color: #0F6E56;
      box-shadow: 0 0 0 3px rgba(15,110,86,0.08);
    }
    .input-field.error { border-color: #f09595; }
    .input-error {
      font-size: 0.72rem;
      color: #A32D2D;
      margin-top: 5px;
      display: flex;
      align-items: center;
      gap: 4px;
    }

    /* Remember & Forgot */
    .form-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 24px;
      flex-wrap: wrap;
      gap: 8px;
    }
    .checkbox-label {
      display: flex;
      align-items: center;
      gap: 7px;
      cursor: pointer;
      font-size: 0.8rem;
      color: #6b7280;
    }
    .checkbox-label input[type="checkbox"] {
      width: 15px; height: 15px;
      border-radius: 4px;
      accent-color: #0F6E56;
      cursor: pointer;
    }
    .forgot-link {
      font-size: 0.8rem;
      color: #0F6E56;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.15s;
    }
    .forgot-link:hover { color: #0a5a46; text-decoration: underline; }

    /* Submit button */
    .btn-submit {
      font-family: 'DM Sans', sans-serif;
      width: 100%;
      padding: 12px;
      background: #0a3d2e;
      color: #fff;
      font-size: 0.9rem;
      font-weight: 600;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      letter-spacing: 0.01em;
    }
    .btn-submit:hover {
      background: #0F6E56;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(10,61,46,0.3);
    }
    .btn-submit:active { transform: translateY(0); }

    /* Session status */
    .session-status {
      background: #e8f5f0;
      border: 1px solid #9FE1CB;
      color: #0F6E56;
      font-size: 0.82rem;
      padding: 10px 14px;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    /* Back link */
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      font-size: 0.78rem;
      color: #9ca3af;
      text-decoration: none;
      margin-top: 28px;
      transition: color 0.15s;
    }
    .back-link:hover { color: #0F6E56; }

    /* Divider hint */
    .form-hint {
      text-align: center;
      font-size: 0.75rem;
      color: #d1d5db;
      margin-top: 24px;
    }
  </style>
</head>
<body>
<div class="login-wrapper">

  {{-- ══ LEFT PANEL ══ --}}
  <div class="login-left">
    <div class="left-pattern"></div>
    <div class="left-circle-1"></div>
    <div class="left-circle-2"></div>

    {{-- Brand --}}
    <div class="left-brand">
      <div class="left-brand-icon">
        <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
               C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
               C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
               C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
      </div>
      <div>
        <div style="font-size: 1rem; font-weight: 600; color: #fff;">
          Library<span class="font-serif" style="font-style:italic;">Connect</span>
        </div>
        <div style="font-size: 10px; color: rgba(255,255,255,0.35); letter-spacing: 0.08em; text-transform: uppercase;">
          SMK Amaliah 1 &amp; 2
        </div>
      </div>
    </div>

    {{-- Tagline --}}
    <div class="left-content">
      <h2 class="left-tagline">
        Perpustakaan<br>
        <span class="font-serif" style="font-style:italic; color: #5DCAA5;">digital</span><br>
        untuk semua.
      </h2>
      <p class="left-desc">
        Cari buku, pantau peminjaman, dan kelola denda — semua dari satu tempat.
        Bisa diakses langsung dari HP kapan saja.
      </p>
    </div>

    {{-- Features --}}
    <div class="left-features">
      <div class="left-feature">
        <div class="left-feature-dot"></div>
        Pencarian buku mobile-friendly
      </div>
      <div class="left-feature">
        <div class="left-feature-dot"></div>
        Denda otomatis & realtime
      </div>
      <div class="left-feature">
        <div class="left-feature-dot"></div>
        Dashboard siswa & admin
      </div>
    </div>
  </div>

  {{-- ══ RIGHT PANEL ══ --}}
  <div class="login-right">

    {{-- Logo (mobile only) --}}
    <a href="{{ route('books.index') }}" class="form-logo">
      <div class="form-logo-icon">
        <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13
               C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13
               C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13
               C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
      </div>
      <span class="form-logo-name">
        Library<span class="font-serif" style="font-style:italic;">Connect</span>
      </span>
    </a>

    {{-- Title --}}
    <h1 class="form-title">Selamat datang</h1>
    <p class="form-subtitle">Masuk untuk mengakses perpustakaan digital</p>

    {{-- Session Status --}}
    @if (session('status'))
      <div class="session-status">{{ session('status') }}</div>
    @endif

    {{-- Form --}}
    <form method="POST" action="{{ route('login') }}">
      @csrf

      {{-- Email --}}
      <div class="input-group">
        <label class="input-label" for="email">Alamat Email</label>
        <input type="email" id="email" name="email"
               value="{{ old('email') }}"
               placeholder="nama@sekolah.sch.id"
               required autofocus autocomplete="username"
               class="input-field {{ $errors->has('email') ? 'error' : '' }}">
        @if($errors->has('email'))
          <p class="input-error">
            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $errors->first('email') }}
          </p>
        @endif
      </div>

      {{-- Password --}}
      <div class="input-group">
        <label class="input-label" for="password">Password</label>
        <div style="position: relative;">
          <input type="password" id="password" name="password"
                 placeholder="••••••••"
                 required autocomplete="current-password"
                 class="input-field {{ $errors->has('password') ? 'error' : '' }}"
                 style="padding-right: 44px;">
          {{-- Toggle show/hide password --}}
          <button type="button" id="togglePwd"
                  style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
                         background: none; border: none; cursor: pointer; color: #9ca3af; padding: 2px;">
            <svg id="eyeIcon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                   -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>
        @if($errors->has('password'))
          <p class="input-error">
            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $errors->first('password') }}
          </p>
        @endif
      </div>

      {{-- Remember & Forgot --}}
      <div class="form-row">
        <label class="checkbox-label">
          <input type="checkbox" name="remember" id="remember_me">
          Ingat saya
        </label>
        @if(Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="forgot-link">
            Lupa password?
          </a>
        @endif
      </div>

      {{-- Submit --}}
      <button type="submit" class="btn-submit">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7
               a3 3 0 013-3h7a3 3 0 013 3v1"/>
        </svg>
        Masuk ke Akun
      </button>

    </form>

    <div style="text-align: center; margin-top: 20px; font-size: 0.8rem; color: #9ca3af;">
  Belum punya akun?
  <a href="{{ route('register') }}"
     style="color: #0F6E56; font-weight: 500; text-decoration: none; transition: color 0.15s;"
     onmouseover="this.style.color='#0a5a46'; this.style.textDecoration='underline';"
     onmouseout="this.style.color='#0F6E56'; this.style.textDecoration='none';">
    Buat akun dulu
  </a>
</div>

    {{-- Hint akun --}}
    <p class="form-hint">
      Admin: admin@library.sch.id
    </p>

    {{-- Back to home --}}
    <a href="{{ route('books.index') }}" class="back-link">
      <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
      Kembali ke beranda
    </a>

  </div>
</div>

<script>
  // Toggle show/hide password
  const toggleBtn = document.getElementById('togglePwd');
  const pwdInput  = document.getElementById('password');
  const eyeIcon   = document.getElementById('eyeIcon');

  toggleBtn?.addEventListener('click', () => {
    const isHidden = pwdInput.type === 'password';
    pwdInput.type = isHidden ? 'text' : 'password';
    eyeIcon.style.opacity = isHidden ? '1' : '0.4';
  });
</script>
</body>
</html>