<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Service;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = Hash::make('Laundry123!');
        $platform = User::create(['name' => 'Nadia Amalia', 'email' => 'admin@laundrydesk.test', 'phone' => '081234567890', 'role' => 'platform_admin', 'password' => $password]);
        $store = Store::create(['owner_id' => $platform->id, 'name' => 'Laundry Desk Kemang', 'address' => 'Jl. Kemang Raya No. 18, Jakarta Selatan', 'phone' => '021-7894561', 'latitude' => -6.2614920, 'longitude' => 106.8106000]);
        User::create(['name' => 'Aris Ganteng', 'email' => 'toko@laundrydesk.test', 'phone' => '081377208411', 'role' => 'store_admin', 'store_id' => $store->id, 'password' => $password]);
        $rina = User::create(['name' => 'Rina Putri', 'email' => 'pelanggan@laundrydesk.test', 'phone' => '081245120098', 'role' => 'customer', 'password' => $password]);
        $bagas = User::create(['name' => 'Bagas Pratama', 'email' => 'bagas@laundrydesk.test', 'phone' => '081377208412', 'role' => 'customer', 'password' => $password]);
        $regular = Service::create(['store_id' => $store->id, 'name' => 'Cuci Kering Lipat', 'description' => 'Selesai 2–3 hari', 'price' => 7000, 'unit' => 'kg']);
        $express = Service::create(['store_id' => $store->id, 'name' => 'Cuci Setrika Express', 'description' => 'Selesai dalam 1 hari', 'price' => 13000, 'unit' => 'kg']);
        Service::create(['store_id' => $store->id, 'name' => 'Bed Cover', 'description' => 'Pencucian per unit', 'price' => 30000, 'unit' => 'unit']);
        $order = Order::create(['order_number' => 'LD-24018', 'customer_id' => $rina->id, 'store_id' => $store->id, 'status' => 'new', 'payment_method' => 'cash', 'payment_status' => 'unpaid', 'total' => 28000]);
        $order->items()->create(['service_id' => $regular->id, 'service_name' => $regular->name, 'unit_price' => 7000, 'quantity' => 4, 'unit' => 'kg', 'subtotal' => 28000]);
        $order = Order::create(['order_number' => 'LD-24017', 'customer_id' => $bagas->id, 'store_id' => $store->id, 'status' => 'processing', 'payment_method' => 'transfer', 'payment_status' => 'paid', 'total' => 39000]);
        $order->items()->create(['service_id' => $express->id, 'service_name' => $express->name, 'unit_price' => 13000, 'quantity' => 3, 'unit' => 'kg', 'subtotal' => 39000]);
    }
}
