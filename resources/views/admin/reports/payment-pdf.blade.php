<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pendapatan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #333; color: white; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Pendapatan</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Booking</th>
                <th>Tipe</th>
                <th>Nominal</th>
                <th>Metode</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $payment->booking->booking_code }}</td>
                    <td>{{ $payment->type_label }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>{{ $payment->method_label }}</td>
                    <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total Pendapatan: Rp {{ number_format($payments->sum('amount'), 0, ',', '.') }}</strong></p>
</body>
</html>
