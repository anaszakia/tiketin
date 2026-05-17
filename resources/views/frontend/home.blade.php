@extends('frontend.layouts.app')

@section('title', 'TIKETIN - Beli Tiket Online Mudah & Cepat')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Clash+Display:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --primary: #FF4D00;
        --primary-light: #FF7340;
        --primary-dark: #CC3D00;
        --dark: #0D0D0D;
        --dark-surface: #1A1A1A;
        --dark-card: #222222;
        --accent-yellow: #FFD600;
        --accent-blue: #00A8FF;
        --text-primary: #F5F5F0;
        --text-muted: #888888;
        --border: rgba(255,255,255,0.08);
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 20px;
        --radius-xl: 28px;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background-color: var(--dark);
        color: var(--text-primary);
        font-family: 'Plus Jakarta Sans', sans-serif;
        overflow-x: hidden;
    }

    h1, h2, h3, .font-display {
        font-family: 'Clash Display', sans-serif;
    }

    /* ===== HERO ===== */
    .hero {
        min-height: 100vh;
        background: var(--dark);
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
        padding: 120px 0 80px;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: -200px; left: 50%;
        transform: translateX(-30%);
        width: 800px; height: 800px;
        background: radial-gradient(circle, rgba(255,77,0,0.18) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero::after {
        content: '';
        position: absolute;
        bottom: -100px; left: -100px;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(0,168,255,0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,77,0,0.12);
        border: 1px solid rgba(255,77,0,0.3);
        color: var(--primary-light);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 6px 14px;
        border-radius: 100px;
        margin-bottom: 24px;
    }

    .hero-badge .dot {
        width: 6px; height: 6px;
        background: var(--primary);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.4); }
    }

    .hero-title {
        font-size: clamp(44px, 5.5vw, 72px);
        font-weight: 700;
        line-height: 1.05;
        letter-spacing: -0.02em;
        margin-bottom: 20px;
    }

    .hero-title .highlight {
        color: var(--primary);
        position: relative;
    }

    .hero-title .highlight::after {
        content: '';
        position: absolute;
        bottom: 4px; left: 0; right: 0;
        height: 3px;
        background: var(--primary);
        border-radius: 2px;
        opacity: 0.4;
    }

    .hero-desc {
        font-size: 16px;
        line-height: 1.7;
        color: var(--text-muted);
        max-width: 440px;
        margin-bottom: 36px;
    }

    .hero-cta {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 52px;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: var(--primary);
        color: white;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 15px;
        font-weight: 600;
        padding: 14px 28px;
        border-radius: 100px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .btn-primary:hover {
        background: var(--primary-light);
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(255,77,0,0.35);
    }

    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: transparent;
        color: var(--text-primary);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 15px;
        font-weight: 500;
        padding: 14px 28px;
        border-radius: 100px;
        text-decoration: none;
        border: 1px solid var(--border);
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .btn-outline:hover {
        border-color: rgba(255,255,255,0.25);
        background: rgba(255,255,255,0.05);
        transform: translateY(-2px);
    }

    .hero-stats {
        display: flex;
        gap: 32px;
    }

    .stat-item {}

    .stat-number {
        font-family: 'Clash Display', sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .stat-label {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .stat-divider {
        width: 1px;
        background: var(--border);
    }

    /* Hero visual */
    .hero-visual {
        position: relative;
    }

    .ticket-main {
        background: var(--dark-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 28px;
        position: relative;
        overflow: hidden;
    }

    .ticket-main::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--accent-yellow));
    }

    .ticket-event-img {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
        border-radius: var(--radius-lg);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .ticket-event-img .overlay-text {
        font-family: 'Clash Display', sans-serif;
        font-size: 36px;
        font-weight: 700;
        color: rgba(255,255,255,0.15);
        letter-spacing: -0.02em;
    }

    .ticket-event-img .live-badge {
        position: absolute;
        top: 14px; left: 14px;
        background: var(--primary);
        color: white;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.06em;
        padding: 4px 10px;
        border-radius: 100px;
    }

    .ticket-event-img .price-badge {
        position: absolute;
        bottom: 14px; right: 14px;
        background: rgba(0,0,0,0.7);
        backdrop-filter: blur(8px);
        color: var(--accent-yellow);
        font-family: 'Clash Display', sans-serif;
        font-size: 18px;
        font-weight: 700;
        padding: 8px 14px;
        border-radius: var(--radius-sm);
        border: 1px solid rgba(255,214,0,0.2);
    }

    .ticket-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .ticket-meta {
        display: flex;
        gap: 16px;
        margin-bottom: 20px;
    }

    .ticket-meta-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: var(--text-muted);
    }

    .ticket-meta-item svg { width: 14px; height: 14px; }

    .ticket-dashed {
        border-top: 1px dashed rgba(255,255,255,0.12);
        margin: 18px -28px;
    }

    .ticket-dashed-circle {
        display: flex;
        justify-content: space-between;
        margin-top: -12px;
    }

    .ticket-dashed-circle::before,
    .ticket-dashed-circle::after {
        content: '';
        width: 24px; height: 24px;
        background: var(--dark);
        border-radius: 50%;
        margin-top: -1px;
    }

    .ticket-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .barcode {
        display: flex;
        gap: 2px;
    }

    .barcode-bar {
        background: var(--text-muted);
        border-radius: 1px;
    }

    .floating-card {
        position: absolute;
        background: var(--dark-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 14px 18px;
        animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-8px); }
    }

    .float-card-1 {
        bottom: -20px; left: -40px;
        animation-delay: 0s;
    }

    .float-card-2 {
        top: 30px; right: -40px;
        animation-delay: 1.5s;
    }

    .fc-label { font-size: 11px; color: var(--text-muted); margin-bottom: 4px; }
    .fc-value { font-family: 'Clash Display', sans-serif; font-size: 16px; font-weight: 600; }
    .fc-value.green { color: #4ADE80; }
    .fc-sub { font-size: 12px; color: var(--text-muted); }

    /* ===== SEARCH BAR ===== */
    .search-section {
        background: var(--dark-surface);
        padding: 40px 0;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
    }

    .search-wrapper {
        background: var(--dark-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 8px;
        display: flex;
        gap: 4px;
        align-items: center;
        max-width: 820px;
        margin: 0 auto;
    }

    .search-field {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        padding: 10px 16px;
        border-radius: var(--radius-lg);
        transition: background 0.2s;
    }

    .search-field:hover { background: rgba(255,255,255,0.04); }

    .search-field svg { width: 18px; height: 18px; color: var(--text-muted); flex-shrink: 0; }

    .search-field input, .search-field select {
        background: none;
        border: none;
        outline: none;
        color: var(--text-primary);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        width: 100%;
    }

    .search-field input::placeholder { color: var(--text-muted); }

    .search-field select option { background: var(--dark-card); }

    .search-divider {
        width: 1px; height: 32px;
        background: var(--border);
        flex-shrink: 0;
    }

    .search-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--primary);
        color: white;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        padding: 13px 24px;
        border-radius: var(--radius-lg);
        border: none;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s;
    }

    .search-btn:hover { background: var(--primary-light); }

    /* ===== SECTION COMMONS ===== */
    section { padding: 80px 0; }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 40px;
    }

    .section-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--primary);
        margin-bottom: 8px;
    }

    .section-title {
        font-family: 'Clash Display', sans-serif;
        font-size: clamp(28px, 3.5vw, 40px);
        font-weight: 700;
        line-height: 1.15;
        letter-spacing: -0.02em;
    }

    .see-all {
        display: flex;
        align-items: center;
        gap: 6px;
        color: var(--primary);
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: gap 0.2s;
    }

    .see-all:hover { gap: 10px; }

    /* ===== CATEGORIES ===== */
    .categories-bg { background: var(--dark-surface); }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
        gap: 12px;
    }

    .category-card {
        background: var(--dark-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 20px 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
        color: var(--text-primary);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .category-card:hover {
        border-color: var(--primary);
        transform: translateY(-4px);
        background: rgba(255,77,0,0.06);
    }

    .category-card.active {
        border-color: var(--primary);
        background: rgba(255,77,0,0.1);
    }

    .cat-icon {
        width: 44px; height: 44px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .cat-name { font-size: 12px; font-weight: 600; }

    /* ===== EVENT CARDS ===== */
    .event-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .event-card {
        background: var(--dark-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        color: var(--text-primary);
        display: flex;
        flex-direction: column;
    }

    .event-card:hover {
        transform: translateY(-6px);
        border-color: rgba(255,77,0,0.3);
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }

    .event-img {
        height: 190px;
        position: relative;
        overflow: hidden;
    }

    .event-img-bg {
        width: 100%; height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        transition: transform 0.4s ease;
    }

    .event-card:hover .event-img-bg { transform: scale(1.08); }

    .event-img .cat-tag {
        position: absolute;
        top: 12px; left: 12px;
        background: rgba(0,0,0,0.65);
        backdrop-filter: blur(6px);
        color: white;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 100px;
        border: 1px solid rgba(255,255,255,0.12);
    }

    .event-img .wishlist-btn {
        position: absolute;
        top: 12px; right: 12px;
        width: 34px; height: 34px;
        background: rgba(0,0,0,0.65);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 15px;
        color: white;
    }

    .event-img .wishlist-btn:hover { background: rgba(255,77,0,0.6); }

    .event-body { padding: 18px; flex: 1; display: flex; flex-direction: column; }

    .event-date {
        font-size: 11px;
        font-weight: 600;
        color: var(--primary-light);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 6px;
    }

    .event-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 17px;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 10px;
    }

    .event-location {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 16px;
    }

    .event-location svg { width: 13px; height: 13px; }

    .event-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px solid var(--border);
    }

    .event-price-label { font-size: 11px; color: var(--text-muted); }

    .event-price {
        font-family: 'Clash Display', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .event-price.free { color: #4ADE80; }

    .btn-ticket {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--primary);
        color: white;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 600;
        padding: 8px 16px;
        border-radius: 100px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-ticket:hover { background: var(--primary-light); }

    /* ===== PROMO BANNER ===== */
    .promo-section { background: var(--dark-surface); }

    .promo-banner {
        background: linear-gradient(135deg, #1a0800 0%, #2d1200 40%, #0d1a2d 100%);
        border: 1px solid rgba(255,77,0,0.2);
        border-radius: var(--radius-xl);
        padding: 56px 60px;
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 40px;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .promo-banner::before {
        content: '';
        position: absolute;
        top: -100px; right: -100px;
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(255,77,0,0.15) 0%, transparent 70%);
        pointer-events: none;
    }

    .promo-banner::after {
        content: '';
        position: absolute;
        bottom: -80px; left: 200px;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(0,168,255,0.08) 0%, transparent 70%);
        pointer-events: none;
    }

    .promo-label {
        display: inline-block;
        background: var(--accent-yellow);
        color: #0D0D0D;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: 100px;
        margin-bottom: 16px;
    }

    .promo-title {
        font-family: 'Clash Display', sans-serif;
        font-size: clamp(26px, 3.5vw, 42px);
        font-weight: 700;
        line-height: 1.15;
        letter-spacing: -0.02em;
        margin-bottom: 14px;
    }

    .promo-desc {
        font-size: 15px;
        color: var(--text-muted);
        line-height: 1.6;
        max-width: 480px;
    }

    .promo-code-box {
        text-align: center;
        flex-shrink: 0;
    }

    .promo-code {
        background: rgba(255,255,255,0.06);
        border: 2px dashed rgba(255,77,0,0.4);
        border-radius: var(--radius-md);
        padding: 24px 32px;
        margin-bottom: 12px;
    }

    .promo-code-label { font-size: 12px; color: var(--text-muted); margin-bottom: 6px; }

    .promo-code-text {
        font-family: 'Clash Display', sans-serif;
        font-size: 28px;
        font-weight: 700;
        letter-spacing: 0.05em;
        color: var(--accent-yellow);
    }

    .promo-discount {
        font-size: 13px;
        color: var(--primary-light);
        font-weight: 600;
    }

    /* ===== HOW IT WORKS ===== */
    .steps-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 24px;
        position: relative;
    }

    .step-card {
        background: var(--dark-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 32px 28px;
        position: relative;
        transition: all 0.3s ease;
    }

    .step-card:hover {
        border-color: rgba(255,77,0,0.3);
        transform: translateY(-4px);
    }

    .step-number {
        font-family: 'Clash Display', sans-serif;
        font-size: 56px;
        font-weight: 700;
        color: rgba(255,77,0,0.12);
        line-height: 1;
        margin-bottom: 16px;
    }

    .step-icon {
        width: 44px; height: 44px;
        background: rgba(255,77,0,0.12);
        border-radius: var(--radius-sm);
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
        margin-bottom: 16px;
    }

    .step-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .step-desc {
        font-size: 14px;
        color: var(--text-muted);
        line-height: 1.6;
    }

    /* ===== TESTIMONIALS ===== */
    .testimonials-bg { background: var(--dark-surface); }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .testi-card {
        background: var(--dark-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 28px;
        transition: all 0.3s ease;
    }

    .testi-card:hover {
        border-color: rgba(255,77,0,0.2);
        transform: translateY(-3px);
    }

    .testi-stars {
        color: var(--accent-yellow);
        font-size: 14px;
        margin-bottom: 14px;
        letter-spacing: 2px;
    }

    .testi-text {
        font-size: 14px;
        line-height: 1.7;
        color: #CCCCCC;
        margin-bottom: 20px;
    }

    .testi-author {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .testi-avatar {
        width: 40px; height: 40px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 700;
        font-size: 15px;
        flex-shrink: 0;
    }

    .testi-name { font-weight: 600; font-size: 14px; }
    .testi-role { font-size: 12px; color: var(--text-muted); }

    /* ===== APP DOWNLOAD ===== */
    .app-section {
        background: var(--dark);
    }

    .app-banner {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 60px;
        align-items: center;
        background: var(--dark-card);
        border: 1px solid var(--border);
        border-radius: var(--radius-xl);
        padding: 56px 60px;
        position: relative;
        overflow: hidden;
    }

    .app-banner::before {
        content: '';
        position: absolute;
        top: -150px; right: 0;
        width: 500px; height: 500px;
        background: radial-gradient(circle, rgba(0,168,255,0.06) 0%, transparent 70%);
    }

    .app-store-btns {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 28px;
    }

    .app-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        background: var(--dark-surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 12px 20px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        color: var(--text-primary);
    }

    .app-btn:hover {
        border-color: rgba(255,255,255,0.2);
        background: rgba(255,255,255,0.05);
    }

    .app-btn-icon { font-size: 28px; }

    .app-btn-label { font-size: 10px; color: var(--text-muted); }
    .app-btn-store { font-family: 'Clash Display', sans-serif; font-size: 16px; font-weight: 700; }

    .app-phones {
        display: flex;
        gap: 16px;
        justify-content: center;
        position: relative;
    }

    .phone-mockup {
        width: 130px;
        background: var(--dark-surface);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 24px;
        padding: 10px;
        height: 240px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        overflow: hidden;
    }

    .phone-mockup.main { width: 150px; height: 270px; transform: translateY(0); }
    .phone-mockup.side { transform: translateY(24px); opacity: 0.6; }

    .phone-notch {
        width: 50px; height: 6px;
        background: rgba(255,255,255,0.1);
        border-radius: 3px;
        margin: 0 auto 6px;
    }

    .phone-screen-block {
        background: rgba(255,77,0,0.12);
        border-radius: 10px;
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .phone-list-item {
        background: rgba(255,255,255,0.04);
        border-radius: 8px;
        height: 32px;
        display: flex;
        align-items: center;
        padding: 0 10px;
        gap: 8px;
        font-size: 10px;
        color: var(--text-muted);
    }

    .phone-list-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* ===== NEWSLETTER ===== */
    .newsletter-section {
        background: var(--dark-surface);
        border-top: 1px solid var(--border);
        padding: 60px 0;
    }

    .newsletter-inner {
        text-align: center;
        max-width: 560px;
        margin: 0 auto;
    }

    .newsletter-inner .section-title { margin-bottom: 12px; }

    .newsletter-inner p {
        color: var(--text-muted);
        font-size: 15px;
        margin-bottom: 28px;
    }

    .newsletter-form {
        display: flex;
        gap: 8px;
        max-width: 440px;
        margin: 0 auto;
    }

    .newsletter-input {
        flex: 1;
        background: var(--dark-card);
        border: 1px solid var(--border);
        border-radius: 100px;
        padding: 12px 20px;
        color: var(--text-primary);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
    }

    .newsletter-input:focus { border-color: var(--primary); }
    .newsletter-input::placeholder { color: var(--text-muted); }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1024px) {
        .promo-banner { grid-template-columns: 1fr; }
        .app-banner { grid-template-columns: 1fr; }
        .app-phones { justify-content: flex-start; }
    }

    @media (max-width: 768px) {
        .hero { padding: 100px 0 60px; }
        .hero-grid { grid-template-columns: 1fr; gap: 40px; }
        .hero-visual { display: none; }
        .hero-stats { gap: 20px; }
        .search-wrapper { flex-direction: column; align-items: stretch; padding: 12px; }
        .search-divider { display: none; }
        .search-btn { justify-content: center; }
        .section-header { flex-direction: column; align-items: flex-start; gap: 12px; }
        .promo-banner { padding: 36px 28px; }
        .app-banner { padding: 36px 28px; }
        .newsletter-form { flex-direction: column; }
        .newsletter-input { border-radius: var(--radius-lg); }
        .btn-primary.newsletter-btn { border-radius: var(--radius-lg); }
    }

    @media (max-width: 480px) {
        .event-grid { grid-template-columns: 1fr; }
        .hero-cta { flex-direction: column; }
        .hero-stats { flex-wrap: wrap; }
    }
</style>
@endsection

@section('content')

{{-- HERO --}}
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Platform Tiket #1 Indonesia
                </div>
                <h1 class="hero-title">
                    Pesan Tiket<br>
                    <span class="highlight">Favoritmu</span><br>
                    Tanpa Ribet
                </h1>
                <p class="hero-desc">
                    Dari konser musik hingga pertandingan olahraga, festival seni hingga pertunjukan teater — semua tiket tersedia di TIKETIN dengan mudah dan aman.
                </p>
                <div class="hero-cta">
                    <a href="#" class="btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                        Jelajahi Acara
                    </a>
                    <a href="#" class="btn-outline">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8" fill="currentColor"/></svg>
                        Cara Kerja
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number">500K+</div>
                        <div class="stat-label">Pengguna Aktif</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-number">12K+</div>
                        <div class="stat-label">Event Tersedia</div>
                    </div>
                    <div class="stat-divider"></div>
                    <div class="stat-item">
                        <div class="stat-number">99%</div>
                        <div class="stat-label">Kepuasan Pelanggan</div>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="ticket-main">
                    <div class="ticket-event-img">
                        <span class="overlay-text">LIVE</span>
                        <span class="live-badge">🔴 Trending</span>
                        <span class="price-badge">Rp 350K</span>
                    </div>
                    <div class="ticket-title">Synchronize Festival 2025</div>
                    <div class="ticket-meta">
                        <div class="ticket-meta-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            3–5 Okt 2025
                        </div>
                        <div class="ticket-meta-item">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            JI-Expo, Jakarta
                        </div>
                    </div>
                    <div class="ticket-dashed"></div>
                    <div class="ticket-dashed-circle"></div>
                    <div class="ticket-bottom">
                        <div>
                            <div style="font-size: 11px; color: var(--text-muted);">Seat tersisa</div>
                            <div style="font-family: 'Clash Display', sans-serif; font-size: 20px; font-weight: 700; color: var(--primary);">248</div>
                        </div>
                        <div class="barcode">
                            @php $heights = [28,20,32,18,26,22,30,16,28,20,24,32,18,26,22]; @endphp
                            @foreach($heights as $h)
                                <div class="barcode-bar" style="width: 2px; height: {{ $h }}px;"></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="floating-card float-card-1">
                    <div class="fc-label">Terjual Hari Ini</div>
                    <div class="fc-value green">+1,284</div>
                    <div class="fc-sub">Tiket terjual</div>
                </div>

                <div class="floating-card float-card-2">
                    <div class="fc-label">Keamanan</div>
                    <div class="fc-value">🔒 SSL</div>
                    <div class="fc-sub">100% Aman</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SEARCH --}}
<div class="search-section">
    <div class="container">
        <form action="#" method="GET">
            <div class="search-wrapper">
                <div class="search-field" style="flex: 2;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <input type="text" name="q" placeholder="Cari konser, festival, olahraga...">
                </div>
                <div class="search-divider"></div>
                <div class="search-field">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <select name="city">
                        <option value="">Semua Kota</option>
                        <option value="jakarta">Jakarta</option>
                        <option value="surabaya">Surabaya</option>
                        <option value="bandung">Bandung</option>
                        <option value="yogyakarta">Yogyakarta</option>
                        <option value="bali">Bali</option>
                        <option value="medan">Medan</option>
                        <option value="semarang">Semarang</option>
                    </select>
                </div>
                <div class="search-divider"></div>
                <div class="search-field">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color: var(--text-muted);"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    <select name="date">
                        <option value="">Kapan Saja</option>
                        <option value="today">Hari Ini</option>
                        <option value="weekend">Akhir Pekan</option>
                        <option value="this_month">Bulan Ini</option>
                        <option value="next_month">Bulan Depan</option>
                    </select>
                </div>
                <button type="submit" class="search-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    Cari Tiket
                </button>
            </div>
        </form>
    </div>
</div>

{{-- CATEGORIES --}}
<section class="categories-bg">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="section-label">Temukan</div>
                <h2 class="section-title">Jelajahi per Kategori</h2>
            </div>
        </div>
        <div class="category-grid">
            @php
                $categories = [
                    ['icon' => '🎵', 'name' => 'Konser', 'color' => 'rgba(255,77,0,0.15)', 'slug' => 'konser'],
                    ['icon' => '⚽', 'name' => 'Olahraga', 'color' => 'rgba(0,168,255,0.15)', 'slug' => 'olahraga'],
                    ['icon' => '🎭', 'name' => 'Teater', 'color' => 'rgba(168,0,255,0.15)', 'slug' => 'teater'],
                    ['icon' => '🎪', 'name' => 'Festival', 'color' => 'rgba(255,214,0,0.15)', 'slug' => 'festival'],
                    ['icon' => '🎬', 'name' => 'Film', 'color' => 'rgba(255,77,100,0.15)', 'slug' => 'film'],
                    ['icon' => '🎮', 'name' => 'Gaming', 'color' => 'rgba(0,255,136,0.15)', 'slug' => 'gaming'],
                    ['icon' => '🍜', 'name' => 'Kuliner', 'color' => 'rgba(255,140,0,0.15)', 'slug' => 'kuliner'],
                    ['icon' => '🎨', 'name' => 'Seni', 'color' => 'rgba(255,0,136,0.15)', 'slug' => 'seni'],
                    ['icon' => '📚', 'name' => 'Edukasi', 'color' => 'rgba(0,200,255,0.15)', 'slug' => 'edukasi'],
                    ['icon' => '🌿', 'name' => 'Alam', 'color' => 'rgba(100,220,0,0.15)', 'slug' => 'alam'],
                ];
            @endphp
            @foreach($categories as $cat)
                <a href="#" class="category-card">
                    <div class="cat-icon" style="background: {{ $cat['color'] }};">{{ $cat['icon'] }}</div>
                    <div class="cat-name">{{ $cat['name'] }}</div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- FEATURED EVENTS --}}
<section>
    <div class="container">
        <div class="section-header">
            <div>
                <div class="section-label">Pilihan Editor</div>
                <h2 class="section-title">Acara Unggulan</h2>
            </div>
            <a href="#" class="see-all">
                Lihat Semua
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="event-grid">
            @forelse($featuredEvents ?? [] as $event)
                <a href="#" class="event-card">
                    <div class="event-img">
                        @if($event->image)
                            <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->name }}" style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <div class="event-img-bg" style="background: linear-gradient(135deg, #1a1a2e, #16213e);">🎟️</div>
                        @endif
                        <span class="cat-tag">{{ $event->category }}</span>
                        <button class="wishlist-btn" onclick="event.preventDefault()">♡</button>
                    </div>
                    <div class="event-body">
                        <div class="event-date">{{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('D, d M Y') }}</div>
                        <div class="event-title">{{ $event->name }}</div>
                        <div class="event-location">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $event->venue }}, {{ $event->city }}
                        </div>
                        <div class="event-footer">
                            <div>
                                <div class="event-price-label">Mulai dari</div>
                                <div class="event-price {{ $event->min_price == 0 ? 'free' : '' }}">
                                    {{ $event->min_price == 0 ? 'GRATIS' : 'Rp '.number_format($event->min_price, 0, ',', '.') }}
                                </div>
                            </div>
                            <span class="btn-ticket">Beli Tiket →</span>
                        </div>
                    </div>
                </a>
            @empty
                {{-- Demo cards saat data kosong --}}
                @php
                    $demoEvents = [
                        ['emoji'=>'🎵','bg'=>'linear-gradient(135deg,#1a0a2e,#2d1a4e)','cat'=>'Konser','title'=>'Dewa 19 Reunion Tour 2025','date'=>'Sab, 14 Jun 2025','venue'=>'Gelora Bung Karno, Jakarta','price'=>'Rp 350.000'],
                        ['emoji'=>'⚽','bg'=>'linear-gradient(135deg,#0a1a0e,#1a3a2e)','cat'=>'Olahraga','title'=>'Persija vs Persib — Liga 1','date'=>'Min, 22 Jun 2025','venue'=>'SUGBK, Jakarta','price'=>'Rp 75.000'],
                        ['emoji'=>'🎪','bg'=>'linear-gradient(135deg,#2e1a00,#4e2d00)','cat'=>'Festival','title'=>'Jazz Gunung Bromo 2025','date'=>'Jum, 18 Jul 2025','venue'=>'Bromo, Jawa Timur','price'=>'Rp 500.000'],
                        ['emoji'=>'🎭','bg'=>'linear-gradient(135deg,#1a001a,#3a003a)','cat'=>'Teater','title'=>'Romeo & Juliet — TIM Jakarta','date'=>'Rab, 9 Jul 2025','venue'=>'TIM, Jakarta','price'=>'GRATIS'],
                    ];
                @endphp
                @foreach($demoEvents as $demo)
                    <div class="event-card" style="cursor: default;">
                        <div class="event-img">
                            <div class="event-img-bg" style="background: {{ $demo['bg'] }}; font-size: 60px;">{{ $demo['emoji'] }}</div>
                            <span class="cat-tag">{{ $demo['cat'] }}</span>
                            <button class="wishlist-btn" onclick="event.preventDefault()">♡</button>
                        </div>
                        <div class="event-body">
                            <div class="event-date">{{ $demo['date'] }}</div>
                            <div class="event-title">{{ $demo['title'] }}</div>
                            <div class="event-location">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $demo['venue'] }}
                            </div>
                            <div class="event-footer">
                                <div>
                                    <div class="event-price-label">Mulai dari</div>
                                    <div class="event-price {{ $demo['price'] === 'GRATIS' ? 'free' : '' }}">{{ $demo['price'] }}</div>
                                </div>
                                <span class="btn-ticket">Beli Tiket →</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- PROMO BANNER --}}
