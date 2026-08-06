<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Booking</title>
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
        @if($studioSettings['logo'])
            <img src="{{ storage_path('app/public/' . $studioSettings['logo']) }}" style="max-height:50px;margin-bottom:10px;" alt="Logo">
        @endif
        <h2>{{ $studioSettings['name'] }}</h2>
        <h3>Laporan Booking</h3>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        @if($studioSettings['address'])
            <p>{{ $studioSettings['address'] }}</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Booking</th>
                <th>Customer</th>
                <th>Paket</th>
                <th>Tanggal</th>
                <th>Studio</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ $booking->package->name }}</td>
                    <td>{{ $booking->booking_date->format('d/m/Y') }}</td>
                    <td>{{ $booking->studio?->name ?? '-' }}</td>
                    <td>{{ $booking->status_label }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total Booking: {{ $bookings->count() }}</strong></p>
</body>
</html>
