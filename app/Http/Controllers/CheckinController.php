<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use App\Models\Attendee;
use App\Models\User;
use Illuminate\Http\Request;

class CheckinController extends Controller
{
    public function index()
    {
        abort_unless(can('checkins.view'), 403);

        $checkins = Checkin::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.checkins.index', compact('checkins'));
    }

    public function create()
    {
        abort_unless(can('checkins.create'), 403);

        $attendees = Attendee::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.checkins.create', compact('checkin', 'attendees', 'users'));
    }

    public function store(Request $request)
    {
        abort_unless(can('checkins.create'), 403);

        $request->validate([
            'attendee_id' => 'nullable|exists:attendees,id',
            'officer_id' => 'nullable|exists:officers,id',
            'checkin_at' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        Checkin::create([
            'attendee_id' => $request->attendee_id,
            'officer_id' => $request->officer_id,
            'checkin_at' => $request->checkin_at,
            'location' => $request->location,
            'note' => $request->note,

        ]);

        return redirect()->route('checkins.index')
            ->with('success', 'Checkin berhasil ditambahkan!');
    }

    public function show(Checkin $checkin)
    {
        abort_unless(can('checkins.view'), 403);

        return view('admin.checkins.show', compact('checkin'));
    }

    public function edit(Checkin $checkin)
    {
        abort_unless(can('checkins.edit'), 403);

        $attendees = Attendee::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.checkins.edit', compact('checkin', 'attendees', 'users'));
    }

    public function update(Request $request, Checkin $checkin)
    {
        abort_unless(can('checkins.edit'), 403);

        $request->validate([
            'attendee_id' => 'nullable|exists:attendees,id',
            'officer_id' => 'nullable|exists:officers,id',
            'checkin_at' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        $data = [
            'attendee_id' => $request->attendee_id,
            'officer_id' => $request->officer_id,
            'checkin_at' => $request->checkin_at,
            'location' => $request->location,
            'note' => $request->note,
        ];

        $checkin->update($data);

        return redirect()->route('checkins.index')
            ->with('success', 'Checkin berhasil diupdate!');
    }

    public function destroy(Checkin $checkin)
    {
        abort_unless(can('checkins.delete'), 403);

        $checkin->delete();

        return redirect()->route('checkins.index')
            ->with('success', 'Checkin berhasil dihapus!');
    }
}