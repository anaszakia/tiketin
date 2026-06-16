@extends('layouts.app')

@section('title', 'Detail Event')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Detail Event</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if(can('events.edit'))
                <a href="{{ route('events.edit', $event) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
            @endif
            <a href="{{ route('events.index') }}" class="btn btn-white">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card card-lg">
        <div class="card-body">
            <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                Informasi Event
            </h6>
            <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="200">Organizer</td>
                            <td>{{ $event->organizer->organizer_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Category</td>
                            <td>{{ $event->category->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Name</td>
                            <td>{{ $event->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Slug</td>
                            <td>{{ $event->slug ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Description</td>
                            <td>{{ $event->description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Ringkasan</td>
                            <td>{{ $event->short_description ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Banner</td>
                            <td>
                                @if($event->banner)
                                    <img src="{{ minio_url($event->banner) }}" alt="Banner" class="rounded" style="max-height:120px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Location</td>
                            <td>{{ $event->location ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Venue</td>
                            <td>{{ $event->venue_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Alamat Detail</td>
                            <td>{{ $event->address_detail ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Kota/Provinsi</td>
                            <td>{{ trim(($event->city ?? '') . ' ' . ($event->province ?? '')) ?: '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Maps</td>
                            <td>
                                @if($event->map_url)
                                    <a href="{{ $event->map_url }}" target="_blank" rel="noopener">Buka Maps</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Start Date</td>
                            <td>{{ $event->start_date ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">End Date</td>
                            <td>{{ $event->end_date ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Capacity</td>
                            <td>{{ $event->capacity ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Minimal Usia</td>
                            <td>{{ $event->minimum_age !== null ? $event->minimum_age . ' tahun' : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Rundown</td>
                            <td>{!! nl2br(e($event->rundown ?? '-')) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Syarat</td>
                            <td>{!! nl2br(e($event->terms ?? '-')) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Refund</td>
                            <td>{!! nl2br(e($event->refund_policy ?? '-')) !!}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Kontak</td>
                            <td>
                                {{ $event->contact_name ?? '-' }}
                                @if($event->contact_phone)
                                    <div class="text-muted small">{{ $event->contact_phone }}</div>
                                @endif
                                @if($event->contact_email)
                                    <div class="text-muted small">{{ $event->contact_email }}</div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Gallery</td>
                            <td>
                                @if(! empty($event->gallery_images))
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($event->gallery_images as $path)
                                            <img src="{{ minio_url($path) }}" alt="Gallery" class="rounded object-fit-cover border" style="width:120px; height:80px;">
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Status</td>
                            <td><span class="badge bg-secondary">{{ $event->status }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Dibuat</td>
                            <td>{{ tgl_jam($event->created_at) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terakhir Update</td>
                            <td>{{ tgl_jam($event->updated_at) }}</td>
                        </tr>
            </table>
        </div>
    </div>

    <div class="card card-lg mt-4">
        <div class="card-body">
            <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                Kategori Tiket
            </h6>

            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Kuota</th>
                            <th>Terjual</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($event->tickets as $ticket)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $ticket->name }}</div>
                                    <div class="text-muted small">{{ $ticket->description }}</div>
                                </td>
                                <td>Rp{{ number_format($ticket->price, 0, ',', '.') }}</td>
                                <td>{{ $ticket->quota }}</td>
                                <td>{{ $ticket->quota_sold }}</td>
                                <td><span class="badge bg-secondary">{{ $ticket->status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada kategori tiket.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
