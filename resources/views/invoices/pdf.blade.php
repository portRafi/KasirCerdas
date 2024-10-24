
@php
use App\Models\BarangAfterCheckout;
use App\Models\DataTransaksi;
$datatransaksi = DataTransaksi::where('kode_transaksi', $invoice->kode_transaksi)->get();
$items = BarangAfterCheckout::where('kode_transaksi', $invoice->kode_transaksi)->get();
@endphp

<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->invoice_number }}</title>
</head>
<body>
<div class="viewd">
    @foreach ($items as $item)
        <div class="item">
            <h1>Invoice #{{ $invoice->invoice_number }}</h1>
            <p>Kode Transaksi: {{ $item->kode_transaksi }}</p>
            <p>Total Harga: ${{ number_format($item->total_harga) }}</p>
            <p>Metode Pembayaran: {{ ucfirst($datatransaksi->metode_pembayaran) }}</p> 
            <p>Email Staff: {{ ucfirst($datatransaksi->email_staff) }}</p>
        </div>
        @endforeach

</div>
</body>
</html>

<style>
    .item strong {
        font-weight: 600;
        color: #cecece;
        font-size: 15px;
    }
    .item p {
        color: rgb(156, 163, 175);
        font-weight: 400;
        font-size: 15px;
    }
    .viewd {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    .item {
        border: 1px solid #454545;
        padding: 15px;
        border-radius: 8px;
        width: 93%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>