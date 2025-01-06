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
            ['cabangs_id', '=', Auth::user()->cabangs_id],
            ['stok', '>=', 1]
        ])->get(); 
        $metodepembayaran = MetodePembayaran::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
            ['is_Active', '=', true]
        ])->get();
        $pajak = Pajak::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
        ])->sum('jumlah_pajak');
        $namaKasir = Auth::user()->name;

        return Inertia::render('Barang/Index', [
            'barangs' => $barangs,
            'metodepembayaran' => $metodepembayaran,
            'pajak' => $pajak,
            'namakasir' => $namaKasir,
        ]);
    }
}