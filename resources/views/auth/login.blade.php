<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Smart Parking') }} – Login</title>

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

        /* Login container */
        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        /* Logo branding */
        .login-branding {
            text-align: center;
            margin-bottom: 40px;
        }

        .brand-mark {
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
            box-shadow: 0 8px 24px rgba(217, 119, 6, 0.15);
        }

        .brand-name {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--text);
            margin-bottom: 4px;
        }

        .brand-tagline {
            font-size: 13px;
            color: var(--muted);
        }

        /* Login card */
        .login-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 40px 36px;
            box-shadow: 0 8px 32px rgba(26, 25, 22, 0.06);
            margin-bottom: 20px;
        }

        .login-card-header {
            margin-bottom: 32px;
        }

        .login-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            letter-spacing: -0.01em;
            margin-bottom: 6px;
        }

        .login-subtitle {
            font-size: 13px;
            color: var(--muted);
        }

        /* Alert messages */
        .alert-box {
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .alert-error {
            background: #FEF2F2;
            border: 1px solid #FECDD3;
            color: #BE123C;
        }

        .alert-error-icon {
            color: #DC2626;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Form elements */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .form-group {
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
            width: 100%;
            padding: 10px 14px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            outline: none;
            transition: border-color 150ms ease, box-shadow 150ms ease;
        }

        .form-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.1);
        }

        .form-input::placeholder {
            color: var(--faint);
        }

        .error-message {
            font-size: 12px;
            color: #DC2626;
            margin-top: 2px;
        }

        /* Checkbox group */
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }

        .checkbox-input {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1px solid var(--border);
            background: var(--surface);
            cursor: pointer;
            accent-color: var(--accent);
        }

        .checkbox-label {
            font-size: 13px;
            color: var(--muted);
            cursor: pointer;
            user-select: none;
        }

        /* Action buttons */
        .login-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        .btn-login {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-h) 100%);
            border: none;
            text-decoration: none;
            cursor: pointer;
            transition: all 150ms ease;
            width: 100%;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(217, 119, 6, 0.25);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Footer links */
        .login-footer {
            display: flex;
            flex-direction: column;
            gap: 8px;
            text-align: center;
        }

        .forgot-link {
            font-size: 12px;
            color: var(--muted);
            text-decoration: none;
            transition: color 150ms ease;
        }

        .forgot-link:hover {
            color: var(--accent);
        }

        .divider {
            font-size: 12px;
            color: var(--faint);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-wrapper {
                padding: 16px;
            }

            .login-card {
                padding: 32px 24px;
                border-radius: 14px;
            }

            .login-branding {
                margin-bottom: 32px;
            }

            .brand-mark {
                width: 40px;
                height: 40px;
                font-size: 12px;
            }

            .brand-name {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        {{-- Branding --}}
        <div class="login-branding">
            <div class="brand-mark">PNP</div>
            <div class="brand-name">SmartParking and Traffic Flow</div>
            <div class="brand-tagline">Manajemen Parkir Cerdas</div>
        </div>

        {{-- Login card --}}
        <div class="login-card">
            <div class="login-card-header">
                <h1 class="login-title">Masuk Akun Anda</h1>
                <p class="login-subtitle">Akses dashboard sistem parkir kampus</p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="alert-box" style="background: #F0FDF4; border-color: #BBF7D0; color: #15803D;">
                    <div style="color: #16A34A;">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            {{-- Login form --}}
            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input id="email" type="email" name="email" class="form-input" value="{{ old('email') }}"
                        placeholder="nama@kampus.ac.id" required autofocus autocomplete="username" />
                    @if ($errors->has('email'))
                        <div class="alert-box alert-error">
                            <div class="alert-error-icon">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                @foreach ($errors->get('email') as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input id="password" type="password" name="password" class="form-input" placeholder="••••••••"
                        required autocomplete="current-password" />
                    @if ($errors->has('password'))
                        <div class="alert-box alert-error">
                            <div class="alert-error-icon">
                                <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                @foreach ($errors->get('password') as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Remember me --}}
                <div class="checkbox-group">
                    <input id="remember_me" type="checkbox" class="checkbox-input" name="remember">
                    <label for="remember_me" class="checkbox-label">Ingat saya di perangkat ini</label>
                </div>

                {{-- Submit --}}
                <div class="login-actions">
                    <button type="submit" class="btn-login">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Masuk Sekarang
                    </button>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Lupa kata sandi?
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Footer info --}}
        <div class="login-footer">
            <p style="font-size: 12px; color: var(--faint);">
                <strong style="color: var(--text); font-weight: 600;">Smart Parking v1.0</strong> – Platform Manajemen
                Parkir Kampus
            </p>
        </div>
    </div>
</body>

</html>
