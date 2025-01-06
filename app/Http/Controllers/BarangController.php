<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pajak;
use App\Models\BarangAfterCheckout;
use Illuminate\Http\Request;
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
    public function store(Request $request)
{
    $request->validate([
        'cart' => 'required|array',
        'cart.*.kode' => 'required|string',
        'cart.*.nama' => 'required|string',
        'cart.*.quantity' => 'required|integer|min:1',
        'cart.*.harga_jual' => 'required|numeric',
        'cart.*.total_harga' => 'required|numeric',
        'cart.*.total_diskon' => 'required|numeric',
        'cart.*.total_pajak' => 'required|numeric',
    ]);

    if (!$request->has('metode_pembayaran') || empty($request->metode_pembayaran)) {
        return response()->json([
            'success' => false,
            'message' => 'Metode pembayaran harus dipilih sebelum checkout.'
        ], 400); 
    }

    foreach ($request->cart as $item) {
        BarangAfterCheckout::create([
            'bisnis_id' => auth()->user()->bisnis_id,
            'cabangs_id' => auth()->user()->cabangs_id,
            'kode_transaksi' => $item['kode_transaksi'],
            'kode' => $item['kode'],
            'kategori' => $item['kategori'],
            'nama' => $item['nama'],
            'quantity' => $item['quantity'],
            'harga_jual' => $item['harga_jual'],
            'harga_beli' => $item['harga_beli'],
            'total_harga' => $item['total_harga'],
            'total_diskon' => $item['total_diskon'],
            'total_pajak' => $item['total_pajak'],
            'note' => $item['note'] ?? '',
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);
    }

    return response()->json([
        'success' => true,
        'message' => 'Checkout berhasil!'
    ]);
}

}
