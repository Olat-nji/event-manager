<?php

namespace App\Nova\Dashboards;

use App\Models\Event;
use App\Nova\Event as NovaEvent;
use App\Nova\Metrics\Events;
use App\Nova\Metrics\RegisteredUsers;
use App\Nova\Metrics\Users;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(): array
    {
        return [
            new RegisteredUsers(),
            new Events(),
            
        ];
    }

    public function name(): string
    {
        return 'Dashboard';
    }
}
