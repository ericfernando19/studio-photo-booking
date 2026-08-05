<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        return DB::table('bookings')
            ->select('customer_name', DB::raw('COUNT(*) as total_bookings'))
            ->whereBetween('booking_date', [$this->startDate, $this->endDate])
            ->groupBy('customer_name')
            ->orderByDesc('total_bookings')
            ->get();
    }

    public function headings(): array
    {
        return ['Nama Customer', 'Total Booking'];
    }

    public function map($customer): array
    {
        return [
            $customer->customer_name,
            $customer->total_bookings,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
