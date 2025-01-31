@php
use App\Models\DataTransaksi;
use App\Models\BarangAfterCheckout;

$datatransaksi = DataTransaksi::where('kode_transaksi', $invoice->kode_transaksi)->first();
$items = BarangAfterCheckout::where('kode_transaksi', $invoice->kode_transaksi)->get();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<style>
    * {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
</style>

<body>
    <div style="text-align: left;border-top:1px solid #000;">
        <div style="font-size: 24px;color: #666;">INVOICE</div>
    </div>
    <table style="line-height: 1.5;">
        <tr>
            <td><b>Kode Transaksi:</b> {{ $datatransaksi->kode_transaksi}}</td>
        </tr>
        <tr>
            <td><b>Date:</b> {{ $datatransaksi->created_at }}</td>
        </tr>
        <tr>
            <td><b>Kasir:</b> {{ $datatransaksi->nama_kasir }}</td>
        </tr>
    </table>

    <div style="border-bottom: 2px solid #ccc; padding: 20px; display:flex; justify-content:center; align-items:center">
        <div style="text-align: center;">
            <table style="width: 100%; margin: 0 auto; border-collapse: collapse; line-height: 1.4; font-family: Arial, sans-serif;">
                <tr style="font-weight: bold; background-color: #f7f7f7; border: 1px solid #ccc;">
                    <td style="padding: 10px; border: 1px solid #ccc; width: 40px;">Kode Item</td>
                    <td style="padding: 10px; border: 1px solid #ccc; width: 220px;">Nama Item</td>
                    <td style="padding: 10px; text-align:right; border: 1px solid #ccc; width: 90px;">Harga (Rp)</td>
                    <td style="padding: 10px; text-align:right; border: 1px solid #ccc; width: 75px;">Quantity</td>
                    <td style="padding: 10px; text-align:right; border: 1px solid #ccc; width: 90px;">Subtotal (Rp)</td>
                </tr>

                @foreach ($items as $item)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ccc;">{{ $item->kode }}</td>
                    <td style="padding: 10px; border: 1px solid #ccc;">{{ $item->nama }}</td>
                    <td style="padding: 10px; text-align:right; border: 1px solid #ccc;">{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                    <td style="padding: 10px; text-align:right; border: 1px solid #ccc;">{{ $item->quantity }}</td>
                    <td style="padding: 10px; text-align:right; border: 1px solid #ccc;">{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </table>
            <div class="data-pembayaran" style="display: flex; justify-content: flex-end; width: 100%; margin-top:3%">
                <div class="box" style="width: 35%; margin-left:auto">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="text-align: left; padding-right: 20px;">Pajak (Rp)</td>
                            <td style="text-align: right;">{{ number_format($datatransaksi->total_pajak ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; padding-right: 20px;">Diskon (Rp)</td>
                            <td style="text-align: right;">{{ number_format($datatransaksi->total_diskon ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; padding-right: 20px;">Dis. Transaksi (Rp)</td>
                            <td style="text-align: right;">{{ number_format($datatransaksi->total_diskon_transaksi ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: left; padding-right: 20px;">Total (Rp)</td>
                            <td style="text-align: right;">{{ number_format($datatransaksi->total_harga ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <p>Metode Pembayaran: <u><b>{{ $datatransaksi->metode_pembayaran }}</b></u></p>
    <p><i>Note: Jika ada kesalahan, segera hubungi Admin</i></p>
</body>

</html>