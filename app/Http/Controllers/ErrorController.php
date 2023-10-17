<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Error;

class ErrorController extends Controller
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
        //dd($user->name);

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
        return Inertia::render('Error/Edit', compact('error'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


    }
}
