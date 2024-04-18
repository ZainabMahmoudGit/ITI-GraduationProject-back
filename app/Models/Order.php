<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'service_center_id', 'order_details', 'order_state', 'order_date','phone','car_model',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceCenter()
    {
        return $this->belongsTo(ServiceCenter::class);
    }


    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_order', 'order_id', 'service_id');
    }
}
