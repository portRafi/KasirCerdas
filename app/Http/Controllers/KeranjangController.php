<?php

namespace App\Http\Controllers;

use App\Models\BarangAfterCheckout;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KeranjangController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Inertia\Response
   */
  public function index(Request $request)
  {
    $barang_after_checkout = BarangAfterCheckout::latest()->get();

    return Inertia::render('Dashboard', [
      'barang_after_checkout' => $barang_after_checkout
    ]);
  }




  /**
   * Show the form for creating a new resource.
   *
   * @return \Inertia\Response
   */
  public function create()
  {
    return Inertia::render('Keranjangs/Create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'price' => 'required|numeric',
    ]);
    Keranjang::create($request->all());
    return redirect()->route('keranjangs.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Keranjang  $keranjang
   * @return \Inertia\Response
   */
  public function show(Keranjang $keranjang)
  {
    return Inertia::render('Keranjangs/Show', [
      'keranjang' => $keranjang
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Keranjang  $keranjang
   * @return \Inertia\Response
   */
  public function edit(Keranjang $keranjang)
  {
    return Inertia::render('Keranjangs/Edit', [
      'keranjang' => $keranjang
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Keranjang  $keranjang
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request, Keranjang $keranjang)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'price' => 'required|numeric',
    ]);

    $keranjang->update($request->all());
    return redirect()->route('keranjangs.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Keranjang  $keranjang
   * @return \Illuminate\Http\RedirectResponse
   */
  public function destroy(Keranjang $keranjang)
  {
    $keranjang->delete();
    return redirect()->route('keranjangs.index');
  }
}
