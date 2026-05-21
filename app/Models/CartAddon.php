<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'addon_id',
        'addon_name',
        'addon_price',
        'quantity'
    ];

    protected $casts = [
        'addon_price' => 'decimal:2',
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the cart item that owns this addon.
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the addon details.
     */
    public function addon(): BelongsTo
    {
        return $this->belongsTo(\Modules\Addon\App\Models\Addon::class);
    }
} 