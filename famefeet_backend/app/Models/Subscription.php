<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Subscription extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'coins',
        'time_perion',
        'status',
        'celebrity_id'
    ];

    public function celebrity(){
        return $this->belongsTo(Celebrity::class);
    }

    public function subscribeUser(){
        return $this->hasMany(SubscribeUser::class);
    }
}
