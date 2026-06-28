@extends('frontend.layout')

@section('title', 'Cari Tiket Event - ' . config('app.name', 'Tiketin'))

@push('styles')
<style>
    /* ── HERO ── */
    .hero {
        position: relative;
        min-height: 620px;
        display: flex; flex-direction: column; justify-content: center;
        overflow: hidden;
        padding: 80px 0 60px;
    }
    .hero-bg {
        position: absolute; inset: 0; z-index: 0;
    }
    .hero-bg img {
        width: 100%; height: 100%; object-fit: cover; object-position: center 30%;
        opacity: .45;
    }
    .hero-bg::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(to right,
            rgba(13,13,26,.92) 0%,
            rgba(13,13,26,.7) 50%,
            rgba(60,20,120,.3) 100%);
    }
    .hero-content { position: relative; z-index: 1; }
    .hero-inner {
        display: grid;
        grid-template-columns: minmax(0,1fr) minmax(0,1fr);
        gap: 48px; align-items: center;
    }
    .hero-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(124,58,237,.18);
        border: 1px solid rgba(124,58,237,.4);
        border-radius: 999px;
        padding: 5px 14px;
        font-size: 12px; font-weight: 700; color: #c4b5fd;
        text-transform: uppercase; letter-spacing: .08em;
        margin-bottom: 18px;
    }
    .hero h1 {
        color: #fff;
        font-size: clamp(34px, 5vw, 58px);
        line-height: 1.06; letter-spacing: -.03em; font-weight: 900;
        margin-bottom: 16px;
    }
    .hero h1 .highlight {
        color: var(--primary-light);
        position: relative;
    }
    .hero-desc {
        font-size: 15px; line-height: 1.65;
        color: rgba(200,200,220,.75);
        max-width: 480px;
        margin-bottom: 28px;
    }
    .hero-pills {
        display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
        margin-bottom: 32px;
    }
    .hero-pill {
        display: flex; align-items: center; gap: 6px;
        font-size: 13px; color: rgba(200,200,220,.8); font-weight: 500;
    }
    .hero-pill-icon {
        width: 28px; height: 28px; border-radius: 8px;
        background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1);
        display: grid; place-items: center; font-size: 13px;
    }

    /* Search bar */
    .search-bar-wrap {
        background: rgba(255,255,255,.05);
        border: 1px solid rgba(255,255,255,.1);
        border-radius: 14px; padding: 6px;
        backdrop-filter: blur(16px);
    }
    .search-tabs {
        display: flex; gap: 4px; padding: 0 4px 6px;
        border-bottom: 1px solid rgba(255,255,255,.07);
        margin-bottom: 6px;
        overflow-x: auto;
    }
    .search-tab {
        display: flex; align-items: center; gap: 5px;
        padding: 5px 12px; border-radius: 8px;
        font-size: 12px; font-weight: 600; color: var(--muted);
        cursor: pointer; white-space: nowrap;
        transition: all .15s; border: none; background: transparent;
    }
    .search-tab.active {
        background: rgba(124,58,237,.2);
        color: var(--primary-light);
        border: 1px solid rgba(124,58,237,.35);
    }
    .search-inputs {
        display: grid;
        grid-template-columns: 1fr 180px 140px 120px auto;
        gap: 6px; align-items: center;
    }
    .search-field {
        display: flex; flex-direction: column;
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 10px;
        padding: 8px 12px;
        cursor: pointer;
    }
    .search-field label {
        font-size: 10px; font-weight: 700; color: var(--muted);
        text-transform: uppercase; letter-spacing: .06em; margin-bottom: 3px;
    }
    .search-field input, .search-field select {
        background: none; border: none; padding: 0;
        color: #fff; font-size: 13px; font-weight: 500;
        font-family: inherit; outline: none; width: 100%; min-width: 0;
    }
    .search-field input::placeholder { color: rgba(255,255,255,.3); }
    .search-field select option { background: #1a1a35; }
    .btn-search {
        height: 52px; padding: 0 22px;
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        border: none; border-radius: 10px;
        color: #fff; font-size: 14px; font-weight: 800;
        cursor: pointer; white-space: nowrap;
        box-shadow: 0 0 24px rgba(124,58,237,.5);
        transition: all .15s;
    }
    .btn-search:hover { transform: translateY(-1px); box-shadow: 0 4px 28px rgba(124,58,237,.6); }

    /* Right hero stats */
    .hero-right {
        display: flex; flex-direction: column; align-items: flex-end; gap: 16px;
    }
    .hero-stat-cards {
        display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; width: 100%;
    }
    .hero-stat-card {
        background: rgba(255,255,255,.05);
        border: 1px solid rgba(255,255,255,.08);
        border-radius: 12px; padding: 16px;
        backdrop-filter: blur(12px);
    }
    .hero-stat-card .num { font-size: 22px; font-weight: 900; color: #fff; }
    .hero-stat-card .lbl { font-size: 12px; color: var(--muted); margin-top: 2px; }

    /* ── CATEGORY TABS ── */
    .cat-section { padding: 40px 0; }
    .cat-section-head {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 20px;
    }
    .link-see-all {
        font-size: 13px; font-weight: 600; color: var(--primary-light);
        display: flex; align-items: center; gap: 4px;
    }
    .link-see-all:hover { color: #fff; }
    .cat-grid {
        display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px;
    }
    .cat-card {
        background: var(--panel2);
        border: 1px solid var(--line2);
        border-radius: 14px; padding: 24px 16px;
        text-align: center; cursor: pointer;
        transition: all .2s;
    }
    .cat-card:hover {
        border-color: var(--primary);
        background: rgba(124,58,237,.1);
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(124,58,237,.2);
    }
    .cat-icon {
        width: 52px; height: 52px; border-radius: 14px;
        display: grid; place-items: center;
        font-size: 24px; margin: 0 auto 12px;
        background: rgba(124,58,237,.15);
        border: 1px solid rgba(124,58,237,.2);
    }
    .cat-card h4 { font-size: 14px; font-weight: 700; color: #fff; margin: 0 0 4px; }
    .cat-card span { font-size: 12px; color: var(--muted); }

    /* ── FEATURED EVENTS ── */
    .events-section { padding: 24px 0 56px; }
    .events-head {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 24px;
    }
    .events-scroll {
        display: grid;
        grid-template-columns: repeat(4, minmax(0,1fr));
        gap: 16px;
    }
    .ecard {
        background: var(--panel2);
        border: 1px solid var(--line2);
        border-radius: 14px; overflow: hidden;
        transition: all .2s;
        display: flex; flex-direction: column;
    }
    .ecard:hover {
        border-color: rgba(124,58,237,.4);
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(0,0,0,.4);
    }
    .ecard-img {
        aspect-ratio: 16/10; position: relative; overflow: hidden;
        background: var(--panel);
    }
    .ecard-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .3s; }
    .ecard:hover .ecard-img img { transform: scale(1.06); }
    .ecard-cat {
        position: absolute; top: 10px; left: 10px;
        padding: 3px 10px; border-radius: 999px;
        font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .06em;
        background: rgba(124,58,237,.85); color: #fff;
        backdrop-filter: blur(4px);
    }
    .ecard-fav {
        position: absolute; top: 10px; right: 10px;
        width: 30px; height: 30px; border-radius: 8px;
        background: rgba(0,0,0,.4); border: none;
        display: grid; place-items: center; cursor: pointer;
        font-size: 14px; color: #fff;
        backdrop-filter: blur(4px);
    }
    .ecard-body { padding: 14px; flex: 1; display: flex; flex-direction: column; }
    .ecard-meta {
        display: flex; gap: 10px; font-size: 11.5px; color: var(--muted);
        margin-bottom: 8px; flex-wrap: wrap;
    }
    .ecard-meta span { display: flex; align-items: center; gap: 4px; }
    .ecard-title {
        font-size: 14px; font-weight: 700; color: #fff; line-height: 1.35;
        margin-bottom: 6px;
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .ecard-loc { font-size: 12px; color: var(--muted); margin-bottom: auto; }
    .ecard-foot {
        display: flex; align-items: center; justify-content: space-between;
        margin-top: 14px; padding-top: 12px;
        border-top: 1px solid var(--line);
    }
    .price-from { font-size: 10px; color: var(--muted); margin-bottom: 1px; }
    .price-val { font-size: 15px; font-weight: 900; color: var(--primary-light); }
    .btn-card {
        height: 32px; padding: 0 12px; border-radius: 7px;
        background: rgba(124,58,237,.15);
        border: 1px solid rgba(124,58,237,.3);
        color: var(--primary-light); font-size: 12px; font-weight: 700;
        cursor: pointer; white-space: nowrap; transition: all .15s;
    }
    .btn-card:hover { background: rgba(124,58,237,.3); }

    /* ── WHY US ── */
    .why-section {
        background: var(--panel);
        border-top: 1px solid var(--line); border-bottom: 1px solid var(--line);
        padding: 64px 0;
    }
    .why-section .sec-head { text-align: center; }
    .why-grid {
        display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;
        margin-top: 40px;
    }
    .why-card { text-align: center; padding: 8px; }
    .why-icon {
        width: 60px; height: 60px; border-radius: 16px;
        background: rgba(124,58,237,.12); border: 1px solid rgba(124,58,237,.2);
        display: grid; place-items: center; font-size: 26px;
        margin: 0 auto 16px;
    }
    .why-card h4 { font-size: 15px; font-weight: 800; color: #fff; margin-bottom: 8px; }
    .why-card p { font-size: 13px; color: var(--muted); line-height: 1.6; }

    /* ── APP DOWNLOAD ── */
    .app-section {
        background: linear-gradient(135deg, #2e0b6e 0%, #4c1d95 40%, #6d28d9 100%);
        padding: 64px 0;
        position: relative; overflow: hidden;
    }
    .app-section::before {
        content: '';
        position: absolute; top: -80px; right: -80px;
        width: 400px; height: 400px; border-radius: 50%;
        background: rgba(255,255,255,.04);
        pointer-events: none;
    }
    .app-section::after {
        content: '';
        position: absolute; bottom: -60px; left: 20%;
        width: 300px; height: 300px; border-radius: 50%;
        background: rgba(255,255,255,.03);
        pointer-events: none;
    }
    .app-inner {
        display: grid; grid-template-columns: 1fr auto;
        gap: 40px; align-items: center;
        position: relative; z-index: 1;
    }
    .app-copy h2 { color: #fff; margin-bottom: 12px; }
    .app-copy p { color: rgba(255,255,255,.7); font-size: 14px; line-height: 1.7; max-width: 440px; }
    .app-btns { display: flex; gap: 12px; margin-top: 28px; flex-wrap: wrap; }
    .app-btn {
        display: flex; align-items: center; gap: 10px;
        background: rgba(0,0,0,.25); border: 1px solid rgba(255,255,255,.2);
        border-radius: 10px; padding: 10px 18px; color: #fff; cursor: pointer;
        transition: background .15s;
    }
    .app-btn:hover { background: rgba(0,0,0,.4); }
    .app-btn-icon { font-size: 22px; }
    .app-btn-text { display: flex; flex-direction: column; }
    .app-btn-text small { font-size: 10px; color: rgba(255,255,255,.6); text-transform: uppercase; letter-spacing: .05em; }
    .app-btn-text strong { font-size: 14px; font-weight: 800; }
    .app-phones {
        display: flex; gap: 16px; align-items: flex-end;
        padding-bottom: 0;
    }
    .app-phone-mock {
        width: 140px; height: 260px; border-radius: 20px;
        background: rgba(0,0,0,.3); border: 2px solid rgba(255,255,255,.15);
        display: grid; place-items: center; font-size: 40px;
        box-shadow: 0 20px 40px rgba(0,0,0,.3);
    }
    .app-phone-mock.tall { height: 300px; }

    /* ── TESTIMONIALS ── */
    .testi-section { padding: 64px 0; }
    .testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 40px; }
    .testi-card {
        background: var(--panel2); border: 1px solid var(--line2);
        border-radius: 14px; padding: 24px;
    }
    .testi-quote { font-size: 28px; color: var(--primary-light); margin-bottom: 12px; line-height: 1; }
    .testi-text { font-size: 14px; color: var(--ink2); line-height: 1.65; margin-bottom: 20px; }
    .testi-author { display: flex; align-items: center; gap: 10px; }
    .testi-avatar {
        width: 38px; height: 38px; border-radius: 50%;
        background: linear-gradient(135deg, #7c3aed, #a855f7);
        display: grid; place-items: center; font-size: 16px;
        color: #fff; font-weight: 800; flex-shrink: 0;
    }
    .testi-name { font-size: 13px; font-weight: 700; color: #fff; }
    .testi-loc { font-size: 12px; color: var(--muted); }

    /* ── NEWSLETTER ── */
    .news-section {
        background: var(--panel); border-top: 1px solid var(--line);
        padding: 48px 0;
    }
    .news-inner {
        display: flex; align-items: center; justify-content: space-between;
        gap: 32px; flex-wrap: wrap;
    }
    .news-copy h3 { font-size: 20px; color: #fff; margin-bottom: 6px; }
    .news-copy p { font-size: 13.5px; color: var(--muted); }
    .news-form { display: flex; gap: 8px; flex-shrink: 0; }
    .news-input {
        height: 44px; padding: 0 16px;
        background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.12);
        border-radius: 10px; color: #fff; font-size: 14px; font-family: inherit;
        outline: none; width: 280px;
    }
    .news-input::placeholder { color: var(--muted); }
    .news-input:focus { border-color: var(--primary); }
    .btn-subscribe {
        height: 44px; padding: 0 22px; border-radius: 10px; border: none;
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        color: #fff; font-size: 14px; font-weight: 700; cursor: pointer;
        box-shadow: 0 0 18px rgba(124,58,237,.4);
        transition: all .15s;
    }
    .btn-subscribe:hover { box-shadow: 0 4px 24px rgba(124,58,237,.6); }

    /* ── EVENT LIST SECTION ── */
    .list-section { padding: 48px 0; }
    .list-head {
        display: flex; justify-content: space-between; align-items: flex-end;
        margin-bottom: 24px; flex-wrap: wrap; gap: 12px;
    }
    .filter-chips { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px; }
    .chip {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(124,58,237,.15); color: var(--primary-light);
        border: 1px solid rgba(124,58,237,.3); border-radius: 999px;
        padding: 4px 12px; font-size: 12px; font-weight: 600;
    }
    .chip-reset {
        background: rgba(239,68,68,.1); color: #f87171; border-color: rgba(239,68,68,.3);
    }
    .badge-count {
        display: inline-flex; align-items: center;
        height: 28px; padding: 0 12px; border-radius: 999px;
        background: rgba(124,58,237,.15); border: 1px solid rgba(124,58,237,.3);
        font-size: 12px; font-weight: 700; color: var(--primary-light);
    }
    .events-grid {
        display: grid; grid-template-columns: repeat(3, minmax(0,1fr)); gap: 18px;
    }
    .empty-state {
        text-align: center; padding: 80px 24px;
        background: var(--panel2); border: 1px dashed var(--line2);
        border-radius: 16px;
    }
    .empty-icon {
        font-size: 40px; margin-bottom: 16px;
    }
    .empty-state h3 { font-size: 18px; color: #fff; margin-bottom: 8px; }
    .empty-state p { font-size: 14px; margin-bottom: 24px; }
    .pagi-wrap { margin-top: 36px; display: flex; justify-content: center; }
    .pagi-wrap .pagination { display: flex; gap: 4px; }
    .pagi-wrap .pagination li { list-style: none; }
    .pagi-wrap .pagination li a,
    .pagi-wrap .pagination li span {
        display: flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 8px;
        background: var(--panel2); border: 1px solid var(--line2);
        font-size: 13px; font-weight: 600; color: var(--muted);
        transition: all .15s;
    }
    .pagi-wrap .pagination li.active span,
    .pagi-wrap .pagination li a:hover {
        background: var(--primary); border-color: var(--primary); color: #fff;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 960px) {
        .hero-inner { grid-template-columns: 1fr; }
        .hero-right { display: none; }
        .search-inputs { grid-template-columns: 1fr 1fr auto; }
        .cat-grid { grid-template-columns: repeat(3, 1fr); }
        .why-grid { grid-template-columns: repeat(2, 1fr); }
        .events-scroll { grid-template-columns: repeat(2, 1fr); }
        .events-grid { grid-template-columns: repeat(2, 1fr); }
        .testi-grid { grid-template-columns: 1fr; }
        .app-inner { grid-template-columns: 1fr; }
        .app-phones { display: none; }
    }
    @media (max-width: 620px) {
        .hero { padding: 48px 0 40px; min-height: auto; }
        .search-inputs { grid-template-columns: 1fr; }
        .cat-grid { grid-template-columns: repeat(2, 1fr); }
        .events-scroll, .events-grid { grid-template-columns: 1fr; }
        .why-grid { grid-template-columns: 1fr; }
        .news-inner { flex-direction: column; align-items: flex-start; }
        .news-form { width: 100%; flex-direction: column; }
        .news-input { width: 100%; }
    }
</style>
@endpush

@section('content')

{{-- ── HERO ── --}}
<section class="hero">
    <div class="hero-bg">
        @if($featuredEvent && $featuredEvent->banner)
            <img src="{{ minio_url($featuredEvent->banner) }}" alt="">
        @else
            <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=1400&q=80" alt="" onerror="this.style.display='none'">
        @endif
    </div>

    <div class="shell hero-content">
        <div class="hero-inner">
            <div class="hero-left">
                <div class="hero-badge">🎫 Platform Tiket Terpercaya</div>
                <h1>Temukan momen<br>tak terlupakan,<br>dengan <span class="highlight">tiket terbaik.</span></h1>
                <p class="hero-desc">Pesan tiket konser, event, olahraga, atraksi, dan perjalanan dengan mudah, aman, dan cepat.</p>

                <div class="hero-pills">
                    <div class="hero-pill">
                        <span class="hero-pill-icon">🛡</span>
                        Tiket Resmi 100% Terjamin
                    </div>
                    <div class="hero-pill">
                        <span class="hero-pill-icon">💰</span>
                        Harga Terbaik Tanpa Biaya Tersembunyi
                    </div>
                    <div class="hero-pill">
                        <span class="hero-pill-icon">📅</span>
                        Pembayaran Aman Berbagai Metode
                    </div>
                </div>

                <div class="search-bar-wrap">
                    <div class="search-tabs">
                        <button class="search-tab active">🎵 Event</button>
                        <button class="search-tab">🎤 Konser</button>
                        <button class="search-tab">⚽ Olahraga</button>
                        <button class="search-tab">🎡 Atraksi</button>
                        <button class="search-tab">✈️ Transportasi</button>
                    </div>
                    <form action="{{ route('front.home') }}" method="GET">
                        <div class="search-inputs">
                            <div class="search-field">
                                <label>Cari event atau artis</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Masukkan kata kunci">
                            </div>
                            <div class="search-field">
                                <label>Lokasi</label>
                                <select name="location">
                                    <option value="">Pilih lokasi</option>
                                    <option>Jakarta</option>
                                    <option>Bandung</option>
                                    <option>Surabaya</option>
                                    <option>Bali</option>
                                </select>
                            </div>
                            <div class="search-field">
                                <label>Tanggal</label>
                                <input type="date" name="date" placeholder="Pilih tanggal">
                            </div>
                            <div class="search-field">
                                <label>Tiket</label>
                                <select name="qty">
                                    <option>1 Tiket</option>
                                    <option>2 Tiket</option>
                                    <option>3 Tiket</option>
                                    <option>4+ Tiket</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-search">Cari Tiket</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="hero-right">
                <div class="hero-stat-cards">
                    <div class="hero-stat-card">
                        <div class="num">{{ $events->total() }}+</div>
                        <div class="lbl">Event Tersedia</div>
                    </div>
                    <div class="hero-stat-card">
                        <div class="num">{{ $categories->count() }}</div>
                        <div class="lbl">Kategori</div>
                    </div>
                    <div class="hero-stat-card">
                        <div class="num">100%</div>
                        <div class="lbl">Tiket Resmi</div>
                    </div>
                    <div class="hero-stat-card">
                        <div class="num">24/7</div>
                        <div class="lbl">Layanan Aktif</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── JELAJAHI KATEGORI ── --}}
<section class="cat-section">
    <div class="shell">
        <div class="cat-section-head">
            <div>
                <div class="eyebrow">Kategori</div>
                <h2>Jelajahi Kategori</h2>
            </div>
            <a href="{{ route('front.home') }}" class="link-see-all">Lihat semua kategori →</a>
        </div>
        <div class="cat-grid">
            @php
                $catIcons = ['konser'=>'🎵','olahraga'=>'⚽','event'=>'📅','atraksi'=>'🎡','transportasi'=>'✈️'];
                $catDefaults = [
                    ['name'=>'Konser','slug'=>'konser','icon'=>'🎵'],
                    ['name'=>'Olahraga','slug'=>'olahraga','icon'=>'⚽'],
                    ['name'=>'Event','slug'=>'event','icon'=>'📅'],
                    ['name'=>'Atraksi','slug'=>'atraksi','icon'=>'🎡'],
                    ['name'=>'Transportasi','slug'=>'transportasi','icon'=>'✈️'],
                ];
            @endphp
            @if($categories->isNotEmpty())
                @foreach($categories->take(5) as $cat)
                    <a href="{{ route('front.home') }}?category={{ $cat->slug }}" class="cat-card">
                        <div class="cat-icon">{{ $catIcons[$cat->slug] ?? '🎫' }}</div>
                        <h4>{{ $cat->name }}</h4>
                        <span>Lihat semua</span>
                    </a>
                @endforeach
            @else
                @foreach($catDefaults as $cat)
                    <a href="{{ route('front.home') }}?category={{ $cat['slug'] }}" class="cat-card">
                        <div class="cat-icon">{{ $cat['icon'] }}</div>
                        <h4>{{ $cat['name'] }}</h4>
                        <span>Lihat semua</span>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</section>

{{-- ── EVENT PILIHAN ── --}}
@if($events->isNotEmpty())
<section class="events-section">
    <div class="shell">
        <div class="events-head">
            <div>
                <div class="eyebrow">Unggulan</div>
                <h2>Event Pilihan</h2>
            </div>
            <a href="{{ route('front.home') }}" class="link-see-all">Lihat semua event →</a>
        </div>
        <div class="events-scroll">
            @foreach($events->take(4) as $event)
                @php
                    $lowestTicket = $event->tickets->where('status','active')->sortBy('price')->first();
                @endphp
                <article class="ecard">
                    <a href="{{ route('front.events.show', $event->slug) }}" class="ecard-img">
                        @if($event->banner)
                            <img src="{{ minio_url($event->banner) }}" alt="{{ $event->name }}" loading="lazy">
                        @else
                            <div style="height:100%;background:linear-gradient(135deg,#2e0b6e,#6d28d9);display:grid;place-items:center;font-size:32px;">🎫</div>
                        @endif
                        @if($event->category)
                            <span class="ecard-cat">{{ $event->category->name }}</span>
                        @endif
                        <button class="ecard-fav">♡</button>
                    </a>
                    <div class="ecard-body">
                        <div class="ecard-meta">
                            <span>📅 {{ $event->start_date ? date('d M Y', strtotime($event->start_date)) : 'Segera' }}</span>
                            @if($event->location)
                                <span>📍 {{ Str::limit($event->location, 20) }}</span>
                            @endif
                        </div>
                        <div class="ecard-title">{{ $event->name }}</div>
                        <div class="ecard-loc">📍 {{ $event->location ?: 'Lokasi menyusul' }}</div>
                        <div class="ecard-foot">
                            <div>
                                <div class="price-from">Mulai dari</div>
                                <div class="price-val">
                                    @if($lowestTicket)
                                        Rp{{ number_format($lowestTicket->price, 0, ',', '.') }}
                                    @else
                                        Segera hadir
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('front.events.show', $event->slug) }}" class="btn-card">Beli Tiket</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── KENAPA TIKETIN ── --}}
<section class="why-section">
    <div class="shell">
        <div class="sec-head" style="text-align:center;">
            <div class="eyebrow">Keunggulan</div>
            <h2>Kenapa pilih Tiketin?</h2>
        </div>
        <div class="why-grid">
            <div class="why-card">
                <div class="why-icon">🛡</div>
                <h4>Tiket Resmi &amp; Terjamin</h4>
                <p>Semua tiket resmi dari partner terpercaya kami di seluruh Indonesia.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">🏷</div>
                <h4>Harga Terbaik</h4>
                <p>Dapatkan harga terbaik tanpa biaya tersembunyi atau markup berlebihan.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">⚡</div>
                <h4>Mudah &amp; Cepat</h4>
                <p>Proses pemesanan cepat dan praktis dalam beberapa langkah mudah saja.</p>
            </div>
            <div class="why-card">
                <div class="why-icon">🎧</div>
                <h4>Layanan 24/7</h4>
                <p>Tim kami siap membantu kapan saja, di mana saja, selama 24 jam penuh.</p>
            </div>
        </div>
    </div>
</section>

{{-- ── APP DOWNLOAD ── --}}
<section class="app-section">
    <div class="shell">
        <div class="app-inner">
            <div class="app-copy">
                <div class="eyebrow" style="color:rgba(255,255,255,.6);">Mobile App</div>
                <h2 style="color:#fff;">Pesan tiket kapan pun,<br>di mana pun dengan aplikasi Tiketin</h2>
                <p>Unduh sekarang dan dapatkan pengalaman pemesanan tiket yang lebih mudah dan cepat!</p>
                <div class="app-btns">
                    <a href="#" class="app-btn">
                        <span class="app-btn-icon">🍎</span>
                        <span class="app-btn-text">
                            <small>Download di</small>
                            <strong>App Store</strong>
                        </span>
                    </a>
                    <a href="#" class="app-btn">
                        <span class="app-btn-icon">▶</span>
                        <span class="app-btn-text">
                            <small>Temukan di</small>
                            <strong>Google Play</strong>
                        </span>
                    </a>
                </div>
            </div>
            <div class="app-phones">
                <div class="app-phone-mock">📱</div>
                <div class="app-phone-mock tall">📲</div>
            </div>
        </div>
    </div>
</section>

{{-- ── TESTIMONIALS ── --}}
<section class="testi-section">
    <div class="shell">
        <div class="sec-head" style="text-align:center;">
            <div class="eyebrow">Ulasan</div>
            <h2>Apa kata mereka?</h2>
        </div>
        <div class="testi-grid">
            <div class="testi-card">
                <div class="testi-quote">❝</div>
                <p class="testi-text">Pemesanan mudah, tiket langsung masuk ke email. Nonton konser jadi makin praktis!</p>
                <div class="testi-author">
                    <div class="testi-avatar">R</div>
                    <div>
                        <div class="testi-name">Rizky Pratama</div>
                        <div class="testi-loc">Jakarta</div>
                    </div>
                </div>
            </div>
            <div class="testi-card">
                <div class="testi-quote">❝</div>
                <p class="testi-text">Harga bersaing dan banyak pilihan event menarik. Pasti jadi langganan!</p>
                <div class="testi-author">
                    <div class="testi-avatar">D</div>
                    <div>
                        <div class="testi-name">Dewi Lestari</div>
                        <div class="testi-loc">Bandung</div>
                    </div>
                </div>
            </div>
            <div class="testi-card">
                <div class="testi-quote">❝</div>
                <p class="testi-text">Customer service responsif dan sangat membantu. Terima kasih Tiketin!</p>
                <div class="testi-author">
                    <div class="testi-avatar">A</div>
                    <div>
                        <div class="testi-name">Andi Wijaya</div>
                        <div class="testi-loc">Surabaya</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── NEWSLETTER ── --}}
<section class="news-section">
    <div class="shell">
        <div class="news-inner">
            <div class="news-copy">
                <h3>🔔 Jangan lewatkan event seru lainnya!</h3>
                <p>Dapatkan info terbaru, promo spesial, dan rekomendasi event pilihan langsung di inbox kamu.</p>
            </div>
            <div class="news-form">
                <input type="email" class="news-input" placeholder="Masukkan email kamu">
                <button class="btn-subscribe">Berlangganan</button>
            </div>
        </div>
    </div>
</section>

{{-- ── ALL EVENTS LIST ── --}}
<section class="list-section">
    <div class="shell">
        <div class="list-head">
            <div>
                <h2>
                    @if(request('search') || request('category'))
                        Hasil Pencarian
                    @else
                        Semua Event
                    @endif
                </h2>
                <p style="margin-top:4px;font-size:14px;">
                    @if(request('search'))Event untuk "<strong style="color:#fff">{{ request('search') }}</strong>"@endif
                    @if(request('category')) &middot; Kategori <strong style="color:#fff">{{ request('category') }}</strong>@endif
                    @if(!request('search') && !request('category'))Event yang sudah terverifikasi dan siap dipesan.@endif
                </p>
            </div>
            <span class="badge-count">{{ $events->total() }} event</span>
        </div>

        @if(request('search') || request('category'))
            <div class="filter-chips">
                <span style="font-size:12px;color:var(--muted)">Filter:</span>
                @if(request('search'))<span class="chip">🔍 {{ request('search') }}</span>@endif
                @if(request('category'))<span class="chip">🗂 {{ request('category') }}</span>@endif
                <a href="{{ route('front.home') }}" class="chip chip-reset">✕ Reset</a>
            </div>
        @endif

        @if($events->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🎫</div>
                <h3>Tidak ada event ditemukan</h3>
                <p>
                    @if(request('search') || request('category'))
                        Coba ubah kata kunci atau pilih kategori lain.
                    @else
                        Belum ada event yang dipublish saat ini.
                    @endif
                </p>
                @if(request('search') || request('category'))
                    <a href="{{ route('front.home') }}" class="btn btn-ghost">Lihat semua event</a>
                @endif
            </div>
        @else
            <div class="events-grid">
                @foreach($events as $event)
                    @php
                        $lowestTicket = $event->tickets->where('status','active')->sortBy('price')->first();
                        $ticketCount  = $event->tickets->where('status','active')->count();
                    @endphp
                    <article class="ecard">
                        <a href="{{ route('front.events.show', $event->slug) }}" class="ecard-img">
                            @if($event->banner)
                                <img src="{{ minio_url($event->banner) }}" alt="{{ $event->name }}" loading="lazy">
                            @else
                                <div style="height:100%;background:linear-gradient(135deg,#2e0b6e,#6d28d9);display:grid;place-items:center;font-size:32px;">🎫</div>
                            @endif
                            @if($event->category)
                                <span class="ecard-cat">{{ $event->category->name }}</span>
                            @endif
                            @if($lowestTicket)
                                <span style="position:absolute;top:10px;right:10px;background:#10b981;color:#fff;font-size:11px;font-weight:700;padding:3px 9px;border-radius:999px;">● Tersedia</span>
                            @endif
                        </a>
                        <div class="ecard-body">
                            <div class="ecard-meta">
                                <span>📅 {{ $event->start_date ? date('d M Y', strtotime($event->start_date)) : 'Segera' }}</span>
                                @if($ticketCount)<span>🎟 {{ $ticketCount }} tipe</span>@endif
                            </div>
                            <div class="ecard-title">{{ $event->name }}</div>
                            <div class="ecard-loc">📍 {{ $event->location ?: 'Lokasi menyusul' }}</div>
                            <div class="ecard-foot">
                                <div>
                                    <div class="price-from">Mulai dari</div>
                                    <div class="price-val">
                                        @if($lowestTicket)
                                            Rp{{ number_format($lowestTicket->price, 0, ',', '.') }}
                                        @else
                                            <span style="font-size:12px;color:var(--muted);font-weight:400">Segera hadir</span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('front.events.show', $event->slug) }}" class="btn-card">Lihat Tiket</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($events->hasPages())
                <div class="pagi-wrap">
                    {{ $events->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>
</section>

@endsection