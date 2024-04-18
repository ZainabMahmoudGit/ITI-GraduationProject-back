<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCenter;
use Illuminate\Http\Request;

class ServiceByController extends Controller
{

    public function show($serviceId)
    {
        $service = Service::with('serviceCenters')->find($serviceId);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        $serviceCenters = $service->serviceCenters;

        return response()->json(['service_centers' => $serviceCenters], 200);
    }

}
