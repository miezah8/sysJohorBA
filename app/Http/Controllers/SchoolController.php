<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\School;
use App\Models\District;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tblSchool = school::all();

        $schoolData = DB::table('school as a')
            ->leftjoin('district as b', 'a.district_id', '=', 'b.id_district')->get();

        // dd($schoolData->take(10));

        return view('school.index', ['schoolData' => $schoolData,]);
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
    public function show(Request $request)
    {
        $id = $request->selectedRecord;
        $school = school::find($id);

        if (!$school) {
            return response()->json(['error' => 'School not found'], 404);
        }

        return response()->json($school);
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

    public function getDistricts()
    {
        return response()->json(district::pluck('district_name', 'id_district'));
    }
}
