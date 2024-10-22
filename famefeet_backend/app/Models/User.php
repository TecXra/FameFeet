<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Models\Celebrity;
use App\Models\Fan;
use App\Models\Post;
use App\Models\Wallet;
use App\Models\PersonalInformation;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    use SoftDeletes;
    protected $fillable = [
        'username',
        'email',
        'phone_number',
        'date_of_birth',
        'password',
        'google_id',
        'referral_code',
        'used_referral_code',
        'email_verified_at',
        'user_type',
        'is_online',
        'account_status',
        'avatar',
        'state',
        'zipcode',
        'full_name',
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_online' => 'boolean',
        // 'is_active' => 'boolean',
    ];

    protected $appends = [
        'user_type_name',
        'avatarURL'
    ];
    public function getAvatarUrlAttribute(){
        $image_path = explode('/', $this->avatar);
        $static_exists = Storage::disk('static')->exists($image_path[2]);
        $dynamic_exists = Storage::disk('upload')->exists($image_path[2]);
        if ($static_exists || $dynamic_exists)
        {
            return config('app.url').'/'.($this->avatar) ;
        }
        return config('app.url').('/storage/static/profileLogo.png');
    }

    public function getUserTypeNameAttribute()
    {
        return getUserTypeNameByUserType($this->user_type);
    }

    public function fan()
    {
        return $this->hasOne(Fan::class);
    }
    public function celebrity(){
        return $this->hasOne(Celebrity::class);
    }
    public function personalInfrmation(){
        return $this->hasOne(PersonalInformation::class);
    }

    public function comments()
     {
        return $this->hasMany(Comments::class);
     }

     public function likes()
     {
        return $this->hasMany(likes::class);
     }

     // users that follow this user
    public function followers()
        {
            return $this->belongsToMany(User::class, 'followships', 'following_id', 'follower_id');
        }
    public function following()
        {
            return $this->belongsToMany(User::class, 'followships', 'follower_id', 'following_id');
        }
    public function hide()
        {
            return $this->belongsToMany(Post::class,'hides');
        }


    public function deleteOffer()
        {
            return $this->belongsToMany(DeleteOffer::class,'delete_offers');
        }
    public function wallet()
        {
        return $this->hasOne(Wallet::class);
        }

    public function send_tip(){
        return $this->hasMany(Tip::class,'sender_id','id');
        }
    public function receive_tip(){
            return $this->hasMany(Tip::class,'receive_id','id');
        }

    public function order(){
        return $this->hasMany(Order::class);
    }

    public function order_content(){
        return $this->hasOne(OrderContent::class);
    }

    // users that follow this user
    public function reportBy()
    {
        return $this->belongsToMany(User::class, 'reported_users', 'reported_user_id', 'user_id')->withPivot('message');
    }
    public function reportFrom()
    {
        return $this->belongsToMany(User::class, 'reported_users', 'user_id', 'reported_user_id')->withPivot('message');
    }

    public function report(){
        return $this->hasMany(ReportedUser::class,'reported_user_id');
    }

    // users that follow this user
    public function blockBy()
    {
        return $this->belongsToMany(User::class, 'banned_users', 'banned_user_id', 'user_id');
    }

    public function blockFrom()
    {
        return $this->belongsToMany(User::class, 'banned_users', 'user_id', 'banned_user_id');
    }

    // public function room(){
    //     return $this->hasOne(ChatRoom::class);
    // }

    public function conversation(){
        return $this->hasMany(Conversation::class);
    }

    public function messages(){
        return $this->hasMany(Conversation::class);
    }

    public function review(){
        return $this->hasOne(ShopItemReview::class);
    }

    public function subscribeUser(){
        return $this->hasOne(SubscribeUser::class);
    }


    public function paymentTransactionLog(){
        return $this->hasMany(PaymentTransactionLog::class);
    }

    public function customerProfile(){
        return $this->hasMany(CustomerProfile::class);
    }

    public function bankAccountDetail(){
        return $this->hasMany(BankAccountDetail::class);
    }

       // users that follow this user
    //    public function rateBy()
    //    {
    //        return $this->belongsToMany(User::class, 'fan_ratings', 'rated_user_id', 'user_id');
    //    }

    //    public function rateFrom()
    //    {
    //        return $this->belongsToMany(User::class, 'fan_ratings', 'user_id', 'rated_user_id');
    //    }

    public function fanRating(){
        return $this->hasOne(FanRating::class);
    }

    public function userAddress()
    {
        return $this->hasMany(UserAddress::class);
    }

    // public function senderUserLog()
    // {
    //     return $this->hasMany(CoinLog::class,'sender_user_id','id');
    // }

    // public function receiverUserLog()
    // {
    //     return $this->hasMany(CoinLog::class,'receiver_user_id','id');
    // }

    public function redeem(){
        return $this->hasMany(Redeem::class);
    }


    public function authProviders()
    {
        return $this->hasMany(AuthProvider::class);
    }

    public function verifyUser(){
        return $this->hasOne(VerifyUser::class);
    }

    public function routeNotificationForVonage(){
        return '+'.$this->phone_number;
    }

}
