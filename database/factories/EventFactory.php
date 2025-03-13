<?php

namespace Database\Factories;

use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'event_date_time' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'duration' => $this->faker->numberBetween(1, 5), // Duration in hours
            'location' => $this->faker->city,
            'capacity' => $this->faker->numberBetween(10, 100),
            'waitlist_capacity' => $this->faker->numberBetween(5, 20),
            'status' => EventStatus::LIVE, // Assuming you have an enum
        ];
    }

    
    /**
     * Configure the event to have only one available spot in waitlist.
     *
     * @return static
     */
    public function withSingleWaitlistCapacity(): static
    {
        return $this->state(fn(array $attributes) => [
            'capacity' => 1,
            'waitlist_capacity' => 1,
        ]);
    }

    /**
     * Configure the event to be fully booked with no waitlist spots.
     *
     * @return static
     */
    public function fullyBooked(): static
    {
        return $this->state(fn(array $attributes) => [
            'capacity' => 1,
            'waitlist_capacity' => 0,
        ]);
    }

     /**
     * Configure the event to be scheduled for today.
     *
     * @return static
     */
    public function forToday(): static
    {
        return $this->state(fn(array $attributes) => [
            'event_date_time' => now()->ceilHour(),
        ]);
    }
}
