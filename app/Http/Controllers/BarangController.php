<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pajak;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BarangController extends Controller
{    
    public function index()
    {
        $barangs = Barang::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id]
        ])->get(); 
        // $metodepembayaran = MetodePembayaran::all();
        $metodepembayaran = MetodePembayaran::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id]
        ]);
        // $pajak = Pajak::all();
        $pajak = Pajak::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id]
        ]);

        return Inertia::render('Barang/Index', [
            'barangs' => $barangs,
            'metodepembayaran' => $metodepembayaran,
            'pajak' => $pajak,
        ]);
    }
}