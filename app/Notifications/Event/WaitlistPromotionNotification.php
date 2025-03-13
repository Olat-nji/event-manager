<?php

namespace App\Notifications\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WaitlistPromotionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        protected string $eventName,
        protected string $eventDate,
        protected string $eventDuration,
        protected string $eventLocation
    ) {}


    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
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
            ->subject("Good News! You're Off the Waitlist for {$this->eventName}")
            ->greeting("Hello, {$notifiable->name}!")
            ->line("We've got great news! A spot has opened up for **{$this->eventName}**.")
            ->line("📅 Date: {$this->eventDate}")
            ->line("📍 Location: {$this->eventLocation}")
            ->line("You're now officially registered! No further action is needed, but feel free to review the event details below.")
            ->action('View Events', route('user.events'))
            ->line("We look forward to seeing you there! If you have any questions, reach out to us.");
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event_name' => $this->eventName,
            'event_date' => $this->eventDate,
            'event_location' => $this->eventLocation,
            'message' => "You've been promoted from the waitlist to a confirmed participant for {$this->eventName} on {$this->eventDate} at {$this->eventLocation}."
        ];
    }
}
