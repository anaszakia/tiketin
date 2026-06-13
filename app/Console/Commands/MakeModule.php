<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * php artisan make:module EventCategory --fields="name,slug"
 * php artisan make:module Event --fields="organizer_id,category_id,name,slug,description,banner,location,start_date,end_date,capacity,status" --belongs-to="Organizer,EventCategory" --has-image=banner
 */
class MakeModule extends Command
{
    protected $signature = 'make:module
                            {name : Nama model, PascalCase (contoh: EventCategory)}
                            {--fields= : Kolom fillable, pisah koma (contoh: name,slug,status)}
                            {--belongs-to= : Relasi belongsTo, pisah koma (contoh: Organizer,EventCategory)}
                            {--has-image= : Nama kolom gambar/file yang disimpan di MinIO (contoh: banner)}
                            {--soft-delete : Tambahkan SoftDeletes ke model}
                            {--no-views : Hanya generate Model dan Controller, skip Views}
                            {--force : Timpa file yang sudah ada}';

    protected $description = 'Generate Model + Controller + Views (index/create/edit/show) sesuai template tiketin';

    // ─── kolom yang TIDAK perlu masuk fillable/tabel UI ───────────────────────
    private array $systemCols = ['id', 'created_at', 'updated_at', 'deleted_at', 'remember_token'];

    public function handle(): int
    {
        $name        = $this->argument('name');                          // EventCategory
        $fields      = $this->parseList($this->option('fields'));        // ['name','slug']
        $belongsTo   = $this->parseList($this->option('belongs-to'));    // ['Organizer','EventCategory']
        $imageField  = $this->option('has-image');                       // 'banner' | null
        $softDelete  = $this->option('soft-delete');
        $noViews     = $this->option('no-views');
        $force       = $this->option('force');

        // ── Turunan nama ─────────────────────────────────────────────────────
        $modelName      = Str::studly($name);                           // EventCategory
        $tableName      = Str::snake(Str::pluralStudly($name));         // event_categories
        $routeBase      = Str::plural(Str::kebab($name));               // event-categories
        $routeName      = Str::snake(Str::pluralStudly($name));         // event_categories  → route('event_categories.index')
        $viewFolder     = Str::snake(Str::pluralStudly($name));         // event_categories
        $permSlug       = Str::snake(Str::pluralStudly($name));         // event_categories
        $varSingle      = Str::camel($name);                            // eventCategory
        $varPlural      = Str::camel(Str::pluralStudly($name));         // eventCategories
        $labelSingle    = Str::headline($name);                         // Event Category
        $labelPlural    = Str::plural(Str::headline($name));            // Event Categories
        $controllerName = $modelName . 'Controller';

        $this->info("📦 Generating module: {$modelName}");
        $this->line("   Table      : {$tableName}");
        $this->line("   Route      : {$routeName}.*");
        $this->line("   Controller : App\\Http\\Controllers\\{$controllerName}");
        $this->line("   Views      : resources/views/admin/{$viewFolder}/");
        $this->newLine();

        // ── 1. Model ──────────────────────────────────────────────────────────
        $this->generateFile(
            app_path("Models/{$modelName}.php"),
            $this->buildModel($modelName, $tableName, $fields, $belongsTo, $imageField, $softDelete),
            "Model [{$modelName}]",
            $force
        );

        // ── 2. Controller ─────────────────────────────────────────────────────
        $this->generateFile(
            app_path("Http/Controllers/{$controllerName}.php"),
            $this->buildController(
                $modelName, $controllerName, $routeName, $viewFolder,
                $fields, $belongsTo, $imageField, $permSlug,
                $varSingle, $varPlural, $labelSingle
            ),
            "Controller [{$controllerName}]",
            $force
        );

        // ── 3. Views ──────────────────────────────────────────────────────────
        if (! $noViews) {
            $viewPath = resource_path("views/admin/{$viewFolder}");
            @mkdir($viewPath, 0755, true);

            foreach (['index', 'create', 'edit', 'show'] as $view) {
                $method = 'build' . ucfirst($view) . 'View';
                $this->generateFile(
                    "{$viewPath}/{$view}.blade.php",
                    $this->$method(
                        $modelName, $routeName, $viewFolder,
                        $fields, $belongsTo, $imageField, $permSlug,
                        $varSingle, $varPlural, $labelSingle, $labelPlural
                    ),
                    "View  [admin/{$viewFolder}/{$view}.blade.php]",
                    $force
                );
            }
        }

        // ── 4. Reminder route ─────────────────────────────────────────────────
        $this->newLine();
        $this->info('✅ Done! Tambahkan route berikut ke routes/web.php:');
        $this->line("   Route::resource('{$routeBase}', \\App\\Http\\Controllers\\{$controllerName}::class);");
        $this->newLine();
        $this->warn('⚠️  Jangan lupa:');
        $this->line("   • Tambahkan permission slugs ke seeder: {$permSlug}.view|create|edit|delete");
        if ($imageField) {
            $this->line("   • Helper minio_upload / minio_replace / minio_delete harus sudah ada");
        }

        return self::SUCCESS;
    }

