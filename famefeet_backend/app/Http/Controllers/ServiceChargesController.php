<?php

namespace App\Http\Controllers;

use App\Models\ServiceCharges;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ServiceChargesController extends Controller
{
    //

    public function getServiceCharges(Request $request,$id)
    {
        $request->validate([
            'service_charges' => 'required|integer|min:1|max:99',
        ]);
        $serviceCharges = ServiceCharges::find($id);
        $serviceCharges->service_charges = $request->service_charges;
        $serviceCharges->save();
        return Redirect::route('home')->with('serviceCharges',$serviceCharges);
    }


}
