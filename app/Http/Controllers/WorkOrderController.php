<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\WorkOrder;
use Inertia\Inertia;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = WorkOrder::with('worker')->get();

        return Inertia::render('WorkOrder/Index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedOrder = $request->validate([
            'worker_id' => ['required'],
            'status' => ['required'],
            'end_status' => ['required'],
            'start_status' => ['required'],
        ]);

        $today = Carbon::today();

        $existingOrder = WorkOrder::where('worker_id', $validatedOrder['worker_id'])
            ->where(function ($query) use ($today) {
                $query->whereDate('start_status', $today)
                    ->orWhereDate('end_status', $today);
            })->first();

        if ($existingOrder) {
            // Ha van ilyen WorkOrder, akkor frissítsük
            $existingOrder->update($validatedOrder);
            $message = 'Beosztás sikeresen frissítve!';
        } else {
            // Ha nincs, akkor hozzunk létre egy újat
            WorkOrder::create($validatedOrder);
            $message = 'Beosztás sikeresen létrehozva!';
        }

        return redirect()->route('workers.index')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => ['required'],
            'end_status' => ['required'],
            'start_status' => ['required'],
        ]);

        $workOrder = WorkOrder::find($id);
        $workOrder->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



}
