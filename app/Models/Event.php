<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'event_date_time',
        'duration',
        'location',
        'capacity',
        'waitlist_capacity',
        'status',
    ];

    protected $casts = [
        'event_date_time' => 'datetime',
        'duration' => 'integer',
        'capacity' => 'integer',
        'waitlist_capacity' => 'integer',
    ];
}
