@extends('layouts.app')

@section('title', 'Tambah Event Staff')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Tambah Event Staff</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event_staff.index') }}">Event Staffs</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('event_staff.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('event_staff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-12">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Informasi Event Staff
                        </h6>

                        <div class="mb-4">
                            <label class="form-label">Event Id</label>
                            <select name="event_id" class="form-select @error('event_id') is-invalid @enderror">
                                <option value="">-- Pilih Event Id --</option>
                                @foreach ($events as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('event_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('event_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">User Id</label>
                            <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                <option value="">-- Pilih User Id --</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('user_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Event Role Id</label>
                            <select name="event_role_id" class="form-select @error('event_role_id') is-invalid @enderror">
                                <option value="">-- Pilih Event Role Id --</option>
                                @foreach ($eventRoles as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('event_role_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('event_role_id')
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
                            <i class="ti ti-check me-1"></i> Simpan Event Staff
                        </button>
                        <a href="{{ route('event_staff.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection
