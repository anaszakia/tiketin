<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index()
    {
        abort_unless(can('event_categories.view'), 403);

        $eventCategories = EventCategory::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.event_categories.index', compact('eventCategories'));
    }

    public function create()
    {
        abort_unless(can('event_categories.create'), 403);


        return view('admin.event_categories.create', compact('eventCategory'));
    }

    public function store(Request $request)
    {
        abort_unless(can('event_categories.create'), 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ]);

        EventCategory::create([
            'name' => $request->name,
            'slug' => $request->slug,

        ]);

        return redirect()->route('event_categories.index')
            ->with('success', 'Event Category berhasil ditambahkan!');
    }

    public function show(EventCategory $eventCategory)
    {
        abort_unless(can('event_categories.view'), 403);

        return view('admin.event_categories.show', compact('eventCategory'));
    }

    public function edit(EventCategory $eventCategory)
    {
        abort_unless(can('event_categories.edit'), 403);


        return view('admin.event_categories.edit', compact('eventCategory'));
    }

    public function update(Request $request, EventCategory $eventCategory)
    {
        abort_unless(can('event_categories.edit'), 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
        ];

        $eventCategory->update($data);

        return redirect()->route('event_categories.index')
            ->with('success', 'Event Category berhasil diupdate!');
    }

    public function destroy(EventCategory $eventCategory)
    {
        abort_unless(can('event_categories.delete'), 403);

        $eventCategory->delete();

        return redirect()->route('event_categories.index')
            ->with('success', 'Event Category berhasil dihapus!');
    }
}