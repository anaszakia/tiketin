@extends('layouts.app')

@section('title', 'Attendees')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Attendees</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Attendees</li>
                </ol>
            </nav>
        </div>
        @if(can('attendees.create'))
            <a href="{{ route('attendees.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Tambah Attendee
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
                            <th>Order Item Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Ticket Code</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attendees as $attendee)
                            <tr>
                                <td>{{ $attendees->firstItem() + $loop->index }}</td>
                                <td>{{ $attendee->orderItem->name ?? '-' }}</td>
                                <td>{{ $attendee->name ?? '-' }}</td>
                                <td>{{ $attendee->email ?? '-' }}</td>
                                <td>{{ $attendee->phone ?? '-' }}</td>
                                <td>{{ $attendee->ticket_code ?? '-' }}</td>
                                <td>{{ tgl_indo($attendee->created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(can('attendees.view'))
                                            <a href="{{ route('attendees.show', $attendee) }}"
                                                class="btn btn-sm btn-white" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        @endif
                                        @if(can('attendees.edit'))
                                            <a href="{{ route('attendees.edit', $attendee) }}"
                                                class="btn btn-sm btn-white" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        @endif
                                        @if(can('attendees.delete'))
                                            <form action="{{ route('attendees.destroy', $attendee) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger"
                                                    data-confirm="Yakin hapus Attendee ini?"
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
                                    Belum ada data Attendee.
                                    <a href="{{ route('attendees.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($attendees->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $attendees->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection