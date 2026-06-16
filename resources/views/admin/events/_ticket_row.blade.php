<div class="border rounded p-3" data-ticket-row>
    <input type="hidden" name="tickets[{{ $index }}][id]" value="{{ $ticket['id'] ?? '' }}">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <strong class="small text-muted">Tiket</strong>
        <button type="button" class="btn btn-sm btn-white text-danger" data-remove-ticket>
            <i class="ti ti-trash"></i>
        </button>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" name="tickets[{{ $index }}][name]" class="form-control"
                value="{{ old('tickets.' . $index . '.name', $ticket['name'] ?? '') }}"
                placeholder="Regular, VIP, VVIP" />
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="tickets[{{ $index }}][price]" min="0" step="0.01" class="form-control"
                value="{{ old('tickets.' . $index . '.price', $ticket['price'] ?? 0) }}" />
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Kuota</label>
            <input type="number" name="tickets[{{ $index }}][quota]" min="0" class="form-control"
                value="{{ old('tickets.' . $index . '.quota', $ticket['quota'] ?? 0) }}" />
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Benefit/Keterangan</label>
        <textarea name="tickets[{{ $index }}][description]" rows="2" class="form-control"
            placeholder="Benefit tiket, area akses, merchandise, atau ketentuan khusus">{{ old('tickets.' . $index . '.description', $ticket['description'] ?? '') }}</textarea>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Mulai Penjualan</label>
            <input type="datetime-local" name="tickets[{{ $index }}][sales_start]" class="form-control"
                value="{{ old('tickets.' . $index . '.sales_start', $ticket['sales_start'] ?? null) ? date('Y-m-d\TH:i', strtotime(old('tickets.' . $index . '.sales_start', $ticket['sales_start'] ?? null))) : '' }}" />
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Akhir Penjualan</label>
            <input type="datetime-local" name="tickets[{{ $index }}][sales_end]" class="form-control"
                value="{{ old('tickets.' . $index . '.sales_end', $ticket['sales_end'] ?? null) ? date('Y-m-d\TH:i', strtotime(old('tickets.' . $index . '.sales_end', $ticket['sales_end'] ?? null))) : '' }}" />
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label">Status</label>
            <select name="tickets[{{ $index }}][status]" class="form-select">
                @foreach (['active' => 'Active', 'inactive' => 'Inactive', 'sold_out' => 'Sold Out'] as $value => $label)
                    <option value="{{ $value }}" {{ old('tickets.' . $index . '.status', $ticket['status'] ?? 'active') == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
