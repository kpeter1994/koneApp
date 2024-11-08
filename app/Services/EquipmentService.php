<?php

namespace App\Services;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EquipmentsImport;

class EquipmentService
{

    public function import(Request $request)
    {
        $file = $request->file('excel_file');
        Excel::import(new EquipmentsImport, $file);

        // További logika, pl. visszajelzés a felhasználónak
        return back()->with('success', 'Az adatok sikeresen importálva/frissítve lettek.');
    }

    public function readFile(){


    }
}
