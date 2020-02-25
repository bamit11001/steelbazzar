<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
   public function create()
    {
    	$countries = DB::table('countries')->get();
    	$states = DB::table('states')->get();
    	$cities = DB::table('cities')->get();
        return view('registration.create', ['countries' => $countries,'states' => $states,'cities' => $cities ]);
    }

     public function store()
    {
        $this->validate(request(), [
            'name' => 'required',
            'mobile' => 'required|numeric|size:12',
            'password' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required'
        ]);
        
        $user = User::create(request(['name', 'email', 'password']));
        
        auth()->login($user);
        
        return redirect()->to('/games');
    }

    public function getStateList(Request $request)
    {
        $states = DB::table("states")
                    ->where("country_id",$request->country_id)
                    ->pluck("name","id");
        return response()->json($states);
    }

    public function getCityList(Request $request)
    {
        $states = DB::table("cities")
                    ->where("state_id",$request->state_id)
                    ->pluck("name","id");
        return response()->json($states);
    }
}
