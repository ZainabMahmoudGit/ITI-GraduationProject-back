<?php

namespace App\Http\Controllers\api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\orderResource;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{


  

    // function __construct(){
    //     $this->middleware("auth:sanctum");
    // }

    
// test api authenticate


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ReviewResource ::collection( Review::all());
        
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // التحقق من مصادقة المستخدم
        if (!Auth::check()) {
            return response()->json('Unauthorized', 401);
        }
        
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "service_center_id" => "required",
            "Description" => "required",
            "rate"=> "required"
            
        ]);
    
        if ($validator->fails()) {
            return response($validator->errors()->all());
        }
    
        // إنشاء المراجعة الجديدة
        $review = Review::create($request->all());
        return response($review, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return $review;
    }

    /**
     * Update the specified resource in storage.
     */

  public function update(Request $request, Review $review)
{

    if ($review->user_id == Auth::id()) {
        $validator = Validator::make($request->all(), [

            "Description" => "required",
         //   "rate"=> "required"
        ]);
    
        if ($validator->fails()) {
            return response($validator->errors()->all());
        }
        $review->update($request->all());
        return response()->json('Review updated successfully', 200);
    } else {
        return response()->json('You are not authorized to update this review', 403);
    }

}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        if ($review->user_id == Auth::id()) {
            $review->delete();
            return response()->json('Deleted Successfully', 200);
        } else {
            return response()->json('You are not authorized to delete this review', 403);
        }
    }

}
