<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Smart Parking') }}</title>

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
        }

        /* NAV */
        .nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 50;
            height: 60px;
            background: rgba(247, 246, 243, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
        }

        .nav-inner {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 28px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .nav-logo-mark {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--mono);
            font-size: 11px;
            font-weight: 500;
            color: #fff;
            letter-spacing: 0.04em;
        }

        .nav-logo-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-ghost {
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            background: transparent;
            border: 1px solid transparent;
            text-decoration: none;
            transition: all 150ms ease;
            cursor: pointer;
        }

        .btn-ghost:hover {
            background: var(--surface);
            border-color: var(--border);
            color: var(--text);
        }

        .btn-primary {
            padding: 7px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            background: var(--accent);
            border: none;
            text-decoration: none;
            transition: background 150ms ease;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--accent-h);
        }

        /* HERO */
        .hero {
            padding-top: 140px;
            padding-bottom: 100px;
            text-align: center;
        }

        .hero-inner {
            max-width: 680px;
            margin: 0 auto;
            padding: 0 28px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 99px;
            background: #FEF3C7;
            border: 1px solid #FDE68A;
            font-size: 11px;
            font-weight: 600;
            color: var(--accent-h);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 28px;
        }

        .hero-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent);
        }

        .hero-title {
            font-size: clamp(36px, 6vw, 60px);
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.04em;
            color: var(--text);
            margin-bottom: 20px;
        }

        .hero-title span {
            color: var(--accent);
        }

        .hero-sub {
            font-size: 16px;
            line-height: 1.7;
            color: var(--muted);
            max-width: 480px;
            margin: 0 auto 36px;
        }

        .hero-cta {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-lg {
            padding: 11px 26px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
        }

        .hero-note {
            margin-top: 16px;
            font-size: 12px;
            color: var(--faint);
        }

        /* STATS STRIP */
        .stats-strip {
            max-width: 1100px;
            margin: 0 auto 80px;
            padding: 0 28px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: var(--border);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .stat-cell {
            background: var(--surface);
            padding: 32px 28px;
            text-align: center;
        }

        .stat-num {
            font-family: var(--mono);
            font-size: 32px;
            font-weight: 500;
            color: var(--text);
            letter-spacing: -0.02em;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-num span {
            color: var(--accent);
        }

        .stat-label {
            font-size: 13px;
            color: var(--muted);
        }

        /* FEATURES */
        .section {
            max-width: 1100px;
            margin: 0 auto 80px;
            padding: 0 28px;
        }

        .section-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 10px;
        }

        .section-title {
            font-size: clamp(24px, 3vw, 32px);
            font-weight: 700;
            letter-spacing: -0.03em;
            color: var(--text);
            margin-bottom: 8px;
        }

        .section-sub {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.7;
            max-width: 480px;
        }

        .section-header {
            margin-bottom: 40px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .feature-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 28px 24px;
            transition: border-color 150ms ease, box-shadow 150ms ease;
        }

        .feature-card:hover {
            border-color: var(--accent);
            box-shadow: 0 4px 20px rgba(217, 119, 6, 0.08);
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #FEF3C7;
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .feature-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }

        .feature-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.65;
        }

        /* HOW IT WORKS */
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .step-card {
            padding: 24px 20px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--surface);
            position: relative;
        }

        .step-num {
            font-family: var(--mono);
            font-size: 11px;
            font-weight: 500;
            color: var(--faint);
            letter-spacing: 0.06em;
            margin-bottom: 14px;
        }

        .step-title {
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }

        .step-desc {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.6;
        }

        .step-arrow {
            position: absolute;
            right: -9px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--bg);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--faint);
            z-index: 1;
        }

        /* CTA BAND */
        .cta-band {
            max-width: 1100px;
            margin: 0 auto 80px;
            padding: 0 28px;
        }

        .cta-inner {
            background: var(--dark);
            border-radius: 16px;
            padding: 56px 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
            position: relative;
            overflow: hidden;
        }

        .cta-inner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 20% 50%, rgba(217, 119, 6, 0.15) 0%, transparent 60%);
        }

        .cta-copy {
            position: relative;
            z-index: 1;
        }

        .cta-title {
            font-size: clamp(22px, 3vw, 30px);
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.03em;
            margin-bottom: 8px;
        }

        .cta-sub {
            font-size: 14px;
            color: #9CA3AF;
        }

        .cta-action {
            position: relative;
            z-index: 1;
            flex-shrink: 0;
        }

        /* FOOTER */
        footer {
            border-top: 1px solid var(--border);
            padding: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-inner {
            max-width: 1100px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .footer-copy {
            font-size: 12px;
            color: var(--faint);
        }

        .footer-mono {
            font-family: var(--mono);
            font-size: 11px;
            color: var(--faint);
            letter-spacing: 0.04em;
        }

        @media (max-width: 768px) {
            .features-grid {
                grid-template-columns: 1fr;
            }

            .steps-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .step-arrow {
                display: none;
            }

            .cta-inner {
                flex-direction: column;
                text-align: center;
                padding: 36px 24px;
            }
        }
    </style>
</head>

<body>

    <!-- NAV -->
    <nav class="nav">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <div class="nav-logo-mark">SP</div>
                <span class="nav-logo-name">Smart Parking</span>
            </a>
            <div class="nav-actions">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-ghost">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero">
        <div class="hero-inner">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                Sistem Parkir Cerdas PNP
            </div>
            <h1 class="hero-title">
                Parkir cerdas,<br>berbasis <span>AI</span> & CCTV.
            </h1>
            <p class="hero-sub">
                Pantau ketersediaan slot parkir secara real-time menggunakan kamera CCTV dan kecerdasan buatan di
                Politeknik Negeri Padang.
            </p>
            <div class="hero-cta">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary btn-lg">Buka Dashboard →</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary btn-lg">Masuk ke Sistem →</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-ghost btn-lg">Daftar Akun</a>
                    @endif
                @endauth
            </div>
            <p class="hero-note">Sistem eksklusif untuk petugas parkir & admin kampus PNP.</p>
        </div>
    </section>

    <!-- STATS -->
    <div class="stats-strip">
        <div class="stats-grid">
            <div class="stat-cell">
                <div class="stat-num">24<span>/7</span></div>
                <div class="stat-label">Monitoring aktif non-stop</div>
            </div>
            <div class="stat-cell">
                <div class="stat-num"><span>AI</span></div>
                <div class="stat-label">Deteksi otomatis berbasis Computer Vision</div>
            </div>
            <div class="stat-cell">
                <div class="stat-num">Real<span>-time</span></div>
                <div class="stat-label">Update status slot secara langsung</div>
            </div>
        </div>
    </div>

    <!-- FEATURES -->
    <section class="section">
        <div class="section-header">
            <div class="section-eyebrow">Fitur Unggulan</div>
            <h2 class="section-title">Semua yang Anda butuhkan<br>dalam satu sistem.</h2>
            <p class="section-sub">Dari monitoring CCTV hingga laporan harian — dikelola dari satu dashboard yang bersih
                dan mudah digunakan.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="feature-title">Manajemen Kamera CCTV</div>
                <div class="feature-desc">Daftarkan dan kelola kamera CCTV dari berbagai area parkiran kampus dengan
                    mudah.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 8V4m0 0h4m-4 0l5 5m11-1V4m0 0h-4m4 0l-5 5M4 20v-4m0 4h4m-4 0l5-5m11 5v-4m0 4h-4m4 0l-5-5" />
                    </svg>
                </div>
                <div class="feature-title">Konfigurasi RoI</div>
                <div class="feature-desc">Tandai area slot parkir langsung di atas video frame menggunakan alat gambar
                    poligon interaktif.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="feature-title">Laporan & Analitik</div>
                <div class="feature-desc">Ekspor data parkiran harian, mingguan, atau bulanan lengkap dengan ringkasan
                    visual.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="feature-title">Multi Area Parkiran</div>
                <div class="feature-desc">Kelola beberapa lokasi area parkir sekaligus dengan kategorisasi yang
                    terstruktur.</div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="feature-title">Manajemen Petugas</div>
                <div class="feature-desc">Atur hak akses dan akun petugas parkir dengan kontrol role yang fleksibel.
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="2" />
                        <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="2" />
                        <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="2" />
                        <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="2" />
                    </svg>
                </div>
                <div class="feature-title">Dashboard Terpusat</div>
                <div class="feature-desc">Satu tampilan ringkasan untuk semua metrik penting parkiran secara real-time.
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="section">
        <div class="section-header">
            <div class="section-eyebrow">Cara Kerja</div>
            <h2 class="section-title">Dari kamera ke data,<br>empat langkah.</h2>
        </div>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-num">01 —</div>
                <div class="step-title">Daftarkan Kamera</div>
                <div class="step-desc">Masukkan URL RTSP kamera CCTV yang terpasang di area parkiran.</div>
                <div class="step-arrow">
                    <svg width="8" height="8" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
            <div class="step-card">
                <div class="step-num">02 —</div>
                <div class="step-title">Konfigurasi RoI</div>
                <div class="step-desc">Gambar polygon di atas frame untuk menandai setiap slot parkir.</div>
                <div class="step-arrow">
                    <svg width="8" height="8" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
            <div class="step-card">
                <div class="step-num">03 —</div>
                <div class="step-title">AI Mendeteksi</div>
                <div class="step-desc">Model AI menganalisis frame secara otomatis untuk mendeteksi ketersediaan slot.
                </div>
                <div class="step-arrow">
                    <svg width="8" height="8" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
            <div class="step-card">
                <div class="step-num">04 —</div>
                <div class="step-title">Lihat di Dashboard</div>
                <div class="step-desc">Status terkini tersedia di dashboard dan dapat diekspor sebagai laporan.</div>
            </div>
        </div>
    </section>

    <!-- CTA BAND -->
    <div class="cta-band">
        <div class="cta-inner">
            <div class="cta-copy">
                <h3 class="cta-title">Siap memulai?</h3>
                <p class="cta-sub">Masuk ke sistem dan mulai kelola parkiran kampus Anda hari ini.</p>
            </div>
            <div class="cta-action">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn-primary btn-lg">Buka Dashboard →</a>
                @else
                    <a href="{{ route('login') }}" class="btn-primary btn-lg">Masuk ke Sistem →</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <div class="footer-inner">
            <span class="footer-copy">© {{ date('Y') }} Smart Parking PNP. Hak cipta dilindungi.</span>
            <span class="footer-mono">v1.0.0</span>
        </div>
    </footer>

</body>

</html>
