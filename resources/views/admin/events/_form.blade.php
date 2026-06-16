@php
    $eventForm = $event ?? new \App\Models\Event();
    $defaultTickets = [
        ['name' => 'Regular', 'description' => 'Akses standar event.', 'price' => 0, 'quota' => 0, 'sales_start' => null, 'sales_end' => null, 'status' => 'active'],
        ['name' => 'VIP', 'description' => 'Akses area VIP dengan benefit tambahan.', 'price' => 0, 'quota' => 0, 'sales_start' => null, 'sales_end' => null, 'status' => 'active'],
        ['name' => 'VVIP', 'description' => 'Akses premium/VVIP dengan benefit terbaik.', 'price' => 0, 'quota' => 0, 'sales_start' => null, 'sales_end' => null, 'status' => 'active'],
    ];
    $ticketRows = old('tickets');
    if (is_null($ticketRows)) {
        $ticketRows = $event
            ? $event->tickets->map(fn ($ticket) => [
                'id' => $ticket->id,
                'name' => $ticket->name,
                'description' => $ticket->description,
                'price' => $ticket->price,
                'quota' => $ticket->quota,
                'sales_start' => $ticket->sales_start,
                'sales_end' => $ticket->sales_end,
                'status' => $ticket->status,
            ])->values()->toArray()
            : $defaultTickets;
    }
    if (empty($ticketRows)) {
        $ticketRows = [['name' => '', 'description' => '', 'price' => 0, 'quota' => 0, 'sales_start' => null, 'sales_end' => null, 'status' => 'active']];
    }
    $galleryImages = $eventForm->gallery_images ?? [];
@endphp

