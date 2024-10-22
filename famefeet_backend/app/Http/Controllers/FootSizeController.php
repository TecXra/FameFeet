<?php

namespace App\Http\Controllers;

use App\Models\Feet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FootSizeController extends Controller
{
    //
    public function getAllFootSizes()
    {
        $femaleFeetSize = Feet::select('id','size','status')->where('gender','female')->get();
        $maleFeetSize = Feet::select('id','size','status')->where('gender','male')->get();

        if(count($femaleFeetSize) > 0){
            foreach ($femaleFeetSize as $size) {
                $data[] = [
                    'value' => $size->id,
                    'text'  => $size->size,
                    'status' => $size->status,
                ];
            }
        }else{
            $data = [];
        }

       if(count($maleFeetSize) > 0){
            foreach ($maleFeetSize as $size) {
                $result[] = [
                    'value' => $size->id,
                    'text'  => $size->size,
                    'status' => $size->status,
                ];
            }
        }else{
            $result = [];
        }
         return response()->json([
               'women_feet_size' => $data,
               'man_feet_size' => $result
         ]);
    }

    //All Feet Size
    public function index(Request $request)
    {
        $search = $request->input('search');

        $feetSizeQuery = Feet::orderBy('id', 'DESC');
    
        if ($search) {
            $feetSizeQuery->where('size', 'like', '%' . $search . '%'); // Replace 'your_column_name' with the actual column name you want to search.
        }
    
        $feetSize = $feetSizeQuery->paginate();
        $trashes = Feet::onlyTrashed()->paginate(8);
    
        return view('footsize.index')->with('feetSizes', $feetSize)->with('trashes', $trashes);
        
        // old

    //    $feetSize  =Feet::orderBy('id','DESC')->paginate();
    //    $trashes = Feet::onlyTrashed()->paginate(8);
    //    return view('footsize.index')->with('feetSizes',$feetSize)->with('trashes',$trashes);
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
            'size' => 'required|string',
            'gender' => 'required|string',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $feet = Feet::where('size', 'like', '%' . $request->size . '%')->get();
        // return $feet;
        if(count($feet) == 0){
            $feetObj = feet::create([
                'size' => strtoupper($request->size),
                'gender' => $request->gender,
            ]);
           return redirect()->route('feet.all');
        }else{
            return redirect()->route('feet.all')->with('success','This Feet Size Already Exist');
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
        $feet = Feet::find($id);
        return view('footsize.edit')->with('feet',$feet);
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
              'size' => 'required|string',
              'gender' => 'required',
        ]);

        Feet::whereId($id)->update($data);
        return redirect()->route('feet.all')->with('success', 'Successfully updated Feet Size!');
    }

      //controll user Active Status
      public function feetStatus($id)
      {
           $category = Feet::select('status')->where('id','=',$id)->first();
           if($category->status == '1'){
                    $status = '0';
            }else{
                    $status = '1';
            }
           $data = array('status' => $status);
           Feet::whereId($id)->update($data);
           return redirect()->back()->with('status', 'Successfully Change Status!');
      }
      // Delete Feet Size
      public function destroy($id){
        $feetSize = Feet::find($id);
        $feetSize->delete();
        return redirect()->route('feet.all')->with('success','Feet Size Delete Successfully!');
      }

      public function restore($id){
        $feet = Feet::withTrashed()->find($id)->restore();
        return redirect()->route('feet.all')->with('success','Feet Size Restore Successfully!');
      }
}
