<?php

namespace App\Http\Controllers;

use App\Models\EventStaff;
use App\Models\Event;
use App\Models\User;
use App\Models\EventRole;
use Illuminate\Http\Request;

class EventStaffController extends Controller
{
    public function index()
    {
        abort_unless(can('event_staff.view'), 403);

        $eventStaff = EventStaff::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.event_staff.index', compact('eventStaff'));
    }

    public function create()
    {
        abort_unless(can('event_staff.create'), 403);

        $events = Event::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $eventRoles = EventRole::orderBy('name')->get();

        return view('admin.event_staff.create', compact('eventStaff', 'events', 'users', 'eventRoles'));
    }

    public function store(Request $request)
    {
        abort_unless(can('event_staff.create'), 403);

        $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'user_id' => 'nullable|exists:users,id',
            'event_role_id' => 'nullable|exists:event_roles,id',
        ]);

        EventStaff::create([
            'event_id' => $request->event_id,
            'user_id' => $request->user_id,
            'event_role_id' => $request->event_role_id,

        ]);

        return redirect()->route('event_staff.index')
            ->with('success', 'Event Staff berhasil ditambahkan!');
    }

    public function show(EventStaff $eventStaff)
    {
        abort_unless(can('event_staff.view'), 403);

        return view('admin.event_staff.show', compact('eventStaff'));
    }

    public function edit(EventStaff $eventStaff)
    {
        abort_unless(can('event_staff.edit'), 403);

        $events = Event::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $eventRoles = EventRole::orderBy('name')->get();

        return view('admin.event_staff.edit', compact('eventStaff', 'events', 'users', 'eventRoles'));
    }

    public function update(Request $request, EventStaff $eventStaff)
    {
        abort_unless(can('event_staff.edit'), 403);

        $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'user_id' => 'nullable|exists:users,id',
            'event_role_id' => 'nullable|exists:event_roles,id',
        ]);

        $data = [
            'event_id' => $request->event_id,
            'user_id' => $request->user_id,
            'event_role_id' => $request->event_role_id,
        ];

        $eventStaff->update($data);

        return redirect()->route('event_staff.index')
            ->with('success', 'Event Staff berhasil diupdate!');
    }

    public function destroy(EventStaff $eventStaff)
    {
        abort_unless(can('event_staff.delete'), 403);

        $eventStaff->delete();

        return redirect()->route('event_staff.index')
            ->with('success', 'Event Staff berhasil dihapus!');
    }
}