<div class="row">
    <div class="col-xl-8">
        <div class="card card-lg mb-4">
            <div class="card-body">
                <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                    Informasi Utama
                </h6>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Organizer <span class="text-danger">*</span></label>
                        <select name="organizer_id" class="form-select @error('organizer_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Organizer --</option>
                            @foreach ($eventOrganizers as $item)
                                <option value="{{ $item->id }}" {{ old('organizer_id', $eventForm->organizer_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->organizer_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('organizer_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Kategori Event</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($eventCategories as $item)
                                <option value="{{ $item->id }}" {{ old('category_id', $eventForm->category_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Nama Event <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $eventForm->name) }}" placeholder="Contoh: Jakarta Music Festival 2026" required />
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Slug <span class="text-danger">*</span></label>
                    <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                        value="{{ old('slug', $eventForm->slug) }}" placeholder="jakarta-music-festival-2026" required />
                    @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Ringkasan Singkat</label>
                    <textarea name="short_description" rows="2" maxlength="500"
                        class="form-control @error('short_description') is-invalid @enderror"
                        placeholder="Ringkasan yang tampil di listing atau preview event">{{ old('short_description', $eventForm->short_description) }}</textarea>
                    @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Deskripsi Lengkap</label>
                    <textarea name="description" rows="6" class="form-control @error('description') is-invalid @enderror"
                        placeholder="Jelaskan konsep acara, line-up, fasilitas, benefit tiket, dan informasi penting lain">{{ old('description', $eventForm->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Mulai Event</label>
                        <input type="datetime-local" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                            value="{{ old('start_date', $eventForm->start_date) ? date('Y-m-d\TH:i', strtotime(old('start_date', $eventForm->start_date))) : '' }}" />
                        @error('start_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Selesai Event</label>
                        <input type="datetime-local" name="end_date" class="form-control @error('end_date') is-invalid @enderror"
                            value="{{ old('end_date', $eventForm->end_date) ? date('Y-m-d\TH:i', strtotime(old('end_date', $eventForm->end_date))) : '' }}" />
                        @error('end_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Kapasitas Total <span class="text-danger">*</span></label>
                        <input type="number" name="capacity" min="0" class="form-control @error('capacity') is-invalid @enderror"
                            value="{{ old('capacity', $eventForm->capacity) }}" required />
                        @error('capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach (['draft' => 'Draft', 'pending' => 'Pending', 'published' => 'Published', 'rejected' => 'Rejected', 'finished' => 'Finished', 'cancelled' => 'Cancelled'] as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $eventForm->status ?? 'draft') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-lg mb-4">
            <div class="card-body">
                <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                    Lokasi dan Venue
                </h6>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Nama Venue</label>
                        <input type="text" name="venue_name" class="form-control @error('venue_name') is-invalid @enderror"
                            value="{{ old('venue_name', $eventForm->venue_name) }}" placeholder="Contoh: Tennis Indoor Senayan" />
                        @error('venue_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label class="form-label">Lokasi/Kota Utama <span class="text-danger">*</span></label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                            value="{{ old('location', $eventForm->location) }}" placeholder="Jakarta" required />
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Alamat Detail</label>
                    <textarea name="address_detail" rows="3" class="form-control @error('address_detail') is-invalid @enderror"
                        placeholder="Alamat lengkap venue, pintu masuk, area parkir, dan petunjuk tambahan">{{ old('address_detail', $eventForm->address_detail) }}</textarea>
                    @error('address_detail')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-4">
                        <label class="form-label">Kota</label>
                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror"
                            value="{{ old('city', $eventForm->city) }}" />
                        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Provinsi</label>
                        <input type="text" name="province" class="form-control @error('province') is-invalid @enderror"
                            value="{{ old('province', $eventForm->province) }}" />
                        @error('province')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label">Minimal Usia</label>
                        <input type="number" name="minimum_age" min="0" max="100"
                            class="form-control @error('minimum_age') is-invalid @enderror"
                            value="{{ old('minimum_age', $eventForm->minimum_age) }}" placeholder="Contoh: 17" />
                        @error('minimum_age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">URL Google Maps</label>
                    <input type="url" name="map_url" class="form-control @error('map_url') is-invalid @enderror"
                        value="{{ old('map_url', $eventForm->map_url) }}" placeholder="https://maps.google.com/..." />
                    @error('map_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card card-lg mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                        Kategori Tiket
                    </h6>
                    <button type="button" class="btn btn-sm btn-white" id="addTicketRow">
                        <i class="ti ti-plus me-1"></i> Tambah Tiket
                    </button>
                </div>

                <div id="ticketRows" class="d-grid gap-3">
                    @foreach ($ticketRows as $index => $ticket)
                        @include('admin.events._ticket_row', ['index' => $index, 'ticket' => $ticket])
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card card-lg mb-4">
            <div class="card-body">
                <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                    Syarat, Rundown, dan Kebijakan
                </h6>

                <div class="mb-4">
                    <label class="form-label">Rundown Acara</label>
                    <textarea name="rundown" rows="5" class="form-control @error('rundown') is-invalid @enderror"
                        placeholder="Contoh: 16.00 Open gate, 18.00 Opening, 19.30 Main performance">{{ old('rundown', $eventForm->rundown) }}</textarea>
                    @error('rundown')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Syarat dan Ketentuan</label>
                    <textarea name="terms" rows="5" class="form-control @error('terms') is-invalid @enderror"
                        placeholder="Aturan masuk, penukaran tiket, barang terlarang, dan ketentuan venue">{{ old('terms', $eventForm->terms) }}</textarea>
                    @error('terms')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Kebijakan Refund</label>
                    <textarea name="refund_policy" rows="4" class="form-control @error('refund_policy') is-invalid @enderror"
                        placeholder="Jelaskan apakah tiket bisa refund/reschedule dan ketentuannya">{{ old('refund_policy', $eventForm->refund_policy) }}</textarea>
                    @error('refund_policy')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card card-lg mb-4">
            <div class="card-body">
                <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                    Gambar Utama
                </h6>

                <div class="text-center mb-4">
                    <img id="imagePreview"
                        src="{{ $eventForm->banner ? minio_url($eventForm->banner) : '' }}"
                        alt="Gambar Utama"
                        class="rounded object-fit-cover border"
                        style="max-width:100%; width:240px; height:160px; background:#f0f0f0;"
                        onerror="this.style.display='none'" />
                </div>

                <input type="file" name="banner" id="imageInput"
                    class="d-none @error('banner') is-invalid @enderror"
                    accept="image/jpg,image/jpeg,image/png,image/webp" />
                @error('banner')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

                <label for="imageInput" class="btn btn-white btn-sm w-100">
                    <i class="ti ti-upload me-1"></i> Pilih Gambar Utama
                </label>
                <small class="text-muted d-block mt-2">JPG, PNG, WEBP. Maks 2MB.</small>

                <div id="fileInfo" class="mt-3 p-2 bg-light rounded-3 d-none">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-file-check text-success"></i>
                        <small id="fileName" class="text-muted text-truncate"></small>
                    </div>
                </div>

                @if($eventForm->banner)
                    <div class="form-check border rounded-3 p-3 mt-3">
                        <input class="form-check-input" type="checkbox" name="remove_banner" id="remove_banner" value="1" />
                        <label class="form-check-label text-danger small" for="remove_banner">
                            <i class="ti ti-trash me-1"></i> Hapus gambar utama saat ini
                        </label>
                    </div>
                @endif
            </div>
        </div>

        <div class="card card-lg mb-4">
            <div class="card-body">
                <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                    Gambar Pendukung
                </h6>

                @if(! empty($galleryImages))
                    <div class="row g-2 mb-3">
                        @foreach ($galleryImages as $path)
                            <div class="col-6">
                                <div class="border rounded p-2">
                                    <img src="{{ minio_url($path) }}" alt="Gallery" class="rounded object-fit-cover w-100 mb-2" style="height:90px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remove_gallery_images[]" value="{{ $path }}" id="gallery_{{ $loop->index }}">
                                        <label class="form-check-label small text-danger" for="gallery_{{ $loop->index }}">Hapus</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <input type="file" name="gallery_images[]" id="galleryInput"
                    class="d-none @error('gallery_images') is-invalid @enderror"
                    accept="image/jpg,image/jpeg,image/png,image/webp" multiple />
                @error('gallery_images')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                @error('gallery_images.*')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

                <label for="galleryInput" class="btn btn-white btn-sm w-100">
                    <i class="ti ti-photo-plus me-1"></i> Tambah Gambar Pendukung
                </label>
                <small class="text-muted d-block mt-2">Bisa pilih beberapa gambar sekaligus. Maks 2MB per gambar.</small>

                <div id="galleryFileInfo" class="mt-3 p-2 bg-light rounded-3 d-none">
                    <small id="galleryFileName" class="text-muted d-block text-truncate"></small>
                </div>
            </div>
        </div>

        <div class="card card-lg mb-4">
            <div class="card-body">
                <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                    Kontak Event
                </h6>

                <div class="mb-4">
                    <label class="form-label">Nama Kontak</label>
                    <input type="text" name="contact_name" class="form-control @error('contact_name') is-invalid @enderror"
                        value="{{ old('contact_name', $eventForm->contact_name) }}" />
                    @error('contact_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">No. Kontak</label>
                    <input type="text" name="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror"
                        value="{{ old('contact_phone', $eventForm->contact_phone) }}" placeholder="08xxxxxxxxxx" />
                    @error('contact_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Email Kontak</label>
                    <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror"
                        value="{{ old('contact_email', $eventForm->contact_email) }}" />
                    @error('contact_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card card-lg mb-4">
            <div class="card-body">
                <button type="submit" class="btn btn-primary w-100 mb-2">
                    <i class="ti ti-check me-1"></i> {{ $submitLabel }}
                </button>
                <a href="{{ route('events.index') }}" class="btn btn-white w-100">Batal</a>
            </div>
        </div>

        @if($event && can('events.delete'))
            <div class="card card-lg border-danger">
                <div class="card-body">
                    <h6 class="mb-1 text-danger">Danger Zone</h6>
                    <p class="text-muted small mb-3">Tindakan ini tidak bisa dibatalkan.</p>
                    <button type="button" class="btn btn-danger w-100"
                        form="eventDeleteForm"
                        data-confirm="Yakin hapus Event ini? Tidak bisa dibatalkan!">
                        <i class="ti ti-trash me-1"></i> Hapus Event Ini
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    const imageInput = document.getElementById('imageInput');
    const galleryInput = document.getElementById('galleryInput');
    const ticketRows = document.getElementById('ticketRows');
    const addTicketRow = document.getElementById('addTicketRow');
    let ticketIndex = {{ count($ticketRows) }};

    function validateImageFiles(input) {
        const files = Array.from(input.files || []);
        const oversized = files.find((file) => file.size > 2 * 1024 * 1024);
        if (oversized) {
            Swal.fire({ icon: 'error', title: 'File terlalu besar!', text: 'Ukuran gambar maksimal 2MB per file.' });
            input.value = '';
            return false;
        }
        return true;
    }

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file || !validateImageFiles(this)) return;

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

    galleryInput.addEventListener('change', function () {
        if (!validateImageFiles(this)) return;

        const names = Array.from(this.files || []).map((file) => file.name).join(', ');
        document.getElementById('galleryFileName').textContent = names;
        document.getElementById('galleryFileInfo').classList.toggle('d-none', !names);
    });

    addTicketRow.addEventListener('click', function () {
        const template = document.getElementById('ticketRowTemplate').innerHTML.replaceAll('__INDEX__', ticketIndex);
        ticketRows.insertAdjacentHTML('beforeend', template);
        ticketIndex += 1;
    });

    ticketRows.addEventListener('click', function (event) {
        const button = event.target.closest('[data-remove-ticket]');
        if (!button) return;

        const rows = ticketRows.querySelectorAll('[data-ticket-row]');
        if (rows.length === 1) {
            rows[0].querySelectorAll('input, textarea').forEach((field) => field.value = '');
            rows[0].querySelector('select').value = 'active';
            return;
        }

        button.closest('[data-ticket-row]').remove();
    });
</script>

<template id="ticketRowTemplate">
    @include('admin.events._ticket_row', ['index' => '__INDEX__', 'ticket' => ['name' => '', 'description' => '', 'price' => 0, 'quota' => 0, 'sales_start' => null, 'sales_end' => null, 'status' => 'active']])
</template>
@endpush
