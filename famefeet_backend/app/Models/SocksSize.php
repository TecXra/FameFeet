<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class SocksSize extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'socks_size_name',
        'status',
        'gender',
    ];

    public function shop(){
        return $this->hasOne(Shop::class);
    }
}
