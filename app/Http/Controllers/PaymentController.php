<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        abort_unless(can('payments.view'), 403);

        $payments = Payment::orderBy('created_at', 'desc')->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        abort_unless(can('payments.create'), 403);

        $orders = Order::orderBy('name')->get();

        return view('admin.payments.create', compact('payment', 'orders'));
    }

    public function store(Request $request)
    {
        abort_unless(can('payments.create'), 403);

        $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'payment_method' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_gateway' => 'required|string|max:255',
            'transaction_id' => 'nullable|exists:transactions,id',
            'status' => 'required|string',
            'paid_at' => 'nullable|date',
        ]);

        Payment::create([
            'order_id' => $request->order_id,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'payment_gateway' => $request->payment_gateway,
            'transaction_id' => $request->transaction_id,
            'status' => $request->status,
            'paid_at' => $request->paid_at,

        ]);

        return redirect()->route('payments.index')
            ->with('success', 'Payment berhasil ditambahkan!');
    }

    public function show(Payment $payment)
    {
        abort_unless(can('payments.view'), 403);

        return view('admin.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        abort_unless(can('payments.edit'), 403);

        $orders = Order::orderBy('name')->get();

        return view('admin.payments.edit', compact('payment', 'orders'));
    }

    public function update(Request $request, Payment $payment)
    {
        abort_unless(can('payments.edit'), 403);

        $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'payment_method' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_gateway' => 'required|string|max:255',
            'transaction_id' => 'nullable|exists:transactions,id',
            'status' => 'required|string',
            'paid_at' => 'nullable|date',
        ]);

        $data = [
            'order_id' => $request->order_id,
            'payment_method' => $request->payment_method,
            'amount' => $request->amount,
            'payment_gateway' => $request->payment_gateway,
            'transaction_id' => $request->transaction_id,
            'status' => $request->status,
            'paid_at' => $request->paid_at,
        ];

        $payment->update($data);

        return redirect()->route('payments.index')
            ->with('success', 'Payment berhasil diupdate!');
    }

    public function destroy(Payment $payment)
    {
        abort_unless(can('payments.delete'), 403);

        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Payment berhasil dihapus!');
    }
}