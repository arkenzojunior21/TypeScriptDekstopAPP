<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $fillable = ['store_id', 'name', 'description', 'price', 'unit', 'status'];
    protected $casts = ['price' => 'decimal:2'];
    public function store(): BelongsTo { return $this->belongsTo(Store::class); }
}
