<?php

namespace App\Http\Controllers;

use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Equipment;
use Carbon\Carbon;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $now = Carbon::now();

        $orders = WorkOrder::with('worker')
            ->where('start_status', '<=', $now)
            ->where('end_status', '>', $now)
            ->get();

        $equipments = Equipment::where('name', 'LIKE', "%{$search}%")
            ->orWhere('address', 'LIKE', "%{$search}%")
            ->orWhere('equipment', 'LIKE', "%{$search}%")
            ->orWhere('emi', 'LIKE', "%{$search}%")
            ->limit(10)
            ->get();
        //dd($equipments) ;

        return Inertia::render('Equipment/Index', compact('equipments', 'orders'));
    }
}
