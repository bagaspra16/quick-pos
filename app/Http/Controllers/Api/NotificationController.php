<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get notification data for the dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Count active orders (pending and processing status)
        $activeOrdersCount = Order::whereIn('status', ['pending', 'processing'])->count();
        
        // Count tables in use
        $activeTablesCount = Table::where('status', 'occupied')->count();
        
        // Get recent orders (last 5)
        $recentOrders = Order::with('table')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get last updated time for orders and tables
        $lastOrderUpdate = Order::orderBy('updated_at', 'desc')->first()?->updated_at->timestamp ?? 0;
        $lastTableUpdate = Table::orderBy('updated_at', 'desc')->first()?->updated_at->timestamp ?? 0;
        
        return response()->json([
            'activeOrdersCount' => $activeOrdersCount,
            'activeTablesCount' => $activeTablesCount,
            'recentOrders' => $recentOrders,
            'lastUpdated' => max($lastOrderUpdate, $lastTableUpdate),
            'orderUpdate' => $lastOrderUpdate,
            'tableUpdate' => $lastTableUpdate
        ]);
    }
}
