<!-- ─── FOOTER ─── -->
    <footer class="footer">
        <div class="footer-top">
            <div class="footer-brand">
                <a href="{{ url('/') }}" class="footer-logo">
                    <div class="logo-mark">TK</div>
                    <span class="logo-text">TIKET<span>IN</span></span>
                </a>
                <p class="footer-tagline">Platform tiket event terpercaya.<br>Temukan, beli, dan nikmati pengalaman tak terlupakan.</p>
                <div class="footer-socials">
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="Twitter/X"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-nav">
                <div class="footer-col">
                    <h4>Platform</h4>
                    <ul>
                        <li><a href="{{ url('/events') }}">Semua Event</a></li>
                        <li><a href="{{ url('/kategori') }}">Kategori Event</a></li>
                        <li><a href="#">Event Populer</a></li>
                        <li><a href="#">Event Gratis</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Penyelenggara</h4>
                    <ul>
                        <li><a href="#">Buat Event</a></li>
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Kelola Tiket</a></li>
                        <li><a href="#">Laporan Penjualan</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Bantuan</h4>
                    <ul>
                        <li><a href="#">Pusat Bantuan</a></li>
                        <li><a href="#">Cara Pembelian</a></li>
                        <li><a href="#">Kebijakan Refund</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Perusahaan</h4>
                    <ul>
                        <li><a href="{{ url('/tentang') }}">Tentang Kami</a></li>
                        <li><a href="#">Karir</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Press Kit</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="footer-copy">© {{ date('Y') }} TIKETIN. Seluruh hak cipta dilindungi.</p>
            <div class="footer-legal">
                <a href="#">Syarat & Ketentuan</a>
                <span>·</span>
                <a href="#">Kebijakan Privasi</a>
                <span>·</span>
                <a href="#">Cookie</a>
            </div>
            <div class="footer-payment">
                <span>Metode Pembayaran:</span>
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/visa.svg" alt="Visa" title="Visa">
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/mastercard.svg" alt="Mastercard" title="Mastercard">
                <img src="https://cdn.jsdelivr.net/gh/simple-icons/simple-icons/icons/gopay.svg" alt="GoPay" title="GoPay">
            </div>
        </div>
    </footer>

    <style>
        /* ─── FOOTER STYLES ─── */
        .footer {
            background: var(--dark-2);
            border-top: 1px solid var(--border);
            padding: 70px 5% 30px;
            margin-top: auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 60px;
            padding-bottom: 50px;
            border-bottom: 1px solid var(--border);
        }

        /* Brand */
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            margin-bottom: 18px;
        }

        .footer-tagline {
            color: var(--text-muted);
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .footer-socials {
            display: flex;
            gap: 10px;
        }

        .footer-socials a {
            width: 38px;
            height: 38px;
            border: 1px solid var(--border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 15px;
            transition: all 0.2s;
        }

        .footer-socials a:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-glow);
        }

        /* Nav Grid */
        .footer-nav {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .footer-col h4 {
            font-family: var(--font-display);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text);
            margin-bottom: 18px;
        }

        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-col ul a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .footer-col ul a:hover { color: var(--text); }

        /* Bottom */
        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            padding-top: 28px;
        }

        .footer-copy {
            color: var(--text-muted);
            font-size: 13px;
        }

        .footer-legal {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-muted);
            font-size: 13px;
        }

        .footer-legal a {
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-legal a:hover { color: var(--text); }

        .footer-payment {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: var(--text-muted);
        }

        .footer-payment img {
            height: 20px;
            opacity: 0.5;
            filter: brightness(10);
        }

        @media (max-width: 1024px) {
            .footer-top { grid-template-columns: 1fr; gap: 40px; }
        }

        @media (max-width: 768px) {
            .footer-nav { grid-template-columns: repeat(2, 1fr); }
            .footer-bottom { flex-direction: column; align-items: flex-start; gap: 12px; }
        }

        @media (max-width: 480px) {
            .footer-nav { grid-template-columns: 1fr 1fr; }
        }
    </style>

</body>
</html>