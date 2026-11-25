<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Order::with(['customer:id,name,phone', 'store:id,name', 'items']);
        if ($user->role === 'customer') $query->where('customer_id', $user->id);
        if ($user->role === 'store_admin') $query->where('store_id', $user->store_id);
        return $query->when($request->get('status'), fn ($q, $status) => $q->where('status', $status))->latest()->paginate($request->integer('per_page', 15));
    }

    public function show(Request $request, Order $order)
    {
        $this->authorizeAccess($request, $order);
        return $order->load(['customer:id,name,email,phone', 'store:id,name,address,phone', 'items']);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'store_id' => ['required', 'exists:stores,id'],
            'customer_id' => ['nullable', 'exists:users,id'],
            'payment_method' => ['required', 'in:cash,transfer,dana,gopay'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.service_id' => ['required', 'exists:services,id'],
            'items.*.quantity' => ['required', 'numeric', 'gt:0'],
        ]);
        $actor = $request->user();
        $customerId = $actor->role === 'customer' ? $actor->id : ($data['customer_id'] ?? null);
        abort_unless($customerId, 422, 'Pelanggan harus dipilih.');
        abort_unless(User::whereKey($customerId)->where('role', 'customer')->exists(), 422, 'Akun yang dipilih bukan pelanggan.');
        if ($actor->role === 'store_admin') abort_unless($actor->store_id === (int) $data['store_id'], 403);

        return DB::transaction(function () use ($data, $customerId, $actor) {
            $order = Order::create(['order_number' => 'LD-'.now()->format('ymd').'-'.str_pad((string) (Order::count() + 1), 4, '0', STR_PAD_LEFT), 'customer_id' => $customerId, 'store_id' => $data['store_id'], 'payment_method' => $data['payment_method'], 'payment_status' => 'unpaid', 'status' => 'new', 'notes' => $data['notes'] ?? null]);
            $total = 0;
            foreach ($data['items'] as $item) {
                $service = Service::where('store_id', $data['store_id'])->findOrFail($item['service_id']);
                $subtotal = $service->price * $item['quantity'];
                $order->items()->create(['service_id' => $service->id, 'service_name' => $service->name, 'unit_price' => $service->price, 'quantity' => $item['quantity'], 'unit' => $service->unit, 'subtotal' => $subtotal]);
                $total += $subtotal;
            }
            $order->update(['total' => $total]);
            $this->audit($actor->id, 'order.created', $order);
            return response()->json($order->load('items'), 201);
        });
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorizeStaff($request, $order);
        $data = $request->validate(['status' => ['required', 'in:new,processing,ready_for_pickup,on_delivery,completed,cancelled'], 'payment_status' => ['nullable', 'in:unpaid,paid,refunded']]);
        $order->update($data);
        $this->audit($request->user()->id, 'order.status_changed', $order, $data);
        return $order->refresh()->load('items');
    }

    private function authorizeAccess(Request $request, Order $order): void
    {
        $user = $request->user();
        abort_unless($user->role === 'platform_admin' || ($user->role === 'store_admin' && $user->store_id === $order->store_id) || ($user->role === 'customer' && $user->id === $order->customer_id), 403);
    }
    private function authorizeStaff(Request $request, Order $order): void
    {
        $user = $request->user();
        abort_unless($user->role === 'platform_admin' || ($user->role === 'store_admin' && $user->store_id === $order->store_id), 403);
    }
    private function audit(int $userId, string $action, Order $order, array $details = []): void
    {
        DB::table('audit_logs')->insert(['user_id' => $userId, 'action' => $action, 'target_type' => 'order', 'target_id' => $order->id, 'details' => json_encode($details), 'created_at' => now()]);
    }
}
