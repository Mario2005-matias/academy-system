<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Check_in extends Model
{
    protected $fillable = [
        'student_id',
        'check_in_date',
        'check_in_time',
    ];
}
