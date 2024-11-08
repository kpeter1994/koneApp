<?php

namespace App\Http\Controllers;

use App\Models\DailyReport;
use Illuminate\Http\Request;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store()
    {
        $user = auth()->user();
        $dailyReport = DailyReport::create([
            'dispatcher' => $user->name,
            'actual' => true,
            ]
        );

        $dailyReport->save();

        return response()->json($dailyReport, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(DailyReport $dailyReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DailyReport $dailyReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DailyReport $dailyReport)
    {
        $dailyReport->update([
            'info_error' => $request['info_error'],
            'firewall_attack' => $request['firewall_attack'],
            'd_solo_demand' => $request['d_solo_demand'],
            'd_articulated_demand' => $request['d_articulated_demand'],
            'd_solo_supply' => $request['d_solo_supply'],
            'd_articulated_supply' => $request['d_articulated_supply'],
            'b_solo_demand' => $request['b_solo_demand'],
            'b_articulated_demand' => $request['b_articulated_demand'],
            'b_solo_supply' => $request['b_solo_supply'],
            'b_articulated_supply' => $request['b_articulated_supply'],
            'k_solo_demand' => $request['k_solo_demand'],
            'k_articulated_demand' => $request['k_articulated_demand'],
            'k_sprinter_demand' => $request['k_sprinter_demand'],
            'k_solo_supply' => $request['k_solo_supply'],
            'k_articulated_supply' => $request['k_articulated_supply'],
            'k_sprinter_supply' => $request['k_sprinter_supply'],
            'd_start_worker' => $request['d_start_worker'],
            'd_middle_worker' => $request['d_middle_worker'],
            'd_end_worker' => $request['d_end_worker'],
            'b_start_worker' => $request['b_start_worker'],
            'b_middle_worker' => $request['b_middle_worker'],
            'b_end_worker' => $request['b_end_worker'],
            'k_start_worker' => $request['k_start_worker'],
            'k_middle_worker' => $request['k_middle_worker'],
            'k_end_worker' => $request['k_end_worker']
        ]);

        $dailyReport->save();

        return response()->json($dailyReport, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DailyReport $dailyReport)
    {
        //
    }
}
