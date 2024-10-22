<?php

namespace App\Http\Controllers;

use App\Models\SocksSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocksSizeController extends Controller
{
    //

    public function getAllSocksSizes(){
        $femaleSocksSize = SocksSize::select('id','socks_size_name','status')->where('gender','female')->get();
        $maleSocksSize = SocksSize::select('id','socks_size_name','status')->where('gender','male')->get();

        if(count($femaleSocksSize) > 0){
            foreach ($femaleSocksSize as $socksSize) {
                $data[] = [
                    'id' => $socksSize->id,
                    'value' => $socksSize->id,
                    'text'  => $socksSize->socks_size_name,
                    'status' => $socksSize->status,
                ];
            }
        }else{
            $data = [];
        }

       if(count($maleSocksSize) > 0){
            foreach ($maleSocksSize as $size) {
                $result[] = [
                    'id' => $size->id,
                    'value' => $size->id,
                    'text'  => $size->socks_size_name,
                    'status' => $size->status,
                ];
            }
        }else{
            $result = [];
        }
         return response()->json([
               'women_socks_size' => $data,
               'man_socks_size' => $result
         ]);
    }



      //All Feet Size
      public function index()
      {
         $socksSize  =SocksSize::orderBy('id','DESC')->paginate();
         $trashes = SocksSize::onlyTrashed()->paginate(8);
         return view('socks.index')->with('socksSizes',$socksSize)->with('trashes',$trashes);
      }
       /**
       * Store a newly created resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @return \Illuminate\Http\Response
       */
      public function store(Request $request)
      {
          // dd($request);
          $validator = Validator::make($request->all(), [
              'socks_size_name' => 'required|string',
              'gender' => 'required|string',

          ]);
          if ($validator->fails()) {
              return response()->json($validator->errors(), 400);
          }

          $socks = SocksSize::where('socks_size_name', 'like', '%' . $request->socks_size_name . '%')->where('gender',$request->gender)->get();
        //   return $socks;
          if(count($socks) == 0){
              $socksObj = SocksSize::create([
                  'socks_size_name' => ucfirst($request->socks_size_name),
                  'gender' => $request->gender,
              ]);
             return redirect()->route('socks.all');
          }else{
              return redirect()->route('socks.all')->with('success','This Feet Size Already Exist');
          }

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
          $socks = SocksSize::find($id);
          return view('socks.edit')->with('socks',$socks);
      }

       /**
       * Update the specified resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function update(Request $request, $id)
      {
          $data =  $request->validate([
                'socks_size_name' => 'required|string',
                'gender' => 'required',
          ]);

          SocksSize::whereId($id)->update($data);
          return redirect()->route('socks.all')->with('success', 'Successfully updated Feet Size!');
      }

        //controll user Active Status
        public function socksStatus($id)
        {
             $category = SocksSize::select('status')->where('id','=',$id)->first();
             if($category->status == '1'){
                      $status = '0';
              }else{
                      $status = '1';
              }
             $data = array('status' => $status);
             SocksSize::whereId($id)->update($data);
             return redirect()->back()->with('status', 'Successfully Change Status!');
        }
        // Delete Feet Size
        public function destroy($id){
          $socksSize = SocksSize::find($id);
          $socksSize->delete();
          return redirect()->route('socks.all')->with('success','Feet Size Delete Successfully!');
        }

        public function restore($id){
          $socks = SocksSize::withTrashed()->find($id)->restore();
          return redirect()->route('socks.all')->with('success','Feet Size Restore Successfully!');
        }
}
