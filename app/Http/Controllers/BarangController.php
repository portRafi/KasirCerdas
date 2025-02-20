<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pajak;
use App\Models\BarangAfterCheckout;
use App\Models\DataPajak;
use App\Models\DataTransaksi;
use App\Models\DiskonTransaksi;
use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class BarangController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole(7)) { //ADMIN BISNIS
            $barangs = Barang::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['stok', '>=', 1]
            ])->get();
            $metodepembayaran = MetodePembayaran::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['is_Active', '=', true]
            ])->get();
            $pajak = Pajak::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
            ])->sum('jumlah_pajak');
            $diskontransaksi_minimalpembelian = DiskonTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['is_Active', '=', true]
            ])->sum('minimum_pembelian');
            $diskontransaksi_getjumlah = DiskonTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['is_Active', '=', true]
            ])->first();
            
            $diskon = $diskontransaksi_getjumlah->jumlah_diskon;
        } 


        else if (Auth::user()->hasRole(4)) { //KASIR
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
            $diskontransaksi_minimalpembelian = DiskonTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id],
                ['is_Active', '=', true]
            ])->sum('minimum_pembelian');
            $diskontransaksi_getjumlah = DiskonTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id],
                ['is_Active', '=', true]
            ])->first();
            
            $diskon = $diskontransaksi_getjumlah->jumlah_diskon;
        } 


        else if (Auth::user()->hasRole(6)) { //ADMIN CABANG
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
            $diskontransaksi_minimalpembelian = DiskonTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id],
                ['is_Active', '=', true]
            ])->sum('minimum_pembelian');
            $diskontransaksi_getjumlah = DiskonTransaksi::where([
                ['bisnis_id', '=', Auth::user()->bisnis_id],
                ['cabangs_id', '=', Auth::user()->cabangs_id],
                ['is_Active', '=', true]
            ])->first();
            
            $diskon = $diskontransaksi_getjumlah->jumlah_diskon;
        } 
        else if (Auth::user()->hasRole(1)) { //SUPERADMIN
            $barangs = Barang::all();
            $metodepembayaran = MetodePembayaran::all();
            $pajak = Pajak::all()->sum('jumlah_pajak');
            $diskontransaksi_minimalpembelian = DiskonTransaksi::all()->sum('minimum_pembelian');
            $diskontransaksi_getjumlah = DiskonTransaksi::all()->sum('jumlah_diskon');

            // dd($diskontransaksi_getjumlah);
        }

        $namaKasir = Auth::user()->name;

        $user = Auth::user();
        $namaBisnis = $user->bisnis ? $user->bisnis->nama_bisnis : null;
        $namaCabang = $user->cabang ? $user->cabang->nama_cabang : null;
        $alamatCabang = $user->cabang ? $user->cabang->alamat : null;

        return Inertia::render('Barang/Index', [
            'barangs' => $barangs,
            'metodepembayaran' => $metodepembayaran,
            'pajak' => $pajak,
            'namakasir' => $namaKasir,
            'diskontransaksi_getjumlah' => $diskon,
            'diskontransaksi_minimalpembelian' => $diskontransaksi_minimalpembelian,
            'namaBisnis' => $namaBisnis,
            'namaCabang' => $namaCabang,
            'alamatCabang' => $alamatCabang,
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

        $totalHargaBeli = 0;
        $totalHargaJual = 0;
        $totalHargaAfterDiskon = 0;
        $totalHargaAfterPajak = 0;
        $totalDiskonTransaksi = 0;
        $totalDiskon = 0;
        $totalHarga = 0;
        $totalPajak = 0;
        $keuntungan = 0;
        $totalDiskonTransaksi = $request->cart[0]['total_diskon_transaksi'] ?? 0;


        foreach ($request->cart as $item) {
            $totalHargaBeli += $item['total_harga_asli'];
            $totalHargaJual += $item['total_harga_without_pajak_diskon'];
            $totalHargaAfterDiskon += $item['total_harga_after_diskon'];
            $totalHargaAfterPajak += $item['total_harga_after_pajak'];
            $totalDiskon += $item['total_diskon'];
            $totalHarga += $item['total_harga'];
            $totalPajak += $item['total_pajak'];

            DataPajak::create([
                'bisnis_id' => auth()->user()->bisnis_id,
                'cabangs_id' => auth()->user()->cabangs_id,
                'kode_transaksi' => $item['kode_transaksi'],
                'jumlah_pajak' => $item['total_pajak']
            ]);
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
                'total_harga' => $item['total_harga'], //blm termasuk potongan diskon transaksi
                'total_diskon' => $item['total_diskon'],
                'total_pajak' => $item['total_pajak'],
                'note' => $item['note'] ?? '',
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);
        }
        $keuntungan = $totalHargaAfterDiskon - $totalHargaBeli;

        DataTransaksi::create([
            'bisnis_id' => Auth::user()->bisnis_id,
            'cabangs_id' => Auth::user()->cabangs_id,
            'kode_transaksi' => $request->cart[0]['kode_transaksi'], 
            'email_staff' => Auth::user()->email,
            'nama_kasir' => Auth::user()->name,
            'metode_pembayaran' => $request->metode_pembayaran,
            'total_harga_beli' => $totalHargaBeli,
            'total_harga_jual' => $totalHargaJual,
            'total_harga_after_diskon' => $totalHargaAfterDiskon,
            'total_harga_after_pajak' => $totalHargaAfterPajak,
            'total_diskon_transaksi' => $totalDiskonTransaksi,
            'total_diskon' => $totalDiskon,
            'total_harga' => $totalHarga - $totalDiskonTransaksi,
            'total_pajak' => $totalPajak,
            'keuntungan' => $keuntungan
        ]);
        return redirect()->back()->with('type', 'success')->with('message', 'berhasil checkout.');

        $barangs = Barang::where([
            ['bisnis_id', '=', Auth::user()->bisnis_id],
            ['cabangs_id', '=', Auth::user()->cabangs_id],
            ['stok', '>=', 1]
        ])->get();
        return Inertia::render('Barang/Index', [
            'barangs' => $barangs,
        ]);
    }
}
