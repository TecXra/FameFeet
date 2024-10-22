<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CelebrityController as AdminCelebrityController;
use App\Http\Controllers\Admin\FanController as AdminFanController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CelebrityController;
use App\Models\BankAccountDetail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FanController;
use App\Http\Controllers\FootSizeController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentTransactionLogsController;
use App\Http\Controllers\PostMediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RedeemController;
use App\Http\Controllers\ServiceChargesController;
use App\Http\Controllers\ShopMediaController;
use App\Http\Controllers\SocksSizeController;
use App\Http\Controllers\TestimonialController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/google', [GoogleAuthController::class, 'redirectToGoogle']);
// Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('admin');
Auth::routes();

// Route::get('/login/google', [SocialAuthController::class,'redirectToProvider']);
// Route::get('/login/google/callback', [SocialAuthController::class,'handleProviderCallback']);

//Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth', 'admin');

Route::group(['middleware' => 'auth', 'admin'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
});

Route::group(['middleware' => 'auth', 'admin'], function () {
	//Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('user/celebrity',[UserController::class,'getAllCelebrities'])->name('user.celebrity');

    Route::get('allUser',[UserController::class,'getAllUser'])->name('user.getAllUser');
    Route::get('user/{id}/edit',[UserController::class,'editUser'])->name('user.edit');
    Route::get('user/{id}',[UserController::class,'showUser'])->name('user.details');
    Route::put('user/{id}',[UserController::class,'updateUser'])->name('user.update');
    Route::delete('user/delete/{id}',[UserController::class,'deleteUser'])->name('user.delete');
    Route::post('user/status/{id}',[UserController::class, 'userStatus'])->name('user.status');
    //Routes for fans
    //Route::get('/user/fan',[FanController::class,'index'])->name('user.fan');

	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    Route::post('addAdmin',[AdminController::class,'addAdmin'])->name('add.admin');
    Route::get('adminView',[AdminController::class,'adminView'])->name('admin.view');

});

Route::group(['middleware'=>'auth', 'admin'], function(){
    Route::get('allIncomingPlatform', [\App\Http\Controllers\WalletController::class, 'allIncomingPlatform'])->name('admin.incoming');
    Route::post('allIncomingPlatform', [\App\Http\Controllers\WalletController::class, 'allIncomingPlatform']);
    Route::get('allOutgoingPlatform', [\App\Http\Controllers\WalletController::class, 'allOutGoingPlatform'])->name('admin.outgoing');
    Route::post('allOutgoingPlatform', [\App\Http\Controllers\WalletController::class, 'allOutGoingPlatform']);

    Route::get('allPlatform', [\App\Http\Controllers\WalletController::class, 'allTransactions'])->name('admin.all');
    Route::post('allPlatform', [\App\Http\Controllers\WalletController::class, 'allTransactions']);

});

