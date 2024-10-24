<!-- 

<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->invoice_number }}</title>
</head>
<body>
<div class="viewd">
        <div class="item">
            <h1>Invoice #{{ $invoice->invoice_number }}</h1>
            <p>Kode Transaksi: {{ $invoice->kode_transaksi }}</p>
            <p>Total Harga: ${{ number_format($invoice->total_harga) }}</p>
            <p>Metode Pembayaran: {{ ucfirst($invoice->metode_pembayaran) }}</p>
            <p>Email Staff: {{ ucfirst($invoice->email_staff) }}</p>
        </div>

</div>
</body>
</html> -->

<!-- <style>
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
</style> -->
@php
use App\Models\BarangAfterCheckout;

$items = BarangAfterCheckout::where('kode_transaksi', $record->kode_transaksi)->get();
@endphp

<div class="transaksi-container">
        <div class="transaksi-header">
            <h2>Transaksi</h2>  
        </div>
        @foreach ($items as $item)
        <div class="transaksi-details">
        <p>Kode Transaksi: {{ $invoice->kode_transaksi }}</p>
            <p>Total Harga: ${{ number_format($invoice->total_harga) }}</p>
            <p>Metode Pembayaran: {{ ucfirst($invoice->metode_pembayaran) }}</p>
            <p>Email Staff: {{ ucfirst($invoice->email_staff) }}</p>

            <p>Kode Barang: {{ $item->kode }}</p>
            <p>Kategori:   {{ $item->kategori }}</p>
            <p>Nama:  {{ $item->nama }}</p>
            <p>Quantity:  {{ $item->quantity }}</p>
            <p>Total Harga:  {{ $item->total_harga }}</p>
            <table style="width: 100%; margin-bottom: 30px">
                <!-- <thead>
                    <tr>
                        <th>Kode Transaksi.</th>
                        <th>Total Harga</th>
                        <th>Metode Pembayaran</th>
                        <th>Email Staff</th>
                    </tr>
                </thead> -->
            </table>
        </div>
    </div>
    @endforeach
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .transaksi-container {
            max-width: 100%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .transaksi-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .transaksi-details label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .transaksi-details span {
            display: block;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px; /* Adjust padding for better spacing */
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-row {
            font-weight: bold;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .transaksi-container {
                box-shadow: none;
                border: none;
            }

            .transaksi-details label {
                display: inline-block;
                width: 120px;
            }
        }
    </style>