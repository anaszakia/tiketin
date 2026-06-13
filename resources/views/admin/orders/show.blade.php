@extends('layouts.app')

@section('title', 'Detail Order')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Detail Order</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Orders</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if(can('orders.edit'))
                <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
            @endif
            <a href="{{ route('orders.index') }}" class="btn btn-white">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card card-lg">
        <div class="card-body">
            <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                Informasi Order
            </h6>
            <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="200">User Id</td>
                            <td>{{ $order->user->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Event Id</td>
                            <td>{{ $order->event->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Invoice Number</td>
                            <td>{{ $order->invoice_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Total Amount</td>
                            <td>{{ $order->total_amount ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Status</td>
                            <td><span class="badge bg-secondary">{{ $order->status }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Payment Method</td>
                            <td>{{ $order->payment_method ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Payment Status</td>
                            <td>{{ $order->payment_status ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Paid At</td>
                            <td>{{ $order->paid_at ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Expired At</td>
                            <td>{{ $order->expired_at ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Dibuat</td>
                            <td>{{ tgl_jam($order->created_at) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terakhir Update</td>
                            <td>{{ tgl_jam($order->updated_at) }}</td>
                        </tr>
            </table>
        </div>
    </div>

@endsection