Route::group(['middleware' => 'auth', 'admin'], function () {
    Route::get('allFans',[FanController::class,'index'])->name('fan.all');
    Route::get('fan/{id}/edit',[FanController::class,'edit'])->name('fan.edit');
    Route::put('fan/update/{id}',[FanController::class,'update'])->name('fan.update');
    Route::delete('fan/delete/{id}',[FanController::class,'destroy'])->name('fan.delete');
    Route::get('fan/show/{id}', [FanController::class,'show'])->name('fan.show');

    Route::get('fan/{fanId}/posts',[AdminFanController::class,'getSingleFanBuyPosts'])->name('single.fan.buy.posts');
    Route::get('fan/buy-post-content/{contentId}/remove',[AdminFanController::class,'removeBuyPostContent'])->name('fan.buy.content.delete');
    // Route::put('fan/post/{postId}/update',[AdminFanController::class,'updatePost'])->name('celebrity.post.update');
    Route::get('fan/post/{contentId}/show',[AdminFanController::class,'showFanBuyContent'])->name('fan.buy.content.show');

    Route::get('fan/{fanId}/offers',[AdminFanController::class,'getSingleFanOffersToCelebrity'])->name('single.fan.offers.to.celebrity');
    Route::get('fan/offer/{offerId}',[AdminFanController::class,'editOffer'])->name('fan.offer.edit');
    Route::put('fan/offer/{offerId}/update',[AdminFanController::class,'updateOffer'])->name('fan.offer.update');
    Route::get('fan/offer/{offerId}/show',[AdminFanController::class,'showOffer'])->name('fan.offer.show');

    Route::get('fan/{fanId}/offers/from/celebrity',[AdminFanController::class,'getSingleFanOffersFromCelebrity'])->name('single.fan.offers.from.celebrity');
    Route::get('fan/offer/from/celebrity/{celebrityOfferId}/edit',[AdminFanController::class,'editFanOfferFromCelebrity'])->name('fan.offer.from.celebrity.edit');
    Route::put('fan/offer/from/celebrity/{celebrityOfferId}/update',[AdminFanController::class,'updateFanOfferFromCelebrity'])->name('fan.offer.from.celebrity.update');
    Route::get('fan/offer/from/celebrity/{celebrityOfferId}/show',[AdminFanController::class,'showFanOfferFromCelebrity'])->name('fan.offer.from.celebrity.show');

    Route::get('fan/{fanId}/subscriptions',[AdminFanController::class,'getFanBuySubscription'])->name('single.fan.subscriptions');

    Route::get('fan/{fanId}/blockUsers',[AdminFanController::class,'getAllBlockUserOfFan'])->name('fan.block.users');
    Route::get('fan/unblock/{blockUserId}',[AdminFanController::class,'unblockUser'])->name('fan.unblock.user');

    Route::get('fan/{fanId}/reportUsers',[AdminFanController::class,'getAllReportUserOfFan'])->name('fan.report.users');
    Route::get('fan/remove/report/{reportUserId}/user',[AdminFanController::class,'removeReportUser'])->name('fan.remove.report.user');

    Route::get('fan/{fanId}/followers',[AdminFanController::class,'gatAllFollowersOfFan'])->name('fan.follower');
    Route::get('fan/{fanId}/followings',[AdminFanController::class,'gatAllFollowingsOfFan'])->name('fan.following');
    Route::get('fan/remove/followers/{followerId}',[AdminFanController::class,'removeFollowerUser'])->name('fan.remove.follower');
    Route::get('fan/unfollow/{followerId}',[AdminFanController::class,'unFollowUser'])->name('fan.unfollow');

    Route::get('fan/{fanId}/orders',[AdminFanController::class,'gatAllOrdersOfFan'])->name('fan.orders');

    Route::get('fan/{fanId}/trasection/logs',[AdminFanController::class,'transectionLogsOfFan'])->name('fan.transection.logs');

});

