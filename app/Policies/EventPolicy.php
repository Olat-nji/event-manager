<?php

namespace App\Policies;

use App\Enums\EventResponseEnum;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Event $event): bool
    {
        return true;
    }

    /**
     * Determine if a user can join an event.
     */
    public function join(User $user, Event $event): Response
    {
        // Check if the user has already joined this specific event
        if (
            EventParticipant::where([
                'event_id' => $event->id,
                'user_id' => $user->id
            ])->exists()
        ) {
            return Response::deny(EventResponseEnum::ERROR_ALREADY_JOINED->value);
        }

        // Check if the user is already attending another event on the same day
        if (
            $user->events()
            ->whereDate('event_date_time', $event->event_date_time)
            ->exists()
        ) {
            return Response::deny(EventResponseEnum::ERROR_SAME_DAY_EVENT->value);
        }

        // Check if the event and its waitlist are full
        return ($event->isFull() && $event->isWaitlistFull())
            ? Response::deny(EventResponseEnum::ERROR_EVENT_WAITLIST_FULL->value)
            : Response::allow();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny(EventResponseEnum::ERROR_NOT_PERMITTED->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny(EventResponseEnum::ERROR_NOT_PERMITTED->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny(EventResponseEnum::ERROR_NOT_PERMITTED->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Event $event): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny(EventResponseEnum::ERROR_NOT_PERMITTED->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Event $event): Response
    {
        return $user->hasRole('admin')
            ? Response::allow()
            : Response::deny(EventResponseEnum::ERROR_NOT_PERMITTED->value);
    }
}
