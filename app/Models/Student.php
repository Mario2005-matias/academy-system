<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'date_of_birth',
        'is_active',
    ];

    public function checkIns()
    {
        return $this->hasMany(CheckIn::class);
    }
}
