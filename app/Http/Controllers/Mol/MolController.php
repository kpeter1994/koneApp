<?php

namespace App\Http\Controllers\Mol;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\MolCharger;

class MolController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $searchTerms = explode(' ', $search);

        $chargersQuery = MolCharger::query();

        foreach ($searchTerms as $term) {
            $chargersQuery->where(function ($query) use ($term) {
                $query->where('charger_id', 'LIKE', "%{$term}%")
                    ->orWhere('model_name', 'LIKE', "%{$term}%")
                    ->orWhere('name', 'LIKE', "%{$term}%")
                    ->orWhere('site_name', 'LIKE', "%{$term}%")
                    ->orWhere('address', 'LIKE', "%{$term}%");
            });
        }

        $chargers = $chargersQuery->with('molService')->limit(10)->get();

        return Inertia::render('Mol/Index', compact('chargers'));
    }
}
