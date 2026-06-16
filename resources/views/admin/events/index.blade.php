@extends('layouts.app')

@section('title', 'Events')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Events</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Events</li>
                </ol>
            </nav>
        </div>
        @if(can('events.create'))
            <a href="{{ route('events.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Tambah Event
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
                            <th>Organizer</th>
                            <th>Category</th>
                            <th>Event</th>
                            <th>Tiket</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $event)
                            <tr>
                                <td>{{ $events->firstItem() + $loop->index }}</td>
                                <td>{{ $event->organizer->organizer_name ?? '-' }}</td>
                                <td>{{ $event->category->name ?? '-' }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $event->name ?? '-' }}</div>
                                    <div class="text-muted small">{{ $event->venue_name ?? $event->location ?? '-' }}</div>
                                </td>
                                <td>
                                    @if($event->tickets->isNotEmpty())
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($event->tickets->take(3) as $ticket)
                                                <span class="badge bg-light text-dark border">
                                                    {{ $ticket->name }} - Rp{{ number_format($ticket->price, 0, ',', '.') }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-secondary">{{ $event->status }}</span></td>
                                <td>{{ tgl_indo($event->created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(can('events.view'))
                                            <a href="{{ route('events.show', $event) }}"
                                                class="btn btn-sm btn-white" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        @endif
                                        @if(can('events.edit'))
                                            <a href="{{ route('events.edit', $event) }}"
                                                class="btn btn-sm btn-white" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        @endif
                                        @if(can('events.delete'))
                                            <form action="{{ route('events.destroy', $event) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger"
                                                    data-confirm="Yakin hapus Event ini?"
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
                                    Belum ada data Event.
                                    <a href="{{ route('events.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($events->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $events->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection
