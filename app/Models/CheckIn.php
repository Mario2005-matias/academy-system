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

    protected $casts = [
        'check_in_date' => 'date',
        'check_in_time' => 'datetime:H:i:s'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function checkIns()
    {
        return $this->hasMany(CheckIn::class);
    }
}
