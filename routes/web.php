<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;

Route::get('/', function () {
    return view('main.index');
});

Fortify::loginView(function ($request) {

    return view('auth.login');
});

Fortify::registerView(function () {
    return view('auth.register');
});