    // ═══════════════════════════════════════════════════════════════════════════
    //  BUILDERS
    // ═══════════════════════════════════════════════════════════════════════════

    private function buildModel(
        string $modelName, string $tableName, array $fields,
        array $belongsTo, ?string $imageField, bool $softDelete
    ): string {
        $fillable   = array_filter($fields, fn($f) => ! in_array($f, $this->systemCols));
        $fillableStr = implode(', ', array_map(fn($f) => "'{$f}'", $fillable));

        $uses = ["use Illuminate\Database\Eloquent\Model;"];
        if ($softDelete) $uses[] = "use Illuminate\Database\Eloquent\SoftDeletes;";

        $traits = $softDelete ? "\n    use SoftDeletes;\n" : '';

        // belongsTo relations
        $relations = '';
        foreach ($belongsTo as $rel) {
            $relModel  = Str::studly($rel);
            $relMethod = Str::camel($rel);
            $relations .= <<<PHP

    public function {$relMethod}()
    {
        return \$this->belongsTo({$relModel}::class);
    }
PHP;
        }

        // image helper
        $imageHelper = '';
        if ($imageField) {
            $imageHelper = <<<PHP

    public function get" . Str::studly($imageField) . "UrlAttribute(): string
    {
        return minio_url(\$this->{$imageField});
    }
PHP;
        }

        $usesStr = implode("\n", $uses);

        return <<<PHP
<?php

namespace App\Models;

{$usesStr}

class {$modelName} extends Model
{
    {$traits}protected \$fillable = [{$fillableStr}];
{$relations}{$imageHelper}
}
PHP;
    }

    // ─────────────────────────────────────────────────────────────────────────

