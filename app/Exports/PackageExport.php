<?php

namespace App\Exports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PackageExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        return Package::withCount(['bookings' => function ($query) {
            $query->whereBetween('booking_date', [$this->startDate, $this->endDate]);
        }])->orderByDesc('bookings_count')->get();
    }

    public function headings(): array
    {
        return ['Nama Paket', 'Harga', 'Minimal DP', 'Jumlah Pemesanan'];
    }

    public function map($package): array
    {
        return [
            $package->name,
            $package->price,
            $package->min_dp,
            $package->bookings_count,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
