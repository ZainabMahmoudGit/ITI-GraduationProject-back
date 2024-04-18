<?php

namespace App\Http\Controllers\api;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    use traitapi\apitrait;
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

  
    
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)){
            $user = User::where("email",$request->email)->first();
            $token = $user->createToken("personal access token")->plainTextToken;
            $user->token = $token;
            return $this->apiresponse($user,"Login succcfully",200); 
        }
        return response()->json(["user"=> "The password is wrong or Email"]);
    }
    
 

    public function logout(Request $request){
        if ($request->user()->currentAccessToken()->delete()){
            return response()->json(['msg' => "You have been successfully logged out!"]);
        }
        return response()->json(['msg' => "some thing went wrong"]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|min:3",
            
            'role' => ['required', 'min:3', 'in:agent,user'],

            "email" => "required|email|unique:users,email",
            'phone' => ['regex:/^01[0-2]{1}[0-9]{8}$/'],
            'image' => 'nullable|image|max:2048',
            'password' => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            
        ]);
    
        if ($validator->fails()) {
            return response($validator->errors()->all());
        }
    
        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'image' => $request->image,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
    
  
    
        return $this->apiresponse($user,"ok",201);;
    }
}
