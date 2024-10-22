<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fan;
use Illuminate\Support\Facades\Auth;
use Services\BanUserService;
use Services\FanService;

class FanController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $search = $request['search'] ?? "";
        // if($search != ""){
        //    $fans = Fan::where('location', 'like', '%' . $search . '%')->paginate(15);

        // }else{
           
            $fans = Fan::with(['user' => function ($query) {
                $query->withTrashed();
            }])->orderBy('id', 'DESC')->paginate(15);

        // }
        return view('fan.index')->with('fans',$fans)->with('search',$search);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $fan = Fan::find($id);
        return view('fan.show')->with('fan',$fan);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $fan = Fan::find($id);
        return view('fan.edit')->with('fan',$fan);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   $fan = Fan::find($id);
        $data =  $request->validate([
              'location' =>'required',
              'gender' => 'required',
              'bio' => 'required'
        ]);
        $fan->update($data);
        return redirect()->route('fan.all')->with('success', 'Successfully updated User!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $fan = Fan::find($id);
        $fan->delete();
        return redirect()->back()->with('status','Fan Deleted Successfully!');
    }

    // get all Fans
    public function getAllFans(Request $request){
        $user = Auth::user();
        $blockedUserIds = BanUserService::getBlockUser($user);
        $fans = FanService::getAllFansUser($request,$blockedUserIds);
        return $fans;

    }
    //get specific fan
    public function getSpecificFan($id)
      {
         $fan = FanService::getSpecificFanUser($id);
         return $fan;
      }

    // public  function fanAvgRating()
    // {
    //     $result = FanService::avgFanRating(5);
    //     return $result;
    // }



}
