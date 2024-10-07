@php
use App\Models\BarangAfterCheckout;
@endphp

<div>
    <p><strong>Kode Transaksi:</strong> {{ $record->kode_transaksi }}</p>
    <p><strong>Kode:</strong> {{ BarangAfterCheckout::where('id', $record->id)->value('kode') }}</p>
    <p><strong>Kategori:</strong> {{ BarangAfterCheckout::where('id', $record->id)->value('kategori') }}</p>
    <p><strong>nama:</strong> {{ BarangAfterCheckout::where('id', $record->id)->value('nama') }}</p>
    <p><strong>Quantity:</strong> {{ BarangAfterCheckout::where('id', $record->id)->value('quantity') }}</p>
    <p><strong>Total Harga:</strong> {{ BarangAfterCheckout::where('id', $record->id)->value('total_harga') }}</p>
</div>


