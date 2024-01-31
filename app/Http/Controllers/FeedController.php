<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Feed;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Carbon\Carbon;

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

        $feeds = $query->limit(100)->get();


        return Inertia::render('Feed/Index', compact('feeds', 'user'));
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
        $feed = new Feed();
        $feed->creator_id = $request->user()->id;
        $feed->message = nl2br($request->message);
        $feed->type = $request->type;
        $feed->save();
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
    public function edit(string $id)
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

    public function solvedTask(Request $request, string $id){
        $feed = Feed::with('creator','comments.creator')->find($id);
        $feed->type = 'solved_task';
        $feed->save();
        return response()->json(['feed' => $feed]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function automaticFeed($creator, $message, $type = null)
    {
        $feed = new Feed();
        $feed->creator_id = $creator;
        $feed->message = nl2br($message);
        $feed->type = $type;
        $feed->save();
    }

    public function lastVisited(){
        $user = auth()->user();
        $userId = $user->id;
        $lastVisitKey = 'last_visit_' . $userId;

        $lastVisit = Cache::get($lastVisitKey);

        $feeds = Feed::where('created_at', '>', $lastVisit)->get();
        $comments = Comment::where('created_at', '>', $lastVisit)->get();

        $allActivities = count($feeds) + count($comments);

        return response()->json([
            'feeds' => $feeds,
            'lastVisit' => date('Y-m-d H:i:s', strtotime($lastVisit)),
            'lastVisitKey' => $lastVisitKey,
            'lastVisitCount' => $allActivities,
        ]);
    }
}
