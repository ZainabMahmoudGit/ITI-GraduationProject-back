<?php

namespace App\Http\Controllers\api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\Service;


class ServiceController extends Controller
{
    use traitapi\apitrait;

    public function index()
    {
        $this->authorize('create', Service::class);
        
        $user_id = Auth::id();
   
       $userServices = Service::where('user_id', $user_id)->get();
   
       return response()->json($userServices);
    }

    public function store(Request $request)
    {

        $this->authorize('create', Service::class);



        $validator = Validator::make($request->all(), [
            'service_name' => 'required|string|max:255',
            'service_details' => 'required|string',
            // 'image' => 'nullable|string|max:255',
            // 'price' => 'max:6',
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }
        $userId = auth()->id();
        $service = Service::create([
            'user_id' => $userId,
            'service_name' => $request->service_name,
            'service_details' => $request->service_details,
            // 'image' => $request->image,
            // 'price' => $request->price,

        ]);

        return response()->json(['message' => 'Service center created successfully', 'data' => $service ],201);
    }

    public function show(Service $service)
    {
        return $this->apiresponse($service, "ok", 200);
    }

    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'service_name' => 'required|string|max:255',
            'service_details' => 'required|string',
            'image' => 'nullable|string|max:255',
            'price' => 'max:6',
        ]);

        if ($validator->fails()) {
            return response($validator->errors()->all(), 422);
        }

        $service->update([
            'service_name' => $request->service_name,
            'service_details' => $request->service_details,
            'image' => $request->image,
            'price' => $request->price,
          
        ]);

        return $this->apiresponse($service, "Service updated successfully", 200);
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return $this->apiresponse([], "Service deleted successfully", 200);
    }
}
