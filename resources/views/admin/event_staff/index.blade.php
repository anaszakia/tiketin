@extends('layouts.app')

@section('title', 'Event Staffs')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Event Staffs</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Event Staffs</li>
                </ol>
            </nav>
        </div>
        @if(can('event_staff.create'))
            <a href="{{ route('event_staff.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Tambah Event Staff
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
                            <th>User Id</th>
                            <th>Event Role Id</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($eventStaff as $eventStaff)
                            <tr>
                                <td>{{ $eventStaff->firstItem() + $loop->index }}</td>
                                <td>{{ $eventStaff->event->name ?? '-' }}</td>
                                <td>{{ $eventStaff->user->name ?? '-' }}</td>
                                <td>{{ $eventStaff->eventRole->name ?? '-' }}</td>
                                <td>{{ tgl_indo($eventStaff->created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(can('event_staff.view'))
                                            <a href="{{ route('event_staff.show', $eventStaff) }}"
                                                class="btn btn-sm btn-white" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        @endif
                                        @if(can('event_staff.edit'))
                                            <a href="{{ route('event_staff.edit', $eventStaff) }}"
                                                class="btn btn-sm btn-white" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        @endif
                                        @if(can('event_staff.delete'))
                                            <form action="{{ route('event_staff.destroy', $eventStaff) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger"
                                                    data-confirm="Yakin hapus Event Staff ini?"
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
                                    Belum ada data Event Staff.
                                    <a href="{{ route('event_staff.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($eventStaff->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $eventStaff->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection