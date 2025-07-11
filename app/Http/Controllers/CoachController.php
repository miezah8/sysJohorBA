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
use App\Models\CoachExperience;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $coach->userDetail = new UserDetail();
       
        // give Blade one “blank” entry for each repeatable block:
        $coach->setRelation('educations',       collect([new Education()]));
        $coach->setRelation('coachExperience',  collect([new CoachExperience()]));
        $coach->setRelation('coachCourse',      collect([new CoachCourse()]));
        
        return view('coach.create', compact(
          'states','districts','clubs','coach','nationalities','institution', 'courses'
        ));
    }

    /**
     * Show the form to edit an existing coach.
     */
    public function edit(Coach $coach)
    {
        // eager‐load everything the edit.blade needs
        $coach->load([
        'user',                            // email & contact_no
        'userDetail',                      // ic_no, address, etc.
        'userDetail.state',                // state_name
        'userDetail.district',             // district_name
        'userDetail.nationalityRelation',  // nationality_name
        'educations.institution',          // for Academic tab
        'coachExperience',                 // for Experience tab
        'coachCourse.course',              // for Qualification tab
        'club',                            // for Club Info tab
        ]);
        
        $states         = State::pluck('state_name','id_state');
        $districts      = District::where('state_id',$coach->userDetail->state_id)
                                  ->pluck('district_name','id_district');
        $clubs          = Club::pluck('club_name','id_club');
        $nationalities  = Nationality::pluck('nationality_name','id_nationality');
        $institution    = Institution::pluck('ipt_name','id');
        $courses        = Course::pluck('course_name','id_course');

        return view('coach.edit', compact(
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
        //dd($request->all());
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
            'jantina'     => 'required|in:M,F',
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
            'club_id'     => 'required|exists:club,id_club',
            'declaration' => 'accepted',
        ];

        // // 2) only if club_id is present in this payload, require it
        // if ($request->has('club_id')) {
        //     $rules['club_id'] = 'required|exists:club,id_club';
        // }

        // // 3) only if declaration is present, require it
        // if ($request->has('declaration')) {
        //     $rules['declaration'] = 'accepted';
        // }

        $data = $request->validate($rules);

        try {
             DB::transaction(function() use($data, $request) {

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

        // 7) upsert user detail
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
                'profile_picture' => $pp,
                'ic_picture'      => $ip,
            ]
        );

        // 8) loop academics
        if (! empty($data['academic'])) {
        foreach($data['academic'] as $acad) {
            $coach->educations()->create([
                'institution_id'  => $acad['institution_id'],
                'education_level' => $acad['education_level'],
                'year'            => $acad['year'],
            ]);
        }}

// 8) Wipe & re-create all courses/certifications
$coach->coachCourse()->delete();

// First, filter out any “completely blank” entries
$qualifications = array_filter($data['qualification'], function($q) {
    // only keep ones where at least one of these fields is non-empty
    return 
        ! empty($q['course_id'])      ||
        ! empty($q['pass_date'])      ||
        ! empty($q['accreditation'])  ||
        ! empty($q['cert_number'])    ||
        ! empty($q['existing_cert_attach']);
});

foreach ($qualifications as $i => $qual) {
    // Determine attachment:  
    // 1) new upload? 2) else existing hidden? 3) else blank
    if (isset($qual['cert_file']) && $qual['cert_file'] instanceof \Illuminate\Http\UploadedFile) {
        $attach = $qual['cert_file']->store('certs','public');
    } elseif (! empty($qual['existing_cert_attach'])) {
        $attach = $qual['existing_cert_attach'];
    } else {
        $attach = '';  // or null if your column allows it
    }

    $coach->coachCourse()->create([
        'course_id'    => $qual['course_id'],
        'course_level' => $qual['level']         ?? null,
        'pass_date'    => $qual['pass_date']     ?? null,
        'recognition'  => $qual['accreditation'] ?? null,
        'cert_siri'    => $qual['cert_number']   ?? null,
        'cert_attach'  => $attach,
    ]);
}



        });

    // If this was an AJAX request, return JSON
    if ($request->ajax()) {
        return response()->json([
            'message' => 'Coach successfully created.',
        ]);
    }

    // Otherwise fall back to normal redirect
    return redirect()
            ->route('coach.index')
            ->with('success','Coach successfully created.');
        

        } catch (\Throwable $e) {
             // log the full exception
            Log::error("Coach::store failed: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

        // send the user back with all their input + an error flash
        return back()
            ->withInput()
            ->with('error', 'Something went wrong saving your coach:\n\n'.$e->getMessage());
    }
    }




