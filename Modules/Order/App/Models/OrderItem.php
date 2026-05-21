<?php

namespace Modules\Order\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\Database\factories\OrderItemFactory;
use Modules\Product\App\Models\Product;
use Modules\Addon\App\Models\Addon;

class OrderItem extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = ['addon_details'];
    
    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = ['addons'];
    
    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    /**
     * Get addon details with id, name, price and quantity from the addons table
     */
    public function getAddonDetailsAttribute()
    {
        if (empty($this->attributes['addons'])) {
            return [];
        }

        try {
            $addonsData = json_decode($this->attributes['addons'], true);
            
            if (!is_array($addonsData) || empty($addonsData)) {
                return [];
            }

            // Extract addon IDs from the keys and convert to integers
            $addonIds = array_map('intval', array_keys($addonsData));
            
            if (empty($addonIds)) {
                return [];
            }

            $addons = Addon::whereIn('id', $addonIds)
                ->where('status', 'enable')
                ->get()
                ->map(function ($addon) use ($addonsData) {
                    // Check both string and integer keys for compatibility
                    $quantity = $addonsData[$addon->id] ?? $addonsData[(string)$addon->id] ?? 1;
                    
                    return [
                        'id' => $addon->id,
                        'name' => $addon->name,
                        'price' => $addon->price,
                        'quantity' => (int)$quantity
                    ];
                });

            return $addons;
        } catch (\Exception $e) {
            return [];
        }
    }
}
