<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 14, 2);
            $table->string('unit', 16);
            $table->string('status', 16)->default('active')->index();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('services'); }
};
