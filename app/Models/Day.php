<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    protected $fillable = ['day', 'start_hour', 'end_hour','service_center_id'];

    public function serviceCenter()
    {
        return $this->belongsTo(ServiceCenter::class);
    }

   


}
