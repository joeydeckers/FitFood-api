<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Recipe;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request){
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if(!Auth::attempt($login)){
            return response(['message' => 'Invalid credentials']);
        }

        $accesToken = Auth::user()->createToken('authToken')->accessToken;

        return response(['user' => Auth::user(), 'accessToken' => $accesToken]);
    }

    public function register(Request $request){
        
        $validatedData = $request->validate([
            'email'=>'email|required|unique:users',
            'password'=>'required|min:6',
            'name'=> 'required',
        ]);


        // if($validatedData->fails()){
        //     return $validatedData->errors();
        // }

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user'=> $user, 'access_token'=> $accessToken]);
    }

    public function getAllRecipes($owner_id){
        $recipes = Recipe::where('owner_id', $owner_id)->get();
        return $recipes;
    }

    public function getUserInfo($id){
        $user = User::find($id);
        return $user;
    }

    public function getCurrentUser(){
        return auth()->guard('api')->user();
    }
}
