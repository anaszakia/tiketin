@extends('layouts.app')

@section('title', 'Detail Event Category')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Detail Event Category</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event_categories.index') }}">Event Categories</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if(can('event_categories.edit'))
                <a href="{{ route('event_categories.edit', $eventCategory) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
            @endif
            <a href="{{ route('event_categories.index') }}" class="btn btn-white">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card card-lg">
        <div class="card-body">
            <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                Informasi Event Category
            </h6>
            <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="200">Name</td>
                            <td>{{ $eventCategory->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Slug</td>
                            <td>{{ $eventCategory->slug ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Dibuat</td>
                            <td>{{ tgl_jam($eventCategory->created_at) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terakhir Update</td>
                            <td>{{ tgl_jam($eventCategory->updated_at) }}</td>
                        </tr>
            </table>
        </div>
    </div>

@endsection