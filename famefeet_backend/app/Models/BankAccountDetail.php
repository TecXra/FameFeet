<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BankAccountDetail extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
            'account_type',
            'routing_number',
            'account_number',
            'name_on_account',
            'bank_name',
            'set_default',
            'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function redde(){
        return $this->hasOne(Redeem::class);
    }

}
