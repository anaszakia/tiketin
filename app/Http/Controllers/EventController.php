<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventOrganizer;
use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        abort_unless(can('events.view'), 403);

        $events = Event::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        abort_unless(can('events.create'), 403);

        $eventOrganizers = EventOrganizer::orderBy('name')->get();
        $eventCategories = EventCategory::orderBy('name')->get();

        return view('admin.events.create', compact('event', 'eventOrganizers', 'eventCategories'));
    }

    public function store(Request $request)
    {
        abort_unless(can('events.create'), 403);

        $request->validate([
            'organizer_id' => 'nullable|exists:organizers,id',
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'location' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'capacity' => 'required|integer|min:0',
            'status' => 'required|string',
        ]);

        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = minio_upload($request->file('banner'), 'events');
        }
        Event::create([
            'organizer_id' => $request->organizer_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'capacity' => $request->capacity,
            'status' => $request->status,
            'banner'      => $bannerPath,
        ]);

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil ditambahkan!');
    }

    public function show(Event $event)
    {
        abort_unless(can('events.view'), 403);

        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        abort_unless(can('events.edit'), 403);

        $eventOrganizers = EventOrganizer::orderBy('name')->get();
        $eventCategories = EventCategory::orderBy('name')->get();

        return view('admin.events.edit', compact('event', 'eventOrganizers', 'eventCategories'));
    }

    public function update(Request $request, Event $event)
    {
        abort_unless(can('events.edit'), 403);

        $request->validate([
            'organizer_id' => 'nullable|exists:organizers,id',
            'category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'location' => 'required|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'capacity' => 'required|integer|min:0',
            'status' => 'required|string',
        ]);

        $data = [
            'organizer_id' => $request->organizer_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'capacity' => $request->capacity,
            'status' => $request->status,
        ];

        if ($request->hasFile('banner')) {
            $data['banner'] = minio_replace($event->banner, $request->file('banner'), 'events');
        }
        if ($request->has('remove_banner') && $event->banner) {
            minio_delete($event->banner);
            $data['banner'] = null;
        }
        $event->update($data);

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil diupdate!');
    }

    public function destroy(Event $event)
    {
        abort_unless(can('events.delete'), 403);

        if ($event->banner) {
            minio_delete($event->banner);
        }
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event berhasil dihapus!');
    }
}