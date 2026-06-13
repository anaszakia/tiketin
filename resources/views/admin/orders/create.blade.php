@extends('layouts.app')

@section('title', 'Tambah Order')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Tambah Order</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-12">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Informasi Order
                        </h6>

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
                            <label class="form-label">Invoice Number <span class="text-danger">*</span></label>
                            <input type="text" name="invoice_number"
                                class="form-control @error('invoice_number') is-invalid @enderror"
                                value="{{ old('invoice_number') }}"
                                placeholder="Masukkan Invoice Number" required />
                            @error('invoice_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Total Amount <span class="text-danger">*</span></label>
                            <input type="text" name="total_amount"
                                class="form-control @error('total_amount') is-invalid @enderror"
                                value="{{ old('total_amount') }}"
                                placeholder="Masukkan Total Amount" required />
                            @error('total_amount')
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

                        <div class="mb-4">
                            <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <input type="text" name="payment_method"
                                class="form-control @error('payment_method') is-invalid @enderror"
                                value="{{ old('payment_method') }}"
                                placeholder="Masukkan Payment Method" required />
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Payment Status <span class="text-danger">*</span></label>
                            <input type="text" name="payment_status"
                                class="form-control @error('payment_status') is-invalid @enderror"
                                value="{{ old('payment_status') }}"
                                placeholder="Masukkan Payment Status" required />
                            @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Paid At</label>
                            <input type="datetime-local" name="paid_at"
                                class="form-control @error('paid_at') is-invalid @enderror"
                                value="{{ old('paid_at') ? date('Y-m-d\TH:i', strtotime(old('paid_at'))) : '' }}" />
                            @error('paid_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Expired At <span class="text-danger">*</span></label>
                            <input type="text" name="expired_at"
                                class="form-control @error('expired_at') is-invalid @enderror"
                                value="{{ old('expired_at') }}"
                                placeholder="Masukkan Expired At" required />
                            @error('expired_at')
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
                            <i class="ti ti-check me-1"></i> Simpan Order
                        </button>
                        <a href="{{ route('orders.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection
