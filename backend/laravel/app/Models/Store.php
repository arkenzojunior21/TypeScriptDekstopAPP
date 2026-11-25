<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    protected $fillable = ['owner_id', 'name', 'address', 'phone', 'latitude', 'longitude', 'status'];
    protected $casts = ['latitude' => 'float', 'longitude' => 'float'];
    public function owner(): BelongsTo { return $this->belongsTo(User::class, 'owner_id'); }
    public function services(): HasMany { return $this->hasMany(Service::class); }
    public function orders(): HasMany { return $this->hasMany(Order::class); }
}
