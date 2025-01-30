<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Models\User;

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
