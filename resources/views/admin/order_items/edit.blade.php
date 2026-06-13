@extends('layouts.app')

@section('title', 'Edit Order Item')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Edit Order Item</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('order_items.index') }}">Order Items</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('order_items.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('order_items.update', $orderItem) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="col-12">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Informasi Order Item
                        </h6>

                        <div class="mb-4">
                            <label class="form-label">Order Id</label>
                            <select name="order_id" class="form-select @error('order_id') is-invalid @enderror">
                                <option value="">-- Pilih Order Id --</option>
                                @foreach ($orders as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('order_id', $orderItem->order_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('order_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Ticket Id</label>
                            <select name="ticket_id" class="form-select @error('ticket_id') is-invalid @enderror">
                                <option value="">-- Pilih Ticket Id --</option>
                                @foreach ($tickets as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('ticket_id', $orderItem->ticket_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ticket_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" min="0" step="0.01"
                                    class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price', $orderItem->price) }}" required />
                            </div>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Discount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="discount" min="0" step="0.01"
                                    class="form-control @error('discount') is-invalid @enderror"
                                    value="{{ old('discount', $orderItem->discount) }}" required />
                            </div>
                            @error('discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Qty <span class="text-danger">*</span></label>
                            <input type="number" name="qty" min="0"
                                class="form-control @error('qty') is-invalid @enderror"
                                value="{{ old('qty', $orderItem->qty) }}" required />
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Subtotal <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="subtotal" min="0" step="0.01"
                                    class="form-control @error('subtotal') is-invalid @enderror"
                                    value="{{ old('subtotal', $orderItem->subtotal) }}" required />
                            </div>
                            @error('subtotal')
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
                            <i class="ti ti-check me-1"></i> Update Order Item
                        </button>
                        <a href="{{ route('order_items.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>

                @if(can('order_items.delete'))
                    <div class="card card-lg border-danger">
                        <div class="card-body">
                            <h6 class="mb-1 text-danger">Danger Zone</h6>
                            <p class="text-muted small mb-3">Tindakan ini tidak bisa dibatalkan.</p>
                            <form action="{{ route('order_items.destroy', $orderItem) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger w-100"
                                    data-confirm="Yakin hapus Order Item ini? Tidak bisa dibatalkan!">
                                    <i class="ti ti-trash me-1"></i> Hapus Order Item Ini
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </form>

@endsection
