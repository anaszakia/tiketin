@extends('layouts.app')

@section('title', 'Detail Attendee')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Detail Attendee</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('attendees.index') }}">Attendees</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if(can('attendees.edit'))
                <a href="{{ route('attendees.edit', $attendee) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
            @endif
            <a href="{{ route('attendees.index') }}" class="btn btn-white">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card card-lg">
        <div class="card-body">
            <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                Informasi Attendee
            </h6>
            <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="200">Order Item Id</td>
                            <td>{{ $attendee->orderItem->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Name</td>
                            <td>{{ $attendee->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Email</td>
                            <td>{{ $attendee->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Phone</td>
                            <td>{{ $attendee->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Ticket Code</td>
                            <td>{{ $attendee->ticket_code ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Qr Code</td>
                            <td>{{ $attendee->qr_code ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Status</td>
                            <td><span class="badge bg-secondary">{{ $attendee->status }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Dibuat</td>
                            <td>{{ tgl_jam($attendee->created_at) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terakhir Update</td>
                            <td>{{ tgl_jam($attendee->updated_at) }}</td>
                        </tr>
            </table>
        </div>
    </div>

@endsection