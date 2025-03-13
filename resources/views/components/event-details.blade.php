<!-- Main modal -->
<div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class=" relative z-50 transition-all " x-show="$store.showEventModal" x-cloak>
    <div id="modal-backdrop" class="fixed inset-0 bg-gray-900/75 z-40 transition-opacity" ></div>
    <div class="fixed inset-0 z-50 w-screen overflow-y-auto ">
        <div class="flex min-h-full items-end justify-center p-4 text-left sm:items-center sm:p-0">
            <!-- Modal content -->
            <div class="relative transform overflow-hidden rounded-lg text-left  transition-all sm:my-8 sm:w-full sm:max-w-lg" @click.outside="$store.showEventModal=false">

                <div class="relative bg-white rounded-xl shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5  rounded-t ">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Event Details
                        </h3>
                        <button type="button" @click="$store.showEventModal=!$store.showEventModal" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="static-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4 flex flex-col gap-3 mb-3">
                        <p class="text-lg" x-text="$store.event.name">Tunji's Birthday Event !</p>

                        <div>
                            <p class="text-xs  mb-0">Description</p>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400" x-text="$store.event.description??'No description'">
                                With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
                            </p>
                        </div>
                        <div>
                            <p class="text-xs  mb-0">Date</p>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400" x-text="$store.event.date">
                            </p>

                        </div>
                        <div>
                            <p class="text-xs  mb-0">Duration</p>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400" x-text="$store.event.duration+' minutes'">
                            </p>

                        </div>
                        <div>
                            <p class="text-xs  mb-0">Location</p>
                            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400" x-text="$store.event.location">
                                Lekki Conservation Center
                            </p>
                        </div>


                        <div>
                            <div class="flex justify-between mb-1 ">
                                <p class="text-xs  mb-0">Event Capacity</p>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white"><span x-text="$store.event.capacity-$store.event.participants_count||'0'">s</span> of <span x-text="$store.event.capacity"></span> seats left</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-600">

                                <div class="bg-green-500 dark:bg-green-700  h-2.5 rounded-full" :style="`width: ${($store.event.participants_count / $store.event.capacity) * 100}%`">
                                </div>

                            </div>
                        </div>
                        <div x-show="$store.event.participants_count>=$store.event.capacity && $store.event.waitlist_count<=$store.event.waitlist_capacity">
                            <div class="flex justify-between mb-1  mt-4">
                                <p class="text-xs  mb-0">Waitlist Capacity</p>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white"><span x-text="$store.event.waitlist_capacity-$store.event.waitlist_count||'0'">s</span> of <span x-text="$store.event.waitlist_capacity"></span> spaces left</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-600">
                                <div class="bg-yellow-400 dark:bg-yellow-500 h-2.5 rounded-full" :style="`width: ${($store.event.waitlist_count / $store.event.waitlist_capacity) * 100}%`">
                                </div>

                            </div>
                        </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <div x-show="!($store.event.is_joined || $store.event.is_waitlisted)">

                            <button x-show="$store.event.participants_count<$store.event.capacity" type="button" class=" position-relative flex text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800" @click="JoinEvent($store.event.id)">
                                <span x-show="!$store.loading">Join Event</span>
                                <div x-show="$store.loading" class="py-1 px-6">
                                    <div class="loader "></div>
                                </div>
                            </button>

                            <button x-show="$store.event.participants_count>=$store.event.capacity && $store.event.waitlist_count<$store.event.waitlist_capacity" type="button" class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800" @click="JoinEvent($store.event.id)">
                                <span x-show="!$store.loading">Join Waitlist</span>
                                <div class="py-1 px-6" x-show="$store.loading">
                                    <div class="loader"></div>
                                </div>
                            </button>
                        </div>
                        <div x-show="$store.event.is_joined || $store.event.is_waitlisted">
                            <button type="button" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" @click="LeaveEvent($store.event.id)">
                                <span x-show="!$store.loading">Leave Event</span>
                                <div class="py-1 px-6" x-show="$store.loading">
                                    <div class="loader"></div>
                                </div>
                            </button>
                        </div>
                        <button @click="$store.showEventModal=!$store.showEventModal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium  focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800  dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
