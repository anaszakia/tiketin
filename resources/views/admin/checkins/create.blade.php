@extends('layouts.app')

@section('title', 'Tambah Checkin')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Tambah Checkin</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('checkins.index') }}">Checkins</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('checkins.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('checkins.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-12">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Informasi Checkin
                        </h6>

                        <div class="mb-4">
                            <label class="form-label">Attendee Id</label>
                            <select name="attendee_id" class="form-select @error('attendee_id') is-invalid @enderror">
                                <option value="">-- Pilih Attendee Id --</option>
                                @foreach ($attendees as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('attendee_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('attendee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Officer Id</label>
                            <select name="officer_id" class="form-select @error('officer_id') is-invalid @enderror">
                                <option value="">-- Pilih Officer Id --</option>
                                @foreach ($officers as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('officer_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('officer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Checkin At</label>
                            <input type="datetime-local" name="checkin_at"
                                class="form-control @error('checkin_at') is-invalid @enderror"
                                value="{{ old('checkin_at') ? date('Y-m-d\TH:i', strtotime(old('checkin_at'))) : '' }}" />
                            @error('checkin_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Location </label>
                            <input type="text" name="location"
                                class="form-control @error('location') is-invalid @enderror"
                                value="{{ old('location') }}"
                                placeholder="Masukkan Location" />
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Note</label>
                            <textarea name="note" rows="3"
                                class="form-control @error('note') is-invalid @enderror"
                                placeholder="Masukkan Note">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card card-lg">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="ti ti-check me-1"></i> Simpan Checkin
                        </button>
                        <a href="{{ route('checkins.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection
