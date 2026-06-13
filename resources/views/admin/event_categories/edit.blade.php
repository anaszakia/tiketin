@extends('layouts.app')

@section('title', 'Edit Event Category')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Edit Event Category</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event_categories.index') }}">Event Categories</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('event_categories.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('event_categories.update', $eventCategory) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="col-12">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Informasi Event Category
                        </h6>

                        <div class="mb-4">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $eventCategory->name) }}"
                                placeholder="Masukkan Name" required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Slug </label>
                            <input type="text" name="slug"
                                class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug', $eventCategory->slug) }}"
                                placeholder="Masukkan Slug" />
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="ti ti-check me-1"></i> Update Event Category
                        </button>
                        <a href="{{ route('event_categories.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>

                @if(can('event_categories.delete'))
                    <div class="card card-lg border-danger">
                        <div class="card-body">
                            <h6 class="mb-1 text-danger">Danger Zone</h6>
                            <p class="text-muted small mb-3">Tindakan ini tidak bisa dibatalkan.</p>
                            <form action="{{ route('event_categories.destroy', $eventCategory) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger w-100"
                                    data-confirm="Yakin hapus Event Category ini? Tidak bisa dibatalkan!">
                                    <i class="ti ti-trash me-1"></i> Hapus Event Category Ini
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </form>

@endsection
