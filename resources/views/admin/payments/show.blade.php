@extends('layouts.app')

@section('title', 'Detail Payment')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Detail Payment</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Payments</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if(can('payments.edit'))
                <a href="{{ route('payments.edit', $payment) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
            @endif
            <a href="{{ route('payments.index') }}" class="btn btn-white">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card card-lg">
        <div class="card-body">
            <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                Informasi Payment
            </h6>
            <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted" width="200">Order Id</td>
                            <td>{{ $payment->order->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Payment Method</td>
                            <td>{{ $payment->payment_method ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Amount</td>
                            <td>{{ $payment->amount ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Payment Gateway</td>
                            <td>{{ $payment->payment_gateway ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Transaction Id</td>
                            <td>{{ $payment->transaction->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Status</td>
                            <td><span class="badge bg-secondary">{{ $payment->status }}</span></td>
                        </tr>
                        <tr>
                            <td class="text-muted" width="200">Paid At</td>
                            <td>{{ $payment->paid_at ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Dibuat</td>
                            <td>{{ tgl_jam($payment->created_at) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terakhir Update</td>
                            <td>{{ tgl_jam($payment->updated_at) }}</td>
                        </tr>
            </table>
        </div>
    </div>

@endsection