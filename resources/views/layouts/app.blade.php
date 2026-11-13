<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Tasker' }}</title>
    <meta name="description" content="Tasks for Today Management System built with Laravel Eloquent ORM.">
    <link rel="icon" type="image/svg+xml" href="{{ preg_replace('~^https?:~', '', asset('favicon.svg')) }}">
    <link rel="alternate icon" href="{{ preg_replace('~^https?:~', '', asset('favicon.ico')) }}">
    <link rel="stylesheet" href="{{ preg_replace('~^https?:~', '', asset('assets/css/style.css')) }}">
</head>
<body class="page-{{ $activePage ?? 'welcome' }}">
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <header class="site-header" role="banner">
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
                    <li>
                        <a href="{{ route('welcome') }}"
                           class="nav-link {{ ($activePage ?? '') === 'welcome' ? 'active' : '' }}"
                           @if(($activePage ?? '') === 'welcome') aria-current="page" @endif>
                            Welcome
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tasks.index') }}"
                           class="nav-link {{ ($activePage ?? '') === 'tasks' ? 'active' : '' }}"
                           @if(($activePage ?? '') === 'tasks') aria-current="page" @endif>
                            Tasks
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.index') }}"
                           class="nav-link {{ ($activePage ?? '') === 'profile' ? 'active' : '' }}"
                           @if(($activePage ?? '') === 'profile') aria-current="page" @endif>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}"
                           class="nav-link {{ ($activePage ?? '') === 'about' ? 'active' : '' }}"
                           @if(($activePage ?? '') === 'about') aria-current="page" @endif>
                            About
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main id="main-content" class="main-content" role="main" tabindex="-1">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="site-footer" role="contentinfo">
        <div class="container footer-inner">
            <p class="footer-copy">Tasker &mdash; Tasks for Today Management System</p>
            <p class="footer-copy">Developed by Charles Lawrence Aniciete &bull; IT0049 TSA3</p>
        </div>
    </footer>
</body>
</html>
