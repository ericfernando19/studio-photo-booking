<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        return Payment::with('booking')
            ->where('status', 'verified')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();
    }

    public function headings(): array
    {
        return ['Kode Booking', 'Tipe', 'Nominal', 'Metode', 'Invoice', 'Tanggal'];
    }

    public function map($payment): array
    {
        return [
            $payment->booking->booking_code,
            $payment->type_label,
            $payment->amount,
            $payment->method_label,
            $payment->invoice_number ?? '-',
            $payment->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
