<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sanction;

class SanctionController extends Controller
{
    // Show the list of sanction
    public function index()
    {
       // $achievementData = Sanction::all(); // Get all achievement records
        //return view('sanction.index', compact('achievementData'));
    }

    // Store a new sanction
    public function store(Request $request)
    {
        
    }

    // Update achievement by ID
    public function update(Request $request, $id)
    {
       
    }
}

