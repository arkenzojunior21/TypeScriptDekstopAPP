<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('store_id')->constrained()->restrictOnDelete();
            $table->text('message');
            $table->text('response')->nullable();
            $table->string('status', 32)->default('new')->index();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('complaints'); }
};
