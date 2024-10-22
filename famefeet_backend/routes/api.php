<?php

use App\Events\MessageBroadcastingEvent;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\BankAccountDetailController;
use App\Http\Controllers\CelebrityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CelebritySendOfferController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FanController;
use App\Http\Controllers\FootSizeController;
use App\Http\Controllers\PostMediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\RedeemController;
use App\Http\Controllers\ReferralUserController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\Common\MiscController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
// Route::get('creditBankAccount',[PaymentTransactionLogsController::class,'creditBankAccount']);
// Route::post('checkUser',[SocialAuthController::class,'checkUser']);
Route::get('getAllShopItems',[ShopMediaController::class,'getAllShopItems']);
Route::get('getAllCelebrities',[CelebrityController::class,'getAllCelebrities']);
Route::get('getAllContents',[PostMediaController::class,'getAllContents']);
Route::get('getCategoriesHaveImages',[CategoryController::class,'getCategoriesHaveImages']);
//All  testimonials
Route::get('getAllTestimonials',[TestimonialController::class,'getAllTestimonials']);

Route::get('warningMailOfAutoSubscribe',[SubscriptionController::class,'warningMailOfAutoSubscribe']);
// Route::get('sendMailToCompleteOrder',[CheckoutController::class,'sendMailToCompleteOrder']);
// Route::get('checkReferralStatus',[ReferralUserController::class,'changeReferralStatus']);
// Route::get('autoSubscribe',[SubscriptionController::class,'autoSubscribe']);
// Route::get('completeOrderStatusCronJob',[CheckoutController::class,'completeOrderStatusCronJob']);
Route::post('contact-us',[ContactUsController::class,'storeContactUsInfo']);
// Route::post('referallCode',[UserController::class,'getReferral']);
// Route::get('restoreLike',[LikesController::class,'restoreLike']);
// Route::get('getAllFans',[FanController::class,'getAllFans']);
Route::get('getFirstTenCelebrities',[CelebrityController::class,'getFirstTenCelebrities']);
Route::get('getAllStates',[StateController::class,'getAllStates']);
Route::get('addToWallet/{id}',[OfferController::class,'addCoinsToWallet']);
Route::get('getAllCategories',[CategoryController::class,'getCategories']);
Route::get('getAllFootSizes',[FootSizeController::class,'getAllFootSizes']);
Route::post('forgetPassword',[ForgotPasswordController::class,'forgetPassword']);
Route::post('varifyToken',[ForgotPasswordController::class,'varifyToken']);
Route::post('resetForgetPassword',[ForgotPasswordController::class,'resetForgetPassword']);
$baseControllerNameSpace = '\App\Http\Controllers\\';

Route::post('auth/loginUser', $baseControllerNameSpace.'Auth\AuthController@loginUser');
Route::post('auth/registerFanUser', $baseControllerNameSpace.'Auth\AuthController@registerFanUser');
Route::get('auth/getAuthenticateUser', $baseControllerNameSpace.'Common\UserController@getAuthenticateUser');


Route::post('auth/isUsernameAvailable', $baseControllerNameSpace.'Auth\AuthController@isUsernameAvailable');


Route::post('auth/registerCelebrityUser', $baseControllerNameSpace.'Auth\AuthController@registerCelebrityUser');
//Route::get('auth/getCelebrity', [CelebrityController::class,'index']);
//Route::get('auth/logoutUser', $baseControllerNameSpace.'Auth\AuthController@logoutUser');
// Route::get('/google', [GoogleAuthController::class, 'redirectToGoogle']);
// Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

Route::get('/login/{provider}', [SocialAuthController::class,'redirectToProvider']);
Route::get('/login/{provider}/callback', [SocialAuthController::class,'handleProviderCallback']);



///////////////////////////////////////////////////////////////////////////
/////////////////// Misc apis ////////////////////////////////////////////

Route::get('getCelebrityMessagePrice',[MiscController::class,'getCelebrityMessagePrice']);



