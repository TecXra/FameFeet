<?php

namespace App\Http\Controllers;

use App\Events\FollowUser;
use App\Events\UnFollowUser;
use App\Helpers\PaginationHelper;
use App\Models\Followship;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BannedUser;
use Illuminate\Support\Facades\Auth;
use Services\BanUserService;
use Services\CelebrityService;
use Services\FanService;
use Services\FollowPostService;
use Services\PostService;

use function PHPUnit\Framework\isEmpty;

class FollowshipController extends Controller
{
    //
    public function userAction(Request $request)
    {
        $followerUser = auth()->user();

        if(checkUserAccountStatus($request->user_id))
        {
            return getUserAccountResponse();
        }
        $followingUser = User::withTrashed()->find($request->user_id);

        $fan_ban_celeb=BannedUser::where('user_id',$followerUser->id)->where('banned_user_id', $followingUser->id)->first();
        $celeb_ban_fan=BannedUser::where('user_id', $followingUser->id)->where('banned_user_id',$followerUser->id)->first();

        $del_user=User::where('account_status',4)->where('id',$followingUser->id)->first();
        if(!$del_user)
        {
            if(!$fan_ban_celeb && !$celeb_ban_fan )
            {
                $exsisting_follow = Followship::where('follower_id',auth()->user()->id)->where('following_id',$request->user_id)->first();
                if(is_null($exsisting_follow))
                {
                    if(auth()->user()->id == $request->user_id){
                        return response()->json([
                            'message' => 'Something Wrong!',
                        ],404);
                    }else{
                        $followerUser = auth()->user();
                        $followingUser = User::find($request->user_id);
                        $data = new Followship();
                        $data->follower_id = auth()->user()->id;
                        $data->following_id = $request->user_id;
                        $data->save();
                        event(new FollowUser($followerUser,$followingUser));
                        // $user_name = null;
                        // if($followingUser->full_name != null)
                        // {
                        //     $user_name = $followingUser->full_name;
                        // }
                        // else
                        // {
                        //     $user_name = $followingUser->username;
                        // }
                        $message = 'You are now following ' . $followingUser->username . '.';
                        return response()->json([
                            'message' => $message,
                        ],200);
                    }
                }else{
                    $exsisting_follow->delete();
                    $unfollowerUser = auth()->user();
                    $unfollowingUser = User::find($request->user_id);
                    event(new UnFollowUser($unfollowerUser,$unfollowingUser));
                    // $user_name = null;
                    // if($followingUser->full_name != null)
                    // {
                    //     $user_name = $followingUser->full_name;
                    // }
                    // else
                    // {
                    // $user_name = $followingUser->username;
                    // }
                    $message = "You've been successfully unfollowed " . $followingUser->username . '.';
                    return response()->json([
                        'message' => $message,
                    ],200);
            }
        }
        else{
            $exsisting_follow = Followship::where('follower_id',auth()->user()->id)
            ->where('following_id',$request->user_id)
            ->first();
            if($exsisting_follow){
                return response()->json([
                    'error' => 'you can not unfollow because you have been blocked!'
                    ],401);
            }else{
            return response()->json([
                'error' => 'you can not follow because you have been blocked!'
                ],401);
            }
        }
    }else{
        return response()->json([
            'message' => 'Your account has been deleted. You cannot perform this action.'
        ]);
    }
        }


    public function getFollowerFollowing()
    {
        $follower = Followship::where('following_id', auth()->user()->id)->get();
        $following = Followship::where('follower_id', auth()->user()->id)->get();
        return response()->json([
                'followers' => $follower->count(),
                'followings' => $following->count(),
        ]);
    }

    public function getAuthUserFollowingFanSide(Request $request)
    {
        $user = Auth::user();
        $fullDiff = [];
        $blockedUserIds = BanUserService::getBlockUser($user);
        $following_ids = Followship::where('follower_id',$user->id)->pluck('following_id')->toArray();
        $fullDiff = array_merge(array_diff($following_ids,$blockedUserIds));

        $query = User::query();
        $query = $query->select('id','username','avatar','date_of_birth','user_type','is_online');
        $query->whereNull('deleted_at');
        if($request->filled('search')){
          $query =  $query->where('username', 'like', '%'.$request->search.'%');
        }
        $query = $query->with(['celebrity'=> function($query1) use ($request){
                    $query1->select('id','user_id');
                    $query1->with('categories:id,text');
                    if($request->filled('categories')){
                        $categories = convetCommaDelimitedStrToArray($request->categories);
                        $query1->whereHas('categories', function ($query2) use ($categories) {
                            $query2->whereIn('categories.id',$categories);
                        });
                    }
                    $query1->with('review');
              }]);
        $query = $query->whereIn('id',$fullDiff);
        $query = $query->orderBy('created_at','DESC')->get();
        $followings = CelebrityService::returnObjOfCelebrity($query);
        $paginated = PaginationHelper::paginate($followings);
        return $paginated;
    }

