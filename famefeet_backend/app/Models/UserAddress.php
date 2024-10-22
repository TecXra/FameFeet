<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'selected_address',
        'name',
        'countryCode',
        'mobile',
        'address_line_one',
        'address_line_two',
        'country',
        'zipCode',
        'state',
        'city',
        'user_id'
    ];

    public function user(){
        $this->belongsTo(User::class);
    }
}
