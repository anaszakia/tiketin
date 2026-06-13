@extends('layouts.app')

@section('title', 'Detail Event Staff')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Detail Event Staff</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event_staff.index') }}">Event Staffs</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if(can('event_staff.edit'))
                <a href="{{ route('event_staff.edit', $eventStaff) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
            @endif
            <a href="{{ route('event_staff.index') }}" class="btn btn-white">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card card-lg">
        <div class="card-body">
            <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                Informasi Event Staff
            </h6>
            <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="200">Event Id</td>
                            <td>{{ $eventStaff->event->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">User Id</td>
                            <td>{{ $eventStaff->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Event Role Id</td>
                            <td>{{ $eventStaff->eventRole->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Dibuat</td>
                            <td>{{ tgl_jam($eventStaff->created_at) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terakhir Update</td>
                            <td>{{ tgl_jam($eventStaff->updated_at) }}</td>
                        </tr>
            </table>
        </div>
    </div>

@endsection