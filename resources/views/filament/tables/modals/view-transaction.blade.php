@php
use App\Models\BarangAfterCheckout;

$items = BarangAfterCheckout::where('kode_transaksi', $record->kode_transaksi)->get();
@endphp

<div class="viewd">
    @foreach ($items as $item)
        <div class="item">
            <p><strong>Kode Barang:  </strong> {{ $item->kode }}</p>
            <p><strong>Kategori:  </strong> {{ $item->kategori }}</p>
            <p><strong>Nama:  </strong> {{ $item->nama }}</p>
            <p><strong>Quantity:  </strong> {{ $item->quantity }}</p>
            <p><strong>Total Harga:  </strong> {{ $item->total_harga }}</p>
        </div>
    @endforeach
</div>

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
