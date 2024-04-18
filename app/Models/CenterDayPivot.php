<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CenterDayPivot extends Model
{
    use HasFactory;
    protected $table = 'center_day_pivot';
    protected $fillable = ['start_hour', 'end_hour'];


    
}
