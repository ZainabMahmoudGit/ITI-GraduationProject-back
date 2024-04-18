<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'image' => 'nullable|string|max:255',
            'role' => 'required|in:user,admin,agent', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'image' => $request->image,
            'role' => $request->role,
        ]);

        return response()->json(['user' => $user], 201);
    }

    public function show($id)
    {
        $user = User::find($id);
    
        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        return response()->json(['user' => $user], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
    
        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'string|min:8',
            'phone' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'role' => 'in:user,admin,agent', 
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        // Update only the provided fields
        $user->fill($request->all());
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
    
        return response()->json(['user' => $user], 200);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }




    
    // public function listAgents()
    // {
       
    //     $role = User::where('role', 'agent')->first();
    
    //     if (!$role) {
    //         return response()->json(['message' => 'agents not found'], 404);
    //     }
    
    //     $agents = $role->users;
    
    //     return response()->json($agents);
    // }



    public function listAgents()
    {
        $agents = User::where('role', 'agent')->get();
        return response()->json($agents);
    }


    public function deleteAgent($id)
    {
       
        $agent = User::findOrFail($id);
        if ($agent->role !== 'agent') {
            return response()->json(['message' => 'User is not an agent'], 404);
        }

        $agent->delete();

        return response()->json(['message' => 'Agent deleted successfully'], 200);
    }
}


