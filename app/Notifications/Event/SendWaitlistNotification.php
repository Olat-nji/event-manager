<?php

namespace App\Notifications\Event;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendWaitlistNotification extends Notification implements ShouldQueue
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
            ->subject("You're on the Waitlist for {$this->eventName}")
            ->greeting("Hello, {$notifiable->name}!")
            ->line("Thank you for your interest in **{$this->eventName}**.")
            ->line("📅 Date: {$this->eventDate}")
            ->line("⏳ Duration: {$this->eventDuration} Minutes") // Fixed the duplicate date issue
            ->line("📍 Location: {$this->eventLocation}")
            ->line("Currently, the event is fully booked, but you're on the waitlist. If a spot opens up, you'll be notified immediately.")
            ->line("In the meantime, keep an eye on your inbox for updates.")
            ->action('View Events', route('user.events'))
            ->line("We appreciate your patience and hope to see you there!");
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
            'message' => "You're on the waitlist for {$this->eventName} on {$this->eventDate} at {$this->eventLocation}. We'll notify you if a spot opens up."
        ];
    }
}
