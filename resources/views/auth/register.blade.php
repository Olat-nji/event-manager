@extends('auth.layouts.app')
@section('redirect')
<div class="hidden sm:flex justify-between flex-col gap-6">
    <p class="text-center text-sm ">Already have an account? <a class="underline" href="{{url('login')}}">Login</a></p>

</div>
@endsection

@section('body')


<form class="bg-white dark:bg-gray-800 shadow rounded-xl p-8  w-full" method="POST" action="{{ route('register') }}">
    @csrf
    
        <h2 class="text-2xl text-center font-light mb-6">Sign Up</h2>


        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium">Full Name</label>
            <input type="text" name="name" value="{{old('name')}}" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your Full Name" required />
            @error('name')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium">Email</label>
            <input type="email" name="email" value="{{old('email')}}" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your Email" required />
            @error('email')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium">Password</label>
            <input type="password" name="password" value="{{old('password')}}" id="password" placeholder="Create a Password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
            @error('password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-7">
            <label for="password_confirmation" class="block mb-2 text-sm font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" id="password_confirmation" placeholder="Confirm Your Password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
            @error('password_confirmation')
            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>



        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Sign Up
        </button>
      <div class="mt-5  sm:hidden block">
            
            <p class="text-center text-sm ">Already have an account? <a class="underline" href="{{url('login')}}">Login</a></p>
        </div>


</form>


@endsection
