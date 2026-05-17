<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TIKETIN — @yield('title', 'Temukan Eventmu')</title>
    <meta name="description" content="Platform penjualan tiket event terpercaya di Indonesia">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #FF3D5A;
            --primary-dark: #CC1F3A;
            --primary-glow: rgba(255, 61, 90, 0.25);
            --accent: #FFB800;
            --dark: #0A0A0F;
            --dark-2: #111118;
            --dark-3: #1A1A24;
            --dark-4: #22222F;
            --text: #F0F0F8;
            --text-muted: #8888A4;
            --border: rgba(255,255,255,0.07);
            --glass: rgba(255,255,255,0.04);
            --radius: 14px;
            --font-display: 'Syne', sans-serif;
            --font-body: 'DM Sans', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-body);
            background: var(--dark);
            color: var(--text);
            min-height: 100vh;
        }

        /* ─── NAVBAR ─── */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 1000;
            padding: 0 5%;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.4s ease;
        }

        .navbar.scrolled {
            background: rgba(10, 10, 15, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
        }

        /* Logo */
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-mark {
            width: 36px;
            height: 36px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 16px;
            color: white;
            letter-spacing: -1px;
            box-shadow: 0 0 20px var(--primary-glow);
        }

        .logo-text {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 22px;
            color: var(--text);
            letter-spacing: -0.5px;
        }

        .logo-text span { color: var(--primary); }

        /* Nav Links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 36px;
            list-style: none;
        }

        .nav-links a {
            font-family: var(--font-body);
            font-size: 15px;
            font-weight: 500;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px; left: 0;
            width: 0; height: 2px;
            background: var(--primary);
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .nav-links a:hover { color: var(--text); }
        .nav-links a:hover::after { width: 100%; }
        .nav-links a.active { color: var(--text); }
        .nav-links a.active::after { width: 100%; }

        /* Nav Actions */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-ghost {
            padding: 9px 20px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: transparent;
            color: var(--text);
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-ghost:hover {
            border-color: rgba(255,255,255,0.2);
            background: var(--glass);
        }

        .btn-primary {
            padding: 9px 22px;
            border: none;
            border-radius: 10px;
            background: var(--primary);
            color: white;
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            box-shadow: 0 4px 15px var(--primary-glow);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px var(--primary-glow);
        }

        /* Hamburger */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            background: none;
            border: none;
            padding: 4px;
        }

        .hamburger span {
            display: block;
            width: 24px;
            height: 2px;
            background: var(--text);
            border-radius: 2px;
            transition: all 0.3s;
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 70px; left: 0; right: 0;
            background: rgba(10, 10, 15, 0.97);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border);
            padding: 20px 5% 30px;
            flex-direction: column;
            gap: 8px;
            z-index: 999;
        }

        .mobile-menu.open { display: flex; }

        .mobile-menu a {
            padding: 12px 16px;
            border-radius: 10px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .mobile-menu a:hover {
            background: var(--glass);
            color: var(--text);
        }

        .mobile-menu-actions {
            display: flex;
            gap: 10px;
            margin-top: 12px;
            padding-top: 16px;
            border-top: 1px solid var(--border);
        }

        .mobile-menu-actions .btn-ghost,
        .mobile-menu-actions .btn-primary {
            flex: 1;
            text-align: center;
        }

        @media (max-width: 768px) {
            .nav-links, .nav-actions { display: none; }
            .hamburger { display: flex; }
        }
    </style>

    @stack('styles')
</head>
<body>

<nav class="navbar" id="navbar">
    <a href="{{ url('/') }}" class="nav-logo">
        <div class="logo-mark">TK</div>
        <span class="logo-text">TIKET<span>IN</span></span>
    </a>

    <ul class="nav-links">
        <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
        <li><a href="{{ url('/events') }}" class="{{ request()->is('events*') ? 'active' : '' }}">Event</a></li>
        <li><a href="{{ url('/kategori') }}">Kategori</a></li>
        <li><a href="{{ url('/tentang') }}">Tentang</a></li>
    </ul>

    <div class="nav-actions">
        <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
        <a href="{{ route('register') }}" class="btn-primary">Daftar Gratis</a>
    </div>

    <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
</nav>

<div class="mobile-menu" id="mobileMenu">
    <a href="{{ url('/') }}">Beranda</a>
    <a href="{{ url('/events') }}">Event</a>
    <a href="{{ url('/kategori') }}">Kategori</a>
    <a href="{{ url('/tentang') }}">Tentang</a>
    <div class="mobile-menu-actions">
        <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
        <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
    </div>
</div>

<script>
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        navbar.classList.toggle('scrolled', window.scrollY > 20);
    });

    // Hamburger toggle
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    hamburgerBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('open');
    });
</script>