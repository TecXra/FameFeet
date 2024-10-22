<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillabel =[
        'price',
        'condition',
        'quantity',
        'description',
        'lock_media',
        'is_active',
        'celebrity_id'
    ];
    protected $fillable = ['title'];

    public function media()
     {
         return $this->morphMany(Media::class, 'mediaable');
     }

     public function celebrity()
     {
        return $this->belongsTo(Celebrity::class);
     }

     public function orderDetail(){
        return $this->hasMany(OrderDetail::class);
    }

    public function socksSize(){
        return $this->belongsTo(SocksSize::class);
    }

    public function review(){
        return $this->hasMany(Review::class,'review_type_id','id');
    }

    public function coinlog(){
        return $this->hasMany(CoinLog::class);
    }
}
