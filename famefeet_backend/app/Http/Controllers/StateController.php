<?php

namespace App\Http\Controllers;

use App\Models\State;

class StateController extends Controller
{
    //
    public function getAllStates(){
        $states = State::all();
        return $states;
    }
}
