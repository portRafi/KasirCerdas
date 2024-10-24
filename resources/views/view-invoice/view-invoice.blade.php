<div class="viewd">
        <div class="item">
        <h1>Invoice #{{ $invoice->invoice_number }}</h1>
            <p>Kode Transaksi: {{ $invoice->kode_transaksi }}</p>
            <p>Total Harga: ${{ number_format($invoice->total_harga) }}</p>
            <p>Metode Pembayaran: {{ ucfirst($invoice->metode_pembayaran) }}</p>
            <p>Email Staff: {{ ucfirst($invoice->email_staff) }}</p>
        </div>
</div>


