<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Celebrity;

class BannedUser extends Model
{
    use HasFactory;
    // use SoftDeletes;

    protected $fillable = [
        'message',
        'user_id',
        'banned_user_id',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function banned(){
    //     return $this->belongsTo(User::class,'banned_user_id','id');
    // }

}
