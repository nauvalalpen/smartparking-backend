<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Smart Parking') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=dm-sans:300,400,500,600,700&family=dm-mono:400,500&display=swap"
        rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-base: #F7F6F3;
            --bg-surface: #FFFFFF;
            --border: #E8E6E1;
            --text-primary: #1A1916;
            --text-secondary: #6B6860;
            --text-muted: #A09D97;
            --accent: #D97706;
            --accent-light: #FEF3C7;
            --accent-hover: #B45309;
            --sidebar-bg: #1A1916;
            --font-sans: 'DM Sans', system-ui, sans-serif;
            --font-mono: 'DM Mono', monospace;
            --shadow-lg: 0 20px 48px rgba(26, 25, 22, 0.10), 0 4px 12px rgba(26, 25, 22, 0.06);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--bg-base);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
            margin: 0;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 99px;
        }
    </style>
</head>

<body>
    <!-- Decorative background pattern -->
    <div class="guest-bg-pattern" aria-hidden="true">
        <div class="guest-bg-dot"></div>
        <div class="guest-bg-dot"></div>
        <div class="guest-bg-dot"></div>
    </div>

    <div class="guest-shell">
        <!-- Left panel — branding -->
        <div class="guest-brand-panel">
            <div class="guest-brand-inner">
                <div class="guest-logo">
                    <div class="guest-logo-mark">SP</div>
                    <div class="guest-logo-text">
                        <span class="guest-logo-name">Smart Parking</span>
                        <span class="guest-logo-sub">PNP System</span>
                    </div>
                </div>

                <div class="guest-brand-copy">
                    <h2 class="guest-headline">Kelola parkir<br>dengan cerdas.</h2>
                    <p class="guest-subline">Sistem manajemen parkir berbasis CCTV AI untuk kampus Politeknik Negeri
                        Padang.</p>
                </div>

                <div class="guest-brand-stats">
                    <div class="guest-stat">
                        <span class="guest-stat-num">24/7</span>
                        <span class="guest-stat-label">Monitoring</span>
                    </div>
                    <div class="guest-stat-divider"></div>
                    <div class="guest-stat">
                        <span class="guest-stat-num">Real-time</span>
                        <span class="guest-stat-label">Detection</span>
                    </div>
                    <div class="guest-stat-divider"></div>
                    <div class="guest-stat">
                        <span class="guest-stat-num">AI</span>
                        <span class="guest-stat-label">Powered</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right panel — form -->
        <div class="guest-form-panel">
            <div class="guest-form-inner">
                <div class="guest-form-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .guest-bg-pattern {
            position: fixed;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
            z-index: 0;
        }

        .guest-bg-dot {
            position: absolute;
            border-radius: 50%;
            opacity: 0.04;
            background: #1A1916;
        }

        .guest-bg-dot:nth-child(1) {
            width: 600px;
            height: 600px;
            top: -200px;
            right: -200px;
        }

        .guest-bg-dot:nth-child(2) {
            width: 400px;
            height: 400px;
            bottom: -100px;
            left: 30%;
            opacity: 0.03;
        }

        .guest-bg-dot:nth-child(3) {
            width: 200px;
            height: 200px;
            top: 40%;
            left: -50px;
            opacity: 0.05;
        }

        .guest-shell {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* Left / Brand panel */
        .guest-brand-panel {
            background: var(--sidebar-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        .guest-brand-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 30% 40%, rgba(217, 119, 6, 0.12) 0%, transparent 65%);
            pointer-events: none;
        }

        .guest-brand-inner {
            position: relative;
            z-index: 1;
            max-width: 380px;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 48px;
        }

        .guest-logo {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .guest-logo-mark {
            width: 44px;
            height: 44px;
            background: var(--accent);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-mono);
            font-weight: 500;
            font-size: 14px;
            color: #fff;
            letter-spacing: 0.02em;
        }

        .guest-logo-text {
            display: flex;
            flex-direction: column;
        }

        .guest-logo-name {
            font-size: 17px;
            font-weight: 600;
            color: #fff;
            line-height: 1.2;
        }

        .guest-logo-sub {
            font-size: 12px;
            color: var(--sidebar-muted);
            margin-top: 1px;
        }

        .guest-headline {
            font-size: clamp(28px, 3vw, 38px);
            font-weight: 700;
            line-height: 1.15;
            color: #fff;
            margin: 0;
            letter-spacing: -0.03em;
        }

        .guest-subline {
            font-size: 14px;
            line-height: 1.7;
            color: var(--sidebar-muted);
            margin: 12px 0 0;
        }

        .guest-brand-stats {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .guest-stat {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .guest-stat-num {
            font-family: var(--font-mono);
            font-size: 13px;
            font-weight: 500;
            color: var(--accent);
        }

        .guest-stat-label {
            font-size: 11px;
            color: var(--sidebar-muted);
        }

        .guest-stat-divider {
            width: 1px;
            height: 32px;
            background: rgba(255, 255, 255, 0.08);
        }

        /* Right / Form panel */
        .guest-form-panel {
            background: var(--bg-base);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 32px;
        }

        .guest-form-inner {
            width: 100%;
            max-width: 400px;
        }

        .guest-form-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 40px 36px;
            box-shadow: var(--shadow-lg);
        }

        @media (max-width: 768px) {
            .guest-shell {
                grid-template-columns: 1fr;
            }

            .guest-brand-panel {
                display: none;
            }

            .guest-form-panel {
                padding: 24px 16px;
            }

            .guest-form-card {
                padding: 28px 24px;
            }
        }
    </style>
</body>

</html>
