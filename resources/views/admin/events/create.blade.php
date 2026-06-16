@extends('layouts.app')

@section('title', 'Tambah Event')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Tambah Event</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('events.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="col-xl-8">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Informasi Event
                        </h6>

                        <div class="mb-4">
                            <label class="form-label">Organizer <span class="text-danger">*</span></label>
                            <select name="organizer_id" class="form-select @error('organizer_id') is-invalid @enderror">
                                <option value="">-- Pilih Organizer --</option>
                                @foreach ($eventOrganizers as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('organizer_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->organizer_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('organizer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- Pilih Category --</option>
                                @foreach ($eventCategories as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('category_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Masukkan Name" required />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Slug </label>
                            <input type="text" name="slug"
                                class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug') }}"
                                placeholder="Masukkan Slug" />
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Description</label>
                            <textarea name="description" rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Masukkan Description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Location </label>
                            <input type="text" name="location"
                                class="form-control @error('location') is-invalid @enderror"
                                value="{{ old('location') }}"
                                placeholder="Masukkan Location" />
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Start Date</label>
                            <input type="datetime-local" name="start_date"
                                class="form-control @error('start_date') is-invalid @enderror"
                                value="{{ old('start_date') ? date('Y-m-d\TH:i', strtotime(old('start_date'))) : '' }}" />
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">End Date</label>
                            <input type="datetime-local" name="end_date"
                                class="form-control @error('end_date') is-invalid @enderror"
                                value="{{ old('end_date') ? date('Y-m-d\TH:i', strtotime(old('end_date'))) : '' }}" />
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Capacity <span class="text-danger">*</span></label>
                            <input type="number" name="capacity" min="0"
                                class="form-control @error('capacity') is-invalid @enderror"
                                value="{{ old('capacity') }}" required />
                            @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="">-- Pilih Status --</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="finished" {{ old('status') == 'finished' ? 'selected' : '' }}>Finished</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Banner
                        </h6>

                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img id="imagePreview"
                                    src=""
                                    alt="Banner"
                                    class="rounded object-fit-cover border"
                                    style="max-width:200px; max-height:150px; min-height:80px; background:#f0f0f0;"
                                    onerror="this.style.display='none'" />
                            </div>
                        </div>

                        <input type="file" name="banner" id="imageInput"
                            class="d-none @error('banner') is-invalid @enderror"
                            accept="image/jpg,image/jpeg,image/png,image/webp" />
                        @error('banner')
                            <div class="text-danger small mb-2">{{ $message }}</div>
                        @enderror

                        <div class="text-center mb-3">
                            <label for="imageInput" class="btn btn-white btn-sm w-100">
                                <i class="ti ti-upload me-1"></i> Pilih Gambar
                            </label>
                            <small class="text-muted d-block mt-2">JPG, PNG, WEBP. Maks 2MB</small>
                        </div>

                        <div id="fileInfo" class="mb-3 p-2 bg-light rounded-3 d-none">
                            <div class="d-flex align-items-center gap-2">
                                <i class="ti ti-file-check text-success"></i>
                                <small id="fileName" class="text-muted text-truncate"></small>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card card-lg">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="ti ti-check me-1"></i> Simpan Event
                        </button>
                        <a href="{{ route('events.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection

@push('scripts')
<script>
    document.getElementById('imageInput').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({ icon: 'error', title: 'File terlalu besar!', text: 'Ukuran gambar maksimal 2MB.' });
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            const preview = document.getElementById('imagePreview');
            preview.src = e.target.result;
            preview.style.display = '';
        };
        reader.readAsDataURL(file);

        document.getElementById('fileName').textContent = file.name;
        document.getElementById('fileInfo').classList.remove('d-none');

        const removeCheckbox = document.getElementById('remove_banner');
        if (removeCheckbox) removeCheckbox.checked = false;
    });
</script>
@endpush
