<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Mail\acceptedMail;
use App\Mail\rejectMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\order;

class mailController extends Controller
{


    public function send($id)
    {
        $order=order::find($id);
        // dd($order->user->email);

         Mail::to($order->user->email)->send(new acceptedMail($order->id));
         return response()->json(['message' => 'email sended successfully']);

    }
    public function reject($id)
    {
        $order=order::find($id);
        // dd($order->user->email);

         Mail::to($order->user->email)->send(new rejectMail($order->id));
         return response()->json(['message' => 'email sended successfully']);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
