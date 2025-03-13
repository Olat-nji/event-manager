<?php

namespace App\Listeners\Event;

use App\Events\Event\ParticipantWaitlistedEvent;
use App\Models\User;
use App\Notifications\Event\EventRegistrationWaitlistConfirmation;
use App\Notifications\Event\SendWaitlistNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWaitlistNotificationListener
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
    public function handle(ParticipantWaitlistedEvent $event): void
    {


        // Send a notification to the user
        $event->user->notify(new SendWaitlistNotification(
            $event->event->name,
            $event->event->event_date_time->format('F d, Y H:i'),
            $event->event->duration,
            $event->event->location
        ));
    }
}
