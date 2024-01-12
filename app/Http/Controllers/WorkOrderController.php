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
        $now = Carbon::now();
        $sevenDaysBefore = $now->copy()->subDays(7);
        $sevenDaysAfter = $now->copy()->addDays(7);

        $orders = WorkOrder::with('worker')
            ->where('end_status', '>', $sevenDaysBefore)
            ->where('end_status', '<', $sevenDaysAfter)
            ->orderBy('start_status', 'asc')
            ->get();

        $groupedOrders = collect();

        foreach ($orders as $order) {
            $start = Carbon::parse($order->start_status);
            $end = Carbon::parse($order->end_status);

            while ($start->lte($end)) {
                $dateKey = $start->format('Y-m-d');

                // Ellenőrzi, hogy az end_status nagyobb-e, mint 08:00 az adott napon
                if ($end->gt(Carbon::parse($dateKey . ' 08:01'))) {
                    if (!$groupedOrders->has($dateKey)) {
                        $groupedOrders[$dateKey] = collect();
                    }

                    $groupedOrders[$dateKey]->push($order);
                }

                $start->addDay();
            }
        }

        return Inertia::render('WorkOrder/Index', ['orders' => $groupedOrders]);
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

        WorkOrder::create($validatedOrder);
        $message = 'Beosztás sikeresen létrehozva!';

//        if ($existingOrder) {
//            // Ha van ilyen WorkOrder, akkor frissítsük
//            $existingOrder->update($validatedOrder);
//            $message = 'Beosztás sikeresen frissítve!';
//        } else {
//            // Ha nincs, akkor hozzunk létre egy újat
//            WorkOrder::create($validatedOrder);
//            $message = 'Beosztás sikeresen létrehozva!';
//        }

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
    public function destroy(Request $request)
    {
        $id = $request->order;;
        $order = WorkOrder::find($id);
        $order->delete();

        return redirect()->route('workers.index')->with('success', 'Beosztás sikeresen törölve!');
    }



}
