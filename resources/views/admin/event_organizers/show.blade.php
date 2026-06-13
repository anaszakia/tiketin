@extends('layouts.app')

@section('title', 'Detail Event Organizer')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Detail Event Organizer</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event_organizers.index') }}">Event Organizers</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if(can('event_organizers.edit'))
                <a href="{{ route('event_organizers.edit', $eventOrganizer) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
            @endif
            <a href="{{ route('event_organizers.index') }}" class="btn btn-white">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card card-lg">
        <div class="card-body">
            <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                Informasi Event Organizer
            </h6>
            <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="200">User Id</td>
                            <td>{{ $eventOrganizer->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Organizer Name</td>
                            <td>{{ $eventOrganizer->organizer_name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Phone</td>
                            <td>{{ $eventOrganizer->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Address</td>
                            <td>{{ $eventOrganizer->address ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Npwp</td>
                            <td>{{ $eventOrganizer->npwp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Logo</td>
                            <td>
                                @if($eventOrganizer->logo)
                                    <img src="{{ minio_url($eventOrganizer->logo) }}" alt="Logo" class="rounded" style="max-height:120px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Dibuat</td>
                            <td>{{ tgl_jam($eventOrganizer->created_at) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terakhir Update</td>
                            <td>{{ tgl_jam($eventOrganizer->updated_at) }}</td>
                        </tr>
            </table>
        </div>
    </div>

@endsection