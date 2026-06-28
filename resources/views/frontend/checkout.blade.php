@extends('frontend.layout')

@section('title', 'Checkout ' . $event->name . ' - ' . config('app.name', 'Tiketin'))

@section('content')
    <main class="section">
        <div class="shell">
            <div style="margin-bottom:22px;">
                <div class="eyebrow">Checkout Tiket</div>
                <h1 style="font-size:40px;">{{ $event->name }}</h1>
                <p style="margin:0;">Pilih kategori tiket, isi data peserta, lalu lanjut ke pembayaran.</p>
            </div>

            <form action="#" method="POST" class="checkout-grid" id="checkoutForm">
                @csrf
                <div>
                    <section class="panel">
                        <div class="panel-body">
                            <h2>1. Pilih Jenis Tiket</h2>
                            @forelse($event->tickets as $ticket)
                                @php $available = max(0, $ticket->quota - $ticket->quota_sold); @endphp
                                <div class="ticket-row" data-ticket data-price="{{ $ticket->price }}">
                                    <div>
                                        <h3>{{ $ticket->name }}</h3>
                                        <p style="margin:0;">{{ $ticket->description ?: 'Kategori tiket event.' }}</p>
                                        <div class="meta" style="margin-top:8px;">
                                            <span>Stok {{ number_format($available) }}</span>
                                            <span>Rp{{ number_format($ticket->price, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                    <div class="qty">
                                        <button type="button" data-minus>-</button>
                                        <input type="number" name="tickets[{{ $ticket->id }}]" value="0" min="0" max="{{ $available }}" data-qty>
                                        <button type="button" data-plus>+</button>
                                    </div>
                                </div>
                            @empty
                                <p>Belum ada tiket aktif untuk dibeli.</p>
                            @endforelse
                        </div>
                    </section>

                    <section class="panel" style="margin-top:18px;">
                        <div class="panel-body">
                            <h2>2. Isi Data Pemesan</h2>
                            <div class="form-grid">
                                <label>
                                    Nama Lengkap
                                    <input class="field" type="text" name="buyer_name" placeholder="Nama sesuai identitas">
                                </label>
                                <label>
                                    Email
                                    <input class="field" type="email" name="buyer_email" placeholder="email@domain.com">
                                </label>
                                <label>
                                    No. HP
                                    <input class="field" type="text" name="buyer_phone" placeholder="08xxxxxxxxxx">
                                </label>
                                <label>
                                    Nomor Identitas
                                    <input class="field" type="text" name="buyer_identity" placeholder="KTP / SIM / Passport">
                                </label>
                            </div>
                        </div>
                    </section>

                    <section class="panel" style="margin-top:18px;">
                        <div class="panel-body">
                            <h2>3. Metode Pembayaran</h2>
                            <div class="form-grid">
                                <label class="choice">
                                    <input type="radio" name="payment_method" value="midtrans" checked>
                                    Payment Gateway
                                    <p style="margin:6px 0 0;">Midtrans, kartu, VA, e-wallet.</p>
                                </label>
                                <label class="choice">
                                    <input type="radio" name="payment_method" value="transfer">
                                    Transfer Manual
                                    <p style="margin:6px 0 0;">Upload bukti pembayaran.</p>
                                </label>
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="panel" style="position:sticky; top:88px;">
                    <div class="panel-body">
                        <h2>Ringkasan Pesanan</h2>
                        <div class="summary-line">
                            <span>Event</span>
                            <strong>{{ $event->name }}</strong>
                        </div>
                        <div class="summary-line">
                            <span>Total tiket</span>
                            <strong><span id="totalQty">0</span> tiket</strong>
                        </div>
                        <div class="summary-line">
                            <span>Subtotal</span>
                            <strong id="subtotal">Rp0</strong>
                        </div>
                        <div class="summary-line">
                            <span>Biaya layanan</span>
                            <strong id="serviceFee">Rp0</strong>
                        </div>
                        <div class="summary-line" style="border-bottom:0; font-size:18px;">
                            <span>Total Bayar</span>
                            <strong id="grandTotal">Rp0</strong>
                        </div>

                        <button type="button" class="btn btn-primary" style="width:100%; margin-top:16px;" disabled>
                            <span class="icon icon-cart"></span>
                            Lanjut Bayar
                        </button>
                        <p style="font-size:13px; margin-bottom:0;">Tombol pembayaran masih nonaktif karena tahap ini baru tampilan frontend. Nanti disambungkan ke pembuatan invoice dan payment gateway.</p>
                    </div>
                </aside>
            </form>
        </div>
    </main>

    <script>
        const formatter = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
        const ticketRows = document.querySelectorAll('[data-ticket]');
        const totalQtyEl = document.getElementById('totalQty');
        const subtotalEl = document.getElementById('subtotal');
        const serviceFeeEl = document.getElementById('serviceFee');
        const grandTotalEl = document.getElementById('grandTotal');

        function updateSummary() {
            let totalQty = 0;
            let subtotal = 0;

            ticketRows.forEach((row) => {
                const input = row.querySelector('[data-qty]');
                const qty = Math.max(0, Number(input.value || 0));
                const price = Number(row.dataset.price || 0);
                totalQty += qty;
                subtotal += qty * price;
            });

            const serviceFee = subtotal > 0 ? 5000 : 0;
            totalQtyEl.textContent = totalQty;
            subtotalEl.textContent = formatter.format(subtotal);
            serviceFeeEl.textContent = formatter.format(serviceFee);
            grandTotalEl.textContent = formatter.format(subtotal + serviceFee);
        }

        ticketRows.forEach((row) => {
            const input = row.querySelector('[data-qty]');
            row.querySelector('[data-minus]').addEventListener('click', () => {
                input.value = Math.max(Number(input.min || 0), Number(input.value || 0) - 1);
                updateSummary();
            });
            row.querySelector('[data-plus]').addEventListener('click', () => {
                input.value = Math.min(Number(input.max || 99), Number(input.value || 0) + 1);
                updateSummary();
            });
            input.addEventListener('input', updateSummary);
        });
    </script>
@endsection
