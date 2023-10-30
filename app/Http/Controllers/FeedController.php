<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feed;
use Inertia\Inertia;

class FeedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $feeds = Feed::with('creator')->orderBy('created_at', 'desc')->limit(20)->get();

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
}
