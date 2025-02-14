<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class RejectedController extends Controller
{
    public function index() {
        return Inertia::render('Rejected');
    }
}
