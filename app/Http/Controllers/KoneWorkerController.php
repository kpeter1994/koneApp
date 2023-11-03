<?php

namespace App\Http\Controllers;

use App\Models\KoneWorker;
use App\Models\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KoneWorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $now = Carbon::now();
        $search = $request->query('search');

        //dd($now);

        $orders = WorkOrder::where('start_status', '<', $now)
            ->where('end_status', '>', $now)
            ->get();
        //dd($orders);

        $workers = KoneWorker::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->get();

        return Inertia::render('Workers/Index', compact('workers','orders', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $worker = KoneWorker::where('name', $request->name)->first();

        if ($worker) {
            return response()->json($worker);
        } else {
            return response()->json(['message' => 'Worker not found'], 404);
        }

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
