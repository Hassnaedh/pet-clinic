<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => AppointmentStatus::class
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
