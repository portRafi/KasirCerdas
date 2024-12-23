<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //get all posts from database
        $barangs = barang::latest()->get();

        //render with data "posts"
        return Inertia::render('Dashboard', [
            'barangs' => $barangs
        ]);
    }
}
