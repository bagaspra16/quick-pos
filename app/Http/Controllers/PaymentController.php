<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['order.table', 'user'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        return view('payments.index', compact('payments'));
    }

    public function create(Order $order)
    {
        if ($order->payment) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Pesanan ini sudah memiliki pembayaran!');
        }

        if ($order->status !== 'completed' && $order->status !== 'processing') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Hanya pesanan yang sedang diproses atau selesai yang dapat dibayar!');
        }

        return view('payments.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'received_amount' => 'required|numeric|min:' . $order->total_amount,
            'payment_method' => 'required|in:cash,debit,credit,qris,other',
            'transaction_id' => 'nullable|required_unless:payment_method,cash|string',
        ]);

        $changeAmount = $request->received_amount - $order->total_amount;

        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'amount' => $order->total_amount,
            'received_amount' => $request->received_amount,
            'change_amount' => $changeAmount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => 'completed',
        ]);

        // Update order status to completed
        $order->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        // Update table status to available
        $order->table->update(['status' => 'available']);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pembayaran berhasil dilakukan!');
    }

    public function show(Payment $payment)
    {
        $payment->load(['order.table', 'order.items.product', 'user']);
        return view('payments.show', compact('payment'));
    }

    public function printReceipt(Payment $payment)
    {
        $payment->load(['order.table', 'order.items.product', 'user']);
        return view('payments.receipt', compact('payment'));
    }
} 