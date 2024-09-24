<!-- resources/views/filament/resources/transaksi/keranjang-tab.blade.php -->

<div>
    <h2>Keranjang List</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keranjangs as $keranjang)
                <tr>
                    <td>{{ $keranjang->barang->nama_barang }}</td> <!-- Adjust this if necessary -->
                    <td>{{ $keranjang->harga }}</td>
                    <td>{{ $keranjang->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
