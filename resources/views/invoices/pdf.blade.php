
use App\Models\BarangAfterCheckout;
use App\Models\DataTransaksi;
<<<<<<< HEAD

<!-- $datatransaksi = DataTransaksi::where('kode_transaksi', $invoice->kode_transaksi)->get(); -->
$items = BarangAfterCheckout::where('kode_transaksi', $invoice->kode_transaksi)->get();

=======
$datatransaksi = DataTransaksi::where('kode_transaksi', $invoice->kode_transaksi)->get();
$items = BarangAfterCheckout::where('kode_transaksi', $invoice->kode_transaksi)->get();
@endphp
>>>>>>> d02e6f79fd933d899d0d65b0fd75a845822dc56d

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">  
    
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

</head>

<body>
    <div class="transaksi-container">
        <div class="transaksi-header">
            <h2>Transaksi</h2>  
        </div>
        <div class="transaksi-details">
        <div class="item">
            <h1>Invoice #{{ $invoice->invoice_number }}</h1>
            <p>Kode Transaksi: {{ $item->kode_transaksi }}</p>
            <p>Kode Barang: {{ $item->kode }}</p>
            <p>Quantity: {{ $item->quantity }}</p>
            <p>Nama Barang: {{ $item->nama }}</p>
            <p>Total Harga: ${{ number_format($item->total_harga) }}</p>
<<<<<<< HEAD
            
=======
            <p>Metode Pembayaran: {{ ucfirst($datatransaksi->metode_pembayaran) }}</p> 
            <p>Email Staff: {{ ucfirst($datatransaksi->email_staff) }}</p>
>>>>>>> d02e6f79fd933d899d0d65b0fd75a845822dc56d
        </div>
        </div>
    </div>
</body>
</html>