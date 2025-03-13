<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthenticatedSessionController extends Controller
{
    

    public function store(Request $request)
    {
        

        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return Redirect::intended('/admin');
        }

        return Redirect::intended('/user/events');
    }
}
