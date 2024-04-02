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
        $searchTerms = explode(' ', $search);

        $now = Carbon::now();

        $orders = WorkOrder::with('worker')
            ->where('start_status', '<=', $now)
            ->where('end_status', '>', $now)
            ->get();

        $equipmentsQuery = Equipment::query();

        foreach ($searchTerms as $term) {
            $equipmentsQuery->where(function ($query) use ($term) {
                $query->where('name', 'LIKE', "%{$term}%")
                    ->orWhere('address', 'LIKE', "%{$term}%")
                    ->orWhere('equipment', 'LIKE', "%{$term}%")
                    ->orWhere('inventory_number', 'LIKE', "%{$term}%")
                    ->orWhere('emi', 'LIKE', "%{$term}%");
            });
        }

        $equipments = $equipmentsQuery->limit(20)->get();


        return Inertia::render('Equipment/Index', compact('equipments', 'orders'));
    }


}
