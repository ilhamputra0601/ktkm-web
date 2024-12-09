<?php

namespace App\Http\Controllers;

use App\Models\Reel;
use App\Models\Division;
use Illuminate\Http\Request;

class ReelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reels = Reel::withCount('comments')
                    ->where('published', true)
                    ->latest()
                    ->get();
        $divisions = Division::all();
        return view('katarReel.index',compact('reels','divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Reel $reel)
    {
        $post = $reel;
        return view('katarReel.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reel $reel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reel $reel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reel $reel)
    {
        //
    }

}
