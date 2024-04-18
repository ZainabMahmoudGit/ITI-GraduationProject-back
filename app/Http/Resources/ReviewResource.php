<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
          
            "name"=>$this->user->name,
            "user_id" => $this->user->id,
            "image"=>$this->user->image,
            "service_center_id" =>$this->service_center_id,
            "id"=>$this->id,
            "Description" =>$this->Description,
            "rate"=>$this->rate,
        ];
    }
}
