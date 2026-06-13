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
                            <td class="text-muted" width="200">Organizer Id</td>
                            <td>{{ $event->organizer->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Category Id</td>
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

@endsection