@extends('layouts.app')

@section('title', 'Tambah Event')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Tambah Event</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('events.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.events._form', [
            'event' => null,
            'submitLabel' => 'Simpan Event',
            'eventOrganizers' => $eventOrganizers,
            'eventCategories' => $eventCategories,
        ])
    </form>

@endsection
