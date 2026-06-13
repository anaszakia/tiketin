@extends('layouts.app')

@section('title', 'Order Items')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Order Items</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Order Items</li>
                </ol>
            </nav>
        </div>
        @if(can('order_items.create'))
            <a href="{{ route('order_items.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Tambah Order Item
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
                            <th>Ticket Id</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Qty</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orderItems as $orderItem)
                            <tr>
                                <td>{{ $orderItems->firstItem() + $loop->index }}</td>
                                <td>{{ $orderItem->order->name ?? '-' }}</td>
                                <td>{{ $orderItem->ticket->name ?? '-' }}</td>
                                <td>{{ $orderItem->price ?? '-' }}</td>
                                <td>{{ $orderItem->discount ?? '-' }}</td>
                                <td>{{ $orderItem->qty ?? '-' }}</td>
                                <td>{{ tgl_indo($orderItem->created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(can('order_items.view'))
                                            <a href="{{ route('order_items.show', $orderItem) }}"
                                                class="btn btn-sm btn-white" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        @endif
                                        @if(can('order_items.edit'))
                                            <a href="{{ route('order_items.edit', $orderItem) }}"
                                                class="btn btn-sm btn-white" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        @endif
                                        @if(can('order_items.delete'))
                                            <form action="{{ route('order_items.destroy', $orderItem) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger"
                                                    data-confirm="Yakin hapus Order Item ini?"
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
                                    Belum ada data Order Item.
                                    <a href="{{ route('order_items.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orderItems->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $orderItems->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection