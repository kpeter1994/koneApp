<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KoneAutocompleteController extends Controller
{
    public function getWhistleblower(Request $request)
    {

       $searchTerms = explode(' ', $request->query('search'));

        $whistleblowers = DB::table('error')
            ->select('whistleblower', DB::raw('COUNT(*) as count'))
            ->where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->where('whistleblower', 'LIKE', "%{$term}%");
                }
            })
            ->groupBy('whistleblower')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->pluck('whistleblower'); // Ha csak a whistleblower értékekre van szükség

        return response()->json($whistleblowers);
    }

    public function getDescription(Request $request)
    {
        $searchTerms = explode(' ', $request->query('search'));

        $descriptions = DB::table('error')
            ->select('description', DB::raw('COUNT(*) as count'))
            ->where(function ($query) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $query->Where('description', 'LIKE', "%{$term}%");
                }
            })
            ->groupBy('description')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get()
            ->pluck('description'); // Ha csak a description értékekre van szükség

        return response()->json($descriptions);
    }


}
