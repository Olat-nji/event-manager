<?php

use Illuminate\Support\Facades\Schedule;

/**
 * Schedule the `events:send-reminders` command to run daily at 08:00 AM.
 *
 * This ensures that all event participants receive a reminder email
 * on the day of their event at the specified time.
 */
Schedule::command('events:send-reminders')->dailyAt('08:00');
