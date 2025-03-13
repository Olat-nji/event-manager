@extends('main.layouts.app')

@section('body')
<div class="w-full self-center flex flex-col mt-20 px-5 py-5">
    <div>
        <h4 class="font-bold leading-none tracking-tight text-xl md:text-3xl px-1 md:px-5 mb-9">Hello {{auth()->user()->name}},</h4>
    </div>
    <div class="px-3 sm:px-14">
        <div class="flex justify-between items-center mb-10 flex-wrap gap-4 ">
            <h4 class="font-extrabold leading-none tracking-tight text-lg md:text-2xl">All Events</h4>


            <div>
                <div class="inline-flex rounded-md shadow-xs  p-2">
                    <a href="#" aria-current="page" @click="changeCalendarView('month')" :class="$store.groupBy=='month'?'bg-gray-300 dark:bg-gray-700 ':''" class="px-4 py-2 rounded-xl text-sm font-medium   focus:z-10 focus:ring-2 focus:ring-blue-700  dark:focus:ring-blue-500">
                        Month
                    </a>
                    <a href="#" aria-current="page" @click="changeCalendarView('week')" :class="$store.groupBy=='week'?'bg-gray-300 dark:bg-gray-700 ':''" class="px-4 py-2 rounded-xl text-sm font-medium   focus:z-10 focus:ring-2 focus:ring-blue-700  dark:focus:ring-blue-500">
                        Week
                    </a>
                    <a href="#" aria-current="page" @click="changeCalendarView('day')" :class="$store.groupBy=='day'?'bg-gray-300 dark:bg-gray-700 ':''" class="px-4 py-2 rounded-xl text-sm font-medium   focus:z-10 focus:ring-2 focus:ring-blue-700  dark:focus:ring-blue-500">
                        Day
                    </a>
                </div>
            </div>

        </div>
        <div >
            <div class="mb-4 p-3  rounded-md ">

                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="w-4 h-4 bg-green-500 dark:bg-green-700 rounded-full"></span>
                        <span class="text-gray-800 dark:text-gray-300 text-sm">Available</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-4 h-4 bg-yellow-500 dark:bg-yellow-600 rounded-full"></span>
                        <span class="text-gray-800 dark:text-gray-300 text-sm">Waitlist Open</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-4 h-4 bg-gray-500 dark:bg-gray-600 rounded-full"></span>
                        <span class="text-gray-800 dark:text-gray-300 text-sm">Fully Booked</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-4 h-4 bg-green-300 rounded-full"></span>
                        <span class="text-gray-800 dark:text-gray-300 text-sm">Joined</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-4 h-4 bg-orange-300 rounded-full"></span>
                        <span class="text-gray-800 dark:text-gray-300 text-sm">Waitlisted</span>
                    </div>
                </div>
            </div>
            <div id="calendar" class="py-3 ">

            </div>
        </div>
    </div>
    <x-event-details></x-event-details>

</div>

@endsection




@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var baseUrl = "{{route('user.events')}}"

</script>


@vite(['resources/js/all-events.js'])
@endpush
