<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RejectedController extends Controller
{
    public function index() {
        return Inertia::render('Rejected');
    }
}
