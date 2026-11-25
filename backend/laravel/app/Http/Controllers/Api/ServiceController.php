<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request) { return Service::query()->when($request->integer('store_id'), fn ($q, $id) => $q->where('store_id', $id))->where('status', 'active')->orderBy('name')->get(); }
    public function store(Request $request)
    {
        $data = $request->validate(['store_id' => ['required', 'exists:stores,id'], 'name' => ['required', 'string', 'max:150'], 'description' => ['nullable', 'string'], 'price' => ['required', 'numeric', 'min:0'], 'unit' => ['required', 'in:kg,unit'], 'status' => ['nullable', 'in:active,inactive']]);
        abort_unless($request->user()->role === 'platform_admin' || $request->user()->store_id === (int) $data['store_id'], 403);
        return response()->json(Service::create($data), 201);
    }
    public function update(Request $request, Service $service)
    {
        abort_unless($request->user()->role === 'platform_admin' || $request->user()->store_id === $service->store_id, 403);
        $service->update($request->validate(['name' => ['sometimes', 'string', 'max:150'], 'description' => ['nullable', 'string'], 'price' => ['sometimes', 'numeric', 'min:0'], 'unit' => ['sometimes', 'in:kg,unit'], 'status' => ['sometimes', 'in:active,inactive']]));
        return $service->refresh();
    }
}
