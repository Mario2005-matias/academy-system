<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'enrollment_id',
        'value',
        'payment_date',
        'payment_method',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'value' => 'decimal:2',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
