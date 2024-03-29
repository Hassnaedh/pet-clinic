<?php

namespace App\Models;

use App\Enums\PetType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => PetType::class
    ];

    public function owner():BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
