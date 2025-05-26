<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athlete;
use Illuminate\Support\Facades\DB;

class AthleteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //  $Athlete = Athlete::all();

        $athlete = DB::table('athlete as a')
            ->leftjoin('school as b', 'a.school_id', '=', 'b.id_school')
            ->leftjoin('club as c', 'a.club_id', '=', 'c.id_club')
            ->select(
                    DB::raw("CONCAT(a.athlete_fname, ' ', a.athlete_lname) as full_name"),
                    'c.club_name',
                    'b.school_name',
                    'a.id_athlete'
                )->get();
        
        return view(
            'athlete.index',
            ['AthleteList' => $athlete,]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'athlete.formAthlete'
        );
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
}
