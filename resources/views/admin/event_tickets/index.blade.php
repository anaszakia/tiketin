@extends('layouts.app')

@section('title', 'Event Tickets')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Event Tickets</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Event Tickets</li>
                </ol>
            </nav>
        </div>
        @if(can('event_tickets.create'))
            <a href="{{ route('event_tickets.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Tambah Event Ticket
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
                            <th>Event Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quota</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($eventTickets as $eventTicket)
                            <tr>
                                <td>{{ $eventTickets->firstItem() + $loop->index }}</td>
                                <td>{{ $eventTicket->event->name ?? '-' }}</td>
                                <td>{{ $eventTicket->name ?? '-' }}</td>
                                <td>{{ $eventTicket->description ?? '-' }}</td>
                                <td>{{ $eventTicket->price ?? '-' }}</td>
                                <td>{{ $eventTicket->quota ?? '-' }}</td>
                                <td>{{ tgl_indo($eventTicket->created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(can('event_tickets.view'))
                                            <a href="{{ route('event_tickets.show', $eventTicket) }}"
                                                class="btn btn-sm btn-white" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        @endif
                                        @if(can('event_tickets.edit'))
                                            <a href="{{ route('event_tickets.edit', $eventTicket) }}"
                                                class="btn btn-sm btn-white" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        @endif
                                        @if(can('event_tickets.delete'))
                                            <form action="{{ route('event_tickets.destroy', $eventTicket) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger"
                                                    data-confirm="Yakin hapus Event Ticket ini?"
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
                                    Belum ada data Event Ticket.
                                    <a href="{{ route('event_tickets.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($eventTickets->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $eventTickets->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection