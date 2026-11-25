<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function summary(Request $request)
    {
        $storeId = $request->user()->role === 'store_admin' ? $request->user()->store_id : $request->integer('store_id');
        $orders = DB::table('orders')->when($storeId, fn ($q) => $q->where('store_id', $storeId));
        $today = (clone $orders)->whereDate('created_at', today());
        return ['orders_today' => $today->count(), 'revenue_today' => (float) $today->where('payment_status', 'paid')->sum('total'), 'new_orders' => (clone $orders)->where('status', 'new')->count(), 'processing_orders' => (clone $orders)->where('status', 'processing')->count(), 'ready_orders' => (clone $orders)->where('status', 'ready_for_pickup')->count(), 'weekly' => (clone $orders)->selectRaw("DATE(created_at) as date, COUNT(*) as count")->where('created_at', '>=', now()->subDays(6)->startOfDay())->groupBy('date')->orderBy('date')->get()];
    }
}
