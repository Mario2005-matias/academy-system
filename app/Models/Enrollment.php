<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'student_id',
        'plan_id',
        'start_date',
        'end_date',
        'value_paid',
        'status',
        'status_payment',
    ];
}
