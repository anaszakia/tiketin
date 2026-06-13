@extends('layouts.app')

@section('title', 'Checkins')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Checkins</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Checkins</li>
                </ol>
            </nav>
        </div>
        @if(can('checkins.create'))
            <a href="{{ route('checkins.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Tambah Checkin
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
                            <th>Attendee Id</th>
                            <th>Officer Id</th>
                            <th>Checkin At</th>
                            <th>Location</th>
                            <th>Note</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checkins as $checkin)
                            <tr>
                                <td>{{ $checkins->firstItem() + $loop->index }}</td>
                                <td>{{ $checkin->attendee->name ?? '-' }}</td>
                                <td>{{ $checkin->officer->name ?? '-' }}</td>
                                <td>{{ $checkin->checkin_at ?? '-' }}</td>
                                <td>{{ $checkin->location ?? '-' }}</td>
                                <td>{{ $checkin->note ?? '-' }}</td>
                                <td>{{ tgl_indo($checkin->created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(can('checkins.view'))
                                            <a href="{{ route('checkins.show', $checkin) }}"
                                                class="btn btn-sm btn-white" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        @endif
                                        @if(can('checkins.edit'))
                                            <a href="{{ route('checkins.edit', $checkin) }}"
                                                class="btn btn-sm btn-white" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        @endif
                                        @if(can('checkins.delete'))
                                            <form action="{{ route('checkins.destroy', $checkin) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger"
                                                    data-confirm="Yakin hapus Checkin ini?"
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
                                    Belum ada data Checkin.
                                    <a href="{{ route('checkins.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($checkins->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $checkins->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection