<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Product\App\Models\Product;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'restaurant_id',
        'size',
        'size_price',
        'qty',
        'addons',
        'addon_price',
        'total_price',
        'status'
    ];

    protected $casts = [
        'addons' => 'array',
        'size_price' => 'decimal:2',
        'addon_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'qty' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who owns the cart item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product in the cart.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the restaurant for the cart item.
     */
    public function restaurant(): BelongsTo
    {
        return $this->belongsTo(\Modules\Restaurant\Entities\Restaurant::class);
    }

    /**
     * Scope to get active cart items.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get cart items by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to get cart items by restaurant.
     */
    public function scopeByRestaurant($query, $restaurantId)
    {
        return $query->where('restaurant_id', $restaurantId);
    }
} 