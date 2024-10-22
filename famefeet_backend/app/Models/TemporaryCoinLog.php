<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class TemporaryCoinLog extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
    'log_type',
    'to_amount',
    'to_currency',
    'from_amount',
    'from_currency',
    'service_charges_percentage',
    'celebrity_charges_percentage',
    'service_charges_price',
    'celebrity_charges_price',
    'exchange_rate',
    'to_wallet_id',
    'to_user_id',
    'from_wallet_id',
    'from_user_id',
    'offer_id',
    'sub_order_id',
    ];


    public function toWallet()
    {
        return $this->belongsTo(Wallet::class,'to_wallet_id','id');
    }
    public function fromWallet()
    {
        return $this->belongsTo(Wallet::class,'from_wallet_id','id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class,'to_user_id','id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class,'from_user_id','id');
    }

    public function offer(){
        return $this->belongsTo(Offer::class);
    }


}
