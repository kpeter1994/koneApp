<?php

namespace App\Imports;

use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;

class EquipmentsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Equipment::updateOrCreate(
                [
                    'equipment' => $row[4], // Feltételezve, hogy az 'equipment' a 5. oszlopban van
                    'emi' => $row[5],       // Feltételezve, hogy az 'emi' a 6. oszlopban van
                ],
                [
                    'contract_ref' => $row[0],
                    'name' => $row[1],
                    'address' => $row[2],
                    'type' => $row[3],
                    'equipment' => $row[4],
                    'emi' => $row[5],
                    'worker' => $row[6],
                    'supervisor' => $row[7],
                    'rated_load' => $row[8],
                    'inventory_number' => $row[9],
                    'comment' => $row[10],
                ]
            );
        }
    }


    public function headingRow(): int
    {
        return 1; // Ha az első sor tartalmazza a fejléceket
    }
}
