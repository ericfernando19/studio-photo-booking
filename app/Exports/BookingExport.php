<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected string $startDate;
    protected string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Booking::with(['package', 'studio'])
            ->whereBetween('booking_date', [$this->startDate, $this->endDate])
            ->get();
    }

    public function headings(): array
    {
        return ['Kode Booking', 'Nama Customer', 'No. HP', 'Paket', 'Tanggal', 'Studio', 'Status', 'Antrian'];
    }

    public function map($booking): array
    {
        return [
            $booking->booking_code,
            $booking->customer_name,
            $booking->customer_phone,
            $booking->package->name,
            $booking->booking_date->format('d/m/Y'),
            $booking->studio?->name ?? '-',
            $booking->status_label,
            $booking->queue_number ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
