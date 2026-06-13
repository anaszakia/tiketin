@extends('layouts.app')

@section('title', 'Event Organizers')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Event Organizers</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Event Organizers</li>
                </ol>
            </nav>
        </div>
        @if(can('event_organizers.create'))
            <a href="{{ route('event_organizers.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Tambah Event Organizer
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
                            <th>Organizer Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Npwp</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($eventOrganizers as $eventOrganizer)
                            <tr>
                                <td>{{ $eventOrganizers->firstItem() + $loop->index }}</td>
                                <td>{{ $eventOrganizer->user->name ?? '-' }}</td>
                                <td>{{ $eventOrganizer->organizer_name ?? '-' }}</td>
                                <td>{{ $eventOrganizer->phone ?? '-' }}</td>
                                <td>{{ $eventOrganizer->address ?? '-' }}</td>
                                <td>{{ $eventOrganizer->npwp ?? '-' }}</td>
                                <td>{{ tgl_indo($eventOrganizer->created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(can('event_organizers.view'))
                                            <a href="{{ route('event_organizers.show', $eventOrganizer) }}"
                                                class="btn btn-sm btn-white" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        @endif
                                        @if(can('event_organizers.edit'))
                                            <a href="{{ route('event_organizers.edit', $eventOrganizer) }}"
                                                class="btn btn-sm btn-white" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        @endif
                                        @if(can('event_organizers.delete'))
                                            <form action="{{ route('event_organizers.destroy', $eventOrganizer) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger"
                                                    data-confirm="Yakin hapus Event Organizer ini?"
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
                                    Belum ada data Event Organizer.
                                    <a href="{{ route('event_organizers.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($eventOrganizers->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $eventOrganizers->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection