<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class UserCardDetail extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
         'card_number',
         'card_holder_name',
         'customer_payment_profile_id',
         'card_type',
         'expiry_date',
         'customer_profile_id'
    ];

   public function customerProfile(){
    return $this->belongsTo(CustomerProfile::class);
   }

    public function paymentTransactionLog(){
        return $this->hasMany(PaymentTransactionLog::class);
    }
}
