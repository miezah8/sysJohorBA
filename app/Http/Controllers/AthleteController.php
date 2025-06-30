<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Athlete;
use App\Models\Club;
use App\Models\Coach;
use App\Models\Nationality;
use App\Models\School;
use App\Models\District;
use App\Models\Guardian;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        $userId = $request->user()->id;
        // Here you'd validate each tab’s data, then:
        $data = $request->validate([
            // Personal tab 
            'firstname'   => 'required|string|max:150',
            
            // ignore current user so we don’t collide with ourselves
              'idNumber'    => [
                'required','string','max:20',
                Rule::unique('users','ic_number')->ignore($userId),
            ],
            'email'       => [
                'required','email',
                Rule::unique('users','email')->ignore($userId),
            ],
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
            // Achievements tab:
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
            'declaration'      => 'required|accepted',
        ]);

        DB::beginTransaction();

        try {
            // 1) Update User record
            $user = $request->user();
            $user->ic_number  = $data['idNumber'];
            $user->contact_no = $data['phone'];
            $user->save();
            
            // 1b) Upsert into user_detail
            $user->detail()->updateOrCreate(
                [ 'user_id' => $user->id ],
                [
                'ic_no'         => $data['idNumber'],
                'nationality'   => $data['citizens'],
                'address'       => $data['address'],
                'postcode'      => $data['postcode'],
                'state_id'      => $data['sch_state'],
                'district_id'   => $data['districts'],
                'gender'        => $data['gender'],
                'race'          => $data['race'],
                // file uploads for pictures:
                'profile_picture' => $request->file('profile_picture') 
                                        ? $request->file('profile_picture')->store('profile_pics','public')
                                        : null,
                'ic_picture'      => $request->file('ic_picture') 
                                        ? $request->file('ic_picture')->store('ic_pics','public')
                                        : null,
                ]
            );

            // 2) Create Athlete
            $athlete = Athlete::create([
                'user_id'       => $user->id,
                'coach_id'      => $data['coachSelect'],
                'school_id'     => $data['schoolDropdown'],
                'club_id'       => $data['clubSelect'],
                'athlete_fname' => $data['firstname'],
                'athlete_lname' => '', 
                'tshirt_size'   => $data['tshirt_size'],
                'shirt_name'    => $data['NameTshirt'],
                'created_at'    => now(),
                'modified_on'   => now(),
            ]);

            // 3) Guardian
            $athlete->guardian()->create([
                'name'  => $data['GuardianName'],
                'phone' => $data['GuardianPhone'],
                'occupation'     => $data['GuardianOccup'],
                'relation'       => $data['GuardianRelation'],
            ]);

            // 4) Experiences (polymorphic)
            foreach ($data['tournament'] as $i => $tourn) {
                $athlete->experiences()->create([
                    'tournament'     => $tourn,
                    'ranking'        => $data['ranking'][$i],
                    'category'       => $data['category'][$i],
                    'achieve_id'     => $data['achieve'][$i],
                    'year'           => $data['year'][$i],
                ]);
            }

            DB::commit();

        // if this was an AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message'  => 'Athlete registered successfully.',
                'redirect' => route('athlete.index'),
            ]);
        }
            // otherwise fall back to a normal redirect:
            return redirect()
                ->route('athlete.index')
                ->with('success','Athlete registered successfully.');
        }
        catch (\Exception $e) {
            DB::rollBack();
            \Log::error("AthleteController@store Error: {$e->getMessage()} in {$e->getFile()}:{$e->getLine()}");
            if ($request->ajax()) {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 500);
            }
            return back()
                ->withInput()
                ->with('error','Something went wrong; please try again.');
        }               
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
            'experiences.achievement',
            'coach',
            'club',
            'user.detail.state',
            'user.detail.district',
            'user.detail.nationality',
        ]);

        return view('athlete.show', compact('athlete'));
    }

    // Edit, update, destroy can follow the same pattern…
        //
    // JSON endpoints for dynamic dropdowns
    //

    /** GET /ajax/nationalities */
    public function nationalityList()
    {
        return response()->json(Nationality::pluck('nationality_name','id_nationality'));
    }

    /** GET /ajax/states */
    public function stateList()
    {
        return response()->json(DB::table('state')->pluck('state_name','id_state'));
    }

    /** GET /ajax/districts?state_id=XX */
    public function districtList(Request $request)
    {
        $request->validate([
          'state_id'=>'required|integer|exists:state,id_state'
        ]);
        return response()->json(
            District::where('state_id',$request->state_id)
                    ->pluck('district_name','id_district')
        );
    }

    public function getSchool(Request $request)
    {
        $request->validate([
        'school_id' => 'required|integer|exists:school,id_school'
        ]);
        return School::where('id_school', $request->school_id)
                    ->select(['sch_code','sc_address','postcode'])
                    ->first();
    }

    /** GET /ajax/schools */
    public function schoolList()
    {
        return response()->json(School::pluck('school_name','id_school'));
    }

    /** GET /ajax/clubs */
    public function clubList()
    {
        return response()->json(Club::pluck('club_name','id_club'));
    }

    /** GET /ajax/coaches */
    public function coachList()
    {
        return response()->json(Coach::pluck('coach_fname','id_coach'));
    }

    /** GET /ajax/achievements */
    public function achievementList()
    {
        return response()->json(Achievement::pluck('achieve_bi','id_achieve'));
    }
}
