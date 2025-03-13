<?php

use App\Http\Controllers\EventsController;
use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;

/**
 * --------------------------------------------------------------------------
 * Web Routes
 * --------------------------------------------------------------------------
 * This file is responsible for defining all the routes for the application.
 * Routes handle incoming HTTP requests and map them to the appropriate 
 * controllers and methods.
 * 
 * Middleware is used to enforce authentication where necessary, and 
 * route groups help with organizing related routes efficiently.
 */

// Landing page route
Route::get('/', [IndexController::class, 'index'])->name('home');

/**
 * --------------------------------------------------------------------------
 * Authentication Routes (Fortify)
 * --------------------------------------------------------------------------
 * Laravel Fortify provides authentication features like login, registration, 
 * password reset, and email verification. Below, we define custom views 
 * for these authentication actions.
 */

// Custom login page view
Fortify::loginView(function ($request) {
    return view('auth.login');
});

// Custom registration page view
Fortify::registerView(function () {
    return view('auth.register');
});

// Custom password reset request page view
Fortify::requestPasswordResetLinkView(function () {
    return view('auth.forgot-password');
});

// Custom password reset form view
Fortify::resetPasswordView(function ($request) {
    return view('auth.reset-password', ['request' => $request]);
});

/**
 * --------------------------------------------------------------------------
 * User Routes (Requires Authentication)
 * --------------------------------------------------------------------------
 * These routes are grouped under the "user" prefix and require authentication.
 * The `auth` middleware ensures that only logged-in users can access them.
 */

Route::name('user.') // Sets route names to start with "user."
    ->prefix('user') // All routes in this group start with "/user"
    ->middleware(['auth']) // Only accessible by authenticated users
    ->group(function () {

        /**
         * ------------------------------------------------------------------
         * Event Management Routes
         * ------------------------------------------------------------------
         * These routes handle event-related actions like listing events,
         * joining an event, and leaving an event.
         */

        Route::name('events') // Sets event route names to start with "user.events"
            ->prefix('events') // All event-related routes start with "/user/events"
            ->group(function () {

                // Display a list of all events
                Route::get('/', [EventsController::class, 'index']);

                // Join an event (authorization middleware ensures user has permission)
                Route::post('{event}/join', [EventsController::class, 'joinEvent'])
                    ->middleware('can:join,event') // Ensures user can join the event
                    ->name('.join');

                // Leave an event
                Route::post('{event}/leave', [EventsController::class, 'leaveEvent'])
                    ->name('.leave');
            });
    });
