@extends('main.layouts.app')
@section('body')
<div class="flex container flex-col w-full mx-auto h-screen justify-center items-center text-center gap-4 px-3">
    <h1 class=" text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
        Join Exciting Events & Connect with Your Community!</h1>
    <p class="text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">Discover and participate in engaging events tailored just for you!</p>
    <div class="flex gap-2 justify-center">
        @auth
        <a href="{{route('user.events')}}"  class="group relative overflow-hidden bg-blue-600 focus:ring-4 focus:ring-blue-300 inline-flex items-center px-7 py-2.5 rounded-lg text-white justify-center">
            <span class="z-40">View all Events</span>
            <svg class="z-40 ml-2 -mr-1 w-3.5 h-3.5 transition-all duration-300 group-hover:translate-x-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
            <div class="absolute inset-0 h-[200%] w-[200%] rotate-45 translate-x-[-70%] transition-all group-hover:scale-100 bg-white/30 group-hover:translate-x-[50%] z-20 duration-1000">
            </div>
        </a>

        @else
        <a href="{{url('login')}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
            Login</a>
        <a href="{{url('register')}}" class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Get Started</a>


        @endauth


    </div>
</div>
@endsection
