@extends('layouts.app')

@section('title', 'Detail Order Item')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Detail Order Item</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('order_items.index') }}">Order Items</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if(can('order_items.edit'))
                <a href="{{ route('order_items.edit', $orderItem) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
            @endif
            <a href="{{ route('order_items.index') }}" class="btn btn-white">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card card-lg">
        <div class="card-body">
            <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                Informasi Order Item
            </h6>
            <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="200">Order Id</td>
                            <td>{{ $orderItem->order->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Ticket Id</td>
                            <td>{{ $orderItem->ticket->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Price</td>
                            <td>{{ $orderItem->price ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Discount</td>
                            <td>{{ $orderItem->discount ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Qty</td>
                            <td>{{ $orderItem->qty ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Subtotal</td>
                            <td>{{ $orderItem->subtotal ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Dibuat</td>
                            <td>{{ tgl_jam($orderItem->created_at) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terakhir Update</td>
                            <td>{{ tgl_jam($orderItem->updated_at) }}</td>
                        </tr>
            </table>
        </div>
    </div>

@endsection