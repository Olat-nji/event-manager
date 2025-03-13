<?php

namespace Tests\Feature;

use App\Enums\EventResponseEnum;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_can_load_event_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('user.events'), [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200);
    }


    public function test_user_can_join_and_leave_an_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        // User joins the event
        $response = $this->actingAs($user)->post(route('user.events.join', $event->id),[], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => EventResponseEnum::SUCCESS_REGISTERED->value,
            ]);

        // User leaves the event
        $response = $this->actingAs($user)->post(route('user.events.leave', $event->id),[], [
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'message' => EventResponseEnum::SUCCESS_UNREGISTERED->value,
            ]);
    }


    public function test_user_cannot_join_a_fully_booked_event()
    {
        // Create a fully booked event
        $participant = EventParticipant::factory()->withFullyBookedEvent()->create();
        $event = $participant->event;

        // Create a user
        $user = User::factory()->create();

        // Act: User attempts to join the event
        $response = $this->actingAs($user)->post(route('user.events.join', $event->id),[], [
            'Accept' => 'application/json'
        ]);

        // Assert: Request failed due to full capacity
        $response->assertStatus(403)
            ->assertJson([
                'message' => EventResponseEnum::ERROR_EVENT_WAITLIST_FULL->value,
            ]);
        $this->assertDatabaseMissing('event_participants', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);
    }

    public function test_user_cannot_join_another_event_on_same_day()
    {
        // Create a fully booked event
        $participant = EventParticipant::factory()->forToday()->create();

        $user = $participant->user;

        $event = Event::factory()->forToday()->create();

        // Act: User attempts to join the event
        $response = $this->actingAs($user)->post(route('user.events.join', $event->id),[], [
            'Accept' => 'application/json'
        ]);

        // Assert: Request failed due to full capacity
        $response->assertStatus(403)
            ->assertJson([
                'message' => EventResponseEnum::ERROR_SAME_DAY_EVENT->value,
            ]);
        $this->assertDatabaseMissing('event_participants', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);
    }


    public function test_user_cannot_join_an_event_they_have_already_joined()
    {
        // Create a participant for a fully booked event
        $participant = EventParticipant::factory()->withFullyBookedEvent()->create();
        $event = $participant->event;
        $user = $participant->user;

        // Act: User attempts to rejoin the event they are already part of
        $response = $this->actingAs($user)->post(route('user.events.join', $event),[], [
            'Accept' => 'application/json'
        ]);

        // Assert: Request failed due to duplicate join attempt
        $response->assertStatus(403)
            ->assertJson([
                'message' => EventResponseEnum::ERROR_ALREADY_JOINED->value,
            ]);
        $this->assertDatabaseCount('event_participants', 1);
        $this->assertDatabaseHas('event_participants', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);
    }


    public function test_user_is_waitlisted_when_joining_a_full_event()
    {
        // Create a full event with a single waitlist spot left
        $participant = EventParticipant::factory()->withSingleWaitlistCapacity()->create();
        $event = $participant->event;

        // Create a user
        $user = User::factory()->create();

        // Act: User attempts to join the event
        $response = $this->actingAs($user)->post(route('user.events.join', $event->id),[], [
            'Accept' => 'application/json'
        ]);

        // Assert: Request was successful, user is waitlisted

        $response->assertStatus(200)
            ->assertJson([
                'message' => EventResponseEnum::SUCCESS_WAITLISTED->value,
            ]);
        // Assert: User was added to the waitlist
        $this->assertDatabaseHas('event_participants', [
            'user_id' => $user->id,
            'event_id' => $event->id,
            'is_waitlisted' => true,
        ]);
    }


    public function test_user_is_promoted_from_waitlist_when_a_participant_leaves_a_full_event()
    {
        // Create a full event with a single waitlist spot left
        $participant = EventParticipant::factory()->withSingleWaitlistCapacity()->create();
        $event = $participant->event;

        // Create a user
        $user = User::factory()->create();

        // Act: User attempts to join the event and is waitlisted
        $response = $this->actingAs($user)->post(route('user.events.join', $event->id),[], [
            'Accept' => 'application/json'
        ]);
        $this->assertDatabaseHas('event_participants', [
            'user_id' => $user->id,
            'event_id' => $event->id,
            'is_waitlisted' => true,
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'message' => EventResponseEnum::SUCCESS_WAITLISTED->value,
            ]);

        // Remove initial user from event, creating a free spot
        $response = $this->actingAs($participant->user)->post(route('user.events.leave', $event->id),[], [
            'Accept' => 'application/json'
        ]);
        $response->assertStatus(200)
        ->assertJson([
            'message' => EventResponseEnum::SUCCESS_UNREGISTERED->value,
        ]);
        // Assert: User was promoted from the waitlist to the main participant list
        $this->assertDatabaseHas('event_participants', [
            'user_id' => $user->id,
            'event_id' => $event->id,
            'is_waitlisted' => false,
        ]);
    }
}
