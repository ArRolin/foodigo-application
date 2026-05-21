<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryManWithdrawMethod extends Model
{
    
    use HasFactory;
    
    // Explicitly define the table name
    protected $table = 'deliveryman_withdraw_methods';

    protected $fillable = [];

}
