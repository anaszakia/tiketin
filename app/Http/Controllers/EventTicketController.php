<?php

namespace App\Http\Controllers;

use App\Models\EventTicket;
use App\Models\Event;
use Illuminate\Http\Request;

class EventTicketController extends Controller
{
    public function index()
    {
        abort_unless(can('event_tickets.view'), 403);

        $eventTickets = EventTicket::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.event_tickets.index', compact('eventTickets'));
    }

    public function create()
    {
        abort_unless(can('event_tickets.create'), 403);

        $events = Event::orderBy('name')->get();

        return view('admin.event_tickets.create', compact('eventTicket', 'events'));
    }

    public function store(Request $request)
    {
        abort_unless(can('event_tickets.create'), 403);

        $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
            'sales_start' => 'nullable|date',
            'sales_end' => 'nullable|date',
            'status' => 'required|string',
        ]);

        EventTicket::create([
            'event_id' => $request->event_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quota' => $request->quota,
            'sales_start' => $request->sales_start,
            'sales_end' => $request->sales_end,
            'status' => $request->status,

        ]);

        return redirect()->route('event_tickets.index')
            ->with('success', 'Event Ticket berhasil ditambahkan!');
    }

    public function show(EventTicket $eventTicket)
    {
        abort_unless(can('event_tickets.view'), 403);

        return view('admin.event_tickets.show', compact('eventTicket'));
    }

    public function edit(EventTicket $eventTicket)
    {
        abort_unless(can('event_tickets.edit'), 403);

        $events = Event::orderBy('name')->get();

        return view('admin.event_tickets.edit', compact('eventTicket', 'events'));
    }

    public function update(Request $request, EventTicket $eventTicket)
    {
        abort_unless(can('event_tickets.edit'), 403);

        $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
            'sales_start' => 'nullable|date',
            'sales_end' => 'nullable|date',
            'status' => 'required|string',
        ]);

        $data = [
            'event_id' => $request->event_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quota' => $request->quota,
            'sales_start' => $request->sales_start,
            'sales_end' => $request->sales_end,
            'status' => $request->status,
        ];

        $eventTicket->update($data);

        return redirect()->route('event_tickets.index')
            ->with('success', 'Event Ticket berhasil diupdate!');
    }

    public function destroy(EventTicket $eventTicket)
    {
        abort_unless(can('event_tickets.delete'), 403);

        $eventTicket->delete();

        return redirect()->route('event_tickets.index')
            ->with('success', 'Event Ticket berhasil dihapus!');
    }
}