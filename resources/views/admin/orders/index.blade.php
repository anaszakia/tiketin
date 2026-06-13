@extends('layouts.app')

@section('title', 'Orders')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Orders</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Orders</li>
                </ol>
            </nav>
        </div>
        @if(can('orders.create'))
            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Tambah Order
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
                            <th>User Id</th>
                            <th>Event Id</th>
                            <th>Invoice Number</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $orders->firstItem() + $loop->index }}</td>
                                <td>{{ $order->user->name ?? '-' }}</td>
                                <td>{{ $order->event->name ?? '-' }}</td>
                                <td>{{ $order->invoice_number ?? '-' }}</td>
                                <td>{{ $order->total_amount ?? '-' }}</td>
                                <td><span class="badge bg-secondary">{{ $order->status }}</span></td>
                                <td>{{ tgl_indo($order->created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(can('orders.view'))
                                            <a href="{{ route('orders.show', $order) }}"
                                                class="btn btn-sm btn-white" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        @endif
                                        @if(can('orders.edit'))
                                            <a href="{{ route('orders.edit', $order) }}"
                                                class="btn btn-sm btn-white" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        @endif
                                        @if(can('orders.delete'))
                                            <form action="{{ route('orders.destroy', $order) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger"
                                                    data-confirm="Yakin hapus Order ini?"
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
                                    Belum ada data Order.
                                    <a href="{{ route('orders.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection