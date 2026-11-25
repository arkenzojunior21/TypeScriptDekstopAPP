<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request) { return Store::query()->where('status', 'active')->orderBy('name')->paginate($request->integer('per_page', 20)); }
    public function show(Store $store) { return $store->load(['services' => fn ($q) => $q->where('status', 'active')]); }
    public function update(Request $request, Store $store)
    {
        abort_unless($request->user()->role === 'platform_admin' || $request->user()->store_id === $store->id, 403);
        $store->update($request->validate(['name' => ['sometimes', 'string', 'max:150'], 'address' => ['sometimes', 'string'], 'phone' => ['nullable', 'string', 'max:32'], 'latitude' => ['nullable', 'numeric', 'between:-90,90'], 'longitude' => ['nullable', 'numeric', 'between:-180,180'], 'status' => ['sometimes', 'in:active,inactive']]));
        return $store->refresh();
    }
}
