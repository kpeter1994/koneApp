<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feed;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        // Az alap lekérdezés, amely minden feedet visszaad.
        $query = Feed::with('creator','comments.creator')->orderBy('created_at', 'desc');

        $userId = $user->id;
        $lastVisitKey = 'last_visit_' . $userId;
        Cache::put($lastVisitKey, Carbon::now(), 60 * 60 * 360);

        // Ha a system=false paraméter jelen van és igaz, akkor ne jelenítse meg a type=system elemeket.
        if ($request->input('system') === 'false') {
            $query->where('type', '!=', 'system');
        }

        $feeds = $query->paginate(10);

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
    public function show(string $id)
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
