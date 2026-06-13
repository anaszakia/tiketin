<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        abort_unless(can('orders.view'), 403);

        $orders = Order::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        abort_unless(can('orders.create'), 403);

        $users = User::orderBy('name')->get();
        $events = Event::orderBy('name')->get();

        return view('admin.orders.create', compact('order', 'users', 'events'));
    }

    public function store(Request $request)
    {
        abort_unless(can('orders.create'), 403);

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'event_id' => 'nullable|exists:events,id',
            'invoice_number' => 'required|string|max:255',
            'total_amount' => 'required|string|max:255',
            'status' => 'required|string',
            'payment_method' => 'required|string|max:255',
            'payment_status' => 'required|string|max:255',
            'paid_at' => 'nullable|date',
            'expired_at' => 'required|string|max:255',
        ]);

        Order::create([
            'user_id' => $request->user_id,
            'event_id' => $request->event_id,
            'invoice_number' => $request->invoice_number,
            'total_amount' => $request->total_amount,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
            'paid_at' => $request->paid_at,
            'expired_at' => $request->expired_at,

        ]);

        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil ditambahkan!');
    }

    public function show(Order $order)
    {
        abort_unless(can('orders.view'), 403);

        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        abort_unless(can('orders.edit'), 403);

        $users = User::orderBy('name')->get();
        $events = Event::orderBy('name')->get();

        return view('admin.orders.edit', compact('order', 'users', 'events'));
    }

    public function update(Request $request, Order $order)
    {
        abort_unless(can('orders.edit'), 403);

        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'event_id' => 'nullable|exists:events,id',
            'invoice_number' => 'required|string|max:255',
            'total_amount' => 'required|string|max:255',
            'status' => 'required|string',
            'payment_method' => 'required|string|max:255',
            'payment_status' => 'required|string|max:255',
            'paid_at' => 'nullable|date',
            'expired_at' => 'required|string|max:255',
        ]);

        $data = [
            'user_id' => $request->user_id,
            'event_id' => $request->event_id,
            'invoice_number' => $request->invoice_number,
            'total_amount' => $request->total_amount,
            'status' => $request->status,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status,
            'paid_at' => $request->paid_at,
            'expired_at' => $request->expired_at,
        ];

        $order->update($data);

        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil diupdate!');
    }

    public function destroy(Order $order)
    {
        abort_unless(can('orders.delete'), 403);

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order berhasil dihapus!');
    }
}