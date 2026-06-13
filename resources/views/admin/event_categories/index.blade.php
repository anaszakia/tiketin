@extends('layouts.app')

@section('title', 'Event Categories')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Event Categories</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Event Categories</li>
                </ol>
            </nav>
        </div>
        @if(can('event_categories.create'))
            <a href="{{ route('event_categories.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Tambah Event Category
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
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($eventCategories as $eventCategory)
                            <tr>
                                <td>{{ $eventCategories->firstItem() + $loop->index }}</td>
                                <td>{{ $eventCategory->name ?? '-' }}</td>
                                <td>{{ $eventCategory->slug ?? '-' }}</td>
                                <td>{{ tgl_indo($eventCategory->created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(can('event_categories.view'))
                                            <a href="{{ route('event_categories.show', $eventCategory) }}"
                                                class="btn btn-sm btn-white" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        @endif
                                        @if(can('event_categories.edit'))
                                            <a href="{{ route('event_categories.edit', $eventCategory) }}"
                                                class="btn btn-sm btn-white" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        @endif
                                        @if(can('event_categories.delete'))
                                            <form action="{{ route('event_categories.destroy', $eventCategory) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger"
                                                    data-confirm="Yakin hapus Event Category ini?"
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
                                    Belum ada data Event Category.
                                    <a href="{{ route('event_categories.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($eventCategories->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ $eventCategories->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection