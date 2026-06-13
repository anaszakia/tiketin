@extends('layouts.app')

@section('title', 'Edit Attendee')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Edit Attendee</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('attendees.index') }}">Attendees</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('attendees.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('attendees.update', $attendee) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="col-12">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Informasi Attendee
                        </h6>

                        <div class="mb-4">
                            <label class="form-label">Order Item Id</label>
                            <select name="order_item_id" class="form-select @error('order_item_id') is-invalid @enderror">
                                <option value="">-- Pilih Order Item Id --</option>
                                @foreach ($orderItems as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('order_item_id', $attendee->order_item_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('order_item_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $attendee->name) }}"
                                placeholder="Masukkan Name" required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $attendee->email) }}"
                                placeholder="Masukkan Email" required />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Phone </label>
                            <input type="text" name="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $attendee->phone) }}"
                                placeholder="Masukkan Phone" />
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Ticket Code </label>
                            <input type="text" name="ticket_code"
                                class="form-control @error('ticket_code') is-invalid @enderror"
                                value="{{ old('ticket_code', $attendee->ticket_code) }}"
                                placeholder="Masukkan Ticket Code" />
                            @error('ticket_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Qr Code </label>
                            <input type="text" name="qr_code"
                                class="form-control @error('qr_code') is-invalid @enderror"
                                value="{{ old('qr_code', $attendee->qr_code) }}"
                                placeholder="Masukkan Qr Code" />
                            @error('qr_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                {{-- Sesuaikan opsi dengan enum di database --}}
                                <option value="">-- Pilih Status --</option>
                                <option value="active" {{ old('status', $attendee->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $attendee->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
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
                            <i class="ti ti-check me-1"></i> Update Attendee
                        </button>
                        <a href="{{ route('attendees.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>

                @if(can('attendees.delete'))
                    <div class="card card-lg border-danger">
                        <div class="card-body">
                            <h6 class="mb-1 text-danger">Danger Zone</h6>
                            <p class="text-muted small mb-3">Tindakan ini tidak bisa dibatalkan.</p>
                            <form action="{{ route('attendees.destroy', $attendee) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger w-100"
                                    data-confirm="Yakin hapus Attendee ini? Tidak bisa dibatalkan!">
                                    <i class="ti ti-trash me-1"></i> Hapus Attendee Ini
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </form>

@endsection
