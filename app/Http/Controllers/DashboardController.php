<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Athlete;  // your Athlete model
use App\Models\Coach;    // your Coach model
use App\Models\Club;     // your Club model

class DashboardController extends Controller
{
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
        return view('dashboard', [
            'totalAthletes'   => $totalAthletes,
            'totalCoaches'    => $totalCoaches,
            'totalClubs'      => $totalClubs,
            'athletesPerClub' => $athletesPerClub,
        ]);
    }
}
