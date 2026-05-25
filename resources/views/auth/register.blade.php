<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Smart Parking') }} – Daftar</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:300,400,500,600,700&family=dm-mono:400,500&display=swap"
        rel="stylesheet" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        :root {
            --bg: #F7F6F3;
            --surface: #FFFFFF;
            --border: #E8E6E1;
            --text: #1A1916;
            --muted: #6B6860;
            --faint: #A09D97;
            --accent: #D97706;
            --accent-h: #B45309;
            --dark: #1A1916;
            --font: 'DM Sans', system-ui, sans-serif;
            --mono: 'DM Mono', monospace;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font);
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .reg-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .reg-branding {
            text-align: center;
            margin-bottom: 32px;
        }

        .reg-mark {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-h) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--mono);
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.04em;
            margin: 0 auto 16px;
        }

        .reg-title {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 4px 0;
        }

        .reg-sub {
            font-size: 13px;
            color: var(--muted);
            margin: 0;
        }

        /* Card */
        .reg-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 28px 26px;
            margin-bottom: 16px;
        }

        /* Form */
        .reg-form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .form-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text);
            letter-spacing: 0.02em;
        }

        .form-input {
            padding: 10px 12px;
            font-size: 13px;
            color: var(--text);
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            outline: none;
            transition: all 150ms ease;
            font-family: var(--font);
        }

        .form-input:focus {
            background: var(--surface);
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
        }

        .form-error {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            font-size: 12px;
            color: #DC2626;
            margin-top: 2px;
        }

        .form-error svg {
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* Button */
        .reg-btn {
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            outline: none;
            transition: all 150ms ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .reg-btn-primary {
            background: var(--accent);
            color: #fff;
            width: 100%;
            margin-top: 6px;
        }

        .reg-btn-primary:hover {
            background: var(--accent-h);
        }

        /* Footer */
        .reg-footer {
            text-align: center;
        }

        .reg-footer-text {
            font-size: 13px;
            color: var(--muted);
            margin: 0;
        }

        .reg-footer-link {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: color 150ms ease;
        }

        .reg-footer-link:hover {
            color: var(--accent-h);
        }
    </style>
</head>

<body>
    <div class="reg-wrapper">
        {{-- Branding --}}
        <div class="reg-branding">
            <div class="reg-mark">SP</div>
            <h1 class="reg-title">Buat Akun</h1>
            <p class="reg-sub">Daftarkan diri Anda sebagai petugas keamanan</p>
        </div>

        {{-- Register Form --}}
        <div class="reg-card">
            @if ($errors->any())
                <div
                    style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px; padding: 12px; background: #FEF2F2; border-radius: 10px; border: 1px solid #FECACA;">
                    @foreach ($errors->all() as $error)
                        <div class="form-error" style="margin-top: 0;">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="reg-form">
                @csrf

                <div class="form-field">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-input" value="{{ old('nama_lengkap') }}"
                        required autofocus autocomplete="name" placeholder="Nama lengkap Anda">
                    @error('nama_lengkap')
                        <div class="form-error"><svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01m0 0h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" value="{{ old('email') }}" required
                        autocomplete="email" placeholder="nama@example.com">
                    @error('email')
                        <div class="form-error"><svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01m0 0h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="form-label">Kata Sandi</label>
                    <input type="password" name="password" class="form-input" required autocomplete="new-password"
                        placeholder="Kata sandi kuat">
                    @error('password')
                        <div class="form-error"><svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01m0 0h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg> {{ $message }}</div>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="form-label">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" class="form-input" required
                        autocomplete="new-password" placeholder="Ulangi kata sandi">
                    @error('password_confirmation')
                        <div class="form-error"><svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01m0 0h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg> {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="reg-btn reg-btn-primary">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16H3V7H1v10a2 2 0 002 2h16V7h-2v9zm6-11h-2V3a1 1 0 10-2 0v2h-2a1 1 0 100 2h2v2a1 1 0 102 0V6h2a1 1 0 100-2z" />
                    </svg>
                    Daftar Akun
                </button>
            </form>
        </div>

        {{-- Footer --}}
        <div class="reg-footer">
            <p class="reg-footer-text">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="reg-footer-link">Masuk di sini</a>
            </p>
        </div>
    </div>
</body>

</html>
