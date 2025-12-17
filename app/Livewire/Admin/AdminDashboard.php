<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\ReturnRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboard extends Component
{
    public $dailyOrders;
    public $dailyRevenue;
    public $totalUsers;
    public $totalProducts;
    public $pendingReturns;
    public $recentOrders;
    public $salesData;

    public function mount()
    {
        // KPIs
        $this->dailyOrders = Order::whereDate('created_at', Carbon::today())->count();
        $this->dailyRevenue = Order::whereDate('created_at', Carbon::today())->sum('total');
        $this->totalUsers = User::where('role', 'customer')->count();
        $this->totalProducts = Product::count();
        $this->pendingReturns = ReturnRequest::where('status', 'pending')->count();

        // Recent Orders
        $this->recentOrders = Order::with('user')->latest()->take(5)->get();

        // Sales data for chart (last 7 days)
        $this->salesData = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total')
            )
            ->whereBetween('created_at', [Carbon::now()->subDays(6), Carbon::now()])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get()
            ->map(fn ($item) => [
                'date' => Carbon::parse($item->date)->format('D, M j'),
                'total' => $item->total,
            ])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard', [
            'chartData' => [
                'labels' => array_column($this->salesData, 'date'),
                'values' => array_column($this->salesData, 'total'),
            ]
        ])->layout('layouts.app');
    }
}
