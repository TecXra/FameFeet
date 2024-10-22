<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TestimonialController extends Controller
{
    //
    public function showAllTestimonial(){
       $testimonials = Testimonial::paginate(15);
       return view('testimonial.index')->with('testimonials',$testimonials);
    }

    public function addTestimonial(Request $request){
        // dd($request);
        $this->validate($request, [
            'name' => 'required',
            'avatar' => 'required',
            'rating' => 'required',
            'review' => 'required',
        ]);
        // dd($request);
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('storage/upload/');
            $image->move($destinationPath, $name);
        }
        $testimonial = new Testimonial();
        $testimonial->name = $request->name;
        $testimonial->avatar = "storage/upload/".$name;
        $testimonial->rating = $request->rating;
        $testimonial->review = $request->review;
        $testimonial->save();
        return Redirect::route('all.testimonial');
        // return $testimonial;
    }

    public function editTestimonial($id){
        $testimonial = Testimonial::find($id);
        return view('testimonial.edit')->with('testimonial',$testimonial);
    }

    public function updateTestimonial(Request $request,$id){
        $data =  $request->validate([
            'name' => 'required|string',
            'rating' => 'required',
            'review' =>'required',
      ]);

      Testimonial::whereId($id)->update($data);
      return redirect()->route('all.testimonial')->with('success', 'Successfully updated Category!');
    }

    public function deleteTestimonial($id){
        $category = Testimonial::find($id);
        $category->delete();
        return Redirect::route('all.testimonial')->with('delete','Testimonial deleted');
    }

    public function changeStatusOfTestimonial($id){
        $testimonial = Testimonial::select('status')->where('id','=',$id)->first();
           if($testimonial->status == '1'){
                    $status = '0';
            }else{
                    $status = '1';
            }
           $data = array('status' => $status);
           Testimonial::whereId($id)->update($data);
           return Redirect::back();
    }

    public function getAllTestimonials(){
       $testimonial = Testimonial::where('status',true)->get();
       return $testimonial;
    }
}
