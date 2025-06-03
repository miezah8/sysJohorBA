<?php
namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index(Request $request)
    {
        $coachData = Coach::withCount('athletesCoach')->get();

        // $coach = coach::find('1');
        // $athletes = $coach->athletes; // returns a collection of athletes associated with the coach
        // $athlete = Athlete::find(1);
        // $coach = $athlete->coach; // returns the coach associated with the athlete

        return view('coach.index', ['coachData' => $coachData]);
    }

    public function players(Coach $coach)
    {
        $players = $coach->athletesCoach()->paginate(25);
        return view('coach.players', compact('coach', 'players'));
    }

    public function form($id = null)
    {
        $coach = $id ? Coach::findOrFail($id) : null;

        return view('coach.form', compact('coach'));
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    // public function show(string $id)
    // {
    //     //
    // }
    // public function create()
    // {
    //     //
    // }
    // public function edit(string $id)
    // {
    //     //
    // }
}
