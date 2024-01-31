<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Error;
use App\Models\Feed;
use App\Exports\ErrorExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\WorkOrder;

class  ErrorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $toBeIssued = $request->query('toBeIssued');
        $searchTerms = explode(' ', $search);

        $errorsQuery = Error::query();

        foreach ($searchTerms as $term) {
            $errorsQuery->where(function ($query) use ($term) {
                $query->where('error_number', 'LIKE', "%{$term}%")
                    ->orWhere('name', 'LIKE', "%{$term}%")
                    ->orWhere('address', 'LIKE', "%{$term}%")
                    ->orWhere('equipment', 'LIKE', "%{$term}%")
                    ->orWhere('emi', 'LIKE', "%{$term}%")
                    ->orWhere('worker', 'LIKE', "%{$term}%")
                    ->orWhere('description', 'LIKE', "%{$term}%")
                    ->orWhere('error_type', 'LIKE', "%{$term}%")
                    ->orWhere('troubleshooter', 'LIKE', "%{$term}%")
                    ->orWhere('injured', 'LIKE', "%{$term}%")
                    ->orWhere('whistleblower', 'LIKE', "%{$term}%")
                    ->orWhere('whistleblower_tel', 'LIKE', "%{$term}%")
                    ->orWhere('comment', 'LIKE', "%{$term}%");
            });
        }

        $errors = $errorsQuery->orderBy('created_at', 'desc')->limit(150)->get();

        if ($toBeIssued == 1) {
            $errors = $errorsQuery->where('troubleshooter', 'LIKE', '%kiadandó%')->orderBy('created_at', 'desc')->limit(150)->get();
        }

        return Inertia::render('Error/Index', compact('errors','search', 'toBeIssued'));
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
        $user = auth()->user();
        $errorNumber = date('mdHi').'_P';
        if($user->name === 'Perényi Csilla')
        {
            $errorNumber = date('mdHi').'_C';
        }

        if($request->error_type === 'feladat'){
            $feed = Feed::create([
                'message' => 'Új feladat: '.$request->description,
                'creator_id' => $user->id,
                'type' => 'task',
            ]);
            $feed->save();
        }

        //dd($user->id);

        $error = Error::create([
            'error_number' => $errorNumber,
            'equipment_id' =>$request->equipment_id,
            'contract_ref' => $request->contract_ref,
            'name' => $request->name,
            'address' => $request->address,
            'type' => $request->type,
            'equipment' => $request->equipment,
            'emi' => $request->emi,
            'worker' => $request->worker,
            'description' => $request->description,
            'error_type' => $request->error_type,
            'isStand' => $request->isStand,
            'troubleshooter' => $request->troubleshooter,
            'injured' => $request->injured,
            'whistleblower' => $request->whistleblower,
            'whistleblower_tel' => $request->whistleblower_tel,
            'comment' => $request->comment,
            'dispatcher' => $user->name,
        ]);

        $error->save();

//        $feed = new FeedController();
//        $errorMessage = '<strong>Új hiba:</strong> '.$error->dispatcher.'
//                        <strong>Cím:</strong> '.$error->equipment->name.' - '.$error->equipment->address.'
//                        <strong>Leírás:</strong> '.$error->description.'
//                        <strong>Bejelentő:</strong> '.$error->whistleblower.'
//                        <strong>Bejelentő tel:</strong> '.$error->whistleblower_tel.'
//                        <strong>Megjegyzés:</strong> '.$error->comment;


//        $feed->automaticFeed(3,$errorMessage,'system');

        return redirect()->route('error.index')->with('success', 'Hiba sikeresen létrehozva!');

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
    public function edit(Error $error)
    {
        $error->load('equipment');

        $now = Carbon::now();

        $orders = WorkOrder::with('worker')
            ->where('start_status', '<=', $now)
            ->where('end_status', '>', $now)
            ->get();

        return Inertia::render('Error/Edit', compact('error', 'orders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Error $error)
    {
        $user = auth()->user();

        if($request->error_type === 'feladat'){
            $equipment = Equipment::findOrFail($request->equipment_id);
            $feed = Feed::create([
                'message' => 'Új feladat:<br> Cím: '.$request->name.' - '.$equipment->address.'<br> Leírás: '.$request->description.'<br> Bejelentő: '.$request->whistleblower.'<br> Bejelentő tel: '.$request->whistleblower_tel,
                'creator_id' => $user->id,
                'type' => 'task',
            ]);
            $feed->save();
        }

        $data = $request->only([
            'description',
            'error_type',
            'isStand',
            'injured',
            'dispatcher',
            'whistleblower',
            'whistleblower_tel',
            'comment',
            'troubleshooter'
        ]);
        $error->fill($data);
        $error->save();
        $feed = new FeedController();

//        $errorMessage = '<strong>Hiba frissítve:</strong> '.$error->dispatcher.'
//                        <strong>Cím:</strong> '.$error->equipment->name.' - '.$error->equipment->address.'
//                        <strong>Leírás:</strong> '.$error->description.'
//                        <strong>Bejelentő:</strong> '.$error->whistleblower.'
//                        <strong>Bejelentő tel:</strong> '.$error->whistleblower_tel.'
//                        <strong>Megjegyzés:</strong> '.$error->comment;

//        $feed->automaticFeed(3,$errorMessage,'system');


        return redirect()->route('error.index')->with('success', 'Hiba sikeresen módosítva!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Error $error)
    {
        $error->delete();
        return redirect()->route('error.index')->with('success', 'Hiba sikeresen törölve!');
    }

    public function getCurrentErrorsGroupByWorkers(Request $request){
        $today = Carbon::today();

        $errors = Error::with('equipment')
            ->where('created_at' , '>=', $today)
            ->get();

        $errorsGroupByWorkers = $errors->groupBy('troubleshooter');

        return response()->json($errorsGroupByWorkers->toArray());

    }

    public function export()
    {
        $date = Carbon::now()->format('Y_m_d');
        return Excel::download(new ErrorExport, 'Pandant_hibabejelentés_Új_'.$date.'.xlsx');
    }
}
