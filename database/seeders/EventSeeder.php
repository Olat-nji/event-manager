<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

      
        if (Event::count() < 30) {
            Event::factory(20)->create();
            EventParticipant::factory(20)->withSingleWaitlistCapacity()->create();
            EventParticipant::factory(20)->withFullyBookedEvent()->create();
            Cache::forget('events_cache_version');
        }
    }
}
