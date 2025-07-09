<?php
namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\UserDetail;
use App\Models\State;
use App\Models\District;
use App\Models\Club;
use App\Models\Nationality;
use App\Models\Institution;
use App\Models\Course;
use App\Models\CoachCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachController extends Controller
{
    public function index(Request $request)
    {
        $coaches = Coach::all();
        $coachData = Coach::withCount('athletesCoach')->get();

        // $coach = coach::find('1');
        // $athletes = $coach->athletes; // returns a collection of athletes associated with the coach
        // $athlete = Athlete::find(1);
        // $coach = $athlete->coach; // returns the coach associated with the athlete

        return view('coach.index', ['coachData' => $coachData]);
    }

    /**
     * Show the form to create a new coach.
     */
    public function create()
    {
        $states         = State::pluck('state_name','id_state');
        $districts      = collect();
        $clubs          = Club::pluck('club_name','id_club');
        $nationalities  = Nationality::pluck('nationality_name','id_nationality');
        $institution    = Institution::pluck('ipt_name','id');
        $courses = Course::pluck('course_name','id_course');
        // brand‐new coach and detail
        $coach             = new Coach();
        $coach->user       = auth()->user();

        // provide an “empty” detail so your blade can still do $coach->userDetail->xxx
        $detail = new UserDetail();
        $coach->userDetail = $detail;

        return view('coach.create', compact(
          'states','districts','clubs','coach','nationalities','institution', 'courses'
        ));
    }

    /**
     * Show the form to edit an existing coach.
     */
    public function edit(Coach $coach)
    {
        // eager‐load detail (or null)
        $coach->load('userDetail');
        if (! $coach->userDetail) {
            $coach->userDetail = new UserDetail();
        }
        
        $states         = State::pluck('state_name','id_state');
        $districts      = District::where('state_id',$coach->userDetail->state_id)
                                  ->pluck('district_name','id_district');
        $clubs          = Club::pluck('club_name','id_club');
        $nationalities  = Nationality::pluck('nationality_name','id_nationality');
        $institution    = Institution::pluck('ipt_name','id');
        $courses = Course::pluck('course_name','id_course');

        return view('coach.create', compact(
          'states','districts','clubs','coach','nationalities','institution', 'courses'
        ));
    }

    public function players(Coach $coach)
    {
        $players = $coach->athletesCoach()->paginate(25);
        return view('coach.players', compact('coach', 'players'));
    }

    /**
     * Store new coach.  Only require `club_id` + `declaration` if they exist (i.e. final step).
     */
    public function store(Request $request)
    {
        // 1) base rules (always apply these)
        $rules = [
            'gambar'      => 'nullable|image|max:2048',
            'ic_picture'  => 'nullable|image|max:2048',
            'nama_penuh'  => 'required|string|max:150',
            'emel'        => 'required|email|max:255',
            'no_tel'      => 'required|string|max:20',
            'nationality' => 'required|string|max:100',
            'no_kad'      => 'required|string|max:50',
            'alamat'      => 'required|string',
            'negeri'      => 'required|exists:state,id_state',
            'daerah'      => 'required|exists:district,id_district',
            'poskod'      => 'required|string|max:10',
            'jantina'     => 'required|in:Lelaki,Perempuan',
            'ethnicity'   => 'required|string|max:50',
            // Academic
            'academic.*.education_level' => 'required|string',
            'academic.*.institution_id'  => 'required|exists:ipt_list,id',
            'academic.*.year'            => 'required|digits:4',
            // Experience
            'experience.*.activity'     => 'required|string',
            'experience.*.position'     => 'nullable|string',
            'experience.*.level'        => 'nullable|string',
            'experience.*.organized_by' => 'nullable|string',
            'experience.*.start_date'   => 'nullable|date',
            'experience.*.end_date'     => 'nullable|date|after_or_equal:experience.*.start_date',
            // Qualification / Courses
            //'qualification.*.course'        => 'required|string',
            'qualification.*.course_id' => 'required|exists:course,id_course',
            'qualification.*.level'         => 'nullable|string',
            'qualification.*.pass_date'     => 'nullable|date',
            'qualification.*.accreditation' => 'nullable|string',
            'qualification.*.cert_number'   => 'nullable|string',
            'qualification.*.cert_file'     => 'nullable|file',
        ];

        // 2) only if club_id is present in this payload, require it
        if ($request->has('club_id')) {
            $rules['club_id'] = 'required|exists:club,id_club';
        }

        // 3) only if declaration is present, require it
        if ($request->has('declaration')) {
            $rules['declaration'] = 'accepted';
        }

        $data = $request->validate($rules);

        try {
        // 4) create the coach (or fill in the FK on updates if you switch to updateOrCreate)
        $coach = Coach::create([
            'user_id'     => Auth::id(),
            'club_id'     => $data['club_id']     ?? null,
            'coach_fname' => $data['nama_penuh'],
        ]);

        // 5) update the user’s email & phone
        Auth::user()->update([
            'email'      => $data['emel'],
            'contact_no' => $data['no_tel'],
        ]);

        // 6) store uploaded files
        if ($request->hasFile('gambar')) {
            $pp = $request->file('gambar')->store('profiles','public');
        }
        if ($request->hasFile('ic_picture')) {
            $ip = $request->file('ic_picture')->store('profiles','public');
        }

        // 7) user detail
        UserDetail::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'ic_no'           => $data['no_kad'],
                'nationality'     => $data['nationality'],
                'address'         => $data['alamat'],
                'postcode'        => $data['poskod'],
                'state_id'        => $data['negeri'],
                'district_id'     => $data['daerah'],
                'gender'          => $data['jantina'],
                'race'            => $data['ethnicity'],
                'profile_picture' => $pp ?? null,
                'ic_picture'      => $ip ?? null,
            ]
        );

        // 8) polymorphic academics
        foreach($data['academic'] as $acad) {
            $coach->educations()->create([
                'institution_id'  => $acad['institution_id'],
                'education_level' => $acad['education_level'],
                'year'            => $acad['year'],
            ]);
        }

        // 9) experiences
        foreach($data['experience'] as $exp) {
            $coach->coachExperience()->create($exp);
        }

        // 10) qualifications / courses
        foreach($data['qualification'] as $qual) {
            $item = [
                'course_id'     => $qual['course_id'], 
                'course_level'  => $qual['level']         ?? null,
                'pass_date'     => $qual['pass_date']     ?? null,
                'recognition'   => $qual['accreditation'] ?? null,
                'cert_siri'     => $qual['cert_number']   ?? null,
            ];
            if (isset($qual['cert_file'])) {
                $item['cert_attach'] = $qual['cert_file']->store('certs','public');
            }
            $coach->coachCourse()->create($item);
        }

        return redirect()
                ->route('coach.index')
                ->with('success','Coach successfully created.');
        
        } catch (\Throwable $e) {
        \Log::error('Coach store failed: '.$e->getMessage());
        // send the user back with all their input + an error flash
        return back()
            ->withInput()
            ->with('error', 'Something went wrong saving your coach: '.$e->getMessage());
    }
    }




    /**
     * Update coach personal detail
     */
    public function update(Request $request, $id)
    {
        $coach = Coach::findOrFail($id);

        $data = $request->validate([
            'gambar'      => 'nullable|image|max:2048',
            'nama_penuh'  => 'required|string|max:150',
            'emel'        => 'required|email|max:255',
            'no_tel'      => 'required|string|max:20',
            'nationality' => 'required|string|max:100',
            'no_kad'      => 'required|string|max:50',
            'alamat'      => 'required|string',
            'negeri'      => 'required|exists:state,id_state',
            'daerah'      => 'required|exists:district,id_district',
            'poskod'      => 'required|string|max:10',
            'jantina'     => 'required|in:Lelaki,Perempuan',
            'ethnicity'   => 'required|string|max:50',
            'club_id'     => 'nullable|integer',
            'coach_fname' => 'nullable|string|max:150',
            'coach_lname' => 'nullable|string|max:150',
        ]);

        // update coach record
        $coach->update([
            'club_id'    => $data['club_id']    ?? $coach->club_id,
            'coach_fname'=> $data['coach_fname'] ?? $coach->coach_fname,
            'coach_lname'=> $data['coach_lname'] ?? $coach->coach_lname,
        ]);

        // update user email & phone
        $coach->user->update([
            'email'      => $data['emel'],
            'contact_no' => $data['no_tel'],
        ]);

        // new picture?
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')
                            ->store('coaches','public');
        }

        // update personal detail
        UserDetail::updateOrCreate(
            ['user_id' => $coach->user_id],
            [
                'ic_no'          => $data['no_kad'],
                'nationality'    => $data['nationality'],
                'address'        => $data['alamat'],
                'postcode'       => $data['poskod'],
                'state_id'       => $data['negeri'],
                'district_id'    => $data['daerah'],
                'gender'         => $data['jantina'],
                'race'           => $data['ethnicity'],
                'profile_picture'=> $path ?? null,
            ]
        );

        // JSON for your AJAX
        return response()->json(['message' => 'Personal info updated']);
    }

    public function show(Coach $coach)
{
    $coach->load([
      'user',
      'userDetail.state',
      'userDetail.district',
      'userDetail.nationalityRelation',
      'educations.institution',
      'coachExperience',
      'coachCourse.course',
      'club',
    ]);
    return view('coach.show', compact('coach'));
}


    /**
     * (Optional) If you need to delete a coach
     */
    public function destroy($id)
    {
        $coach = Coach::findOrFail($id);
        $coach->delete();
        return redirect()->route('coach.index')
                         ->with('success','Coach removed');
    }

    /**
     * Helper endpoint for AJAX-loading districts by state
     */
    public function districtsByState($stateId)
    {
        $list = District::where('state_id',$stateId)
                        ->pluck('district_name','id_district');
        return response()->json($list);
    }

}
