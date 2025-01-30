<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            return Inertia::location('/admin');
        } else if (auth()->user()->hasRole('super_admin')) {
            return Inertia::location('/admin');
        } else {
            return Inertia::location('/pos');
        }
    }
}
