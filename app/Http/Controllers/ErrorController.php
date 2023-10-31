<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Error;
use App\Models\Feed;

class  ErrorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $errors = Error::with('equipment')->orderBy('created_at', 'desc')->get();


        return Inertia::render('Error/Index', compact('errors'));
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
        $errorNumber = date('mHis').'_P';
        $user = auth()->user();
        //dd($user->id);

        $error = Error::create([
            'error_number' => $errorNumber,
            'equipment_id' =>$request->equipment_id,
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

        $feed = new FeedController();
        $errorMessage = '<strong>Új hiba:</strong> '.$error->dispatcher.'
                        <strong>Cím:</strong> '.$error->equipment->name.' - '.$error->equipment->address.'
                        <strong>Leírás:</strong> '.$error->description.'
                        <strong>Bejelentő:</strong> '.$error->whistleblower.'
                        <strong>Bejelentő tel:</strong> '.$error->whistleblower_tel.'
                        <strong>Megjegyzés:</strong> '.$error->comment;

        $feed->automaticFeed($user->id,$errorMessage,'system');

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
        return Inertia::render('Error/Edit', compact('error'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Error $error)
    {
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
        $user = auth()->user();
        $errorMessage = '<strong>Hiba frissítve:</strong> '.$error->dispatcher.'
                        <strong>Cím:</strong> '.$error->equipment->name.' - '.$error->equipment->address.'
                        <strong>Leírás:</strong> '.$error->description.'
                        <strong>Bejelentő:</strong> '.$error->whistleblower.'
                        <strong>Bejelentő tel:</strong> '.$error->whistleblower_tel.'
                        <strong>Megjegyzés:</strong> '.$error->comment;

        $feed->automaticFeed($user->id,$errorMessage,'system');
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
}
