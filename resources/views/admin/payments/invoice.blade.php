<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $booking->invoice_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin-bottom: 5px; font-size: 24px; }
        .info-row { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .info-block { width: 48%; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
        .total { text-align: right; font-size: 16px; font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        @if($studioSettings['logo'])
            <img src="{{ storage_path('app/public/' . $studioSettings['logo']) }}" style="max-height:60px;margin-bottom:10px;" alt="Logo">
        @endif
        <h1>{{ strtoupper($studioSettings['name']) }}</h1>
        @if($studioSettings['address'])
            <p>{{ $studioSettings['address'] }}</p>
        @endif
        @if($studioSettings['phone'] || $studioSettings['email'])
            <p>
                @if($studioSettings['phone'])Telp: {{ $studioSettings['phone'] }}@endif
                @if($studioSettings['phone'] && $studioSettings['email']) | @endif
                @if($studioSettings['email'])Email: {{ $studioSettings['email'] }}@endif
            </p>
        @endif
    </div>

    <div class="info-row">
        <div class="info-block">
            <h3>Invoice</h3>
            <p><strong>No:</strong> {{ $booking->invoice_number }}</p>
            <p><strong>Tanggal:</strong> {{ now()->format('d/m/Y') }}</p>
        </div>
        <div class="info-block">
            <h3>Customer</h3>
            <p><strong>Nama:</strong> {{ $booking->customer_name }}</p>
            <p><strong>HP:</strong> {{ $booking->customer_phone }}</p>
            <p><strong>Kode Booking:</strong> {{ $booking->booking_code }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Paket: {{ $booking->package->name }}</td>
                <td>Rp {{ number_format($booking->package->price, 0, ',', '.') }}</td>
            </tr>
            @if($booking->studio)
                <tr>
                    <td>Studio: {{ $booking->studio->name }}</td>
                    <td>-</td>
                </tr>
            @endif
            <tr>
                <td>Tanggal Foto</td>
                <td>{{ $booking->booking_date->format('d/m/Y') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total">
        <p>Total: Rp {{ number_format($booking->package->price, 0, ',', '.') }}</p>
        <p>Dibayar: Rp {{ number_format($booking->total_paid, 0, ',', '.') }}</p>
        <p>Sisa: Rp {{ number_format($booking->remaining_amount, 0, ',', '.') }}</p>
    </div>
</body>
</html>
