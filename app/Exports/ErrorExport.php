<?php

namespace App\Exports;

use App\Models\Error;
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


class ErrorExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Error::orderBy('created_at', 'asc')->limit(100)->get();
    }

    public function headings(): array
    {
        return [
            'Hibajegy száma',
            'Dátum ',
            'Bejelentés Időpontja ',
            'Szerződésszám / Legacy reference',
            'Partner neve / Soldto- Name 1',
            'Beépítési cím / Description of Technical Object',
            'Berendezés típusa',
            'Equipment',
            'ÉMI szám ',
            'Karbantartó ',
            'Hiba elhárító karbantartó',
            'Hibajelenség leírása (Bejelentő) ',
            'Hiba típusa',
            'Áll-e a lift? ',
            'Hány sérült van? ',
            'Diszpécser neve',
            'Bejelentő',
            'Bejelentő telefonszáma',
            'megjegyzés, észrevétel',
            'újraindítás'
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
            $error->worker,
            $error->troubleshooter,
            $error->description,
            $error->error_type,
            $error->isStand,
            $error->injured,
            $error->dispatcher,
            $error->whistleblower,
            $error->whistleblower_tel,
            $error->comment,
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:T1')->applyFromArray([
            'font' => [
                'bold' => true,
                'name' => 'Arial',
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);
        $sheet->getStyle('A1:C1')->applyFromArray([
            'font' => [
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => Color::COLOR_RED],
            ],

        ]);

        $sheet->getStyle('D1:J1')->applyFromArray([
            'font' => [
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => '92D050'],
            ],

        ]);

        $sheet->getStyle('K1:R1')->applyFromArray([
            'font' => [
                'color' => ['argb' => Color::COLOR_WHITE],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => Color::COLOR_RED],
            ],
        ]);

        $sheet->getStyle('S1:T1')->applyFromArray([
            'font' => [
                'color' => ['argb' => Color::COLOR_BLACK],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFFF00'],
            ],
        ]);

        // Beállítja az összes fejléc cella magasságát, hogy elférjen a többsoros szöveg
        $sheet->getRowDimension(1)->setRowHeight(-1);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getColumnDimension('A')->setWidth(20);
                $event->sheet->getColumnDimension('B')->setWidth(20);
                $event->sheet->getColumnDimension('C')->setWidth(10);
                $event->sheet->getColumnDimension('E')->setWidth(30);
                $event->sheet->getColumnDimension('F')->setWidth(30);
                $event->sheet->getColumnDimension('G')->setWidth(20);
                $event->sheet->getColumnDimension('H')->setWidth(20);
                $event->sheet->getColumnDimension('I')->setWidth(20);
                $event->sheet->getColumnDimension('J')->setWidth(20);
                $event->sheet->getColumnDimension('K')->setWidth(20);
                $event->sheet->getColumnDimension('L')->setWidth(40);
                $event->sheet->getColumnDimension('M')->setWidth(15);
                $event->sheet->getColumnDimension('N')->setWidth(15);
                $event->sheet->getColumnDimension('O')->setWidth(10);
                $event->sheet->getColumnDimension('P')->setWidth(20);
                $event->sheet->getColumnDimension('Q')->setWidth(20);
                $event->sheet->getColumnDimension('R')->setWidth(20);
                $event->sheet->getColumnDimension('S')->setWidth(30);
                $event->sheet->getColumnDimension('T')->setWidth(30);

                // Az első három oszlop formázásának alkalmazása minden sorra
                $highestRow = $event->sheet->getHighestRow();

                $highestRow = $event->sheet->getHighestRow();
                $highestColumn = $event->sheet->getHighestColumn();
                $cellRange = 'A1:' . $highestColumn . $highestRow;

                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                        'inside' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                    'font' => [
                        'name' => 'Arial',
                        'size' => 12
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ],
                ]);

                $event->sheet->getStyle('A2:C' . $highestRow)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => 'E2EFD9'],
                    ],

                ]);
                $event->sheet->getStyle('D2:K' . $highestRow)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => 'ECECEC'],
                    ],
                ]);
                $event->sheet->getStyle('L2:T' . $highestRow)->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'color' => ['argb' => 'E2EFD9'],
                    ],
                ]);

                $highlightKeywords = ['kiadandó', 'külön kiszállási díj', ' kiszállási díjas', ' kiszállási díj', 'extra kiszállás', 'TODO', 'TODO:'];
                $highestRow = $event->sheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $cellValues = [
                        $event->sheet->getCell('K' . $row)->getValue(),
                        $event->sheet->getCell('L' . $row)->getValue(),
                    ];
                    foreach ($cellValues as $cellValue) {
                        foreach ($highlightKeywords as $keyword) {
                            if (stripos($cellValue, $keyword) !== false) {
                                // Alkalmazd a formázást mindkét oszlopra, ha bármelyik cella tartalmazza a megadott szöveget
                                $event->sheet->getStyle('K' . $row)->applyFromArray([
                                    'fill' => [
                                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                        'color' => ['argb' => 'FFFFFF00'], // Sárga háttér
                                    ],
                                ]);
                                $event->sheet->getStyle('L' . $row)->applyFromArray([
                                    'fill' => [
                                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                        'color' => ['argb' => 'FFFFFF00'], // Sárga háttér
                                    ],
                                ]);
                                // Ha a cella tartalmaz bármelyik kifejezést, ne keressünk tovább
                                break 2; // Kilép a belső foreach ciklusból és a külső foreach ciklusból is
                            }
                        }
                    }
                }
            },
        ];
    }
}
