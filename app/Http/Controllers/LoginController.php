<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::user()->name === 'admin') {
            return Inertia::location('/admin'); 
        } else {
            return Inertia::location('/pos'); 
        }
    }
}
