<?php

use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Kasir/Dashboard', [
            'user' => Auth::user(), 
        ]);
    }
}
