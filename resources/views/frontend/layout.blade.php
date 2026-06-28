<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Tiketin'))</title>
    <link rel="icon" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0d0d1a;
            --bg2: #13132a;
            --bg3: #1a1a35;
            --panel: #16162e;
            --panel2: #1e1e38;
            --ink: #ffffff;
            --ink2: #c8c8e8;
            --muted: #8888aa;
            --line: rgba(255,255,255,.08);
            --line2: rgba(255,255,255,.12);
            --primary: #7c3aed;
            --primary-light: #a78bfa;
            --primary-glow: rgba(124,58,237,.35);
            --accent: #7c3aed;
            --accent2: #6d28d9;
            --danger: #ef4444;
            --success: #10b981;
            --radius: 10px;
            --radius-lg: 16px;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; color: var(--ink); background: var(--bg); -webkit-font-smoothing: antialiased; }
        a { color: inherit; text-decoration: none; }
        img { display: block; max-width: 100%; }
        .shell { width: min(1200px, calc(100% - 40px)); margin: 0 auto; }

        /* ── TOPBAR ── */
        .topbar {
            position: sticky; top: 0; z-index: 100;
            background: rgba(13,13,26,.92);
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .topbar-inner {
            height: 64px;
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
        }
        .brand {
            display: flex; align-items: center; gap: 8px;
            font-weight: 800; font-size: 18px; letter-spacing: -.01em; white-space: nowrap;
        }
        .brand-icon {
            width: 32px; height: 32px;
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            border-radius: 8px;
            display: grid; place-items: center;
            font-size: 16px;
        }
        .topnav {
            display: flex; align-items: center; gap: 2px;
            font-size: 13.5px; font-weight: 500;
            flex: 1; justify-content: center;
        }
        .topnav a {
            padding: 6px 12px; border-radius: 6px;
            color: var(--ink2);
            transition: color .15s, background .15s;
        }
        .topnav a:hover, .topnav a.active { color: #fff; }
        .topnav a.active { font-weight: 700; border-bottom: 2px solid var(--primary-light); border-radius: 0; }
        .topbar-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }
        .icon-btn {
            width: 38px; height: 38px;
            border-radius: 8px; border: 1px solid var(--line2);
            background: var(--panel2);
            display: grid; place-items: center;
            cursor: pointer; color: var(--ink2);
            font-size: 16px; position: relative;
        }
        .icon-btn .badge-dot {
            position: absolute; top: 6px; right: 6px;
            width: 8px; height: 8px;
            background: var(--primary-light); border-radius: 50%;
            border: 2px solid var(--bg);
        }
        .btn-outline {
            display: inline-flex; align-items: center; gap: 6px;
            height: 36px; padding: 0 16px;
            border-radius: 8px; border: 1px solid var(--line2);
            background: transparent; color: var(--ink);
            font-size: 13px; font-weight: 700; cursor: pointer;
            white-space: nowrap;
        }
        .btn-primary-nav {
            display: inline-flex; align-items: center; gap: 6px;
            height: 36px; padding: 0 18px;
            border-radius: 8px; border: none;
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
            color: #fff; font-size: 13px; font-weight: 700; cursor: pointer;
            white-space: nowrap;
            box-shadow: 0 0 18px rgba(124,58,237,.4);
        }
        .btn-primary-nav:hover { background: linear-gradient(135deg, #6d28d9, #5b21b6); }

        /* ── COMMON ── */
        .section { padding: 64px 0; }
        .section-sm { padding: 40px 0; }
        h1 { margin: 0; font-size: clamp(32px, 5vw, 56px); line-height: 1.08; letter-spacing: -.03em; font-weight: 900; }
        h2 { margin: 0; font-size: clamp(22px, 3vw, 32px); font-weight: 800; letter-spacing: -.02em; }
        h3 { margin: 0; font-size: 16px; font-weight: 700; letter-spacing: -.01em; }
        p { color: var(--muted); line-height: 1.65; margin: 0; }
        .eyebrow {
            display: inline-block; font-size: 12px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .1em;
            color: var(--primary-light); margin-bottom: 10px;
        }
        .sec-head { text-align: left; margin-bottom: 32px; }
        .sec-head p { margin-top: 6px; font-size: 14px; }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            height: 44px; padding: 0 20px; border-radius: var(--radius);
            font-weight: 700; font-size: 14px; cursor: pointer; border: none;
            transition: all .15s;
        }
        .btn-primary {
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
            color: white;
            box-shadow: 0 0 20px rgba(124,58,237,.4);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 24px rgba(124,58,237,.5); }
        .btn-ghost {
            background: rgba(255,255,255,.06); color: var(--ink);
            border: 1px solid var(--line2);
        }
        .btn-ghost:hover { background: rgba(255,255,255,.1); }

        /* ── FOOTER ── */
        .footer { background: #0a0a18; border-top: 1px solid var(--line); padding: 60px 0 32px; }
        .footer-grid { display: grid; grid-template-columns: 1.8fr repeat(4, 1fr); gap: 40px; }
        .footer-brand p { color: var(--muted); font-size: 13px; line-height: 1.7; margin: 12px 0 20px; }
        .footer-socials { display: flex; gap: 10px; margin-top: 16px; }
        .footer-social {
            width: 34px; height: 34px; border-radius: 8px;
            border: 1px solid var(--line2); background: var(--panel2);
            display: grid; place-items: center; font-size: 13px;
            color: var(--muted); transition: all .15s;
        }
        .footer-social:hover { border-color: var(--primary-light); color: var(--primary-light); }
        .footer-col h4 { font-size: 13px; font-weight: 700; color: #fff; margin: 0 0 16px; }
        .footer-col ul { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px; }
        .footer-col ul li a { font-size: 13px; color: var(--muted); transition: color .15s; }
        .footer-col ul li a:hover { color: var(--primary-light); }
        .footer-payments { margin-top: 12px; }
        .footer-payments h5 { font-size: 12px; font-weight: 700; color: #fff; margin: 0 0 10px; }
        .payment-logos { display: flex; flex-wrap: wrap; gap: 6px; }
        .pay-badge {
            background: var(--panel2); border: 1px solid var(--line2);
            border-radius: 6px; padding: 4px 8px;
            font-size: 10px; font-weight: 700; color: var(--ink2);
            letter-spacing: .03em;
        }
        .footer-bottom {
            margin-top: 48px; padding-top: 24px; border-top: 1px solid var(--line);
            display: flex; justify-content: space-between; align-items: center;
            font-size: 12px; color: var(--muted);
        }

        @media (max-width: 960px) {
            .topnav { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 28px; }
        }
        @media (max-width: 620px) {
            .shell { width: calc(100% - 24px); }
            .footer-grid { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; gap: 8px; text-align: center; }
        }
    </style>
    @stack('styles')
</head>
<body>

<header class="topbar">
    <div class="shell topbar-inner">
        <a href="{{ route('front.home') }}" class="brand">
            <span class="brand-icon">🎫</span>
            <span>{{ config('app.name', 'Tiketin') }}</span>
        </a>
        <nav class="topnav">
            <a href="{{ route('front.home') }}" class="active">Beranda</a>
            <a href="{{ route('front.home') }}?category=event">Event</a>
            <a href="{{ route('front.home') }}?category=konser">Konser</a>
            <a href="{{ route('front.home') }}?category=olahraga">Olahraga</a>
            <a href="{{ route('front.home') }}?category=atraksi">Atraksi</a>
            <a href="{{ route('front.home') }}?category=transportasi">Transportasi</a>
            <a href="#">Blog</a>
            <a href="#">Bantuan</a>
        </nav>
        <div class="topbar-right">
            <button class="icon-btn" title="Cari">🔍</button>
            <button class="icon-btn" title="Keranjang">
                🛒
                <span class="badge-dot"></span>
            </button>
            <a href="{{ route('login') }}" class="btn-primary-nav">Masuk / Daftar</a>
        </div>
    </div>
</header>

@yield('content')

<footer class="footer">
    <div class="shell">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ route('front.home') }}" class="brand" style="font-size:16px;">
                    <span class="brand-icon">🎫</span>
                    <span>{{ config('app.name', 'Tiketin') }}</span>
                </a>
                <p>Platform tiket online terpercaya untuk berbagai event, konser, olahraga, atraksi, dan transportasi di seluruh Indonesia.</p>
                <div class="footer-socials">
                    <a href="#" class="footer-social">📸</a>
                    <a href="#" class="footer-social">👤</a>
                    <a href="#" class="footer-social">✕</a>
                    <a href="#" class="footer-social">▶</a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Jelajahi</h4>
                <ul>
                    <li><a href="#">Event</a></li>
                    <li><a href="#">Konser</a></li>
                    <li><a href="#">Olahraga</a></li>
                    <li><a href="#">Atraksi</a></li>
                    <li><a href="#">Transportasi</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Bantuan</h4>
                <ul>
                    <li><a href="#">Cara Pemesanan</a></li>
                    <li><a href="#">Pembayaran</a></li>
                    <li><a href="#">Pengembalian Dana</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Hubungi Kami</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Perusahaan</h4>
                <ul>
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Karir</a></li>
                    <li><a href="#">Syarat &amp; Ketentuan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <div class="footer-payments">
                    <h5>Metode Pembayaran</h5>
                    <div class="payment-logos">
                        <span class="pay-badge">BCA</span>
                        <span class="pay-badge">Mandiri</span>
                        <span class="pay-badge">BRI</span>
                        <span class="pay-badge">BNI</span>
                        <span class="pay-badge">OVO</span>
                        <span class="pay-badge">GoPay</span>
                        <span class="pay-badge">Dana</span>
                        <span class="pay-badge">LinkAja</span>
                        <span class="pay-badge">VISA</span>
                        <span class="pay-badge">Mastercard</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <span>© 2024 Tiketin. All rights reserved.</span>
            <span>Made with ♥ in Indonesia</span>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>