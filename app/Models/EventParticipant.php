<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventParticipant extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'user_id',
        'is_waitlisted',
    ];

    protected $casts = [
        'is_waitlisted' => 'boolean',
    ];

    /**
     * Get the event associated with the participant.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the user associated with the participant.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
