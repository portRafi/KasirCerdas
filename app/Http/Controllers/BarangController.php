<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pajak;
use App\Models\MetodePembayaran;
use Inertia\Inertia;

class BarangController extends Controller
{    
    public function index()
    {
        $barangs = Barang::all();
        $metodepembayaran = MetodePembayaran::all();
        $pajak = Pajak::all();

        return Inertia::render('Barang/Index', [
            'barangs' => $barangs,
            'metodepembayaran' => $metodepembayaran,
            'pajak' => $pajak,
        ]);
    }
}