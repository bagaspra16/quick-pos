<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['table', 'user'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['table', 'user', 'items.product', 'payment']);
        return view('orders.show', compact('order'));
    }

    public function create()
    {
        $tables = Table::where('status', 'available')->get();
        $products = Product::where('available', true)->get();
        return view('orders.create', compact('tables', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.notes' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Create order
        $order = Order::create([
            'table_id' => $request->table_id,
            'user_id' => Auth::id(),
            'status' => 'processing',
            'ordered_at' => now(),
            'notes' => $request->notes,
        ]);

        $totalAmount = 0;

        // Add order items
        foreach ($request->products as $item) {
            $product = Product::find($item['id']);
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'notes' => $item['notes'] ?? null,
                'status' => 'pending',
            ]);
            
            $totalAmount += $product->price * $item['quantity'];
        }

        // Update order total
        $order->update(['total_amount' => $totalAmount]);

        // Update table status
        Table::find($request->table_id)->update(['status' => 'occupied']);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;
        
        if ($request->status == 'completed') {
            $order->completed_at = now();
            // Set table as available again if needed
            if ($order->table->status == 'occupied') {
                $order->table->status = 'available';
                $order->table->save();
            }
        }
        
        if ($request->status == 'cancelled' && $oldStatus != 'completed') {
            // Set table as available again if cancelled
            if ($order->table->status == 'occupied') {
                $order->table->status = 'available';
                $order->table->save();
            }
        }
        
        $order->save();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Status pesanan berhasil diubah!');
    }

    public function updateItemStatus(Request $request, OrderItem $item)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,served,cancelled',
        ]);

        $item->status = $request->status;
        $item->save();

        return redirect()->route('orders.show', $item->order_id)
            ->with('success', 'Status item berhasil diubah!');
    }
} 