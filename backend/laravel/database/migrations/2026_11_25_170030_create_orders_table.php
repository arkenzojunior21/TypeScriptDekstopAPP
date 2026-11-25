<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('store_id')->constrained()->restrictOnDelete();
            $table->string('status', 32)->default('new')->index();
            $table->string('payment_method', 32);
            $table->string('payment_status', 32)->default('unpaid')->index();
            $table->decimal('total', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['store_id', 'created_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('orders'); }
};
