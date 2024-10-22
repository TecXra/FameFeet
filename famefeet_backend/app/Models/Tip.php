<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tip extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable =
    [
         'fan_id',
         'celebrity_id',
         'coins',
    ];

    public function fan(){
        return $this->belongsTo(Fan::class);
    }

    public function celebrity(){
        return $this->belongsTo(Celebrity::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
