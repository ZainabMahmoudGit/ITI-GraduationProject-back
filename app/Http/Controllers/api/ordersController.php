<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\orderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\ServiceCenter;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    use traitapi\apitrait;

    public function index()
    {


        $orders = Order::all();
         if ($orders->isEmpty()) {
             return "No orders available!";
         } else {
            return orderResource::collection($orders);
         }
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'user_id' => 'required',

            'service_center_id' => 'required',
            'order_details' => 'required',
            'order_date' => 'required',
            'order_state' => 'required',
            'phone' => 'required',
            'car_model' => 'required',
            'services' => 'array|required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->messages()], 422);
        }

        $order = Order::create($request->all());
        ([
            'user_id' => $request->user_id,
            // 'order_details' => $request->order_details,
            'service_center_id' => $request->service_center_id,
            'order_date' => $request->order_date,
            'phone' => $request->phone,
            'car_model' => $request->car_model,
            'order_state' => $request->order_state,
        ]);

        $order->services()->attach($request->input('services'));

        return response()->json(['message' => 'Order created successfully', 'data' => $order],201);
    }

    public function show(Order $order)
    {
        return $this->apiresponse($order, "ok", 200);
    }

    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            // 'order_details' => 'required',
            'service_center_id' => 'required',
            'order_date' => 'required',
            'phone' => 'required',
            'car_model' => 'required',
            'services' => 'array|required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->messages()], 422);
        }

        $order->update($request->all());

        // Sync the selected services with the order
        $order->services()->sync($request->input('services'));

        return response()->json(['message' => 'Order Updated Successfully', 'data' => $order],201);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return $this->apiresponse([], "Order deleted successfully", 200);
    }

    public function archeive($service_center_id){
        $servicCenter= ServiceCenter::find($service_center_id);
        $user_id = Auth::id();
        if($servicCenter->user_id==$user_id){
        $order=order::onlyTrashed()->where('service_center_id', $service_center_id)->get();
        return orderResource::collection($order);
        }
    }
    public function userarcheive($user_id){
        $order=order::onlyTrashed()->where('user_id', $user_id)->get();
        return orderResource::collection($order);
    }
    public function restore($id){
        order::withTrashed()->where('id',$id)->restore();
    }
    public function forcedelete($id){
        order::withTrashed()->where('id',$id)->forceDelete();
    }

    public function getOrdersByServiceCenterId($service_center_id)
    {
        $user_id = Auth::id();
        $servicCenter= ServiceCenter::find($service_center_id);
       if($servicCenter->user_id==$user_id){

           $orders = Order::where('service_center_id', $service_center_id)->get();

           if ($orders->isEmpty()) {
               return $this->apiresponse([], "No orders found for the specified service center ID", 404);
           }

           return orderResource::collection($orders);
       }
    }


    public function getOrdersByUserId($user_id)
{
    $orders = Order::where('user_id', $user_id)->get();

    if ($orders->isEmpty()) {
        return $this->apiresponse([], "No orders found for the specified user ID", 404);
    }

    return orderResource::collection($orders);
}
}
