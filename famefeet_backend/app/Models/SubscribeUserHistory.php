<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscribeUserHistory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'coins',
        'active',
        'subscription_start_date',
        'subscription_end_date',
        'subscription_id',
        'user_id',
    ];

    public function subscription(){
        return $this->belongsTo(Subscription::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
