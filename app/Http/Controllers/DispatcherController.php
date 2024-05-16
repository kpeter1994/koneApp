<?php

namespace App\Http\Controllers;

use App\Exports\EventExport;
use App\Mail\ReportEmail;
use App\Models\BusEvent;
use App\Models\CallCenterReport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\DailyReport;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventEmail;


class DispatcherController extends Controller
{
    public function index()
    {
        $dalyReport = DailyReport::where('actual', true)->first();

        $events = BusEvent::when($dalyReport, function ($query) use ($dalyReport) {
            // Ez a blokk csak akkor fut le, ha a $dalyReport nem null
            return $query->where('daily_report_id', $dalyReport->id);
        }, function ($query) {
            // Ez a blokk akkor fut le, ha a $dalyReport null, azaz nincs 'aktual' jelentés
            return $query->latest()->limit(5);
        })->get();

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

        $dailyReport = DailyReport::with('busEvents')->where('actual', true)->first();

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

    public function sendReport()
    {
        $dailyReport = DailyReport::where('actual', true)->first();
        $events = BusEvent::where('daily_report_id', $dailyReport->id)->get();
        $callCenterReport = CallCenterReport::with('user')->where('daily_report_id', $dailyReport->id)->get();

        $address = env('DAY_REPORT_ADDRESS');

        $address = explode(',', $address);

        Mail::to($address)->send(new ReportEmail($dailyReport, $events,$callCenterReport));

        $dailyReport->update([
            'actual' => false
        ]);
        $dailyReport->save();
    }

    public function editEvent($id){
        $event = BusEvent::find($id);
        return Inertia::render('Dispatcher/Edit', compact('event'));
    }

    public function updateEvent(Request $request, $id)
    {
        $event = BusEvent::find($id);

        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'time' => $request->time,
            'location' => $request->location,
            'reporter' => $request->reporter,
            'recorder' => $request->recorder,
            'damage_value' => $request->damage_value
        ]);

        return redirect()->route('fougyelet.index')->with('success', 'Esemény sikeresen módosítva!');
    }

    public function deleteEvent($id)
    {
        $event = BusEvent::find($id);
        $event->delete();

        return response()->json(['success' => 'Esemény sikeresen törölve!']);
    }

    public function sendEvent($id)
    {
        $event = BusEvent::find($id);

        $address = null;

        if ($event->location == 'Budapest, Óradna u.5.'){
            $address = env('BUDAPEST_EVENT');
        }
        if ($event->location == 'Budapest, Óbuda BKV garázs'){
            $address = env('BUDAPEST_EVENT');
        }
        if ($event->location == 'Debrecen, Kígyóhagyma u.'){
            $address = env('DEBRECEN_EVENT');
        }
        if ($event->location == 'Kecskemét, Georg Knorr u.'){
            $address = env('KECSKEMET_EVENT');
        }


        $address = explode(',', $address);

        Mail::to($address)->send(new EventEmail($event));

       return response()->json(['success' => 'Esemény sikeresen elküldve!']);
    }




}
