<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Achievement;

class AchievementController extends Controller
{
    // Show list page
    public function index()
    {
        $achievementData = Achievement::all(); // get all achievement records
        return view('achievement.index', compact('achievementData'));
    }

    // Update achievement by id
    public function update(Request $request, $id)
    {
        // Validate inputs (simple example)
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
