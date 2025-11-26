<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #333; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>

<h2>Detail Master Item</h2>

<table>
    <tr>
        <th>Kode</th>
        <td>{{ $data->kode }}</td>
    </tr>
    <tr>
        <th>Nama</th>
        <td>{{ $data->nama }}</td>
    </tr>
    <tr>
        <th>Harga Beli</th>
        <td>{{ $data->harga_beli }}</td>
    </tr>
    <tr>
        <th>Laba (%)</th>
        <td>{{ $data->laba }}</td>
    </tr>
    <tr>
        <th>Harga Jual</th>
        <td>{{ $data->harga_beli + ($data->harga_beli * $data->laba / 100) }}</td>
    </tr>
    <tr>
        <th>Supplier</th>
        <td>{{ $data->supplier }}</td>
    </tr>
    <tr>
        <th>Jenis</th>
        <td>{{ $data->jenis }}</td>
    </tr>
</table>


<h3 style="margin-top:25px;">Kategori Item</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Kategori</th>
        </tr>
    </thead>
    <tbody>

        @forelse ($data->kategoriItems as $i => $kat)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $kat->nama }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="2" style="text-align:center;">Tidak ada kategori</td>
        </tr>
        @endforelse

    </tbody>
</table>

</body>
</html>
