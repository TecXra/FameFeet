<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Wallet extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'total_coins',
        'available_coins',
        'user_id',
        'total_spent_coins'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function senderLog()
    {
         return $this->hasMany(CoinLog::class,'sender_wallet_id','id');
    }
    public function receiverLog()
    {
         return $this->hasMany(CoinLog::class,'receiver_wallet_id','id');
    }
}