Route::middleware(['auth:api'])->group(function () {
    Route::post('auth/logOut',[AuthController::class,'logoutUser']);


/*
|--------------------------------------------------------------------------
| Profile Control API Routes
|--------------------------------------------------------------------------
*/
    Route::post('auth/changePassword',[ProfileController::class,'changePassword']);
    Route::post('auth/changePhoneNumber',[ProfileController::class,'changePhoneNumber']);
    Route::post('auth/updateAvatar',[ProfileController::class,'updateAvatar']);
    Route::get('auth/getAvatar',[ProfileController::class,'getAvatar']);
    Route::post('auth/fanProfile',[ProfileController::class,'FanProfileInformation']);
    Route::post('auth/celebrityProfile',[ProfileController::class,'CelebrityProfileInformation']);
/*
|--------------------------------------------------------------------------
| Category Control API Routes
|--------------------------------------------------------------------------
*/
    Route::post('auth/setCategoriesToCelebrity',[CategoryController::class,'setCategoriesToCelebrity']);
    Route::get('auth/getSelectedCategoriesOfCelebrity',[CategoryController::class,'getSelectedCategoriesOfCelebrity']);
/*
|--------------------------------------------------------------------------
| Post Control API Routes
|--------------------------------------------------------------------------
*/
    // Route::get('auth/getAllContents',[PostMediaController::class,'getAllContents']);
    Route::post('auth/createPost',[PostMediaController::class,'createPost']);
    Route::get('auth/getAllPostsOnCelebritySide',[PostMediaController::class,'getAllPostsOnCelebritySide']);
    Route::get('auth/getPostsOfAuthCelebrity',[PostMediaController::class,'getPostsOfAuthCelebrity']);
    Route::get('auth/getPostsOfCelebrity/{id}',[PostMediaController::class,'getPostsOfCelebrity']);
    Route::post('auth/editPost/{id}',[PostMediaController::class,'editPost']);
    Route::delete('auth/deletePost/{id}',[PostMediaController::class,'deletePost']);
    Route::get('auth/buyPostContent/{id}',[PostMediaController::class,'buyPostContent']);
    Route::get('auth/getPurchasePostAndOfferContent',[PostMediaController::class,'getPurchasePostContent']);
    Route::get('auth/getAllSoldContent',[PostMediaController::class,'getAllSoldContent']);

    Route::post('auth/sharePost',[SharePostController::class,'sharePost']);
    Route::get('auth/getSharedPosts',[SharePostController::class,'getSharedPosts']);
    Route::get('auth/getAuthCelebrityPsotsForSharing/{id}',[SharePostController::class,'getAllPostsForSharing']);
/*
|--------------------------------------------------------------------------
| Shop Control API Routes
|--------------------------------------------------------------------------
*/
    Route::post('auth/createShopItem',[ShopMediaController::class,'createShop']);
    Route::get('auth/getAllShopItem',[ShopMediaController::class,'getAllShopItems']);
    // Route::get('auth/getShopItemOfCelebrity/{id}',[ShopMediaController::class,'getShopsOfCelebrity']);
    Route::get('auth/getShopItemOfAuthCelebrity',[ShopMediaController::class,'getShopsOfAuthCelebrity']);
    Route::post('auth/editShopItem/{id}',[ShopMediaController::class,'editShop']);
    Route::delete('auth/deleteShopItem/{id}',[ShopMediaController::class,'deleteShop']);
    Route::get('auth/getShopSingleItem/{id}',[ShopMediaController::class,'getShopSingleItem']);
/*
|--------------------------------------------------------------------------
| Media Control API Routes
|--------------------------------------------------------------------------
*/
    // Route::post('auth/editMedia/{id}',[MediaController::class,'editMedia']);
/*
|--------------------------------------------------------------------------

Route::get('fan/avg/rating',[FanController::class,'fanAvgRating']);
// Route::get('/service/charges',[ServiceChargesController::class,'getServiceCharges']);

// Route::get('/event', function () {
//     event(new MessageBroadcastingEvent('this is first message'));
//     return 'yes';
// });







////////////////////////////////////////////////////////////////////
////////////////////// New public routes ///////////////////////////


Route::get('/getCelebrityDetailByUsername/{username}',[CelebrityController::class,'getCelebrityDetailByUsername']);
Route::get('/getCelebrityPosts/{celeb_id}/{content_type?}',[PostMediaController::class,'getCelebrityPosts']);
Route::get('/getCelebrityShopItems/{celeb_id}',[ShopMediaController::class,'getCelebrityShopItems']);
Route::get('/getCelebrityReviews/{celeb_id}',[ReviewController::class,'getCelebrityReviews']);

////////////////////////////////////////
///////////////// verify user email ///////////////
Route::get('/verifyUserEmail/{token}',[AuthController::class,'verifyUserEmail']);
Route::post('/resendUserEmailVerificationEmail',[AuthController::class,'resendUserEmailVerificationEmail']);

Route::post('/checkVideoDuration', [MediaController::class, 'checkVideoDuration'])->name('videoDuration');
Route::get('outGoingplatformpagination',[WalletController::class,'allOutGoingPlatformDatatables'])->name('outGoingplatformpagination');
Route::get('allPlatformpagination',[WalletController::class,'allPlatformDatatables'])->name('allPlatformpagination');
Route::get('allIncomingPlatformPagination',[WalletController::class,'allIncomingPlatformDatatables'])->name('allIncomingPlatformPagination');






