<?php

use App\Http\Controllers\paymentContoller;
use App\Mail\acceptedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/senddd', function () {
//     Mail::to('mayar.m.hamed97@gmail.com')->send(new acceptedMail);
// });

Route::get('/payment/{id}',[paymentContoller::class,'payment']);
