<?php

namespace App\Notifications\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendUnregisteredNotification extends Notification implements ShouldQueue
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
            ->subject("You Have Been Unregistered from {$this->eventName}")
            ->greeting("Hello, {$notifiable->name}")
            ->line("You have been successfully unregistered from **{$this->eventName}**.")
            ->line("📅 **Date:** {$this->eventDate}")
            ->line("⏳ **Duration:** {$this->eventDuration} Minutes")
            ->line("📍 **Location:** {$this->eventLocation}")
            ->line("If this was a mistake or you'd like to rejoin, you can register again if spots are available.")
            ->action('View Events', route('user.events'))
            ->line("We hope to see you at another event soon!");
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
            'message' => "You have been unregistered from {$this->eventName} on {$this->eventDate} at {$this->eventLocation}."
        ];
    }
}