    private function buildController(
        string $modelName, string $controllerName, string $routeName,
        string $viewFolder, array $fields, array $belongsTo, ?string $imageField,
        string $permSlug, string $varSingle, string $varPlural, string $labelSingle
    ): string {

        // import models
        $imports = ["use App\Models\\{$modelName};"];
        foreach ($belongsTo as $rel) {
            $imports[] = "use App\Models\\" . Str::studly($rel) . ";";
        }
        $importsStr = implode("\n", array_unique($imports));

        // compact extra (related models for dropdowns)
        $compactCreate = [$varSingle];
        $compactEdit   = [$varSingle];
        foreach ($belongsTo as $rel) {
            $plural = Str::camel(Str::pluralStudly($rel));
            $compactCreate[] = $plural;
            $compactEdit[]   = $plural;
        }
        $compactCreateStr = "'" . implode("', '", $compactCreate) . "'";
        $compactEditStr   = "'" . implode("', '", $compactEdit)   . "'";

        // related fetches for create/edit
        $relatedFetches = '';
        foreach ($belongsTo as $rel) {
            $relModel  = Str::studly($rel);
            $relVar    = Str::camel(Str::pluralStudly($rel));
            $relatedFetches .= "        \${$relVar} = {$relModel}::orderBy('name')->get();\n";
        }

        // validation rules
        $rules = [];
        $skipFields = ['id', 'created_at', 'updated_at', 'deleted_at'];
        foreach ($fields as $field) {
            if (in_array($field, $skipFields)) continue;
            if ($field === $imageField) {
                $rules[] = "            '{$field}' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',";
            } elseif (str_ends_with($field, '_id')) {
                $rel = rtrim($field, '_id');
                $tbl = Str::snake(Str::pluralStudly($rel));
                $rules[] = "            '{$field}' => 'nullable|exists:{$tbl},id',";
            } elseif (in_array($field, ['email'])) {
                $rules[] = "            '{$field}' => 'required|email|unique:{$this->guessTable($modelName)},{$field}',";
            } elseif (in_array($field, ['description', 'address', 'note', 'body', 'content'])) {
                $rules[] = "            '{$field}' => 'nullable|string',";
            } elseif (in_array($field, ['price', 'amount', 'total', 'subtotal', 'discount'])) {
                $rules[] = "            '{$field}' => 'required|numeric|min:0',";
            } elseif (in_array($field, ['start_date', 'end_date', 'sales_start', 'sales_end', 'paid_at'])) {
                $rules[] = "            '{$field}' => 'nullable|date',";
            } elseif ($field === 'status') {
                $rules[] = "            '{$field}' => 'required|string',";
            } elseif (in_array($field, ['capacity', 'quota', 'qty', 'order'])) {
                $rules[] = "            '{$field}' => 'required|integer|min:0',";
            } else {
                $rules[] = "            '{$field}' => 'required|string|max:255',";
            }
        }
        $rulesStr = implode("\n", $rules);

        // fillable data build
        $dataLines = [];
        foreach ($fields as $field) {
            if (in_array($field, $skipFields) || $field === $imageField) continue;
            $dataLines[] = "            '{$field}' => \$request->{$field},";
        }
        $dataStr = implode("\n", $dataLines);

        // image handling blocks
        $imageStoreBlock = $imageField ? <<<PHP

        \${$imageField}Path = null;
        if (\$request->hasFile('{$imageField}')) {
            \${$imageField}Path = minio_upload(\$request->file('{$imageField}'), '{$varPlural}');
        }
PHP : '';

        $imageUpdateBlock = $imageField ? <<<PHP

        if (\$request->hasFile('{$imageField}')) {
            \$data['{$imageField}'] = minio_replace(\${$varSingle}->{$imageField}, \$request->file('{$imageField}'), '{$varPlural}');
        }
        if (\$request->has('remove_{$imageField}') && \${$varSingle}->{$imageField}) {
            minio_delete(\${$varSingle}->{$imageField});
            \$data['{$imageField}'] = null;
        }
PHP : '';

        $imageDestroyBlock = $imageField ? <<<PHP

        if (\${$varSingle}->{$imageField}) {
            minio_delete(\${$varSingle}->{$imageField});
        }
PHP : '';

        $imageDataLine = $imageField ? "            '{$imageField}'      => \${$imageField}Path," : '';

        // with relations for eager loading
        $withStr = $belongsTo
            ? "'" . implode("', '", array_map(fn($r) => Str::camel($r), $belongsTo)) . "'"
            : '';
        $withBlock = $withStr ? "->with({$withStr})" : '';

        return <<<PHP
<?php

namespace App\Http\Controllers;

{$importsStr}
use Illuminate\Http\Request;

class {$controllerName} extends Controller
{
    public function index()
    {
        abort_unless(can('{$permSlug}.view'), 403);

        \${$varPlural} = {$modelName}::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.{$viewFolder}.index', compact('{$varPlural}'));
    }

    public function create()
    {
        abort_unless(can('{$permSlug}.create'), 403);

{$relatedFetches}
        return view('admin.{$viewFolder}.create', compact({$compactCreateStr}));
    }

    public function store(Request \$request)
    {
        abort_unless(can('{$permSlug}.create'), 403);

        \$request->validate([
{$rulesStr}
        ]);
{$imageStoreBlock}
        {$modelName}::create([
{$dataStr}
{$imageDataLine}
        ]);

        return redirect()->route('{$routeName}.index')
            ->with('success', '{$labelSingle} berhasil ditambahkan!');
    }

    public function show({$modelName} \${$varSingle})
    {
        abort_unless(can('{$permSlug}.view'), 403);

        return view('admin.{$viewFolder}.show', compact('{$varSingle}'));
    }

    public function edit({$modelName} \${$varSingle})
    {
        abort_unless(can('{$permSlug}.edit'), 403);

{$relatedFetches}
        return view('admin.{$viewFolder}.edit', compact({$compactEditStr}));
    }

    public function update(Request \$request, {$modelName} \${$varSingle})
    {
        abort_unless(can('{$permSlug}.edit'), 403);

        \$request->validate([
{$rulesStr}
        ]);

        \$data = [
{$dataStr}
        ];
{$imageUpdateBlock}
        \${$varSingle}->update(\$data);

        return redirect()->route('{$routeName}.index')
            ->with('success', '{$labelSingle} berhasil diupdate!');
    }

    public function destroy({$modelName} \${$varSingle})
    {
        abort_unless(can('{$permSlug}.delete'), 403);
{$imageDestroyBlock}
        \${$varSingle}->delete();

        return redirect()->route('{$routeName}.index')
            ->with('success', '{$labelSingle} berhasil dihapus!');
    }
}
PHP;
    }

