<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubOrder extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
    'name',
    'mobile_number',
    'address_line_one',
    'address_line_two',
    'country',
    'state',
    'city',
    'zipcode',
    'sub_order_price',
    'status',
    'shipping_charges',
    'service_charges_percentage',
    'celebrity_charges_percentage',
    'service_charges_price',
    'celebrity_charges_price',
    'order_id',
    'celebrity_id',
    'user_id'
];

public function order(){
    return $this->belongsTo(Order::class);
   }

public function user(){
     return $this->belongsTo(User::class);
}
public function celebrity(){
    return $this->belongsTo(Celebrity::class);
}

public function orderItem(){
    return $this->hasMany(OrderItem::class);
}

public function review()
{
    return $this->hasMany(Review::class);
}

public function coinlog(){
    return $this->hasMany(CoinLog::class);
}

}
