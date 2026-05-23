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
            --bg-elevated: #FAFAF8;
            --border: #E8E6E1;
            --border-soft: #F0EDE8;
            --text-primary: #1A1916;
            --text-secondary: #6B6860;
            --text-muted: #A09D97;
            --accent: #D97706;
            --accent-light: #FEF3C7;
            --accent-hover: #B45309;
            --sidebar-bg: #1A1916;
            --sidebar-text: #C9C6BF;
            --sidebar-muted: #6B6860;
            --sidebar-active-bg: rgba(217, 119, 6, 0.15);
            --sidebar-active-text: #F59E0B;
            --sidebar-hover-bg: rgba(255, 255, 255, 0.05);
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --shadow-sm: 0 1px 3px rgba(26, 25, 22, 0.06), 0 1px 2px rgba(26, 25, 22, 0.04);
            --shadow-md: 0 4px 12px rgba(26, 25, 22, 0.08), 0 2px 4px rgba(26, 25, 22, 0.04);
            --shadow-lg: 0 12px 32px rgba(26, 25, 22, 0.12), 0 4px 8px rgba(26, 25, 22, 0.06);
            --font-sans: 'DM Sans', system-ui, sans-serif;
            --font-mono: 'DM Mono', monospace;
            --transition: 150ms cubic-bezier(0.4, 0, 0.2, 1);
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
            -moz-osx-font-smoothing: grayscale;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 99px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }
    </style>
</head>

<body>
    <div x-data="{ sidebarOpen: false }" class="layout-shell">
        @include('layouts.sidebar')

        <div class="layout-main">
            @include('layouts.header')

            <main class="layout-content">
                {{ $slot }}
            </main>
        </div>
    </div>

    <style>
        .layout-shell {
            display: flex;
            height: 100vh;
            overflow: hidden;
            background: var(--bg-base);
        }

        .layout-main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-width: 0;
        }

        .layout-content {
            flex: 1;
            overflow-y: auto;
            padding: 28px 32px;
        }

        @media (max-width: 768px) {
            .layout-content {
                padding: 20px 16px;
            }
        }
    </style>
</body>

</html>
