<?php

namespace App\Exports;

use App\Models\Error;
use App\Models\BusEvent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;


class EventExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $startOfDay = Carbon::today()->hour(7);
        $endOfDay = Carbon::tomorrow()->hour(7);

        return BusEvent::where('created_at', '>=', $startOfDay)
            ->where('created_at', '<', $endOfDay)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Fődiszpécser napi üzemviteli jelentés - 2024. Március 05.',
        ];
    }

    public function map($error): array
    {
        return [
            $error->error_number,
            Carbon::parse($error->created_at)->format('Y.m.d'),
            Carbon::parse($error->created_at)->format('H:i'),
            $error->contract_ref,
            $error->name,
            $error->address,
            $error->type,
            $error->equipment,
            $error->emi,

        ];
    }

    public function styles(Worksheet $sheet)
    {

        return [
            1    => ['font' => ['bold' => true, 'size' => 10]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:I100')->applyFromArray([
                    'font' => [
                        'name' => 'Arial',
                    ],
                ]);
                $event->sheet->getDelegate()->mergeCells('A1:I1');
                $event->sheet->getDelegate()->getRowDimension(2)->setRowHeight(0);
                $event->sheet->getDelegate()->mergeCells('A3:I3')->getStyle('A3:I3')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('989898');
                $event->sheet->getDelegate()->setCellValue('A3', 'Itt a fix szöveg');
                $event->sheet->getDelegate()->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


                $h1 = 'A1';
                $h2 = 'A3';
                $event->sheet->getDelegate()->getStyle($h1)->getFont()->setSize(10)->setBold(true);
                $event->sheet->getDelegate()->getStyle($h2)->getFont()->setSize(10)->setBold(true);

                $event->sheet->getDelegate()->getStyle($h1)->getAlignment()->setHorizontal('center');

                $event->sheet->getDelegate()->mergeCells('A4:C4');
                $event->sheet->getDelegate()->mergeCells('D4:I4');




            },
        ];
    }
}
