<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kategori</title>
    <style>
        body { font-family: sans-serif; }
        
        /* Header styling */
        .header { text-align: center; margin-bottom: 20px; }
        .header h2, .header p { margin: 0; }
        
        /* Table styling */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; font-size: 12px; }
        th { background-color: #f2f2f2; }

        /* Footer styling untuk tanggal cetak di bawah */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            text-align: right;
            font-size: 10px;
            color: #555;
            border-top: 1px solid #ccc;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    {{-- HEADER: Nama & Kode Kategori --}}
    <div class="header">
        <h2>Laporan Detail Kategori</h2>
        <p><strong>Nama Kategori:</strong> {{ $category->nama }}</p>
        <p><strong>Kode Kategori:</strong> {{ $category->kode }}</p>
    </div>

    <hr>

    {{-- ISI: Tabel List Item --}}
    <h4>Daftar Item dalam Kategori Ini:</h4>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Kode Item</th>
                <th>Nama Item</th>
                <th>Jenis</th>
                <th>Harga Beli</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            @forelse($category->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->jenis }}</td>
                <td>Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                <td>{{ $item->supplier }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada item terhubung.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER: Waktu Cetak --}}
    <div class="footer">
        Dicetak pada: {{ $tanggal_cetak }}
    </div>

</body>
</html>