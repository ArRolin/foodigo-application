<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;

class DeliveryMan extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone',
        'password',
        'man_image',
        'address',
        'latitude',
        'longitude',
        'status',
        'is_online',
        'current_orders',
        'man_type',
        'idn_type',
        'idn_num',
        'idn_image',
        'restaurant_id',
        'zone_id',
        'active',
        'available',
        'last_active_at',
        'fcm_token',
        'remember_token',
        // New fields for registration
        'gender',
        'country_code',
        'date_of_birth',
        'city_id',
        'zip_code',
        'document_type_id',
        'document_number',
        'profile_image',
        'document',
        'short_note',
        'vehicle_type_id',
        'vehicle_number',
        'vehicle_image',
        'otp',
        'otp_expires_at',
        'is_email_verified',
        'verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'otp_expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'is_email_verified' => 'boolean',
        'status' => 'integer',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get full name accessor
     */
    public function getNameAttribute()
    {
        return $this->fname . ' ' . $this->lname;
    }
}
