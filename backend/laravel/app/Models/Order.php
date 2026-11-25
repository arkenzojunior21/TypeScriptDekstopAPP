<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = ['order_number', 'customer_id', 'store_id', 'status', 'payment_method', 'payment_status', 'total', 'notes'];
    protected $casts = ['total' => 'decimal:2'];
    public function customer(): BelongsTo { return $this->belongsTo(User::class, 'customer_id'); }
    public function store(): BelongsTo { return $this->belongsTo(Store::class); }
    public function items(): HasMany { return $this->hasMany(OrderItem::class); }
}
