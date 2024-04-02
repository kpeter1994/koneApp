<?php

namespace App\Http\Controllers;

use App\Exports\EventExport;
use App\Models\BusEvent;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DailyReport;

class DispatcherController extends Controller
{
    public function index()
    {
        $startOfDay = Carbon::today()->hour(7);
        $endOfDay = Carbon::tomorrow()->hour(7);

        $events = BusEvent::where('created_at', '>=', $startOfDay)
            ->where('created_at', '<', $endOfDay)
            ->get();
        $dalyReport = DailyReport::where('actual', true)->first();

        return Inertia::render('Dispatcher/Index', compact('events', 'dalyReport'));
    }

    public function show()
    {
        return Inertia::render('Dispatcher/Show');
    }

    public function create()
    {
        return Inertia::render('Dispatcher/Create');
    }

    public function store(Request $request)
    {
        $busEvent = new BusEvent();

        $dailyReport = DailyReport::with('bus_event')->where('actual', true)->first();

        $user = auth()->user();

        $busEvent->create([
            'name' => $request->name,
            'daily_report_id' => $dailyReport->id,
            'description' => $request->description,
            'time' => $request->time,
            'location' => $request->location,
            'reporter' => $request->reporter,
            'notified' => $user->name,
            'recorder' => $request->recorder,
            'damage_value' => $request->damage_value

            ]);


        return redirect()->route('fougyelet.index')->with('success', 'Esemény sikeresen rögzítve!');

    }

    public function edit()
    {
        return Inertia::render('Dispatcher/Edit');
    }

    public function update()
    {
        return Inertia::render('Dispatcher/Update');
    }

    public function destroy()
    {
        return Inertia::render('Dispatcher/Destroy');
    }

    public function export()
    {
        return Excel::download(new EventExport, 'Főügyeleti.xlsx');
    }


}
