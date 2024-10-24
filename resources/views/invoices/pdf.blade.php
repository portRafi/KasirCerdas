

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