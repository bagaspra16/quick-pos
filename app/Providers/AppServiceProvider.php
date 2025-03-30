<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share notification data with all views
        view()->composer('layouts.app', function ($view) {
            // Only execute when user is logged in
            if (auth()->check()) {
                $activeOrdersCount = \App\Models\Order::whereIn('status', ['pending', 'processing'])->count();
                $activeTablesCount = \App\Models\Table::where('status', 'occupied')->count();
                $recentOrders = \App\Models\Order::with('table')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
                
                $view->with([
                    'activeOrdersCount' => $activeOrdersCount,
                    'activeTablesCount' => $activeTablesCount,
                    'recentOrders' => $recentOrders,
                ]);
            } else {
                $view->with([
                    'activeOrdersCount' => 0,
                    'activeTablesCount' => 0,
                    'recentOrders' => collect([]),
                ]);
            }
        });
    }
}
