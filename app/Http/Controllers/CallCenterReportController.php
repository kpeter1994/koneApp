<?php

namespace App\Http\Controllers;

use App\Models\CallCenterReport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\DailyReport;

class CallCenterReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('CallCenterReport/Index');
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
        $callCenterReport = new CallCenterReport();

        $dailyReport = DailyReport::where('actual', true)->first();

        $user = auth()->user();

        $callCenterReport->create([
            'user_id' => $user->id,
            'daily_report_id' => $dailyReport->id,
            'comment' => $request->comment,
            'call_count' => $request->call_count,
        ]);

        return redirect()->route('posts.index')->with('success', 'Sikeres hozzáadás!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CallCenterReport $callCenterReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CallCenterReport $callCenterReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CallCenterReport $callCenterReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CallCenterReport $callCenterReport)
    {
        //
    }
}
