<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

/**
 * Class Event
 * 
 * Represents an event entity with details such as name, description, date, duration, location, and capacity.
 */
class Event extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_date_time' => 'datetime',
        'duration' => 'integer',
        'capacity' => 'integer',
        'waitlist_capacity' => 'integer',
        'status' => EventStatus::class
    ];

    /**
     * Get all participants of the event, including those on the waitlist.
     *
     */
    public function all_participants()
    {
        return $this->hasMany(EventParticipant::class);
    }

    /**
     * Get only the confirmed participants (excluding the waitlist).
     *
     */
    public function participants()
    {
        return $this->hasMany(EventParticipant::class)->where('is_waitlisted', false);
    }

    /**
     * Get the waitlisted participants.
     *
     */
    public function waitlist()
    {
        return $this->hasMany(EventParticipant::class)->where('is_waitlisted', true);
    }

    /**
     * Check if the event is full (based on confirmed participants only).
     *
     * @return bool
     */
    public function isFull()
    {
        return $this->participants()->count() >= $this->capacity;
    }

    /**
     * Check if the waitlist is full.
     *
     * @return bool
     */
    public function isWaitlistFull()
    {
        return $this->waitlist()->count() >= $this->waitlist_capacity;
    }


}