    public function getAuthUserFollowerFanSide(Request $request){
        $user = Auth::user();
        $blockedUserIds = BanUserService::getBlockUser($user);
        $follower_ids = Followship::where('following_id',$user->id)->pluck('follower_id')->toArray();
        $fullDiff = array_merge(array_diff($follower_ids,$blockedUserIds));

        $query = User::query();
        $query = $query->select('id','username','avatar','date_of_birth','user_type','is_online');
        $query->whereNull('deleted_at');
        if($request->filled('search')){
            $query->where('username', 'like', '%'.$request->search.'%');
        }
        $query = $query->with(['celebrity'=> function($query1) use ($request){
            $query1->select('id','user_id');
            $query1->with('categories:id,text');
            if($request->filled('categories')){
                $categories = convetCommaDelimitedStrToArray($request->categories);
                $query1->whereHas('categories', function ($query2) use ($categories) {
                    $query2->whereIn('categories.id',$categories);
                });
            }
            $query1->with('review');
          }]);
        $query = $query->whereIn('id',$fullDiff);
        $query = $query->orderBy('created_at','DESC')->get();
        $followers = CelebrityService::returnObjOfCelebrity($query);
        $paginated = PaginationHelper::paginate($followers);
        return $paginated;

    }

    public function getAuthUserFollowingCelebritySide(Request $request){
        $user = Auth::user();
        $blockedUserIds = BanUserService::getBlockUser($user);
        $following_ids = Followship::where('follower_id',$user->id)->pluck('following_id')->toArray();
        $fullDiff = array_merge(array_diff($following_ids,$blockedUserIds));

        $query = User::query();
        $query = $query->select('id','username','avatar','date_of_birth','user_type','is_online');
        $query->whereNull('deleted_at');
        if($request->filled('search')){
            $query->where('username', 'like', '%'.$request->search.'%');
        }
        $query = $query->with(['fan'=> function($query){
                    $query->select('id','user_id')
                    ->get();}])
                ->whereIn('id',$fullDiff)
                ->orderBy('created_at','DESC')
                ->get();
        $followings = FanService::returnObjOfFan($query);
        $paginated = PaginationHelper::paginate($followings);
        return $paginated;

    }

    public function  getAuthUserFollowerCelebritySide(Request $request){
        $user = Auth::user();
        $blockedUserIds = BanUserService::getBlockUser($user);
        $follower_ids = Followship::where('following_id',$user->id)->pluck('follower_id')->toArray();
        $fullDiff = array_merge(array_diff($follower_ids,$blockedUserIds));

        $query =User::query();
        $query = $query->select('id','username','avatar','date_of_birth','user_type','is_online');
        $query->whereNull('deleted_at');
        if($request->filled('search')){
            $query->where('username', 'like', '%'.$request->search.'%');
        }
        $query = $query->with(['fan'=> function($query){
                    $query->select('id','user_id')
                    ->get();}])->whereIn('id',$fullDiff)->orderBy('created_at','DESC')->get();
        $followings = FanService::returnObjOfFan($query);
        $paginated = PaginationHelper::paginate($followings);
        return $paginated;
    }



    public function getPostsOfFollowingCelebrity(Request $request)
    {
        $authUser = Auth::user();
        $results = [];
        $unlock_post_ids = PostService::unlockContent($authUser);
        // return $unlock_post_ids;
        if(count($unlock_post_ids) > 0){
            $posts = FollowPostService::followPost($request,$authUser);
            if(count($posts) > 0){
            foreach ($unlock_post_ids as $unlock_post_id) {
                foreach ($posts as $post) {
                    if($post->id == $unlock_post_id){
                        $post->lock_media = 0;
                        $results[] = $post;
                    }
                }
            }
            $diffPosts  = array_diff(array($posts),$results);
            $result = PaginationHelper::paginate($diffPosts[0],$request->perPage);
            return $result;
          }
          $result = PaginationHelper::paginate($posts,$request->perPage);
          return $result;
        }else{
            $posts = FollowPostService::followPost($request,$authUser);
            $result = PaginationHelper::paginate($posts,$request->perPage);
            return $result;
        }
    }
}
