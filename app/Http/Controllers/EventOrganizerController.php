<?php

namespace App\Http\Controllers;

use App\Models\EventOrganizer;
use App\Models\User;
use Illuminate\Http\Request;

class EventOrganizerController extends Controller
{
    public function index()
    {
        abort_unless(can('event_organizers.view'), 403);

        $eventOrganizers = EventOrganizer::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.event_organizers.index', compact('eventOrganizers'));
    }

    public function create()
    {
        abort_unless(can('event_organizers.create'), 403);

        $users = User::orderBy('name')->get();

        return view('admin.event_organizers.create', compact('eventOrganizer', 'users'));
    }

    public function store(Request $request)
    {
        abort_unless(can('event_organizers.create'), 403);

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'organizer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'nullable|string',
            'npwp' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = minio_upload($request->file('logo'), 'eventOrganizers');
        }
        EventOrganizer::create([
            'user_id' => $request->user_id,
            'organizer_name' => $request->organizer_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'npwp' => $request->npwp,
            'logo'      => $logoPath,
        ]);

        return redirect()->route('event_organizers.index')
            ->with('success', 'Event Organizer berhasil ditambahkan!');
    }

    public function show(EventOrganizer $eventOrganizer)
    {
        abort_unless(can('event_organizers.view'), 403);

        return view('admin.event_organizers.show', compact('eventOrganizer'));
    }

    public function edit(EventOrganizer $eventOrganizer)
    {
        abort_unless(can('event_organizers.edit'), 403);

        $users = User::orderBy('name')->get();

        return view('admin.event_organizers.edit', compact('eventOrganizer', 'users'));
    }

    public function update(Request $request, EventOrganizer $eventOrganizer)
    {
        abort_unless(can('event_organizers.edit'), 403);

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'organizer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'nullable|string',
            'npwp' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'user_id' => $request->user_id,
            'organizer_name' => $request->organizer_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'npwp' => $request->npwp,
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = minio_replace($eventOrganizer->logo, $request->file('logo'), 'eventOrganizers');
        }
        if ($request->has('remove_logo') && $eventOrganizer->logo) {
            minio_delete($eventOrganizer->logo);
            $data['logo'] = null;
        }
        $eventOrganizer->update($data);

        return redirect()->route('event_organizers.index')
            ->with('success', 'Event Organizer berhasil diupdate!');
    }

    public function destroy(EventOrganizer $eventOrganizer)
    {
        abort_unless(can('event_organizers.delete'), 403);

        if ($eventOrganizer->logo) {
            minio_delete($eventOrganizer->logo);
        }
        $eventOrganizer->delete();

        return redirect()->route('event_organizers.index')
            ->with('success', 'Event Organizer berhasil dihapus!');
    }
}