//Admin side specific celebrity routes
Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('allCelebrities',[CelebrityController::class,'index'])->name('celebrity.all');
    Route::get('celebrity/{id}/edit',[CelebrityController::class,'edit'])->name('celebrity.edit');
    Route::put('celebrity/update/{id}',[CelebrityController::class,'update'])->name('celebrity.update');
    Route::delete('celebrity/delete/{id}',[CelebrityController::class,'delete'])->name('celebrity.delete');
    Route::get('celebrity/show/{id}',[CelebrityController::class,'show'])->name('celebrity.show');

    Route::get('celebrity/{celebrityId}/posts',[AdminCelebrityController::class,'getSingleCelebrityPosts'])->name('single.celebrity.posts');
    Route::get('celebrity/post/{postId}',[AdminCelebrityController::class,'editPost'])->name('celebrity.post.edit');
    Route::put('celebrity/post/{postId}/update',[AdminCelebrityController::class,'updatePost'])->name('celebrity.post.update');
    Route::get('celebrity/post/{postId}/show',[AdminCelebrityController::class,'showPost'])->name('celebrity.post.show');

    Route::get('celebrity/{celebrityId}/shops',[AdminCelebrityController::class,'getSingleCelebrityShops'])->name('single.celebrity.shops');
    Route::get('celebrity/shop/{shopId}',[AdminCelebrityController::class,'editShop'])->name('celebrity.shop.edit');
    Route::put('celebrity/shop/{shopId}/update',[AdminCelebrityController::class,'updateShop'])->name('celebrity.shop.update');
    Route::get('celebrity/shop/{shopId}/show',[AdminCelebrityController::class,'showShop'])->name('celebrity.shop.show');

    Route::get('celebrity/{celebrityId}/offers',[AdminCelebrityController::class,'getSingleCelebrityOffers'])->name('single.celebrity.offers');
    Route::get('celebrity/offer/{offerId}',[AdminCelebrityController::class,'editOffer'])->name('celebrity.offer.edit');
    Route::put('celebrity/offer/{offerId}/update',[AdminCelebrityController::class,'updateOffer'])->name('celebrity.offer.update');
    Route::get('celebrity/offer/{offerId}/show',[AdminCelebrityController::class,'showOffer'])->name('celebrity.offer.show');

    Route::get('celebrity/{celebrityId}/offers/to/fan',[AdminCelebrityController::class,'getSingleCelebrityOffersToFan'])->name('single.celebrity.offers.to.fan');
    Route::get('celebrity/offer/to/fan/{celebrityOfferId}/edit',[AdminCelebrityController::class,'editCelebrityOfferToFan'])->name('celebrity.offer.to.fan.edit');
    Route::put('celebrity/offer/to/fan/{celebrityOfferId}/update',[AdminCelebrityController::class,'updateCelebrityOfferToFan'])->name('celebrity.offer.to.fan.update');
    Route::get('celebrity/offer/to/fan/{celebrityOfferId}/show',[AdminCelebrityController::class,'showCelebrityOfferToFan'])->name('celebrity.offer.to.fan.show');

    Route::get('celebrity/{celebrityId}/subscribeUser',[AdminCelebrityController::class,'getAllSubscribeUserOfCelebrity'])->name('single.celebrity.subscribe.users');
    Route::get('celebrity/subscribeUser/{subscribeUserId}/status',
           [AdminCelebrityController::class,'changeStatusOfSubscribeUser'])
           ->name('celebrity.subscribe.user.status');
    Route::get('celebrity/{celebrityId}/subscriptions',[AdminCelebrityController::class,'getAllSubscriptionsOfCelebrity'])->name('single.celebrity.subscriptions');
    Route::get('celebrity/subscription/{subscriptionId}/status',
            [AdminCelebrityController::class,'changeStatusOfSubscription'])
            ->name('celebrity.subscription.status');

    Route::get('celebrity/{celebrityId}/blockUsers',[AdminCelebrityController::class,'getAllBlockUserOfCelebrity'])->name('celebrity.block.users');
    Route::get('celebrity/unblock/{blockUserId}',[AdminCelebrityController::class,'unblockUser'])->name('celebrity.unblock.user');

    Route::get('celebrity/{celebrityId}/reportUsers',[AdminCelebrityController::class,'getAllReportUserOfCelebrity'])->name('celebrity.report.users');
    Route::get('remove/report/{reportUserId}/user',[AdminCelebrityController::class,'removeReportUser'])->name('celebrity.remove.report.user');

    Route::get('celebrity/{celebrityId}/followers',[AdminCelebrityController::class,'gatAllFollowersOfCelebrity'])->name('celebrity.follower');
    Route::get('celebrity/{celebrityId}/followings',[AdminCelebrityController::class,'gatAllFollowingsOfCelebrity'])->name('celebrity.following');
    Route::get('celebrity/remove/followers/{followerId}',[AdminCelebrityController::class,'removeFollowerUser'])->name('celebrity.remove.follower');
    Route::get('celebrity/unfollow/{followerId}',[AdminCelebrityController::class,'unFollowUser'])->name('celebrity.unfollow');

    Route::get('celebrity/{celebrityId}/orders',[AdminCelebrityController::class,'gatAllOrdersOfCelebrity'])->name('celebrity.orders');
    Route::get('celebrity/complete/order/{orderId}',[AdminCelebrityController::class,'completeOrderOfCelebrity'])->name('celebrity.complete.order');
    Route::get('celebrity/order/{orderId}/details',[AdminCelebrityController::class,'orderDetailsOfCelebrity'])->name('celebrity.order.detail');

    Route::get('celebrity/{celebrityId}/redeems',[AdminCelebrityController::class,'gatAllRedeemRequests'])->name('celebrity.redeem.requests');
    Route::get('celebrity/redeem/{redeemId}/accept',[RedeemController::class,'withdrawAmountAccept'])->name('celebrity.redeem.request.accept');
    Route::get('celebrity/redeem/{redeemId}/reject',[RedeemController::class,'withdrawAmountReject'])->name('celebrity.redeem.request.reject');

    Route::get('celebrity/{celebrityId}/accounts',[AdminCelebrityController::class,'getAllCelebrityBankAccountsDetails'])->name('celebrity.bank.accounts');
    Route::get('celebrity/account/{accountId}/edit',[AdminCelebrityController::class,'editCelebrityBankAccount'])->name('edit.celebrity.bank.account');
    Route::put('celebrity/account/{accountId}/update',[AdminCelebrityController::class,'updateCelebrityBankAccount'])->name('update.celebrity.bank.account');
    Route::get('celebrity/account/{accountId}/delete',[AdminCelebrityController::class,'deleteCelebrityBankAccount'])->name('delete.celebrity.bank.account');

    Route::get('celebrity/{celebrityId}/trasection/logs',[AdminCelebrityController::class,'transectionLogsOfCelebrity'])->name('celebrity.transection.logs');

});

Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('allCategories',[CategoryController::class,'index'])->name('category.all');
    Route::post('category/store',[CategoryController::class,'store'])->name('category.store');
    Route::get('category/{id}/edit',[CategoryController::class,'edit'])->name('category.edit');
    Route::put('category/update/{id}',[CategoryController::class,'update'])->name('category.update');
    Route::get('category/delete/{id}',[CategoryController::class,'destroy'])->name('category.delete');
    Route::get('category/restore/{id}',[CategoryController::class,'restore'])->name('category.restore');
    Route::get('category/status/{id}',[CategoryController::class,'categoryStatus'])->name('category.status');


});
Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('allFeets',[FootSizeController::class,'index'])->name('feet.all');
    Route::post('feet/store',[FootSizeController::class,'store'])->name('feet.store');
    Route::get('feet/{id}/edit',[FootSizeController::class,'edit'])->name('feet.edit');
    Route::put('feet/update/{id}',[FootSizeController::class,'update'])->name('feet.update');
    Route::get('feet/status/{id}',[FootSizeController::class,'feetStatus'])->name('feet.status');
    Route::get('feet/delete/{id}',[FootSizeController::class,'destroy'])->name('feet.delete');
    Route::get('feet/restore/{id}',[FootSizeController::class,'restore'])->name('feet.restore');
});

Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('allPosts',[PostMediaController::class,'index'])->name('post.all');
    Route::get('post/{id}/edit',[PostMediaController::class,'edit'])->name('post.edit');
    Route::put('post/update/{id}',[PostMediaController::class,'update'])->name('post.update');
    Route::get('post/show/{id}',[PostMediaController::class,'show'])->name('post.show');
    Route::delete('post/delete/{id}',[PostMediaController::class,'destroy'])->name('post.delete');
});

Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('/allOffers',[OfferController::class,'index'])->name('offer.all');
    Route::get('offer/{id}/edit',[OfferController::class,'edit'])->name('offer.edit');
    Route::put('offer/update/{id}',[OfferController::class,'update'])->name('offer.update');
    Route::get('offer/show/{id}',[OfferController::class,'show'])->name('offer.show');
    Route::delete('offer/delete/{id}',[OfferController::class,'destroy'])->name('offer.delete');
});

Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('allShops',[ShopMediaController::class,'index'])->name('shop.all');
    Route::get('shop/{id}/edit',[ShopMediaController::class,'edit'])->name('shop.edit');
    Route::put('shop/update/{id}',[ShopMediaController::class,'update'])->name('shop.update');
    Route::get('shop/show/{id}',[ShopMediaController::class,'show'])->name('shop.show');
});

Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('post/media/all',[MediaController::class,'postIndex'])->name('post_media.all');
});

Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('shop/media/all',[MediaController::class,'shopIndex'])->name('shop_media.all');
});

Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('allOrder',[OrderController::class,'index'])->name('order.all');
    Route::get('order/{id}/edit',[OrderController::class,'edit'])->name('order.edit');
    Route::put('order/update/{id}',[OrderController::class,'update'])->name('order.update');
    Route::get('order/show/{id}',[OrderController::class,'show'])->name('order.show');

});

Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('allRedeem',[RedeemController::class,'index'])->name('redeem.all');
});

Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('allSocks',[SocksSizeController::class,'index'])->name('socks.all');
    Route::post('socks/store',[SocksSizeController::class,'store'])->name('socks.store');
    Route::get('socks/{id}/edit',[SocksSizeController::class,'edit'])->name('socks.edit');
    Route::put('socks/update/{id}',[SocksSizeController::class,'update'])->name('socks.update');
    Route::get('socks/status/{id}',[SocksSizeController::class,'socksStatus'])->name('socks.status');
    Route::get('socks/delete/{id}',[SocksSizeController::class,'destroy'])->name('socks.delete');
    Route::get('socks/restore/{id}',[SocksSizeController::class,'restore'])->name('socks.restore');
});


Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::post('/serviceCharges/{id}/edit',[ServiceChargesController::class,"getServiceCharges"])->name('edit.service.charges');
});

Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('allTestimonials',[TestimonialController::class,'showAllTestimonial'])->name('all.testimonial');
    Route::post('add/testimonial',[TestimonialController::class,'addTestimonial'])->name('add.testimonial');
    Route::get('testimonial/{id}/edit',[TestimonialController::class,'editTestimonial'])->name('edit.testimonial');
    Route::put('testimonial/update/{id}',[TestimonialController::class,'updateTestimonial'])->name('update.testimonial');
    Route::get('testimonial/delete/{id}',[TestimonialController::class,'deleteTestimonial'])->name('delete.testimonial');
    Route::get('changeStatusOfTestimonial/{id}',[TestimonialController::class,'changeStatusOfTestimonial'])->name('testimonial.status');

});

Route::group(['middleware' => 'auth', 'admin'],function(){
    Route::get('allTransactions',[TransactionController::class,'showAllTransections'])->name('all.transactions');
    Route::get('transaction/{transactionId}/details',[TransactionController::class,'getDetailsOfTransaction'])->name('transaction.details');
});

Route::get('myEarnings', [TransactionController::class, 'allEarnings'])->name('admin.earnings.all');
Route::post('myEarnings', [TransactionController::class, 'allEarnings'])->name('admin.earnings');
Route::get('allWithdrawRequests', [RedeemController::class, 'index'])->name('admin.withdrawal_requests');

Route::get('upload_video', function(){
    return view('video');
});
Route::post('upload',[AdminController::class, 'videoUpload'])->name('upload');
Route::get('logs', function(){
    \Illuminate\Support\Facades\Log::info('TEST LOG');
});
