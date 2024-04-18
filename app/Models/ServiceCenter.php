<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','name', 'phone', 'rating', 'working_days', 'working_hours', 'description', 'image','location','price',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }


    public function days()
    {
        return $this->hasMany(Day::class);
    }
}