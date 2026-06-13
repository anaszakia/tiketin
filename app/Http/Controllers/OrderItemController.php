<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\EventTicket;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        abort_unless(can('order_items.view'), 403);

        $orderItems = OrderItem::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.order_items.index', compact('orderItems'));
    }

    public function create()
    {
        abort_unless(can('order_items.create'), 403);

        $orders = Order::orderBy('name')->get();
        $eventTickets = EventTicket::orderBy('name')->get();

        return view('admin.order_items.create', compact('orderItem', 'orders', 'eventTickets'));
    }

    public function store(Request $request)
    {
        abort_unless(can('order_items.create'), 403);

        $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'ticket_id' => 'nullable|exists:tickets,id',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        OrderItem::create([
            'order_id' => $request->order_id,
            'ticket_id' => $request->ticket_id,
            'price' => $request->price,
            'discount' => $request->discount,
            'qty' => $request->qty,
            'subtotal' => $request->subtotal,

        ]);

        return redirect()->route('order_items.index')
            ->with('success', 'Order Item berhasil ditambahkan!');
    }

    public function show(OrderItem $orderItem)
    {
        abort_unless(can('order_items.view'), 403);

        return view('admin.order_items.show', compact('orderItem'));
    }

    public function edit(OrderItem $orderItem)
    {
        abort_unless(can('order_items.edit'), 403);

        $orders = Order::orderBy('name')->get();
        $eventTickets = EventTicket::orderBy('name')->get();

        return view('admin.order_items.edit', compact('orderItem', 'orders', 'eventTickets'));
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        abort_unless(can('order_items.edit'), 403);

        $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'ticket_id' => 'nullable|exists:tickets,id',
            'price' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:0',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $data = [
            'order_id' => $request->order_id,
            'ticket_id' => $request->ticket_id,
            'price' => $request->price,
            'discount' => $request->discount,
            'qty' => $request->qty,
            'subtotal' => $request->subtotal,
        ];

        $orderItem->update($data);

        return redirect()->route('order_items.index')
            ->with('success', 'Order Item berhasil diupdate!');
    }

    public function destroy(OrderItem $orderItem)
    {
        abort_unless(can('order_items.delete'), 403);

        $orderItem->delete();

        return redirect()->route('order_items.index')
            ->with('success', 'Order Item berhasil dihapus!');
    }
}