<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $completedOrders = Order::whereIn('status', ['completed', 'selesai'])->get();
        $totalOmset = $completedOrders->sum('total_price');

        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');

        $recentOrders = Order::with('orderItems.product')
            ->latest()
            ->take(5)
            ->get();

        $recentProducts = Product::latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOmset',
            'totalOrders',
            'completedOrders',
            'totalProducts',
            'totalStock',
            'recentOrders',
            'recentProducts'
        ));
    }
}
