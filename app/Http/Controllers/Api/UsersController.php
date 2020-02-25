<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    public function getContries(){
    	$countries = Countries::all();
    	return response()->json([
				    'countries' => $countries, 'status' => 200
				]);

    }
     public function register()
    {
       // $user = [
       //          'name' => request('name'),
       //          'email' => request('email'),
       //          'password' => Hash::make(request('password')),
       // ];
       //  if(User::create($user)){
       //      $credentials = request(['email', 'password']);
       //      if (! $token = auth('api')->attempt($credentials)) {
       //          return response()->json(['error' => 'Unauthorized'], 401);
       //      }
       //      return $this->respondWithToken($token);
       //  }else{
       //       return response()->json(['error' => 'error registering'], 401);
       //  }
       

        
    }
}
