@extends('auth.layouts.app')
@section('redirect')
<div class="hidden sm:flex justify-between flex-col gap-6">
    <p class="text-center text-sm ">Don't have an account? <a class="underline" href="{{url('register')}}">Sign Up</a></p>

</div>
@endsection
@section('body')


    <form class="bg-white dark:bg-gray-800 shadow rounded-xl p-8  w-full" method="POST" action="{{ route('login') }}">
        @csrf
        <h2 class="text-2xl text-center font-light mb-6">Sign In</h2>

        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium ">Email</label>
            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="email@gmail.com" required />
            @error('email')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium ">Password</label>
            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
            @error('password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="justify-between flex flex-wrap gap-1 mb-5">
            <div class="flex items-start ">
                <div class="flex items-center h-5">
                    <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                </div>
                <label for="remember" class="ms-2 text-sm font-light">Remember me</label>
            </div>
            <div class="col text-end hidden sm:inline"><a class=" text-sm font-light" href="{{ route('password.request') }}">Forgot Password?</a></div>
        </div>

        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full  px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Login</button>

        <div class="mt-5 flex justify-between sm:hidden">
            <div class="col text-start "><a class=" text-sm font-light" href="{{ route('password.request') }}">Forgot Password?</a></div>
            <div class="col text-start "><a class=" text-sm font-light" href="{{ route('register') }}">Or Sign Up?</a></div>
        </div>
    </form>

@endsection
