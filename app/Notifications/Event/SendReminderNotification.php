<?php

namespace App\Notifications\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Event;

class SendReminderNotification extends Notification implements ShouldQueue
{
    use Queueable;



    /**
     * Create a new notification instance.
     */
    public function __construct(protected Event $event) {}

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Event Reminder: ' . $this->event->name)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('This is a reminder for the event "' . $this->event->name . '" happening today.')
            ->line('Date: ' . $this->event->event_date_time->format('F j, Y'))
            ->line('Time: ' . $this->event->event_date_time->format('h:i A'))
            ->action('View Events', route('user.events'))
            ->line('Looking forward to seeing you there!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'name' => $this->event->name,
            'date' => $this->event->event_date_time->toDateString(),
        ];
    }
}
