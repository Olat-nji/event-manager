<?php

namespace App\Notifications\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendRegistrationNotification extends Notification implements ShouldQueue
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
            ->subject("Registration Confirmation for {$this->eventName}")
            ->greeting("Hello, {$notifiable->name}!")
            ->line("You have successfully registered for the event **{$this->eventName}**.")
            ->line("📅 Date: {$this->eventDate}")
            ->line("⏳ Duration: {$this->eventDuration} minutes") // Fixed the duplicate date issue
            ->line("📍 Location: {$this->eventLocation}")
            ->action('View Events', route('user.events'))
            ->line('Thank you for registering! We look forward to seeing you.');
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
            'message' => "You have successfully registered for {$this->eventName} on {$this->eventDate} at {$this->eventLocation}."
        ];
    }
}
