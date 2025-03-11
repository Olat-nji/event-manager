@extends('auth.layouts.app')
@section('redirect')
<div class="hidden sm:flex justify-between flex-col gap-6">
    <p class="text-center text-sm ">Remembered your password? <a class="underline" href="{{url('login')}}">Sign In</a></p>
</div>
@endsection
@section('body')


<form class="bg-white dark:bg-gray-800 shadow rounded-xl p-8  w-full" method="POST" action="{{ route('password.email') }}">
    @csrf
    <h2 class="text-2xl text-center font-light mb-6">Forgot Password</h2>

    <div class="mb-5">
        <label for="email" class="block mb-2 text-sm font-medium ">Email</label>
        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your Email Address" required />
        @error('email')
        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
        @enderror
    </div>


    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full  px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Send Password Reset Link</button>


    @if (session('status'))
    <div class="p-4  text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        {{ session('status') }}
    </div>
    @endif
    <div class="mt-5 block sm:hidden">
        <p class="text-center text-sm ">Remembered your password? <a class="underline" href="{{url('login')}}">Sign In</a></p>
    </div>
</form>

@endsection
