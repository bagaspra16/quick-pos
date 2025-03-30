<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Table;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function tableMenu($barcode)
    {
        $table = Table::where('barcode', $barcode)->firstOrFail();
        
        // Get categories with products
        $categories = Category::with(['products' => function($query) {
            $query->where('available', true);
        }])->get();
        
        // Check if table has an active order
        $activeOrder = $table->activeOrder();
        
        return view('menu.index', compact('table', 'categories', 'activeOrder'));
    }
    
    public function placeOrder(Request $request, $barcode)
    {
        $table = Table::where('barcode', $barcode)->firstOrFail();
        
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        // Check if table already has an active order
        $activeOrder = $table->activeOrder();
        
        if ($activeOrder) {
            // Add items to existing order
            $order = $activeOrder;
        } else {
            // Create new order
            $order = Order::create([
                'table_id' => $table->id,
                'user_id' => null, // Akan diperbarui saat kasir mengkonfirmasi pesanan
                'status' => 'pending',
                'ordered_at' => now(),
                'notes' => $request->notes,
            ]);
            
            // Update table status
            $table->update(['status' => 'occupied']);
        }
        
        // Add items to order
        $totalAmount = $order->total_amount ?? 0;
        
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
                'notes' => $item['notes'] ?? null,
                'status' => 'pending',
            ]);
            
            $totalAmount += ($product->price * $item['quantity']);
        }
        
        // Update order total
        $order->update(['total_amount' => $totalAmount]);
        
        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat',
            'order' => $order->id
        ]);
    }
    
    public function checkOrderStatus($barcode)
    {
        $table = Table::where('barcode', $barcode)->firstOrFail();
        $activeOrder = $table->activeOrder();
        
        if (!$activeOrder) {
            return response()->json([
                'status' => 'no_order',
                'message' => 'Tidak ada pesanan aktif untuk meja ini'
            ]);
        }
        
        $activeOrder->load('items.product');
        
        return response()->json([
            'status' => $activeOrder->status,
            'order' => $activeOrder,
            'items' => $activeOrder->items
        ]);
    }
} 