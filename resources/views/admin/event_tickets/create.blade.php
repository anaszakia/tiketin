@extends('layouts.app')

@section('title', 'Tambah Event Ticket')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Tambah Event Ticket</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event_tickets.index') }}">Event Tickets</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('event_tickets.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('event_tickets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-12">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Informasi Event Ticket
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
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Masukkan Name" required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Masukkan Description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" min="0" step="0.01"
                                    class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}" required />
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Quota <span class="text-danger">*</span></label>
                            <input type="number" name="quota" min="0"
                                class="form-control @error('quota') is-invalid @enderror"
                                value="{{ old('quota') }}" required />
                            @error('quota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Sales Start</label>
                            <input type="datetime-local" name="sales_start"
                                class="form-control @error('sales_start') is-invalid @enderror"
                                value="{{ old('sales_start') ? date('Y-m-d\TH:i', strtotime(old('sales_start'))) : '' }}" />
                            @error('sales_start')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Sales End</label>
                            <input type="datetime-local" name="sales_end"
                                class="form-control @error('sales_end') is-invalid @enderror"
                                value="{{ old('sales_end') ? date('Y-m-d\TH:i', strtotime(old('sales_end'))) : '' }}" />
                            @error('sales_end')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                {{-- Sesuaikan opsi dengan enum di database --}}
                                <option value="">-- Pilih Status --</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
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
                            <i class="ti ti-check me-1"></i> Simpan Event Ticket
                        </button>
                        <a href="{{ route('event_tickets.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection
