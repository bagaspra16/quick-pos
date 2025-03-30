<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Tanggal dan waktu 
        $today = Carbon::today();
        $lastWeek = Carbon::now()->subDays(7);
        $lastMonth = Carbon::now()->subDays(30);
        $currentYear = Carbon::now()->year;
        $lastYear = $currentYear - 1;
        
        // Statistik Hari Ini
        $totalSalesDay = Payment::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->sum('amount');
            
        $totalOrdersDay = Order::whereDate('created_at', $today)->count();
        
        // Top products
        $topProducts = OrderItem::whereHas('order', function ($query) use ($today) {
                $query->whereDate('created_at', $today);
            })
            ->select('product_id', DB::raw('SUM(quantity) as total'))
            ->groupBy('product_id')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->with('product')
            ->get();
            
        // Table status
        $tableStatus = Table::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
            
        // Penjualan mingguan
        $lastWeekSales = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$lastWeek, Carbon::now()])
            ->select(DB::raw('created_at::date as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Penjualan berdasarkan kategori (food/drink)
        $categorySales = OrderItem::whereHas('order', function ($query) use ($lastWeek) {
                $query->whereBetween('created_at', [$lastWeek, Carbon::now()]);
            })
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.type',
                DB::raw('order_items.created_at::date as date'),
                DB::raw('SUM(order_items.price * order_items.quantity) as total')
            )
            ->groupBy('products.type', 'date')
            ->orderBy('date')
            ->get();
            
        // Metode pembayaran
        $paymentMethods = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$lastMonth, Carbon::now()])
            ->select('payment_method', DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')
            ->get();
            
        // Penjualan per jam
        $hourlySales = Payment::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->select(DB::raw('EXTRACT(HOUR FROM created_at) as hour'), DB::raw('SUM(amount) as total'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
            
        // Monthly sales data for current year and last year
        $monthlySales = Payment::where('status', 'completed')
            ->select(
                DB::raw('EXTRACT(YEAR FROM created_at) as year'),
                DB::raw('EXTRACT(MONTH FROM created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Get last year's data
        $lastYearMonthlySales = $monthlySales->where('year', $lastYear);
            
        // Average order value
        $averageOrderValue = Payment::where('status', 'completed')
            ->whereBetween('created_at', [$lastMonth, Carbon::now()])
            ->select(DB::raw('created_at::date as date'), DB::raw('AVG(amount) as average'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Table performance
        $tablePerformance = Order::join('payments', 'orders.id', '=', 'payments.order_id')
            ->where('payments.status', 'completed')
            ->whereBetween('orders.created_at', [$lastMonth, Carbon::now()])
            ->select('orders.table_id', DB::raw('SUM(payments.amount) as total'))
            ->groupBy('orders.table_id')
            ->with('table')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
            
        return view('dashboard.index', compact(
            'totalSalesDay', 
            'totalOrdersDay', 
            'topProducts', 
            'tableStatus',
            'lastWeekSales',
            'categorySales',
            'paymentMethods',
            'hourlySales',
            'monthlySales',
            'lastYearMonthlySales',
            'averageOrderValue',
            'tablePerformance'
        ));
    }
} 