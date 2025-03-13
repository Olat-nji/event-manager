<nav class="bg-white dark:bg-gray-800 fixed w-full z-10" x-data="{isMenuOpen:false}">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between w-full @if(!auth()->check()) sm:flex-row flex-row-reverse @endif">

            {{-- @auth --}}
            <div class="flex items-center sm:hidden">
                <!-- Mobile menu button-->
                <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden focus:ring-inset" aria-controls="mobile-menu" aria-expanded="false" x-on:click="isMenuOpen = !isMenuOpen">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            {{-- @endauth --}}

            <div class="flex items-center justify-center sm:items-stretch sm:justify-between sm:w-full">
                <div class="flex shrink-0 items-center">
                    <a href="{{url('/')}}">
                        
                        <picture>
                            <source srcset="https://raw.githubusercontent.com/olat-nji/event-manager/main/resources/images/logo-white.svg" media="(prefers-color-scheme: dark)">
                            <img  class="h-4 w-auto" src="https://raw.githubusercontent.com/olat-nji/event-manager/main/resources/images/logo-black.svg">
                        </picture>
                    </a>
                </div>
                @auth
                <div class="hidden sm:ml-6 sm:block">

                    <div class="flex space-x-4">




                    </div>

                </div>
                <div></div>
                @endauth

            </div>

            @auth


            <div class=" flex gap-2 ">

                <button type="button" class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
                    <span class="absolute -inset-1.5"></span>
                    <span class="sr-only">View notifications</span>
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                </button>

                <!-- Profile dropdown -->
                <div class="relative shrink-0" x-data="{isDropdownExpanded:false}">
                    <div>
                        <button type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden" id="user-menu-button" aria-expanded="false" aria-haspopup="true" x-on:click="isDropdownExpanded=!isDropdownExpanded">
                            <span class="sr-only">Open user menu</span>
                            <img class="size-8 rounded-full " src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                        </button>
                    </div>

                    <div class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" :class="isDropdownExpanded?'block':'hidden'">

                        @if(auth()->user()->hasRole('admin'))
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" aria-current="page">All Events</a>
                        <a href="{{url('admin')}}" class="block px-4 py-2 text-sm text-gray-700">Admin Dashboard</a>
                        @endif


                        <form method="POST" action="{{ url('logout') }}" class=" nav-item">
                            @csrf
                            <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" onclick="event.preventDefault();this.closest('form').submit();">Logout</a>
                        </form>
                    </div>
                </div>
            </div>

            @else
            <div class="hidden sm:flex gap-2 self-center">
                <a href="{{url('login')}}" class=" px-4 py-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Login
                </a>
                <a href="{{url('register')}}" class="px-4 py-2 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Register
                </a>
            </div>
            @endauth

        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu">

        <div class="space-y-1 px-2 pt-2 pb-3" :class="isMenuOpen?'block':'hidden'">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            @auth

            <a href="{{route('user.events')}}" class="block rounded-md @if(request()->routeIs('user.events')) bg-gray-900 @endif px-3 py-2 text-base font-medium hover:bg-gray-700" aria-current="page">All Events</a>
            @if(auth()->user()->hasRole('admin'))
            <a href="{{url('admin')}}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 ">Admin Dashboard</a>
            @endif
            @else
            <a href="{{url('login')}}" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white" aria-current="page">Login</a>
            <a href="{{url('register')}}" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Register</a>
            @endauth

        </div>
    </div>
</nav>
