<?php

namespace App\Http\Controllers;

use App\Models\BarangDummy;
use App\Models\PajakDummy;
use App\Models\MetodePembayaranDummy;
use Inertia\Inertia;

class DummyController extends Controller
{
    public function index()
    {
        $barangs = BarangDummy::where('stok', '>=', 1)->get(); 
        $metodepembayaran = MetodePembayaranDummy::all(); 
        $pajak = PajakDummy::all()->sum('jumlah_pajak'); 

        return Inertia::render('Demo', [
            'barangs' => $barangs,
            'metodepembayaran' => $metodepembayaran,
            'pajak' => $pajak,
        ]);
    }
}
