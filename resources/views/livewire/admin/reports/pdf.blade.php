<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        h1 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .meta {
            margin-bottom: 15px;
        }
        .meta div {
            margin-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #444;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
        .right {
            text-align: right;
        }
        .summary {
            margin-top: 15px;
            width: 100%;
        }
        .summary td {
            border: none;
            padding: 4px 0;
        }
    </style>
</head>
<body>

<h1>Laporan Penjualan</h1>

<div class="meta">
    <div>Periode: {{ $startDate }} sampai {{ $endDate }}</div>
    <div>Total Pendapatan: Rp {{ number_format((float)$totalRevenue, 0, ',', '.') }}</div>
    <div>Total Pesanan: {{ (int)$totalOrders }}</div>
    <div>Rata-rata Pesanan: Rp {{ number_format((float)$avgOrderValue, 0, ',', '.') }}</div>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th class="right">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $o)
            <tr>
                <td>{{ $o->id }}</td>
                <td>{{ $o->user->name ?? '-' }}</td>
                <td>{{ ucfirst((string)$o->status) }}</td>
                <td>{{ $o->created_at->format('Y-m-d H:i') }}</td>
                <td class="right">Rp {{ number_format((float)$o->total, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
