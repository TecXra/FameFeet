<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Services\BanUserService;
use Services\ReportUserService;
//use Facades\Services\UserStatusService;
use Services\UserStatusService;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = User::simplePaginate(4);
        return view('users.index')->with('users',$user);
    }
       /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function getAllUser(Request $request)
    {
        $search = $request->input('search');
        $usersQuery = User::orderBy('id', 'DESC');

        if ($search) {
            $usersQuery->where(function ($query) use ($search) {
            $query->where('username', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('full_name', 'like', '%' . $search . '%');
                });
        }
        $usersQuery->withTrashed();
        $users = $usersQuery->paginate(15);

        return view('users.user')->with('users', $users);
    // end
        // // $search = $request['search'] ?? "";
        // // if($search != ""){
        // //    $users = User::where('username', 'like', '%' . $search . '%')->paginate(10);

        // // }else{
        //     $users = User::orderBy('id','DESC')->paginate(15);

        // // }
        // return view('users.user')->with('users',$users);
    }
           /**
     * Edit a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function editUser($id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        // $user = User::find($id);
       // \dd($user);
        return view('users.edit')->with('user',$user);
    }
           /**
     * Update a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function updateUser(Request $request,$id)
    {
      $data = $request->validate([
                    'username' => 'required|string|min:4|max:32',
                    'email' => 'required|email',
                    'user_type' => 'required'
         ]);

         User::whereId($id)->update($data);

         return redirect()->route('user.getAllUser')->with('success', 'Successfully updated User!');

    }
    /**
     * show a particular user
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function showUser($id)
    {
        $user = User::find($id); 
        $reports = $user->report;
       return view('users.show', compact('user', 'reports'));
     // old
    //     $user = User::find($id);
    //    // \dd($user);
    //     return view('users.show')->with('user',$user);
    }

       /**
     * Destroy a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->fan()->detach();
        $user->delete();
        return response()->json(['status' => 'User and its Refrence Record Deleted!']);


    }

      /**
     * Display a listing of the Celebrity
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function getAllCelebrities()
    {
        return view('users.celebrity');
    }


    //controll user Active Status
    public function userStatus(Request $request,$id)
    {
        $user = User::withTrashed()->where('id', $id)->first();
        // $user = User::find($id);
        UserStatusService::updateUserStatus($request,$user);
        return redirect()->back()->with('status', 'Successfully  User Status Update!');
    }

    public function getSpecificUser($id){
        $user = User::find($id);
        return $user;
    }


    public function blockOrUnblockUser(Request $request){
            $banUser = BanUserService::banUser($request);
            return $banUser;
        }
    public function getBlockUser()
    {
        $blockFrom = Auth::user()->blockFrom;
        return response()->json([
        'Block From' => $blockFrom,
        ]);

    }

    public function reportUser(Request $request){
      $validator = Validator::make($request->all(),[
          'message' => 'required|string'
      ]);
      if($validator->fails()){
        return response()->json($validator->errors(),400);
      }
      $data = ReportUserService::report($request);
      return $data;
    }

    public function getReportUser()
    {
        $reportBy = Auth::user()->reportBy;
        $reportFrom = Auth::user()->reportFrom;
        return response()->json([
        'Report By' => $reportBy,
        'Report From' => $reportFrom,
        ]);

    }

}
