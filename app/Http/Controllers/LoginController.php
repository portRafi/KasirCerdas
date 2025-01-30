<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole(6)) {
            return Inertia::location('/admin');
        } else if (auth()->user()->hasRole(1)) {
            return Inertia::location('/admin');
        } else if (auth()->user()->hasRole(7)) {
            return Inertia::location('/admin');
        } else {
            return Inertia::location('/pos');
        }
    }
}
