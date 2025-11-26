<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size:12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 6px; border: 1px solid #333; }
        h2 { text-align: left; margin-bottom: 6px; }

        /* Footer fixed */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: right;
            font-size: 11px;
            color: #555;
            padding: 6px 20px;
            border-top: 1px solid #CCC;
        }

        /* Jika ingin page number (dompdf) */
        @page { margin: 40px 30px 60px 30px; }
        .pagenum:before { content: counter(page); }
    </style>
</head>
<body>

<h2>Daftar Produk — Kategori: {{ $kategori->nama }}</h2>
<p>Total Produk: {{ $items->count() }}</p>

<table>
    <thead>
        <tr>
            <th style="width:4%;">No</th>
            <th style="width:46%;">Nama Item</th>
            <th style="width:15%;">Kode</th>
            <th style="width:15%;">Harga Beli</th>
            <th style="width:10%;">Laba (%)</th>
            <th style="width:10%;">Harga Jual</th>
        </tr>
    </thead>
    <tbody>
        @forelse($items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->kode ?? '-' }}</td>
                <td>{{ number_format($item->harga_beli ?? 0, 0, ',', '.') }}</td>
                <td>{{ $item->laba ?? 0 }}</td>
                <td>{{ number_format( ($item->harga_beli ?? 0) + (($item->harga_beli ?? 0) * ($item->laba ?? 0) / 100), 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center;">Tidak ada item</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div class="footer">
    Dicetak pada: {{ now()->format('d-m-Y H:i:s') }} &nbsp; | &nbsp; Halaman <span class="pagenum"></span>
</div>

</body>
</html>
