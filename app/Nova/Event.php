<?php

namespace App\Nova;

use App\Nova\Actions\Event\PublishEvent;
use App\Nova\Actions\Event\UnpublishEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Nova\Fields\Badge;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Event extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Event>
     */
    public static $model = \App\Models\Event::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),

            DateTime::make('Event Date & Time', 'event_date_time')
                ->sortable()
                ->rules('required'),

            Number::make('Duration')
                ->sortable()
                ->placeholder('Duration (in minutes)')
                ->rules('required', 'min:1'),

            Text::make('Location')
                ->sortable()
                ->rules('required', 'max:255')->hideFromIndex(),

            Number::make('Capacity')
                ->sortable()
                ->rules('required', 'min:0')->hideFromIndex(),

            Number::make('Waitlist Capacity')
                ->sortable()
                ->rules('required', 'min:0')->hideFromIndex(),
            Badge::make('Status')->map([
                'draft' => 'danger',
                'live' => 'success',
            ]),
        ];
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [
            (new PublishEvent)
                ->canSee(function ($request) {
                    return $this->status !== 'live';
                }),

            (new UnpublishEvent)
                ->canSee(function ($request) {
                    return $this->status === 'live';
                }),
        ];
    }
}
