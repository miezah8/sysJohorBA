<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;

class AchievementController extends Controller
{
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
}

