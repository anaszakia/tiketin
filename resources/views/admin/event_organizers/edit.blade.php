@extends('layouts.app')

@section('title', 'Edit Event Organizer')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Edit Event Organizer</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('event_organizers.index') }}">Event Organizers</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('event_organizers.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('event_organizers.update', $eventOrganizer) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="col-xl-8">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Informasi Event Organizer
                        </h6>

                        <div class="mb-4">
                            <label class="form-label">User Id</label>
                            <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                                <option value="">-- Pilih User Id --</option>
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('user_id', $eventOrganizer->user_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Organizer Name <span class="text-danger">*</span></label>
                            <input type="text" name="organizer_name"
                                class="form-control @error('organizer_name') is-invalid @enderror"
                                value="{{ old('organizer_name', $eventOrganizer->organizer_name) }}"
                                placeholder="Masukkan Organizer Name" required />
                            @error('organizer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Phone </label>
                            <input type="text" name="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $eventOrganizer->phone) }}"
                                placeholder="Masukkan Phone" />
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Address</label>
                            <textarea name="address" rows="3"
                                class="form-control @error('address') is-invalid @enderror"
                                placeholder="Masukkan Address">{{ old('address', $eventOrganizer->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Npwp </label>
                            <input type="text" name="npwp"
                                class="form-control @error('npwp') is-invalid @enderror"
                                value="{{ old('npwp', $eventOrganizer->npwp) }}"
                                placeholder="Masukkan Npwp" />
                            @error('npwp')
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
                            Logo
                        </h6>

                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img id="imagePreview"
                                    src="{{ $eventOrganizer->logo ? minio_url($eventOrganizer->logo) : '' }}"
                                    alt="Logo"
                                    class="rounded object-fit-cover border"
                                    style="max-width:200px; max-height:150px; min-height:80px; background:#f0f0f0;"
                                    onerror="this.style.display='none'" />
                            </div>
                        </div>

                        <input type="file" name="logo" id="imageInput"
                            class="d-none @error('logo') is-invalid @enderror"
                            accept="image/jpg,image/jpeg,image/png,image/webp" />
                        @error('logo')
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

                        @if($eventOrganizer->logo)
                            <div class="form-check border rounded-3 p-3">
                                <input class="form-check-input" type="checkbox"
                                    name="remove_logo" id="remove_logo" value="1" />
                                <label class="form-check-label text-danger small" for="remove_logo">
                                    <i class="ti ti-trash me-1"></i> Hapus gambar saat ini
                                </label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="ti ti-check me-1"></i> Update Event Organizer
                        </button>
                        <a href="{{ route('event_organizers.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>

                @if(can('event_organizers.delete'))
                    <div class="card card-lg border-danger">
                        <div class="card-body">
                            <h6 class="mb-1 text-danger">Danger Zone</h6>
                            <p class="text-muted small mb-3">Tindakan ini tidak bisa dibatalkan.</p>
                            <form action="{{ route('event_organizers.destroy', $eventOrganizer) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger w-100"
                                    data-confirm="Yakin hapus Event Organizer ini? Tidak bisa dibatalkan!">
                                    <i class="ti ti-trash me-1"></i> Hapus Event Organizer Ini
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
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

        const removeCheckbox = document.getElementById('remove_logo');
        if (removeCheckbox) removeCheckbox.checked = false;
    });
</script>
@endpush