<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $metrics = [
            'total_customers' => Customer::count(),
            'total_orders' => Order::count(),
            'revenue_this_month' => Order::whereMonth('created_at', now())
                ->sum('total'),
            'orders_this_week' => Order::whereDate('created_at', '>=', now()->startOfWeek())
                ->count(),
        ];

        $recentOrders = Order::with(['customer', 'status'])
            ->latest()
            ->take(5)
            ->get();

        $ordersByStatus = Order::select('status_id', DB::raw('count(*) as count'))
            ->with('status')
            ->groupBy('status_id')
            ->get();

        $topCustomers = Customer::withCount('orders')
            ->withSum('orders', 'total')
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();

        return Inertia::render('Dashboard', [
            'metrics' => $metrics,
            'recentOrders' => $recentOrders,
            'ordersByStatus' => $ordersByStatus,
            'topCustomers' => $topCustomers,
        ]);
    }
}
