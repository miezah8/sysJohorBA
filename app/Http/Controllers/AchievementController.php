<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;

class AchievementController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view achievement')->only(['index']);
        $this->middleware('permission:add achievement')->only(['store']);
        $this->middleware('permission:edit achievement')->only(['update']);
    }
    
    // Show the list of achievements
    public function index()
    {
        $achievementData = Achievement::all(); // Get all achievement records
        return view('achievement.index', compact('achievementData'));
    }

    // Store a new achievement
    public function store(Request $request)
    {
        $request->validate([
            'achieve_bm' => 'required|string|max:255',
            'achieve_bi' => 'required|string|max:255',
        ]);

        $achievement = new Achievement();
        $achievement->achieve_bm = $request->achieve_bm;
        $achievement->achieve_bi = $request->achieve_bi;
        $achievement->save();

        return response()->json(['message' => 'Achievement added successfully']);
    }

    // Update achievement by ID
    public function update(Request $request, $id)
    {
        // Validate inputs
        $request->validate([
            'achieve_bm' => 'required|string|max:255',
            'achieve_bi' => 'required|string|max:255',
        ]);

        $achievement = Achievement::findOrFail($id);
        $achievement->achieve_bm = $request->achieve_bm;
        $achievement->achieve_bi = $request->achieve_bi;
        $achievement->save();

        return response()->json(['message' => 'Achievement updated successfully']);
    }

    public function show(Achievement $achievement)
    {
        // If the request is AJAX (fetch in JS), return JSON:
        if (request()->ajax()) {
            return response()->json([
                'achieve_bm' => $achievement->achieve_bm,
                'achieve_bi' => $achievement->achieve_bi,
            ]);
        }

        // Otherwise (non-AJAX), you could return a normal “show” page if you like:
        return view('achievement.show', compact('achievement'));
    }

    public function destroy($id)
    {
        $achieve = Achievement::findOrFail($id);
        $achieve->delete();
        return response()->json(['message' => 'Achievement deleted']);
    }

}

