<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventOrganizer;
use App\Models\EventCategory;
use App\Models\EventTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function index()
    {
        abort_unless(can('events.view'), 403);

        $events = Event::with('tickets')->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        abort_unless(can('events.create'), 403);

        $eventOrganizers = EventOrganizer::orderBy('organizer_name')->get();
        $eventCategories = EventCategory::orderBy('name')->get();

        return view('admin.events.create', compact('eventOrganizers', 'eventCategories'));
    }

    public function store(Request $request)
    {
        abort_unless(can('events.create'), 403);

        $request->validate([
            ...$this->eventRules(),
            'slug' => 'required|string|max:255|unique:events,slug',
        ]);

        DB::transaction(function () use ($request) {
            $data = $this->eventData($request);
            $data['banner'] = $request->hasFile('banner')
                ? minio_upload($request->file('banner'), 'events')
                : null;
            $data['gallery_images'] = $this->uploadGalleryImages($request);

            $event = Event::create($data);
            $this->syncTickets($event, $request->input('tickets', []));
        });

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil ditambahkan!');
    }

    public function show(Event $event)
    {
        abort_unless(can('events.view'), 403);

        $event->load('tickets');

        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        abort_unless(can('events.edit'), 403);

        $eventOrganizers = EventOrganizer::orderBy('organizer_name')->get();
        $eventCategories = EventCategory::orderBy('name')->get();
        $event->load('tickets');

        return view('admin.events.edit', compact('event', 'eventOrganizers', 'eventCategories'));
    }

    public function update(Request $request, Event $event)
    {
        abort_unless(can('events.edit'), 403);

        $request->validate([
            ...$this->eventRules(),
            'slug' => ['required', 'string', 'max:255', Rule::unique('events', 'slug')->ignore($event->id)],
        ]);

        DB::transaction(function () use ($request, $event) {
            $data = $this->eventData($request);

            if ($request->hasFile('banner')) {
                $data['banner'] = minio_replace($event->banner, $request->file('banner'), 'events');
            } elseif ($request->has('remove_banner') && $event->banner) {
                minio_delete($event->banner);
                $data['banner'] = null;
            }

            $galleryImages = $event->gallery_images ?? [];
            foreach ($request->input('remove_gallery_images', []) as $path) {
                if (in_array($path, $galleryImages, true)) {
                    minio_delete($path);
                    $galleryImages = array_values(array_diff($galleryImages, [$path]));
                }
            }
            $data['gallery_images'] = array_values(array_merge($galleryImages, $this->uploadGalleryImages($request)));

            $event->update($data);
            $this->syncTickets($event, $request->input('tickets', []));
        });

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil diupdate!');
    }

    public function destroy(Event $event)
    {
        abort_unless(can('events.delete'), 403);

        if ($event->banner) {
            minio_delete($event->banner);
        }
        foreach ($event->gallery_images ?? [] as $galleryImage) {
            minio_delete($galleryImage);
        }
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dihapus!');
    }

    private function eventRules(): array
    {
        return [
            'organizer_id' => 'required|exists:event_organizers,id',
            'category_id' => 'nullable|exists:event_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'location' => 'required|string|max:255',
            'venue_name' => 'nullable|string|max:255',
            'address_detail' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'province' => 'nullable|string|max:100',
            'map_url' => 'nullable|url|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'capacity' => 'required|integer|min:0',
            'terms' => 'nullable|string',
            'rundown' => 'nullable|string',
            'contact_name' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:30',
            'contact_email' => 'nullable|email|max:255',
            'minimum_age' => 'nullable|integer|min:0|max:100',
            'refund_policy' => 'nullable|string',
            'status' => ['required', Rule::in(['draft', 'pending', 'published', 'rejected', 'finished', 'cancelled'])],
            'tickets' => 'nullable|array',
            'tickets.*.id' => 'nullable|exists:event_tickets,id',
            'tickets.*.name' => 'nullable|string|max:255',
            'tickets.*.description' => 'nullable|string',
            'tickets.*.price' => 'nullable|numeric|min:0',
            'tickets.*.quota' => 'nullable|integer|min:0',
            'tickets.*.sales_start' => 'nullable|date',
            'tickets.*.sales_end' => 'nullable|date',
            'tickets.*.status' => ['nullable', Rule::in(['active', 'inactive', 'sold_out'])],
        ];
    }

    private function eventData(Request $request): array
    {
        return $request->only([
            'organizer_id',
            'category_id',
            'name',
            'slug',
            'description',
            'short_description',
            'location',
            'venue_name',
            'address_detail',
            'city',
            'province',
            'map_url',
            'start_date',
            'end_date',
            'capacity',
            'terms',
            'rundown',
            'contact_name',
            'contact_phone',
            'contact_email',
            'minimum_age',
            'refund_policy',
            'status',
        ]);
    }

    private function uploadGalleryImages(Request $request): array
    {
        $paths = [];

        foreach ($request->file('gallery_images', []) as $image) {
            $paths[] = minio_upload($image, 'events/gallery');
        }

        return $paths;
    }

    private function syncTickets(Event $event, array $tickets): void
    {
        $keptIds = [];

        foreach ($tickets as $ticket) {
            if (blank($ticket['name'] ?? null)) {
                continue;
            }

            $data = [
                'name' => $ticket['name'],
                'description' => $ticket['description'] ?? null,
                'price' => $ticket['price'] ?? 0,
                'quota' => $ticket['quota'] ?? 0,
                'sales_start' => $ticket['sales_start'] ?? null,
                'sales_end' => $ticket['sales_end'] ?? null,
                'status' => $ticket['status'] ?? 'active',
            ];

            if (! empty($ticket['id'])) {
                $eventTicket = $event->tickets()->whereKey($ticket['id'])->first();
                if (! $eventTicket) {
                    continue;
                }

                $eventTicket->update($data);
                $keptIds[] = $eventTicket->id;
                continue;
            }

            $keptIds[] = $event->tickets()->create($data)->id;
        }

        EventTicket::where('event_id', $event->id)
            ->when($keptIds, fn ($query) => $query->whereNotIn('id', $keptIds))
            ->delete();
    }
}
