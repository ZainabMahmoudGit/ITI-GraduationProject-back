<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;



use Illuminate\Support\Facades\Hash;
use  App\Http\Requests;
class usersController extends Controller
{
// trait api 

use traitapi\apitrait;

// public function __construct(){

//      $this->middleware('auth');
//      abort(403, 'please Log In !');
// }

public function index()
{
    $users = User::all();

    if ($users->isEmpty()) {
        return "No User here !";
    } else {
        return $this->apiresponse($users, "ok", 200);
    }
}



        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                "name" => "required|min:3",
                "email" => "required|email|unique:users,email",
                'phone' => ['regex:/^01[0-2]{1}[0-9]{8}$/'],
                "image" => 'max:1000','mimes:png,jpg,jpeg',
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
                'password' => Hash::make($request->password),
            ]);
        
      
        
            return $this->apiresponse($user,"ok",201);;
        }
        

    public function show($id)
    {
        $user = user::findOrFail($id);
       if($user){
        return  $this->apiresponse($user,"ok",200);
       }else{
        return  $this->apiresponse(null,"this user not found",401); 
    } 
    }


    public function update(Request $request, User $user)
    {
     
          $validator = Validator::make($request->all(), [
            "email"=> [Rule::unique('users')->ignore($user->id)],
            'name' => 'required|string|min:3|max:255',
            'phone' => 'required|string|min:11|max:11',
            'image' => 'nullable|image|max:2048',
            "password"=>'required|min:8'
        ]);

        if($validator->fails()){
            return response()->json(['message' => "Errors", 'data' => $validator->errors()->all()], 422);
        }

           $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $imagePath = 'images/' . $imageName; 
        }
    
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'image' => $imagePath,
            'password' => bcrypt($request->password)
        ]);

 
    
        return   $this->apiresponse($user,"User updated succcfully",201); 

    }

   
    public function destroy(User $user)
    {
     
          $user->delete();
        return $this->apiresponse($user,"User delete succcfully",201); 
    }











   
}