    // ─────────────────────────────────────────────────────────────────────────
    //  VIEW BUILDERS
    // ─────────────────────────────────────────────────────────────────────────

    private function buildIndexView(
        string $modelName, string $routeName, string $viewFolder,
        array $fields, array $belongsTo, ?string $imageField, string $permSlug,
        string $varSingle, string $varPlural, string $labelSingle, string $labelPlural
    ): string {
        // Build table headers & rows from fields (exclude system + image)
        $displayFields = array_filter($fields, fn($f) => ! in_array($f, $this->systemCols) && $f !== $imageField);
        $maxShow       = 5; // max kolom di tabel agar tidak overflow
        $displayFields = array_slice($displayFields, 0, $maxShow);

        $headers = '';
        $rows    = '';
        foreach ($displayFields as $f) {
            $label    = Str::headline($f);
            $headers .= "                            <th>{$label}</th>\n";
            if (str_ends_with($f, '_id')) {
                $rel   = Str::camel(rtrim($f, '_id'));
                $rows .= "                                <td>{{ \${$varSingle}->{$rel}->name ?? '-' }}</td>\n";
            } elseif ($f === 'status') {
                $rows .= "                                <td><span class=\"badge bg-secondary\">{{ \${$varSingle}->{$f} }}</span></td>\n";
            } else {
                $rows .= "                                <td>{{ \${$varSingle}->{$f} ?? '-' }}</td>\n";
            }
        }

        return <<<BLADE
@extends('layouts.app')

@section('title', '{$labelPlural}')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">{$labelPlural}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{$labelPlural}</li>
                </ol>
            </nav>
        </div>
        @if(can('{$permSlug}.create'))
            <a href="{{ route('{$routeName}.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i> Tambah {$labelSingle}
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
{$headers}                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse (\${$varPlural} as \${$varSingle})
                            <tr>
                                <td>{{ \${$varPlural}->firstItem() + \$loop->index }}</td>
{$rows}                                <td>{{ tgl_indo(\${$varSingle}->created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(can('{$permSlug}.view'))
                                            <a href="{{ route('{$routeName}.show', \${$varSingle}) }}"
                                                class="btn btn-sm btn-white" title="Detail">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        @endif
                                        @if(can('{$permSlug}.edit'))
                                            <a href="{{ route('{$routeName}.edit', \${$varSingle}) }}"
                                                class="btn btn-sm btn-white" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        @endif
                                        @if(can('{$permSlug}.delete'))
                                            <form action="{{ route('{$routeName}.destroy', \${$varSingle}) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-white text-danger"
                                                    data-confirm="Yakin hapus {$labelSingle} ini?"
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
                                    Belum ada data {$labelSingle}.
                                    <a href="{{ route('{$routeName}.create') }}">Tambah sekarang</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(\${$varPlural}->hasPages())
                <div class="px-4 py-3 border-top">
                    {{ \${$varPlural}->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection
BLADE;
    }

    // ─────────────────────────────────────────────────────────────────────────

    private function buildCreateView(
        string $modelName, string $routeName, string $viewFolder,
        array $fields, array $belongsTo, ?string $imageField, string $permSlug,
        string $varSingle, string $varPlural, string $labelSingle, string $labelPlural
    ): string {
        $formFields  = $this->buildFormFields($fields, $belongsTo, $imageField, null);
        $imagePanel  = $imageField ? $this->buildImagePanel($imageField, null, $varSingle) : '';
        $colClass    = $imageField ? 'col-xl-8' : 'col-12';

        return <<<BLADE
@extends('layouts.app')

@section('title', 'Tambah {$labelSingle}')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Tambah {$labelSingle}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('{$routeName}.index') }}">{$labelPlural}</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('{$routeName}.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('{$routeName}.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="{$colClass}">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Informasi {$labelSingle}
                        </h6>
{$formFields}
                    </div>
                </div>
            </div>
{$imagePanel}
            <div class="{$colClass}">
                <div class="card card-lg">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="ti ti-check me-1"></i> Simpan {$labelSingle}
                        </button>
                        <a href="{{ route('{$routeName}.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>
            </div>

        </div>
    </form>

@endsection
{$this->buildImageScript($imageField)}
BLADE;
    }

    // ─────────────────────────────────────────────────────────────────────────

    private function buildEditView(
        string $modelName, string $routeName, string $viewFolder,
        array $fields, array $belongsTo, ?string $imageField, string $permSlug,
        string $varSingle, string $varPlural, string $labelSingle, string $labelPlural
    ): string {
        $formFields = $this->buildFormFields($fields, $belongsTo, $imageField, $varSingle);
        $imagePanel = $imageField ? $this->buildImagePanel($imageField, $varSingle, $varSingle) : '';
        $colClass   = $imageField ? 'col-xl-8' : 'col-12';

        return <<<BLADE
@extends('layouts.app')

@section('title', 'Edit {$labelSingle}')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Edit {$labelSingle}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('{$routeName}.index') }}">{$labelPlural}</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('{$routeName}.index') }}" class="btn btn-white">
            <i class="ti ti-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('{$routeName}.update', \${$varSingle}) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">

            <div class="{$colClass}">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            Informasi {$labelSingle}
                        </h6>
{$formFields}
                    </div>
                </div>
            </div>
{$imagePanel}
            <div class="{$colClass}">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="ti ti-check me-1"></i> Update {$labelSingle}
                        </button>
                        <a href="{{ route('{$routeName}.index') }}" class="btn btn-white w-100">Batal</a>
                    </div>
                </div>

                @if(can('{$permSlug}.delete'))
                    <div class="card card-lg border-danger">
                        <div class="card-body">
                            <h6 class="mb-1 text-danger">Danger Zone</h6>
                            <p class="text-muted small mb-3">Tindakan ini tidak bisa dibatalkan.</p>
                            <form action="{{ route('{$routeName}.destroy', \${$varSingle}) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger w-100"
                                    data-confirm="Yakin hapus {$labelSingle} ini? Tidak bisa dibatalkan!">
                                    <i class="ti ti-trash me-1"></i> Hapus {$labelSingle} Ini
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </form>

@endsection
{$this->buildImageScript($imageField)}
BLADE;
    }

    // ─────────────────────────────────────────────────────────────────────────

    private function buildShowView(
        string $modelName, string $routeName, string $viewFolder,
        array $fields, array $belongsTo, ?string $imageField, string $permSlug,
        string $varSingle, string $varPlural, string $labelSingle, string $labelPlural
    ): string {
        $rows = '';
        foreach ($fields as $f) {
            if (in_array($f, $this->systemCols)) continue;
            $label = Str::headline($f);
            if ($f === $imageField) {
                $rows .= <<<BLADE
                        <tr>
                            <td class="text-muted" width="200">{$label}</td>
                            <td>
                                @if(\${$varSingle}->{$f})
                                    <img src="{{ minio_url(\${$varSingle}->{$f}) }}" alt="{$label}" class="rounded" style="max-height:120px;">
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>

BLADE;
            } elseif (str_ends_with($f, '_id')) {
                $rel = Str::camel(rtrim($f, '_id'));
                $rows .= <<<BLADE
                        <tr>
                            <td class="text-muted" width="200">{$label}</td>
                            <td>{{ \${$varSingle}->{$rel}->name ?? '-' }}</td>
                        </tr>

BLADE;
            } elseif ($f === 'status') {
                $rows .= <<<BLADE
                        <tr>
                            <td class="text-muted" width="200">{$label}</td>
                            <td><span class="badge bg-secondary">{{ \${$varSingle}->{$f} }}</span></td>
                        </tr>

BLADE;
            } else {
                $rows .= <<<BLADE
                        <tr>
                            <td class="text-muted" width="200">{$label}</td>
                            <td>{{ \${$varSingle}->{$f} ?? '-' }}</td>
                        </tr>

BLADE;
            }
        }

        // tambah timestamps
        $rows .= <<<BLADE
                        <tr>
                            <td class="text-muted">Dibuat</td>
                            <td>{{ tgl_jam(\${$varSingle}->created_at) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Terakhir Update</td>
                            <td>{{ tgl_jam(\${$varSingle}->updated_at) }}</td>
                        </tr>
BLADE;

        return <<<BLADE
@extends('layouts.app')

@section('title', 'Detail {$labelSingle}')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-6">
        <div>
            <h4 class="mb-0">Detail {$labelSingle}</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('{$routeName}.index') }}">{$labelPlural}</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            @if(can('{$permSlug}.edit'))
                <a href="{{ route('{$routeName}.edit', \${$varSingle}) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i> Edit
                </a>
            @endif
            <a href="{{ route('{$routeName}.index') }}" class="btn btn-white">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card card-lg">
        <div class="card-body">
            <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                Informasi {$labelSingle}
            </h6>
            <table class="table table-borderless mb-0">
{$rows}
            </table>
        </div>
    </div>

@endsection
BLADE;
    }

    // ═══════════════════════════════════════════════════════════════════════════
    //  HELPERS
    // ═══════════════════════════════════════════════════════════════════════════

    private function buildFormFields(array $fields, array $belongsTo, ?string $imageField, ?string $varSingle): string
    {
        $html       = '';
        $skipFields = array_merge($this->systemCols, [$imageField]);

        foreach ($fields as $f) {
            if (in_array($f, $skipFields)) continue;

            $label    = Str::headline($f);
            $oldVal   = $varSingle ? "old('{$f}', \${$varSingle}->{$f})" : "old('{$f}')";

            if (str_ends_with($f, '_id')) {
                // dropdown dari relasi
                $rel      = rtrim($f, '_id');
                $relModel = Str::studly($rel);
                $relVar   = Str::camel(Str::pluralStudly($rel));
                $html    .= <<<BLADE

                        <div class="mb-4">
                            <label class="form-label">{$label}</label>
                            <select name="{$f}" class="form-select @error('{$f}') is-invalid @enderror">
                                <option value="">-- Pilih {$label} --</option>
                                @foreach (\${$relVar} as \$item)
                                    <option value="{{ \$item->id }}"
                                        {{ {$oldVal} == \$item->id ? 'selected' : '' }}>
                                        {{ \$item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('{$f}')
                                <div class="invalid-feedback">{{ \$message }}</div>
                            @enderror
                        </div>

BLADE;
            } elseif ($f === 'status') {
                $html .= <<<BLADE

                        <div class="mb-4">
                            <label class="form-label">{$label} <span class="text-danger">*</span></label>
                            <select name="{$f}" class="form-select @error('{$f}') is-invalid @enderror">
                                {{-- Sesuaikan opsi dengan enum di database --}}
                                <option value="">-- Pilih {$label} --</option>
                                <option value="active" {{ {$oldVal} == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ {$oldVal} == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('{$f}')
                                <div class="invalid-feedback">{{ \$message }}</div>
                            @enderror
                        </div>

BLADE;
            } elseif (in_array($f, ['description', 'address', 'note', 'body', 'content'])) {
                $html .= <<<BLADE

                        <div class="mb-4">
                            <label class="form-label">{$label}</label>
                            <textarea name="{$f}" rows="3"
                                class="form-control @error('{$f}') is-invalid @enderror"
                                placeholder="Masukkan {$label}">{{ {$oldVal} }}</textarea>
                            @error('{$f}')
                                <div class="invalid-feedback">{{ \$message }}</div>
                            @enderror
                        </div>

BLADE;
            } elseif (in_array($f, ['start_date', 'end_date', 'sales_start', 'sales_end', 'paid_at', 'checkin_at'])) {
                $html .= <<<BLADE

                        <div class="mb-4">
                            <label class="form-label">{$label}</label>
                            <input type="datetime-local" name="{$f}"
                                class="form-control @error('{$f}') is-invalid @enderror"
                                value="{{ {$oldVal} ? date('Y-m-d\TH:i', strtotime({$oldVal})) : '' }}" />
                            @error('{$f}')
                                <div class="invalid-feedback">{{ \$message }}</div>
                            @enderror
                        </div>

BLADE;
            } elseif (in_array($f, ['price', 'amount', 'total', 'subtotal', 'discount'])) {
                $html .= <<<BLADE

                        <div class="mb-4">
                            <label class="form-label">{$label} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="{$f}" min="0" step="0.01"
                                    class="form-control @error('{$f}') is-invalid @enderror"
                                    value="{{ {$oldVal} }}" required />
                            </div>
                            @error('{$f}')
                                <div class="invalid-feedback">{{ \$message }}</div>
                            @enderror
                        </div>

BLADE;
            } elseif (in_array($f, ['capacity', 'quota', 'qty', 'order'])) {
                $html .= <<<BLADE

                        <div class="mb-4">
                            <label class="form-label">{$label} <span class="text-danger">*</span></label>
                            <input type="number" name="{$f}" min="0"
                                class="form-control @error('{$f}') is-invalid @enderror"
                                value="{{ {$oldVal} }}" required />
                            @error('{$f}')
                                <div class="invalid-feedback">{{ \$message }}</div>
                            @enderror
                        </div>

BLADE;
            } else {
                $required = ! in_array($f, ['phone', 'npwp', 'location', 'slug', 'qr_code', 'ticket_code'])
                    ? '<span class="text-danger">*</span>' : '';
                $isRequired = $required ? ' required' : '';
                $html    .= <<<BLADE

                        <div class="mb-4">
                            <label class="form-label">{$label} {$required}</label>
                            <input type="text" name="{$f}"
                                class="form-control @error('{$f}') is-invalid @enderror"
                                value="{{ {$oldVal} }}"
                                placeholder="Masukkan {$label}"{$isRequired} />
                            @error('{$f}')
                                <div class="invalid-feedback">{{ \$message }}</div>
                            @enderror
                        </div>

BLADE;
            }
        }

        return $html;
    }

    private function buildImagePanel(?string $imageField, ?string $varSingle, string $varForName): string
    {
        if (! $imageField) return '';

        $currentImg = $varSingle
            ? "{{ \${$varSingle}->{$imageField} ? minio_url(\${$varSingle}->{$imageField}) : '' }}"
            : '';

        $removeBlock = $varSingle ? <<<BLADE

                        @if(\${$varForName}->{$imageField})
                            <div class="form-check border rounded-3 p-3">
                                <input class="form-check-input" type="checkbox"
                                    name="remove_{$imageField}" id="remove_{$imageField}" value="1" />
                                <label class="form-check-label text-danger small" for="remove_{$imageField}">
                                    <i class="ti ti-trash me-1"></i> Hapus gambar saat ini
                                </label>
                            </div>
                        @endif
BLADE : '';

        $label = Str::headline($imageField);

        return <<<BLADE

            <div class="col-xl-4">
                <div class="card card-lg mb-4">
                    <div class="card-body">
                        <h6 class="mb-4 text-muted text-uppercase" style="font-size:11px; letter-spacing:.05em;">
                            {$label}
                        </h6>

                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img id="imagePreview"
                                    src="{$currentImg}"
                                    alt="{$label}"
                                    class="rounded object-fit-cover border"
                                    style="max-width:200px; max-height:150px; min-height:80px; background:#f0f0f0;"
                                    onerror="this.style.display='none'" />
                            </div>
                        </div>

                        <input type="file" name="{$imageField}" id="imageInput"
                            class="d-none @error('{$imageField}') is-invalid @enderror"
                            accept="image/jpg,image/jpeg,image/png,image/webp" />
                        @error('{$imageField}')
                            <div class="text-danger small mb-2">{{ \$message }}</div>
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
{$removeBlock}
                    </div>
                </div>
            </div>

BLADE;
    }

    private function buildImageScript(?string $imageField): string
    {
        if (! $imageField) return '';

        return <<<BLADE

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

        const removeCheckbox = document.getElementById('remove_{$imageField}');
        if (removeCheckbox) removeCheckbox.checked = false;
    });
</script>
@endpush
BLADE;
    }

    private function generateFile(string $path, string $content, string $label, bool $force): void
    {
        if (file_exists($path) && ! $force) {
            $this->warn("  SKIP  {$label} (sudah ada, gunakan --force untuk menimpa)");
            return;
        }

        @mkdir(dirname($path), 0755, true);
        file_put_contents($path, $content);
        $this->info("  ✔     {$label}");
    }

    private function parseList(?string $value): array
    {
        if (! $value) return [];
        return array_filter(array_map('trim', explode(',', $value)));
    }

    private function guessTable(string $modelName): string
    {
        return Str::snake(Str::pluralStudly($modelName));
    }
}