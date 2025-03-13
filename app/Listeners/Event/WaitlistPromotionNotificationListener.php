<?php

namespace App\Listeners\Event;

use App\Events\Event\ParticipantsPromotedFromWaitlistEvent;
use App\Models\User;
use App\Notifications\Event\EventRegistrationWaitlistConfirmation;
use App\Notifications\Event\SendWaitlistNotification;
use App\Notifications\Event\WaitlistPromotionNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class WaitlistPromotionNotificationListener
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
    public function handle(ParticipantsPromotedFromWaitlistEvent $event): void
    {

        $users = User::whereIn('id', $event->user_ids)->get();
        
        // Send a notification to the user
        Notification::send($users, new WaitlistPromotionNotification(
            $event->event->name,
            $event->event->event_date_time->format('F d, Y H:i'),
            $event->event->duration,
            $event->event->location
        ));
    }
}
