<?php

namespace App\Http\Controllers;

use App\Models\Athlete;  //  Athlete model
use App\Models\Coach;    //  Coach model
use App\Models\Club;     //  Club model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    public function index()
    {
        // 1) Simple totals:
        $totalAthletes = Athlete::count();
        $totalCoaches  = Coach::count();
        $totalClubs    = Club::count();

        // 2) If you want a breakdown (e.g. athletes per club), you can do:
        //    This will give you a Collection: [ 'Club A' => 12, 'Club B' => 7, ... ]
        $athletesPerClub = Club::withCount('athletes')
            ->orderBy('athletes_count', 'desc')
            ->get()
            ->pluck('athletes_count', 'club_name');

        // 3) Pass everything to the view
        /*return view('dashboard', [
            'totalAthletes'   => $totalAthletes,
            'totalCoaches'    => $totalCoaches,
            'totalClubs'      => $totalClubs,
            'athletesPerClub' => $athletesPerClub,
        ]);*/

        return view('dashboard', compact('totalAthletes', 'totalCoaches', 'totalClubs', 'athletesPerClub'));
    }
}
