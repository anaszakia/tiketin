<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function index()
    {
        abort_unless(can('attendees.view'), 403);

        $attendees = Attendee::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.attendees.index', compact('attendees'));
    }

    public function create()
    {
        abort_unless(can('attendees.create'), 403);

        $orderItems = OrderItem::orderBy('name')->get();

        return view('admin.attendees.create', compact('attendee', 'orderItems'));
    }

    public function store(Request $request)
    {
        abort_unless(can('attendees.create'), 403);

        $request->validate([
            'order_item_id' => 'nullable|exists:order_items,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:attendees,email',
            'phone' => 'required|string|max:255',
            'ticket_code' => 'required|string|max:255',
            'qr_code' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        Attendee::create([
            'order_item_id' => $request->order_item_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'ticket_code' => $request->ticket_code,
            'qr_code' => $request->qr_code,
            'status' => $request->status,

        ]);

        return redirect()->route('attendees.index')
            ->with('success', 'Attendee berhasil ditambahkan!');
    }

    public function show(Attendee $attendee)
    {
        abort_unless(can('attendees.view'), 403);

        return view('admin.attendees.show', compact('attendee'));
    }

    public function edit(Attendee $attendee)
    {
        abort_unless(can('attendees.edit'), 403);

        $orderItems = OrderItem::orderBy('name')->get();

        return view('admin.attendees.edit', compact('attendee', 'orderItems'));
    }

    public function update(Request $request, Attendee $attendee)
    {
        abort_unless(can('attendees.edit'), 403);

        $request->validate([
            'order_item_id' => 'nullable|exists:order_items,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:attendees,email',
            'phone' => 'required|string|max:255',
            'ticket_code' => 'required|string|max:255',
            'qr_code' => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        $data = [
            'order_item_id' => $request->order_item_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'ticket_code' => $request->ticket_code,
            'qr_code' => $request->qr_code,
            'status' => $request->status,
        ];

        $attendee->update($data);

        return redirect()->route('attendees.index')
            ->with('success', 'Attendee berhasil diupdate!');
    }

    public function destroy(Attendee $attendee)
    {
        abort_unless(can('attendees.delete'), 403);

        $attendee->delete();

        return redirect()->route('attendees.index')
            ->with('success', 'Attendee berhasil dihapus!');
    }
}