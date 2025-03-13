<?php

namespace App\Listeners\Event;


use App\Events\Event\ParticipantRegisteredEvent;
use App\Models\User;
use App\Notifications\Event\SendRegistrationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendRegistrationNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ParticipantRegisteredEvent $event): void
    {

        // Send a notification to the user
        $event->user->notify(new SendRegistrationNotification(
            $event->event->name,
            $event->event->event_date_time->format('F d, Y H:i'),
            $event->event->duration,
            $event->event->location
        ));
    }
}
