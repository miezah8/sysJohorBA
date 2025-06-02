<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\Club;
use App\Models\Coach;
use App\Models\Nationality;
use App\Models\School;
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
        return view('athlete.formAthlete');
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
    public function show($id)
    {
        $school = School::find($id);

        if (! $school) {
            return response()->json(['error' => 'School not found'], 404);
        }

        $stateName = DB::table('state')->where('id_state', $school->state_id)->value('state_name');
        $districtName = DB::table('district')->where('id_district', $school->district_id)->value('district_name');

        $schoolData = $school->toArray();
        $schoolData['state_name'] = $stateName;
        $schoolData['district_name'] = $districtName;

        return response()->json($schoolData);
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

    public function getNationality()
    {
        // returns { id_state: state_name, … }
        return response()->json(Nationality::pluck('nationality_name', 'id_nationality'));
    }

    public function getSchool()
    {
        // returns { id_state: state_name, … }
        return response()->json(School::pluck('school_name', 'id_school'));
    }

    public function getClub()
    {
        // returns { id_state: state_name, … }
        return response()->json(Club::pluck('club_name', 'id_club'));
    }

    public function getCoach()
    {
        // returns { id_state: state_name, … }
        return response()->json(Coach::pluck('coach_fname', 'id_coach'));
    }
}
