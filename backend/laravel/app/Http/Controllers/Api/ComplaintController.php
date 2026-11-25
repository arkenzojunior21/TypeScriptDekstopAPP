<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('complaints')->join('users', 'users.id', '=', 'complaints.user_id')->select('complaints.*', 'users.name as customer_name');
        if ($request->user()->role === 'customer') $query->where('complaints.user_id', $request->user()->id);
        if ($request->user()->role === 'store_admin') $query->where('complaints.store_id', $request->user()->store_id);
        return $query->when($request->get('status'), fn ($q, $status) => $q->where('complaints.status', $status))->latest('complaints.created_at')->paginate($request->integer('per_page', 15));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['store_id' => ['required', 'exists:stores,id'], 'order_id' => ['nullable', 'exists:orders,id'], 'message' => ['required', 'string', 'max:5000']]);
        $id = DB::table('complaints')->insertGetId([...$data, 'user_id' => $request->user()->id, 'status' => 'new', 'created_at' => now(), 'updated_at' => now()]);
        return response()->json(DB::table('complaints')->find($id), 201);
    }

    public function update(Request $request, int $complaint)
    {
        $data = $request->validate(['status' => ['required', 'in:new,processing,resolved'], 'response' => ['nullable', 'string', 'max:5000']]);
        $row = DB::table('complaints')->find($complaint);
        abort_if(! $row, 404);
        abort_unless($request->user()->role === 'platform_admin' || $request->user()->store_id === $row->store_id, 403);
        DB::table('complaints')->where('id', $complaint)->update([...$data, 'resolved_at' => $data['status'] === 'resolved' ? now() : null, 'updated_at' => now()]);
        return DB::table('complaints')->find($complaint);
    }
}
