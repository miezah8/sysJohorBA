<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\Club;
use App\Models\Coach;
use App\Models\Nationality;
use App\Models\School;
use App\Models\District;
use Illuminate\Support\Facades\DB;

class AthleteController extends Controller
{
    /**
     * Display a paginated listing of athletes.
     */
    public function index()
    {
        // Eager-load everything the index table needs:
/*        $athletes = Athlete::with(['club', 'school', 'coach'])
                           ->orderBy('created_at', 'desc')
                           ->paginate(20);
*/
    $athleteData = DB::table('athlete as a')
      ->leftJoin('club as c','a.club_id','=','c.id_club')
      ->leftJoin('school as b','a.school_id','=','b.id_school')
      ->leftJoin('users as d','a.user_id','=','d.id')
      //->selectRaw("a.id_athlete, CONCAT(a.athlete_fname,' ',a.athlete_lname) as full_name, c.club_name, b.school_name")
      ->selectRaw("a.id_athlete, d.name AS full_name, c.club_name, b.school_name")
      ->get();

    return view('athlete.index', compact('athleteData'));
    }

    /**
     * Show the form for creating a new athlete.
     */
    public function create(Request $request)
    {
        // For your dropdowns in the multi-step form:
        $nationalities = Nationality::pluck('nationality_name', 'id_nationality');
        $states        = DB::table('state')->pluck('state_name', 'id_state');
        // only load districts if ?state_id=… is present
        $districts = $request->filled('state_id')
        ? District::where('state_id',$request->state_id)->pluck('district_name','id_district') : []; // loaded dynamically via AJAX
        $schools       = School::pluck('school_name', 'id_school');
        $clubs         = Club::pluck('club_name', 'id_club');
        $coaches       = Coach::pluck('coach_fname', 'id_coach');
        $achievement   = Achievement::pluck('achieve_bi', 'id_achieve');

        return view('athlete.create', compact(
            'nationalities', 'states', 'districts',
            'schools', 'clubs', 'coaches', 'achievement'
        ));
    }

    /**
     * Store a newly created athlete in storage.
     */
    public function store(Request $request)
    {
        // Here you'd validate each tab’s data, then:
        $data = $request->validate([
            'firstname'   => 'required|string|max:150',
            'lastname'    => 'required|string|max:150',
            'idNumber'    => 'required|string|max:20|unique:users,ic_number',
            'email'       => 'required|email|unique:users,email',
            'phone'       => 'required|string|max:20',
            'gender'      => 'required|in:M,F',
            'race'        => 'required|string|max:30',
            'citizens'    => 'required|integer|exists:nationality,id_nationality',
            'address'     => 'required|string',
            'postcode'    => 'required|string|max:10',
            'sch_state'   => 'required|integer|exists:state,id_state',
            'districts'   => 'required|integer|exists:district,id_district',
            'tshirt_size' => 'required|string|max:10',
            'NameTshirt'  => 'required|string|max:50',
            // guardian tab:
            'GuardianName'     => 'required|string|max:150',
            'GuardianPhone'    => 'required|string|max:20',
            'GuardianOccup'    => 'required|string|max:150',
            'GuardianRelation' => 'required|string|max:50',
            // school tab:
            'schoolDropdown'   => 'required|integer|exists:school,id_school',
            // experience tab (array of rows):
            'tournament'       => 'required|array',
            'tournament.*'     => 'required|string|max:200',
            'ranking'          => 'required|array',
            'ranking.*'        => 'required|in:1,2,3,4,5',
            'category'         => 'required|array',
            'category.*'       => 'required|string|max:10',
            'achieve'          => 'required|array',
            'achieve.*'        => 'required|integer|exists:achievement,id_achieve',
            'year'             => 'required|array',
            'year.*'           => 'required|digits:4',
            // coach & club tab:
            'coachSelect'      => 'required|integer|exists:coach,id_coach',
            'clubSelect'       => 'required|integer|exists:club,id_club',
        ]);

        // 1) Create the User + UserDetail record...
        // 2) Create Athlete (with the new sys_id from user)...
        // 3) Create Guardian, Experience rows, etc.

        // For brevity, we’ll just show the Athlete create:
        $athlete = Athlete::create([
            'user_id'       => auth()->id(),      // or the new user’s ID
            'coach_id'      => $data['coachSelect'],
            'school_id'     => $data['schoolDropdown'],
            'club_id'       => $data['clubSelect'],
            'athlete_fname' => $data['firstname'],
            'athlete_lname' => $data['lastname'],
            'tshirt_size'   => $data['tshirt_size'],
            'shirt_name'    => $data['NameTshirt'],
            'created_at'    => now(),
            'modified_on'   => now(),
        ]);

        // ...then guardian, experiences, etc.

        return redirect()->route('athlete.index')
                         ->with('success', 'Athlete registered successfully.');
    }

    /**
     * Display the specified athlete’s detail page.
     */
    public function show(Athlete $athlete)
    {
        // eager-load everything for your “show” view
        $athlete->load([
            'guardian',
            'school',
            'experiences', 
            'coach', 
            'club'
        ]);

        return view('athlete.show', compact('athlete'));
    }

    // Edit, update, destroy can follow the same pattern…
}
