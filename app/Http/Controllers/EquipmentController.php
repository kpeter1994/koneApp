<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $equipments = Equipment::where('name', 'LIKE', "%{$search}%")
            ->orWhere('address', 'LIKE', "%{$search}%")
            ->orWhere('equipment', 'LIKE', "%{$search}%")
            ->orWhere('emi', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get();
        //dd($equipments) ;

        return Inertia::render('Equipment/Index', compact('equipments'));
    }
}
