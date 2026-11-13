<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $protocolRelative = static fn (string $path): string => preg_replace('~^https?:~', '', asset($path));
        $navItems = [
            ['key' => 'welcome', 'label' => 'Welcome', 'route' => route('welcome')],
            ['key' => 'tasks', 'label' => 'Tasks', 'route' => route('tasks.index')],
            ['key' => 'profile', 'label' => 'Profile', 'route' => route('profile.index')],
            ['key' => 'about', 'label' => 'About', 'route' => route('about')],
        ];
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Tasker' }}</title>
    <meta name="description" content="Tasks for Today Management System built with Laravel Eloquent ORM.">
    <link rel="icon" type="image/svg+xml" href="{{ $protocolRelative('favicon.svg') }}">
    <link rel="alternate icon" href="{{ $protocolRelative('favicon.ico') }}">
    <link rel="stylesheet" href="{{ $protocolRelative('assets/css/style.css') }}">
</head>
<body class="page-{{ $activePage ?? 'welcome' }}">
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <header class="site-header">
        <div class="container header-inner">
            <a href="{{ route('welcome') }}" class="brand-link" aria-label="Tasker Home">
                <span class="brand-mark" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M3.5 8.5L6.5 11.5L12.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span>Tasker</span>
            </a>

            <nav class="site-nav" aria-label="Main navigation">
                <ul class="nav-list">
                    @foreach ($navItems as $item)
                        @php $isCurrent = ($activePage ?? '') === $item['key']; @endphp
                        <li>
                            <a href="{{ $item['route'] }}"
                               class="nav-link {{ $isCurrent ? 'active' : '' }}"
                               @if($isCurrent) aria-current="page" @endif>
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </header>

    <main id="main-content" class="main-content" tabindex="-1">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="site-footer">
        <div class="container footer-inner">
            <p class="footer-copy">Tasker &mdash; Tasks for Today Management System</p>
            <p class="footer-copy">Developed by Charles Lawrence Aniciete &bull; IT0049 TSA3</p>
        </div>
    </footer>
</body>
</html>