<section class="promo-section">
    <div class="container">
        <div class="promo-banner">
            <div>
                <span class="promo-label">🔥 Penawaran Terbatas</span>
                <div class="promo-title">Diskon 30% untuk<br>Pembelian Pertama</div>
                <p class="promo-desc">Daftar sekarang dan nikmati diskon eksklusif untuk pembelian tiket pertamamu. Berlaku untuk semua kategori acara sampai akhir bulan.</p>
                <a href="#" class="btn-primary" style="margin-top: 24px; display: inline-flex;">
                    Daftar Sekarang
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="promo-code-box">
                <div class="promo-code">
                    <div class="promo-code-label">Gunakan kode promo</div>
                    <div class="promo-code-text">TIKETIN30</div>
                </div>
                <div class="promo-discount">Hemat hingga Rp 150.000</div>
            </div>
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section>
    <div class="container">
        <div class="section-header">
            <div>
                <div class="section-label">Mudah & Cepat</div>
                <h2 class="section-title">Cara Pesan Tiket</h2>
            </div>
        </div>
        <div class="steps-grid">
            @php
                $steps = [
                    ['n'=>'01','icon'=>'🔍','title'=>'Cari Acara','desc'=>'Temukan acara favoritmu dengan mudah melalui fitur pencarian atau jelajahi berdasarkan kategori dan kota.'],
                    ['n'=>'02','icon'=>'🎟️','title'=>'Pilih Tiket','desc'=>'Pilih jenis dan jumlah tiket yang kamu inginkan. Lihat denah tempat duduk secara langsung.'],
                    ['n'=>'03','icon'=>'💳','title'=>'Bayar Aman','desc'=>'Bayar dengan berbagai metode: transfer bank, e-wallet, kartu kredit, atau bayar di minimarket.'],
                    ['n'=>'04','icon'=>'✅','title'=>'Tiket Siap!','desc'=>'Tiket dikirim langsung ke emailmu dalam hitungan detik. Tunjukkan QR code di lokasi acara.'],
                ];
            @endphp
            @foreach($steps as $step)
                <div class="step-card">
                    <div class="step-number">{{ $step['n'] }}</div>
                    <div class="step-icon">{{ $step['icon'] }}</div>
                    <div class="step-title">{{ $step['title'] }}</div>
                    <p class="step-desc">{{ $step['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- UPCOMING EVENTS --}}
<section style="background: var(--dark-surface);">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="section-label">Jangan Sampai Ketinggalan</div>
                <h2 class="section-title">Segera Hadir</h2>
            </div>
            <a href="#" class="see-all">
                Lihat Semua
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="event-grid">
            @forelse($upcomingEvents ?? [] as $event)
                <a href="#" class="event-card">
                    <div class="event-img">
                        @if($event->image)
                            <img src="{{ asset('storage/'.$event->image) }}" alt="{{ $event->name }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <div class="event-img-bg" style="background: linear-gradient(135deg, #1a1a2e, #16213e);">🎟️</div>
                        @endif
                        <span class="cat-tag">{{ $event->category }}</span>
                        <button class="wishlist-btn" onclick="event.preventDefault()">♡</button>
                    </div>
                    <div class="event-body">
                        <div class="event-date">{{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('D, d M Y') }}</div>
                        <div class="event-title">{{ $event->name }}</div>
                        <div class="event-location">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            {{ $event->venue }}, {{ $event->city }}
                        </div>
                        <div class="event-footer">
                            <div>
                                <div class="event-price-label">Mulai dari</div>
                                <div class="event-price {{ $event->min_price == 0 ? 'free' : '' }}">
                                    {{ $event->min_price == 0 ? 'GRATIS' : 'Rp '.number_format($event->min_price, 0, ',', '.') }}
                                </div>
                            </div>
                            <span class="btn-ticket">Beli Tiket →</span>
                        </div>
                    </div>
                </a>
            @empty
                @php
                    $demoUpcoming = [
                        ['emoji'=>'🎸','bg'=>'linear-gradient(135deg,#0a1a2e,#1a2e4e)','cat'=>'Konser','title'=>'Coldplay Music of the Spheres','date'=>'Rab, 2 Agu 2025','venue'=>'Gelora Bung Karno, Jakarta','price'=>'Rp 1.500.000'],
                        ['emoji'=>'🏀','bg'=>'linear-gradient(135deg,#1a0e00,#3a1e00)','cat'=>'Olahraga','title'=>'Indonesia Basketball League','date'=>'Sab, 12 Jul 2025','venue'=>'Istora Senayan, Jakarta','price'=>'Rp 100.000'],
                        ['emoji'=>'🎆','bg'=>'linear-gradient(135deg,#1a001a,#2e002e)','cat'=>'Festival','title'=>'We The Fest 2025','date'=>'Jum–Min, 18–20 Jul 2025','venue'=>'JIEXPO, Jakarta','price'=>'Rp 850.000'],
                    ];
                @endphp
                @foreach($demoUpcoming as $demo)
                    <div class="event-card" style="cursor: default;">
                        <div class="event-img">
                            <div class="event-img-bg" style="background: {{ $demo['bg'] }}; font-size: 60px;">{{ $demo['emoji'] }}</div>
                            <span class="cat-tag">{{ $demo['cat'] }}</span>
                            <button class="wishlist-btn" onclick="event.preventDefault()">♡</button>
                        </div>
                        <div class="event-body">
                            <div class="event-date">{{ $demo['date'] }}</div>
                            <div class="event-title">{{ $demo['title'] }}</div>
                            <div class="event-location">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                {{ $demo['venue'] }}
                            </div>
                            <div class="event-footer">
                                <div>
                                    <div class="event-price-label">Mulai dari</div>
                                    <div class="event-price">{{ $demo['price'] }}</div>
                                </div>
                                <span class="btn-ticket">Beli Tiket →</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- TESTIMONIALS --}}
<section class="testimonials-bg">
    <div class="container">
        <div class="section-header">
            <div>
                <div class="section-label">Kata Mereka</div>
                <h2 class="section-title">Dipercaya Ratusan<br>Ribu Pengguna</h2>
            </div>
        </div>
        <div class="testimonials-grid">
            @php
                $testimonials = [
                    ['name'=>'Rizky Ananda','role'=>'Music Enthusiast, Jakarta','text'=>'TIKETIN bikin pesan tiket konser jadi super gampang! Ga pake antri, langsung bayar, tiket langsung masuk email. Udah 10+ konser pake TIKETIN, ga pernah kecewa.','stars'=>5,'initials'=>'RA','color'=>'rgba(255,77,0,0.2)','textColor'=>'#FF7340'],
                    ['name'=>'Siti Maharani','role'=>'Event Organizer, Surabaya','text'=>'Sebagai EO, TIKETIN sangat membantu untuk distribusi tiket. Dashboard-nya lengkap, laporan penjualannya real-time. Recommended banget buat sesama EO!','stars'=>5,'initials'=>'SM','color'=>'rgba(0,168,255,0.2)','textColor'=>'#40B8FF'],
                    ['name'=>'Bagas Prasetyo','role'=>'Football Fan, Bandung','text'=>'Nonton Persib jadi makin seru karena ga perlu repot ngantri beli tiket di stadion. Tinggal scan QR code, langsung masuk. Simple dan efisien!','stars'=>5,'initials'=>'BP','color'=>'rgba(168,0,255,0.2)','textColor'=>'#C040FF'],
                ];
            @endphp
            @foreach($testimonials as $t)
                <div class="testi-card">
                    <div class="testi-stars">{{ str_repeat('★', $t['stars']) }}</div>
                    <p class="testi-text">"{{ $t['text'] }}"</p>
                    <div class="testi-author">
                        <div class="testi-avatar" style="background: {{ $t['color'] }}; color: {{ $t['textColor'] }};">{{ $t['initials'] }}</div>
                        <div>
                            <div class="testi-name">{{ $t['name'] }}</div>
                            <div class="testi-role">{{ $t['role'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- APP DOWNLOAD --}}
<section class="app-section">
    <div class="container">
        <div class="app-banner">
            <div>
                <div class="section-label">Aplikasi Mobile</div>
                <h2 class="section-title">Pesan Tiket di<br>Mana Saja</h2>
                <p style="color: var(--text-muted); font-size: 15px; line-height: 1.6; margin-top: 12px; max-width: 440px;">
                    Unduh aplikasi TIKETIN dan nikmati kemudahan memesan tiket langsung dari smartphone kamu. Notifikasi real-time, dompet digital, dan fitur wishlist tersedia.
                </p>
                <div class="app-store-btns">
                    <a href="#" class="app-btn">
                        <span class="app-btn-icon">🍎</span>
                        <div>
                            <div class="app-btn-label">Download di</div>
                            <div class="app-btn-store">App Store</div>
                        </div>
                    </a>
                    <a href="#" class="app-btn">
                        <span class="app-btn-icon">🤖</span>
                        <div>
                            <div class="app-btn-label">Tersedia di</div>
                            <div class="app-btn-store">Google Play</div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="app-phones">
                <div class="phone-mockup side">
                    <div class="phone-notch"></div>
                    <div class="phone-screen-block" style="font-size: 36px;">📅</div>
                    <div class="phone-list-item"><div class="phone-list-dot" style="background: #FF4D00;"></div>Jadwal Saya</div>
                    <div class="phone-list-item"><div class="phone-list-dot" style="background: #4ADE80;"></div>Tiket Aktif</div>
                </div>
                <div class="phone-mockup main">
                    <div class="phone-notch"></div>
                    <div class="phone-screen-block" style="font-size: 44px;">🎟️</div>
                    <div class="phone-list-item"><div class="phone-list-dot" style="background: #FF4D00;"></div>Konser Minggu Ini</div>
                    <div class="phone-list-item"><div class="phone-list-dot" style="background: #00A8FF;"></div>Festival Bulan Ini</div>
                    <div class="phone-list-item"><div class="phone-list-dot" style="background: #FFD600;"></div>Promo Khusus</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- NEWSLETTER --}}
<div class="newsletter-section">
    <div class="container">
        <div class="newsletter-inner">
            <div class="section-label" style="text-align:center;">Newsletter</div>
            <h2 class="section-title">Jangan Lewatkan<br>Satu Acara pun</h2>
            <p>Daftar newsletter dan dapatkan info acara terbaru, penawaran eksklusif, dan promo tiket langsung di inbox kamu.</p>
            <form action="#" method="POST" class="newsletter-form">
                @csrf
                <input type="email" name="email" class="newsletter-input" placeholder="Masukkan alamat email kamu..." required>
                <button type="submit" class="btn-primary newsletter-btn">
                    Langganan
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Wishlist toggle
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            this.textContent = this.textContent === '♡' ? '♥' : '♡';
            this.style.color = this.textContent === '♥' ? '#FF4D00' : 'white';
        });
    });

    // Promo code copy
    const promoCode = document.querySelector('.promo-code-text');
    if (promoCode) {
        promoCode.style.cursor = 'pointer';
        promoCode.title = 'Klik untuk menyalin';
        promoCode.addEventListener('click', function() {
            navigator.clipboard.writeText('TIKETIN30').then(() => {
                const original = this.textContent;
                this.textContent = '✓ Tersalin!';
                setTimeout(() => this.textContent = original, 1500);
            });
        });
    }
</script>
@endsection