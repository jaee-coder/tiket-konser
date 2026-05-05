<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Tiket</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .header { text-align: center; margin-bottom: 20px; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Penjualan Tiket</h2>
        <p>Tanggal Cetak: {{ $tanggalCetak }}</p>
        @if(request('start_date') || request('end_date'))
        <p>Periode: {{ request('start_date', 'awal') }} s/d {{ request('end_date', 'akhir') }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode Tiket</th>
                <th>Konser</th>
                <th>Customer</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $tiket)
            <tr>
                <td>{{ $tiket->kode_tiket }}</td>
                <td>{{ $tiket->konser->nama_concert ?? '-' }}</td>
                <td>{{ $tiket->customer->name ?? '-' }}</td>
                <td>Rp {{ number_format($tiket->harga_jual, 0, ',', '.') }}</td>
                <td>{{ ucfirst($tiket->status) }}</td>
                <td>{{ $tiket->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <strong>Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</strong>
    </div>
</body>
</html>