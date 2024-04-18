<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;
use Srmklive\PayPal\Services\ExpressCheckout;
use App\Models\order;

class paymentContoller extends Controller
{
    public function payment($id){
        $orderss=Order::withTrashed()->find($id);
        $priceee=$orderss->serviceCenter->price;
        $data=[];
        $data['items']=
        [
            ['name'=>$orderss->user->name,
            'price'=>$priceee,
            'desc'=>'description',
            'qty'=>1]
        ];
        $data['invoice_id']=1;
        $data['invoice_description']="order #{$data['invoice_id']} invoice";
        $data['return_url']="http://127.0.0.1:8000/api/success";
        $data['cancel_url']="http://127.0.0.1:8000/api/cancel";
        $data['total']=$priceee;
        $provider=new ExpressCheckout;
        $response=$provider->setExpressCheckout($data , true);
        // dd(($response));

        return redirect($response['paypal_link']);

    }

    public function success(Request $request){
        $provider=new ExpressCheckout;
        $response= $provider->getExpresscheckoutDetails($request->token);
        if (in_array(strtoupper($response['ACK']),['SUCCESS' , 'SUCCESSWITHWARNING'])){
            return response()->json(['order paied']);
        }
        return response()->json(['fail payment']);
    }
    public function cancel(){
        return response()->json('payment canceled');
    }
}
