<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventParticipant>
 */
class EventParticipantFactory extends Factory
{
    protected $model = EventParticipant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'user_id' => User::factory(),
            'is_waitlisted' => 0,
        ];
    }

    /**
     * Associate the participant with an event that has a full waitlist.
     *
     * @return static
     */
    public function withSingleWaitlistCapacity(): static
    {
        return $this->state(fn(array $attributes) => [
            'event_id' => Event::factory()->withSingleWaitlistCapacity(),
        ]);
    }

    /**
     * Associate the participant with a fully booked event (no waitlist spots).
     *
     * @return static
     */
    public function withFullyBookedEvent(): static
    {
        return $this->state(fn(array $attributes) => [
            'event_id' => Event::factory()->fullyBooked(),
        ]);
    }


     /**
     * Associate the participant with an event that is for today.
     *
     * @return static
     */
    public function forToday(): static
    {
        return $this->state(fn(array $attributes) => [
            'event_id' => Event::factory()->forToday(),
        ]);
    }
}
