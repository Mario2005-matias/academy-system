<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    protected $fillable = [
        'student_id',
        'check_in_date',
        'check_in_time',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
