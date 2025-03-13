<?php

namespace App\Http\Controllers;

use App\Features\Event\EventService;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventsController extends Controller
{
    /**
     * The event service instance.
     *
     * @var EventService
     */
    protected EventService $eventService;

    /**
     * EventsController constructor.
     *
     * @param  EventService  $eventService  The service handling event-related operations.
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * Get a list of events within a specified date range.
     *
     * @param  Request  $request  The request instance containing query parameters.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        
        if ($request->expectsJson()) {
            $request->validate([
                'start' => ['required'],
                'end' => ['required'],
                'calendar' => ['sometimes', 'boolean'],
            ]);
            $events = $this->eventService->getEvents($request->query('start'), $request->query('end'));
            return EventResource::collection($events);
        }

        return view('main.events');
    }

    /**
     * Allow an authenticated user to join a specified event.
     *
     * @param  Event  $event  The event to join.
     * @return \Illuminate\Http\JsonResponse
     */
    public function joinEvent(Event $event)
    {
        $response = $this->eventService->addParticipant($event, auth()->user());
        return $response->toJson();
    }

    /**
     * Allow an authenticated user to leave a specified event.
     *
     * @param  Event  $event  The event to leave.
     * @return \Illuminate\Http\JsonResponse
     */
    public function leaveEvent(Event $event)
    {
        $response = $this->eventService->removeParticipant($event, [auth()->user()->id]);
        return $response->toJson();
    }
}
