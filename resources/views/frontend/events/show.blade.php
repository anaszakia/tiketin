@extends('frontend.layout')

@section('title', $event->name . ' - ' . config('app.name', 'Tiketin'))

@section('content')
    <main class="section">
        <div class="shell">
            <div class="detail-media">
                @if($event->banner)
                    <img src="{{ minio_url($event->banner) }}" alt="{{ $event->name }}">
                @else
                    <div class="image-fallback">{{ $event->name }}</div>
                @endif
            </div>

            <div class="split" style="margin-top:24px;">
                <div>
                    <div class="panel">
                        <div class="panel-body">
                            <div class="meta" style="margin-bottom:12px;">
                                <span>{{ $event->category->name ?? 'Event' }}</span>
                                <span>{{ $event->organizer->organizer_name ?? 'Organizer' }}</span>
                                <span>{{ $event->status }}</span>
                            </div>
                            <h1 style="font-size:42px; margin-bottom:12px;">{{ $event->name }}</h1>
                            <p style="font-size:16px;">{{ $event->short_description ?: $event->description }}</p>

                            <div class="fact-grid">
                                <div class="fact">
                                    <strong>Tanggal</strong>
                                    <p style="margin:6px 0 0;">{{ $event->start_date ? date('d M Y, H:i', strtotime($event->start_date)) : 'Menyusul' }}</p>
                                </div>
                                <div class="fact">
                                    <strong>Lokasi</strong>
                                    <p style="margin:6px 0 0;">{{ $event->venue_name ?: $event->location }}</p>
                                </div>
                                <div class="fact">
                                    <strong>Kapasitas</strong>
                                    <p style="margin:6px 0 0;">{{ number_format($event->capacity) }} orang</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel" style="margin-top:18px;">
                        <div class="panel-body">
                            <h2>Detail Event</h2>
                            <p>{!! nl2br(e($event->description ?: '-')) !!}</p>

                            @if($event->gallery_images)
                                <div class="grid" style="margin-top:18px;">
                                    @foreach($event->gallery_images as $image)
                                        <div class="event-card-img" style="border-radius:8px;">
                                            <img src="{{ minio_url($image) }}" alt="Gallery {{ $loop->iteration }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="panel" style="margin-top:18px;">
                        <div class="panel-body">
                            <h2>Lokasi, Rundown, dan Ketentuan</h2>
                            <div class="form-grid">
                                <div>
                                    <h3>Alamat</h3>
                                    <p>{{ $event->address_detail ?: $event->location }}</p>
                                    @if($event->map_url)
                                        <a class="btn" href="{{ $event->map_url }}" target="_blank" rel="noopener">Buka Maps</a>
                                    @endif
                                </div>
                                <div>
                                    <h3>Kontak</h3>
                                    <p>
                                        {{ $event->contact_name ?: '-' }}<br>
                                        {{ $event->contact_phone ?: '' }}<br>
                                        {{ $event->contact_email ?: '' }}
                                    </p>
                                </div>
                            </div>
                            <h3 style="margin-top:18px;">Rundown</h3>
                            <p>{!! nl2br(e($event->rundown ?: '-')) !!}</p>
                            <h3>Syarat dan Refund</h3>
                            <p>{!! nl2br(e($event->terms ?: '-')) !!}</p>
                            <p>{!! nl2br(e($event->refund_policy ?: '-')) !!}</p>
                        </div>
                    </div>
                </div>

                <aside class="panel" style="position:sticky; top:88px;">
                    <div class="panel-body">
                        <h2>Pilih Tiket</h2>
                        @forelse($event->tickets as $ticket)
                            <div class="ticket-row">
                                <div>
                                    <h3>{{ $ticket->name }}</h3>
                                    <p style="margin:0;">{{ $ticket->description ?: 'Kategori tiket event.' }}</p>
                                    <div class="price">Rp{{ number_format($ticket->price, 0, ',', '.') }}</div>
                                </div>
                                <span class="badge">{{ $ticket->status }}</span>
                            </div>
                        @empty
                            <p>Belum ada tiket aktif untuk event ini.</p>
                        @endforelse

                        <a class="btn btn-primary" style="width:100%; margin-top:16px;" href="{{ route('front.checkout', $event->slug) }}">
                            <span class="icon icon-cart"></span>
                            Beli Tiket
                        </a>
                    </div>
                </aside>
            </div>

            @if($relatedEvents->isNotEmpty())
                <section style="margin-top:28px;">
                    <h2>Event Terkait</h2>
                    <div class="grid">
                        @foreach($relatedEvents as $relatedEvent)
                            <article class="event-card">
                                <a href="{{ route('front.events.show', $relatedEvent->slug) }}" class="event-card-img">
                                    @if($relatedEvent->banner)
                                        <img src="{{ minio_url($relatedEvent->banner) }}" alt="{{ $relatedEvent->name }}">
                                    @else
                                        <div class="image-fallback">Tiketin</div>
                                    @endif
                                </a>
                                <div class="event-card-body">
                                    <h3>{{ $relatedEvent->name }}</h3>
                                    <p style="margin:0;">{{ $relatedEvent->location }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </main>
@endsection
