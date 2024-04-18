<?php

 namespace App\Http\Controllers\api\traitapi;

trait apitrait
{

    public function apiresponse($data=null, $msg=null, $status=null)
    {
        $array =["data"=> $data,"message"=>$msg,"status"=> $status];
        return response($array, $status);
    }
}
