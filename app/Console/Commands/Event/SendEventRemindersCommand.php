<?php

namespace App\Console\Commands\Event;

use App\Models\Event;
use App\Notifications\Event\SendReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendEventRemindersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'events:send-reminders';
    


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminders to participants on the event day';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $events = Event::whereDate('event_date_time', $today)->get();

        foreach ($events as $event) {
            $participants = $event->participants()->get();
            Notification::send($participants, new SendReminderNotification($event));
        }

        $this->info('Event reminders sent successfully.');
    }
}
