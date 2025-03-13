<?php

namespace App\Features\Event;

use App\DTO\ApiResponse;
use App\Enums\EventResponseEnum;
use App\Enums\EventStatus;
use App\Events\Event\ParticipantRegisteredEvent;
use App\Events\Event\ParticipantsPromotedFromWaitlistEvent;
use App\Events\Event\ParticipantsUnregisteredEvent;
use App\Events\Event\ParticipantWaitlistedEvent;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Class EventService
 *
 * Service responsible for managing event-related operations, including participant registration, 
 * waitlist handling, and automated promotions when event slots become available.
 *
 * This class enforces event capacity constraints, prevents overbooking, and streamlines the 
 * promotion process for waitlisted participants.
 */

class EventService
{
    /** @var Event|null Cached event instance to minimize redundant queries. */
    protected ?Event $event = null;

    /**
     * Retrieves all events occurring within the specified date range.
     *
     * @param string $start Start date.
     * @param string $end End date.
     * @return Collection<Event> Collection of events within the specified range.
     */
    public function getEvents(string $start, string $end): Collection
    {
        $versionKey = "events_cache_version";
        $cacheVersion = Cache::rememberForever($versionKey, function () {
            return now()->timestamp;
        });

        $cacheKey = "events_{$start}_{$end}_v{$cacheVersion}";

        if (config('app.cache_enabled', false)) {

            $events = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($start, $end) {
                return Event::withCount('participants', 'waitlist')
                    ->withExists(['participants as is_joined' => fn($q) => $q->where('user_id', auth()->id())])
                    ->withExists(['waitlist as is_waitlisted' => fn($q) => $q->where('user_id', auth()->id())])
                    ->where('status', EventStatus::LIVE)
                    ->whereBetween('event_date_time', [$start, $end])
                    ->get();
            });

            ///A few more measures could be taken to further optimize the below but due to time constraints I'd have to skip

            return $events->loadExists([
                'participants as is_joined' => fn($q) => $q->where('user_id', auth()->id()),
                'waitlist as is_waitlisted' => fn($q) => $q->where('user_id', auth()->id()),
            ]);
        }


        return Event::withCount('participants', 'waitlist')
            ->withExists(['participants as is_joined' => fn($q) => $q->where('user_id', auth()->id())])
            ->withExists(['waitlist as is_waitlisted' => fn($q) => $q->where('user_id', auth()->id())])
            ->where('status', EventStatus::LIVE)
            ->whereBetween('event_date_time', [$start, $end])
            ->get();
    }

    /**
     * Registers a user for an event. If the event is full, the user is added to the waitlist.
     *
     * @param Event $event The event instance.
     * @param User $user The user instance.
     * @return ApiResponse Response indicating registration or waitlist status.
     */
    public function addParticipant(Event $event, User $user): ApiResponse
    {
        $event->loadCount(['participants', 'waitlist']);

        if ($event->participants_count >= $event->capacity) {
            return $this->addToWaitlist($event, $user);
        }

        EventParticipant::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'is_waitlisted' => false,
        ]);

        event(new ParticipantRegisteredEvent($user, $event));

        self::invalidateCache();

        return ApiResponse::success($event, EventResponseEnum::SUCCESS_REGISTERED->value);
    }

    /**
     * Adds a user to the event waitlist if the event is at full capacity.
     *
     * @param Event $event The event instance.
     * @param User $user The user instance.
     * @return ApiResponse Response indicating waitlist status.
     */
    private function addToWaitlist(Event $event, User $user): ApiResponse
    {
        if ($event->waitlist_count >= $event->waitlist_capacity) {
            return ApiResponse::error(EventResponseEnum::ERROR_WAITLIST_FULL->value, 400);
        }

        $waitlistedUser = EventParticipant::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'is_waitlisted' => true,
        ]);

        event(new ParticipantWaitlistedEvent($user, $event));
        self::invalidateCache();
        return ApiResponse::success($event, EventResponseEnum::SUCCESS_WAITLISTED->value);
    }

    /**
     * Removes specified participants from an event and promotes users from the waitlist if slots become available.
     *
     * @param Event $event The event instance.
     * @param array $userIds List of user IDs to remove.
     * @return ApiResponse Response indicating removal and promotion status.
     */
    public function removeParticipant(Event $event, array $userIds): ApiResponse
    {
        $deletedCount = $event->all_participants()
            ->whereIn('user_id', $userIds)
            ->delete();



        if ($deletedCount === 0) {
            return ApiResponse::error(EventResponseEnum::ERROR_NOT_REGISTERED->value, 404);
        }

        event(new ParticipantsUnregisteredEvent($userIds, $event));

        $this->promoteFromWaitlist($event);
        self::invalidateCache();
        return ApiResponse::success($event, EventResponseEnum::SUCCESS_UNREGISTERED->value);
    }

    /**
     * Promotes waitlisted users to active participants when event slots open up.
     *
     * @param Event $event The event instance.
     * @return ApiResponse Response indicating promotion status.
     */
    private function promoteFromWaitlist(Event $event)
    {
        $event->loadCount(['participants', 'waitlist']);
        $availableSlots = $event->capacity - $event->participants_count;

        if ($availableSlots <= 0) {
            return;
        }

        if ($event->waitlist_count === 0) {
            return;
        }

        $waitlistedUsers = $event->waitlist()
            ->where('is_waitlisted', true)
            ->orderBy('created_at')
            ->limit($availableSlots)
            ->get(['id', 'user_id']);

        EventParticipant::whereIn('id', $waitlistedUsers->pluck('id'))
            ->update(['is_waitlisted' => false]);

        event(new ParticipantsPromotedFromWaitlistEvent($waitlistedUsers->pluck('user_id')->toArray(), $event));
    }

    public static function invalidateCache()
    {
        Cache::forget('events_cache_version');
        Cache::forever('events_cache_version', now()->timestamp);
    }

  
}
