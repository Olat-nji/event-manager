@extends('main.layouts.app')

@section('body')
<div class="w-full self-center flex flex-col mt-20 px-5 py-5">
    
    
    <div class="px-1 md:px-5">
        <nav class="flex mb-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{route('home')}}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                        </svg>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">All Events</span>
                    </div>
                </li>
            </ol>
        </nav>

        <h4 class="font-bold leading-none tracking-tight text-xl md:text-3xl  mb-9">All Events</h4>
    </div>

    <div class="px-3 sm:px-14">
        <div class="flex justify-between items-center mb-10 flex-wrap gap-4 ">
            <h4 class="font-extrabold leading-none tracking-tight text-lg md:text-2xl">Hello {{auth()->user()->name}},</h4>


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
        <div>
            <div class="mb-4 p-3  rounded-md ">

                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="w-4 h-4 bg-green-300 dark:bg-green-700 rounded-full"></span>
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
                        <span class="w-4 h-4 bg-green-600 dark:bg-green-300 rounded-full"></span>
                        <span class="text-gray-800 dark:text-gray-300 text-sm">Joined</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-4 h-4 bg-orange-600 dark:bg-orange-300 rounded-full"></span>
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
