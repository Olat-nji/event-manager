<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class EventResource
 *
 * Transforms event data for API responses.
 */
class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->boolean('calendar')) {
            return $this->formatForCalendar();
        }

        return parent::toArray($request);
    }

    /**
     * Format event data for calendar view.
     *
     * @return array<string, mixed>
     */
    private function formatForCalendar(): array
    {


        return [
            'id' => $this->id,
            'title' => $this->name,
            'start' => $this->event_date_time,
            'end' => $this->event_date_time->clone()->addMinutes($this->duration),
            'data' => [
                'description' => $this->description,
                'date' => $this->event_date_time->format('F d, Y H:i'),
                'duration' => $this->duration,
                'location' => $this->location,
                'capacity' => $this->capacity,
                'waitlist_capacity' => $this->waitlist_capacity,
                'participants_count' => $this->participants_count,
                'waitlist_count' => $this->waitlist_count,
                'is_joined' => $this->is_joined,
                'is_waitlisted' => $this->is_waitlisted,
            ]
        ];
    }
}
