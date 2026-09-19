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

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'value_paid' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
