@extends('layouts.app')

@section('title', 'Edit Payment')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Edit Payment</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('payments.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('payments.update', $payment) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="col-12">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Informasi Payment
                        </h6>

                        <div class="mb-4">
                            <label class="form-label">Order Id</label>
                            <select name="order_id" class="form-select @error('order_id') is-invalid @enderror">
                                <option value="">-- Pilih Order Id --</option>
                                @foreach ($orders as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('order_id', $payment->order_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('order_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <input type="text" name="payment_method"
                                class="form-control @error('payment_method') is-invalid @enderror"
                                value="{{ old('payment_method', $payment->payment_method) }}"
                                placeholder="Masukkan Payment Method" required />
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="amount" min="0" step="0.01"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount', $payment->amount) }}" required />
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Payment Gateway <span class="text-danger">*</span></label>
                            <input type="text" name="payment_gateway"
                                class="form-control @error('payment_gateway') is-invalid @enderror"
                                value="{{ old('payment_gateway', $payment->payment_gateway) }}"
                                placeholder="Masukkan Payment Gateway" required />
                            @error('payment_gateway')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Transaction Id</label>
                            <select name="transaction_id" class="form-select @error('transaction_id') is-invalid @enderror">
                                <option value="">-- Pilih Transaction Id --</option>
                                @foreach ($transactions as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('transaction_id', $payment->transaction_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('transaction_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                {{-- Sesuaikan opsi dengan enum di database --}}
                                <option value="">-- Pilih Status --</option>
                                <option value="active" {{ old('status', $payment->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $payment->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Paid At</label>
                            <input type="datetime-local" name="paid_at"
                                class="form-control @error('paid_at') is-invalid @enderror"
                                value="{{ old('paid_at', $payment->paid_at) ? date('Y-m-d\TH:i', strtotime(old('paid_at', $payment->paid_at))) : '' }}" />
                            @error('paid_at')
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
                            <i class="ti ti-check me-1"></i> Update Payment
                        </button>
                        <a href="{{ route('payments.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>

                @if(can('payments.delete'))
                    <div class="card card-lg border-danger">
                        <div class="card-body">
                            <h6 class="mb-1 text-danger">Danger Zone</h6>
                            <p class="text-muted small mb-3">Tindakan ini tidak bisa dibatalkan.</p>
                            <form action="{{ route('payments.destroy', $payment) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger w-100"
                                    data-confirm="Yakin hapus Payment ini? Tidak bisa dibatalkan!">
                                    <i class="ti ti-trash me-1"></i> Hapus Payment Ini
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </form>

@endsection
