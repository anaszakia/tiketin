@extends('layouts.app')

@section('title', 'Edit Event')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Edit Event</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('events.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.events._form', [
            'event' => $event,
            'submitLabel' => 'Update Event',
            'eventOrganizers' => $eventOrganizers,
            'eventCategories' => $eventCategories,
        ])
    </form>

    @if(can('events.delete'))
        <form id="eventDeleteForm" action="{{ route('events.destroy', $event) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endif

@endsection
