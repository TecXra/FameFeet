<?php

namespace App\Providers;

use App\Events\AddTrackingNumberEvent;
use App\Events\BuyCelebrityCustomeOffer;
use App\Events\BuyContentEvent;
use App\Events\BuySubscriptionEvent;
use App\Events\BuySubscriptionFanEvent;
use App\Events\CancelCustomeOfferEvent;
use App\Events\CancelOrderAutoEvent;
use App\Events\CancelOrderCelebAutoEvent;
use App\Events\CelebritySendCustomOffer;
use App\Events\ChangeOrderStatusEvent;
use App\Events\FollowUser;
use App\Events\NewMessage;
use App\Events\PlacedOrderEvent;
use App\Events\SendCustomOffer;
use App\Events\SendTipEvent;
use App\Events\SharePostEvent;
use App\Events\UnFollowUser;
use App\Events\UpdateSubscriptionPriceEvent;
use App\Events\UploadCustomOffer;
use App\Events\WithdrawalEvent;
use App\Events\CommentEvent;
use App\Events\OrderCancelAdminEvent;
use App\Events\LikeEvent;
use App\Events\CelebrityRateEvent;
use App\Events\FanRateEvent;
use App\Events\EnableDisableSubcription;
use App\Events\CelebEnableSubcription;



use App\Listeners\CelebEnableSubscriptionEventListener;
use App\Listeners\EnableDisableSubscriptionEventListener;
use App\Listeners\FanRateEventListener;
use App\Listeners\CelebrityRateEventListener;
use App\Listeners\LikeEventListener;
use App\Listeners\OrderCancelAdminEventListener;
use App\Listeners\CommentEventListener;
use App\Listeners\WithdrawalEventListener;
use App\Listeners\AddTrackingNumberEventListener;
use App\Listeners\BuyCelebrityCustomeOfferEventListener;
use App\Listeners\BuyContentEventListener;
use App\Listeners\BuySubscriptionEventListener;
use App\Listeners\BuySubscriptionFanEventListener;
use App\Listeners\CancelCustomeOfferEventListener;
use App\Listeners\CancelOrderAutoEventListener;
use App\Listeners\CancelOrderCelebAutoEventListener;
use App\Listeners\CelebritySendCustomOfferEventListener;
use App\Listeners\ChangeOrderStatusEventListener;
use App\Listeners\FollowUserEventListener;
use App\Listeners\NewMessageEventListener;
use App\Listeners\PlacedOrderEventListener;
use App\Listeners\SendCustomOfferEventListener;
use App\Listeners\SendTipEventListener;
use App\Listeners\SharePostEventListener;
use App\Listeners\UnFollowUserEventListener;
use App\Listeners\UpdateSubscriptionPriceEventListener;
use App\Listeners\UploadCustomOfferEventListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        FollowUser::class =>[
            FollowUserEventListener::class,
        ],
        
        UnFollowUser::class =>[
            UnFollowUserEventListener::class,
        ],
        SendCustomOffer::class =>[
           SendCustomOfferEventListener::class,
        ],
        UploadCustomOffer::class =>[
            UploadCustomOfferEventListener::class,
        ],
        SendTipEvent::class =>[
            SendTipEventListener::class,
        ],
        NewMessage::class => [
          NewMessageEventListener::class,
        ],
        PlacedOrderEvent::class =>[
            PlacedOrderEventListener::class,
        ],
        ChangeOrderStatusEvent::class =>[
            ChangeOrderStatusEventListener::class,
        ],
        BuySubscriptionEvent::class =>[
            BuySubscriptionEventListener::class,
        ],
        BuySubscriptionFanEvent::class =>[
            BuySubscriptionFanEventListener::class,
        ],
        BuyContentEvent::class => [
            BuyContentEventListener::class,
        ],
        SharePostEvent::class => [
            SharePostEventListener::class,
        ],
        UpdateSubscriptionPriceEvent::class => [
            UpdateSubscriptionPriceEventListener::class,
        ],
        CancelCustomeOfferEvent::class => [
            CancelCustomeOfferEventListener::class,
        ],
        AddTrackingNumberEvent::class =>[
            AddTrackingNumberEventListener::class,
        ],
        BuyCelebrityCustomeOffer::class => [
            BuyCelebrityCustomeOfferEventListener::class
        ],
        CelebritySendCustomOffer::class => [
            CelebritySendCustomOfferEventListener::class
        ],
        CancelOrderAutoEvent::class => [
            CancelOrderAutoEventListener::class
        ],
        CancelOrderCelebAutoEvent::class => [
            CancelOrderCelebAutoEventListener::class
        ],
        WithdrawalEvent::class => [
            WithdrawalEventListener::class
        ],
        OrderCancelAdminEvent::class => [
            OrderCancelAdminEventListener::class
        ],
        CommentEvent::class => [
            CommentEventListener::class
        ],
        LikeEvent::class => [
            LikeEventListener::class
        ],
        CelebrityRateEvent::class => [
            CelebrityRateEventListener::class
        ],
        FanRateEvent::class => [
            FanRateEventListener::class
        ],
        EnableDisableSubcription::class => [
            EnableDisableSubscriptionEventListener::class
        ],
        CelebEnableSubcription::class => [
            CelebEnableSubscriptionEventListener::class
        ]


    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
