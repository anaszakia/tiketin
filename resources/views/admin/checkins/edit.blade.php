@extends('layouts.app')

@section('title', 'Edit Checkin')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Edit Checkin</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('checkins.index') }}">Checkins</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('checkins.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('checkins.update', $checkin) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
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
                                        {{ old('attendee_id', $checkin->attendee_id) == $item->id ? 'selected' : '' }}>
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
                                        {{ old('officer_id', $checkin->officer_id) == $item->id ? 'selected' : '' }}>
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
                                value="{{ old('checkin_at', $checkin->checkin_at) ? date('Y-m-d\TH:i', strtotime(old('checkin_at', $checkin->checkin_at))) : '' }}" />
                            @error('checkin_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Location </label>
                            <input type="text" name="location"
                                class="form-control @error('location') is-invalid @enderror"
                                value="{{ old('location', $checkin->location) }}"
                                placeholder="Masukkan Location" />
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Note</label>
                            <textarea name="note" rows="3"
                                class="form-control @error('note') is-invalid @enderror"
                                placeholder="Masukkan Note">{{ old('note', $checkin->note) }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="ti ti-check me-1"></i> Update Checkin
                        </button>
                        <a href="{{ route('checkins.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>

                @if(can('checkins.delete'))
                    <div class="card card-lg border-danger">
                        <div class="card-body">
                            <h6 class="mb-1 text-danger">Danger Zone</h6>
                            <p class="text-muted small mb-3">Tindakan ini tidak bisa dibatalkan.</p>
                            <form action="{{ route('checkins.destroy', $checkin) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger w-100"
                                    data-confirm="Yakin hapus Checkin ini? Tidak bisa dibatalkan!">
                                    <i class="ti ti-trash me-1"></i> Hapus Checkin Ini
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </form>

@endsection
