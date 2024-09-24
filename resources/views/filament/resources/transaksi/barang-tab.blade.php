<!-- resources/views/filament/resources/transaksi/barang-tab.blade.php -->

<div>
    <h2>Barang List</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barangs as $barang)
                <tr>
                    <td>{{ $barang->nama_barang }}</td>
                    <td>{{ $barang->harga }}</td>
                    <td>{{ $barang->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
