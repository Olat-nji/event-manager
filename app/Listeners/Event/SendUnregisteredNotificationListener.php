<?php

namespace App\Listeners\Event;



use App\Events\Event\ParticipantsUnregisteredEvent;
use App\Models\User;
use App\Notifications\Event\SendRegistrationNotification;
use App\Notifications\Event\SendUnregisteredNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendUnregisteredNotificationListener
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
    public function handle(ParticipantsUnregisteredEvent $event): void
    {

        $users = User::whereIn('id', $event->user_ids)->get();
        
        // Send a notification to the user
        Notification::send($users, new SendUnregisteredNotification(
            $event->event->name,
            $event->event->event_date_time->format('F d, Y H:i'),
            $event->event->duration,
            $event->event->location
        ));
    }
}
