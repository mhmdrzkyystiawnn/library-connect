<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar — LibraryConnect</title>
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

    .login-wrapper {
      flex: 1;
      display: flex;
      min-height: 100vh;
    }

    /* Left panel */
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
      position: absolute; inset: 0; opacity: 0.04;
      background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0);
      background-size: 28px 28px;
    }
    .left-circle-1 {
      position: absolute; width: 400px; height: 400px;
      border-radius: 50%; background: rgba(29,158,117,0.15);
      top: -100px; right: -100px;
    }
    .left-circle-2 {
      position: absolute; width: 300px; height: 300px;
      border-radius: 50%; background: rgba(29,158,117,0.08);
      bottom: -80px; left: -80px;
    }
    .left-brand {
      display: flex; align-items: center; gap: 12px;
      position: relative; z-index: 1;
    }
    .left-brand-icon {
      width: 42px; height: 42px; border-radius: 12px;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.15);
      display: flex; align-items: center; justify-content: center;
    }
    .left-content { position: relative; z-index: 1; }
    .left-tagline {
      font-size: 2.2rem; font-weight: 500; color: #fff;
      line-height: 1.2; margin-bottom: 16px;
    }
    .left-desc {
      font-size: 0.9rem; color: rgba(255,255,255,0.5);
      line-height: 1.7; max-width: 320px;
    }
    .left-features {
      position: relative; z-index: 1;
      display: flex; flex-direction: column; gap: 12px;
    }
    .left-feature {
      display: flex; align-items: center; gap: 10px;
      color: rgba(255,255,255,0.6); font-size: 0.82rem;
    }
    .left-feature-dot {
      width: 6px; height: 6px; border-radius: 50%;
      background: #1D9E75; flex-shrink: 0;
    }

    /* Right panel */
    .login-right {
      width: 100%; max-width: 480px; margin: 0 auto;
      display: flex; flex-direction: column; justify-content: center;
      padding: 40px 32px;
    }
    @media (min-width: 1024px) {
      .login-right { width: 480px; flex-shrink: 0; margin: 0; padding: 48px 56px; }
    }

    .form-logo {
      display: flex; align-items: center; gap: 10px;
      margin-bottom: 32px; text-decoration: none;
    }
    .form-logo-icon {
      width: 36px; height: 36px; border-radius: 10px;
      background: #0a3d2e;
      display: flex; align-items: center; justify-content: center;
    }
    .form-logo-name { font-size: 1rem; font-weight: 600; color: #1a1a1a; }
    .form-title { font-size: 1.6rem; font-weight: 600; color: #1a1a1a; margin-bottom: 6px; }
    .form-subtitle { font-size: 0.875rem; color: #9ca3af; margin-bottom: 28px; }

    .input-group { margin-bottom: 16px; }
    .input-label {
      display: block; font-size: 0.78rem; font-weight: 500;
      color: #374151; margin-bottom: 6px;
    }
    .input-field {
      font-family: 'DM Sans', sans-serif;
      width: 100%; padding: 11px 14px;
      border: 1.5px solid #e5e7eb; border-radius: 10px;
      font-size: 0.875rem; color: #1a1a1a; background: #fff;
      outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .input-field:focus {
      border-color: #0F6E56;
      box-shadow: 0 0 0 3px rgba(15,110,86,0.08);
    }
    .input-field.error { border-color: #f09595; }
    .input-error {
      font-size: 0.72rem; color: #A32D2D; margin-top: 5px;
      display: flex; align-items: center; gap: 4px;
    }

    /* Password strength */
    .pwd-strength { margin-top: 6px; }
    .pwd-bars { display: flex; gap: 4px; margin-bottom: 4px; }
    .pwd-bar {
      flex: 1; height: 3px; border-radius: 3px;
      background: #e5e7eb; transition: background 0.3s;
    }
    .pwd-bar.weak   { background: #f09595; }
    .pwd-bar.medium { background: #FAC775; }
    .pwd-bar.strong { background: #1D9E75; }
    .pwd-hint { font-size: 0.68rem; color: #9ca3af; }

    /* Password toggle wrapper */
    .pwd-wrapper { position: relative; }
    .pwd-toggle {
      position: absolute; right: 12px; top: 50%;
      transform: translateY(-50%);
      background: none; border: none; cursor: pointer;
      color: #9ca3af; padding: 2px; transition: color 0.15s;
    }
    .pwd-toggle:hover { color: #374151; }

    .btn-submit {
      font-family: 'DM Sans', sans-serif;
      width: 100%; padding: 12px;
      background: #0a3d2e; color: #fff;
      font-size: 0.9rem; font-weight: 600;
      border: none; border-radius: 12px; cursor: pointer;
      transition: all 0.2s; margin-top: 8px;
      display: flex; align-items: center;
      justify-content: center; gap: 8px;
    }
    .btn-submit:hover {
      background: #0F6E56; transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(10,61,46,0.3);
    }
    .btn-submit:active { transform: translateY(0); }

    .login-link {
      text-align: center; margin-top: 20px;
      font-size: 0.8rem; color: #9ca3af;
    }
    .login-link a {
      color: #0F6E56; font-weight: 500;
      text-decoration: none; transition: color 0.15s;
    }
    .login-link a:hover { color: #0a5a46; text-decoration: underline; }

    .back-link {
      display: inline-flex; align-items: center; gap: 6px;
      font-size: 0.78rem; color: #9ca3af; text-decoration: none;
      margin-top: 20px; transition: color 0.15s;
    }
    .back-link:hover { color: #0F6E56; }

    /* Info box */
    .info-box {
      background: #f0faf6; border: 1px solid #9FE1CB;
      border-radius: 10px; padding: 10px 14px;
      margin-bottom: 24px; font-size: 0.78rem; color: #0F6E56;
      display: flex; align-items: flex-start; gap: 8px;
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

    <div class="left-content">
      <h2 class="left-tagline">
        Bergabung &<br>
        mulai <span class="font-serif" style="font-style:italic; color: #5DCAA5;">eksplorasi</span><br>
        koleksi buku.
      </h2>
      <p class="left-desc">
        Daftarkan akun untuk meminjam buku, memantau status peminjaman, dan melihat riwayat denda secara langsung.
      </p>
    </div>

    <div class="left-features">
      <div class="left-feature">
        <div class="left-feature-dot"></div>
        Akses dashboard pribadi siswa
      </div>
      <div class="left-feature">
        <div class="left-feature-dot"></div>
        Notifikasi batas pengembalian
      </div>
      <div class="left-feature">
        <div class="left-feature-dot"></div>
        Riwayat peminjaman lengkap
      </div>
    </div>
  </div>

  {{-- ══ RIGHT PANEL ══ --}}
  <div class="login-right">

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

    <h1 class="form-title">Buat akun baru</h1>
    <p class="form-subtitle">Daftar untuk mulai menggunakan perpustakaan digital</p>

    {{-- Info box --}}
    <div class="info-box">
      <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" style="flex-shrink:0; margin-top:1px;">
        <path fill-rule="evenodd"
          d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
          clip-rule="evenodd"/>
      </svg>
      Akun baru akan terdaftar sebagai <strong>siswa</strong>. Untuk akun admin, hubungi petugas perpustakaan.
    </div>

    <form method="POST" action="{{ route('register') }}">
      @csrf

      {{-- Nama --}}
      <div class="input-group">
        <label class="input-label" for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name"
               value="{{ old('name') }}"
               placeholder="Nama sesuai kartu pelajar"
               required autofocus autocomplete="name"
               class="input-field {{ $errors->has('name') ? 'error' : '' }}">
        @if($errors->has('name'))
          <p class="input-error">
            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $errors->first('name') }}
          </p>
        @endif
      </div>

      {{-- Email --}}
      <div class="input-group">
        <label class="input-label" for="email">Alamat Email</label>
        <input type="email" id="email" name="email"
               value="{{ old('email') }}"
               placeholder="nama@siswa.sch.id"
               required autocomplete="username"
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
        <div class="pwd-wrapper">
          <input type="password" id="password" name="password"
                 placeholder="Minimal 8 karakter"
                 required autocomplete="new-password"
                 class="input-field {{ $errors->has('password') ? 'error' : '' }}"
                 style="padding-right: 44px;"
                 oninput="checkStrength(this.value)">
          <button type="button" class="pwd-toggle" onclick="togglePwd('password', this)">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                   -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>
        {{-- Strength indicator --}}
        <div class="pwd-strength" id="strengthWrapper" style="display:none;">
          <div class="pwd-bars">
            <div class="pwd-bar" id="bar1"></div>
            <div class="pwd-bar" id="bar2"></div>
            <div class="pwd-bar" id="bar3"></div>
            <div class="pwd-bar" id="bar4"></div>
          </div>
          <p class="pwd-hint" id="strengthText">Masukkan password</p>
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

      {{-- Konfirmasi Password --}}
      <div class="input-group">
        <label class="input-label" for="password_confirmation">Konfirmasi Password</label>
        <div class="pwd-wrapper">
          <input type="password" id="password_confirmation"
                 name="password_confirmation"
                 placeholder="Ulangi password"
                 required autocomplete="new-password"
                 class="input-field {{ $errors->has('password_confirmation') ? 'error' : '' }}"
                 style="padding-right: 44px;"
                 oninput="checkMatch()">
          <button type="button" class="pwd-toggle" onclick="togglePwd('password_confirmation', this)">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                   -1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>
        <p class="input-error" id="matchError" style="display:none;">
          <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
          </svg>
          Password tidak cocok
        </p>
        @if($errors->has('password_confirmation'))
          <p class="input-error">{{ $errors->first('password_confirmation') }}</p>
        @endif
      </div>

      {{-- Submit --}}
      <button type="submit" class="btn-submit">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        Buat Akun
      </button>

    </form>

    <p class="login-link">
      Sudah punya akun?
      <a href="{{ route('login') }}">Masuk di sini</a>
    </p>

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
  function togglePwd(fieldId, btn) {
    const field = document.getElementById(fieldId);
    const isHidden = field.type === 'password';
    field.type = isHidden ? 'text' : 'password';
    btn.style.opacity = isHidden ? '1' : '0.4';
  }

  // Password strength checker
  function checkStrength(val) {
    const wrapper = document.getElementById('strengthWrapper');
    const bars    = [document.getElementById('bar1'), document.getElementById('bar2'),
                     document.getElementById('bar3'), document.getElementById('bar4')];
    const text    = document.getElementById('strengthText');

    if (!val) { wrapper.style.display = 'none'; return; }
    wrapper.style.display = 'block';

    let score = 0;
    if (val.length >= 8)  score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const levels = [
      { cls: 'weak',   label: 'Terlalu pendek',  active: 1 },
      { cls: 'weak',   label: 'Lemah',            active: 2 },
      { cls: 'medium', label: 'Sedang',           active: 3 },
      { cls: 'strong', label: 'Kuat',             active: 4 },
    ];
    const lvl = levels[Math.max(0, score - 1)];

    bars.forEach((bar, i) => {
      bar.className = 'pwd-bar';
      if (i < (score || 1)) bar.classList.add(lvl.cls);
    });
    text.textContent = lvl.label;
    text.style.color = score >= 3 ? '#1D9E75' : score >= 2 ? '#BA7517' : '#A32D2D';
  }

  // Password match checker
  function checkMatch() {
    const pwd     = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    const errEl   = document.getElementById('matchError');
    const confField = document.getElementById('password_confirmation');

    if (confirm && pwd !== confirm) {
      errEl.style.display = 'flex';
      confField.style.borderColor = '#f09595';
    } else {
      errEl.style.display = 'none';
      confField.style.borderColor = confirm && pwd === confirm ? '#1D9E75' : '#e5e7eb';
    }
  }
</script>
</body>
</html>