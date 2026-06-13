@extends('layouts.app')

@section('title', 'Payments')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Payments</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Payments</li>
                </ol>
            </nav>
        </div>
        @if(can('payments.create'))
            <a href="{{ route('payments.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Tambah Payment
            </a>
        @endif
    </div>

    <div class="card card-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-centered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Id</th>
                            <th>Payment Method</th>
                            <th>Amount</th>
                            <th>Payment Gateway</th>
                            <th>Transaction Id</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $payments->firstItem() + $loop->index }}</td>
                                <td>{{ $payment->order->name ?? '-' }}</td>
                                <td>{{ $payment->payment_method ?? '-' }}</td>
                                <td>{{ $payment->amount ?? '-' }}</td>
                                <td>{{ $payment->payment_gateway ?? '-' }}</td>
                                <td>{{ $payment->transaction->name ?? '-' }}</td>
                                <td>{{ tgl_indo($payment->created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(can('payments.view'))
                                            <a href="{{ route('payments.show', $payment) }}"
                                                class="btn btn-sm btn-white" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        @endif
                                        @if(can('payments.edit'))
                                            <a href="{{ route('payments.edit', $payment) }}"
                                                class="btn btn-sm btn-white" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        @endif
                                        @if(can('payments.delete'))
                                            <form action="{{ route('payments.destroy', $payment) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger"
                                                    data-confirm="Yakin hapus Payment ini?"
                                                    title="Hapus">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-6">
                                    Belum ada data Payment.
                                    <a href="{{ route('payments.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($payments->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection