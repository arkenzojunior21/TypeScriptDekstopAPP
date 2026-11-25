<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->where('role', 'customer')->select('id', 'name', 'email', 'phone', 'created_at');
        if ($request->user()->role === 'store_admin') {
            $query->whereHas('customerOrders', fn ($orders) => $orders->where('store_id', $request->user()->store_id));
        }
        if ($search = $request->get('search')) $query->where(fn ($q) => $q->where('name', 'ilike', "%{$search}%")->orWhere('phone', 'ilike', "%{$search}%"));
        return $query->latest()->paginate($request->integer('per_page', 15));
    }
}
