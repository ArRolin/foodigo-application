<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleTypeTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_type_id', 'lang_code', 'name'];

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }
}