/**
 * Update an existing coach and all its related data.
 */
public function update(Request $request, $id)
{
    // Fetch coach + existing relationships
    $coach = Coach::with(['educations','coachExperience','coachCourse'])
                  ->findOrFail($id);

    // 1) Validation rules (same as store)
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
        'jantina'     => 'required|in:M,F',
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
        'qualification.*.course_id'    => 'required|exists:course,id_course',
        'qualification.*.level'        => 'nullable|string',
        'qualification.*.pass_date'    => 'nullable|date',
        'qualification.*.accreditation'=> 'nullable|string',
        'qualification.*.cert_number'  => 'nullable|string',
        'qualification.*.cert_file'    => 'nullable|file',
        // Club & declaration are only on final tab
        'club_id'     => 'required|exists:club,id_club',
        'declaration' => 'accepted',
    ];

    $data = $request->validate($rules);

    DB::transaction(function() use ($coach, $data, $request) {
        // 2) update coach, userDetail, wipe & recreate academics/experiences
        $coach->update([
            'club_id'     => $data['club_id'],
            'coach_fname' => $data['nama_penuh'],
        ]);

        // 3) Update user email & phone
        $coach->user->update([
            'email'      => $data['emel'],
            'contact_no' => $data['no_tel'],
        ]);

        // 4) Store uploaded files
        if ($request->hasFile('gambar')) {
            $pic = $request->file('gambar')->store('profiles','public');
        }
        if ($request->hasFile('ic_picture')) {
            $ic  = $request->file('ic_picture')->store('profiles','public');
        }

        // 5) Update or create user detail
        UserDetail::updateOrCreate(
            ['user_id' => $coach->user_id],
            [
                'ic_no'           => $data['no_kad'],
                'nationality'     => $data['nationality'],
                'address'         => $data['alamat'],
                'postcode'        => $data['poskod'],
                'state_id'        => $data['negeri'],
                'district_id'     => $data['daerah'],
                'gender'          => $data['jantina'],
                'race'            => $data['ethnicity'],
                'profile_picture' => $pic ?? null,
                'ic_picture'      => $ic  ?? null,
            ]
        );

        // 6) Wipe & re-create all academics
        $coach->educations()->delete();
        foreach ($data['academic'] as $acad) {
            $coach->educations()->create([
                'institution_id'  => $acad['institution_id'],
                'education_level' => $acad['education_level'],
                'year'            => $acad['year'],
            ]);
        }

        // 7) Wipe & re-create all experiences
        $coach->coachExperience()->delete();
        foreach ($data['experience'] as $exp) {
            $coach->coachExperience()->create($exp);
        }

        // 8) courses/certifications
// 8) Wipe & re-create all courses/certifications
$coach->coachCourse()->delete();

// First, filter out any “completely blank” entries
$qualifications = array_filter($data['qualification'], function($q) {
    // only keep ones where at least one of these fields is non-empty
    return 
        ! empty($q['course_id'])      ||
        ! empty($q['pass_date'])      ||
        ! empty($q['accreditation'])  ||
        ! empty($q['cert_number'])    ||
        ! empty($q['existing_cert_attach']);
});

foreach ($qualifications as $i => $qual) {
    // Determine attachment:  
    // 1) new upload? 2) else existing hidden? 3) else blank
    if (isset($qual['cert_file']) && $qual['cert_file'] instanceof \Illuminate\Http\UploadedFile) {
        $attach = $qual['cert_file']->store('certs','public');
    } elseif (! empty($qual['existing_cert_attach'])) {
        $attach = $qual['existing_cert_attach'];
    } else {
        $attach = '';  // or null if your column allows it
    }

    $coach->coachCourse()->create([
        'course_id'    => $qual['course_id'],
        'course_level' => $qual['level']         ?? null,
        'pass_date'    => $qual['pass_date']     ?? null,
        'recognition'  => $qual['accreditation'] ?? null,
        'cert_siri'    => $qual['cert_number']   ?? null,
        'cert_attach'  => $attach,
    ]);
}

    });

    return redirect()
           ->route('coach.index')
           ->with('success','Coach updated successfully.');
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
