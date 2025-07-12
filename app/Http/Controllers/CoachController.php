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
    public function index()
    {
        $query = Coach::withCount('athletesCoach');

        // if not an admin, only show the logged‐in user's own coach record(s)
        if (! Auth::user()->hasRole('admin')) {
            $query->where('user_id', Auth::id());
        }

        $coachData = $query->get();
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
        if (! Auth::user()->hasRole('admin') 
            && $coach->user_id !== Auth::id()) {
            abort(403);
        }

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
            //'email'      => $data['emel'],
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

        // experiences
        foreach ($data['experience'] as $exp) {
            // skip blank rows
            if (empty($exp['activity'])) {
                continue;
            }
            $coach->coachExperience()->create($exp);
        }

    // 8) Wipe & re-create all courses/certifications

// 0) collect existing qualification PKs
$existing = $coach->coachCourse
                  ->pluck('id_cco')
                  ->toArray();

// 1) pull submitted IDs out of the payload
$submitted = array_filter(array_column($data['qualification'], 'id'));

// 2) figure out which got removed
$toDelete = array_diff($existing, $submitted);

// 3) delete them in one go
if (! empty($toDelete)) {
    $coach->coachCourse()
          ->whereIn('id_cco', $toDelete)
          ->delete();
}

// 4) now proceed to update-or-create as before
foreach ($data['qualification'] as $i => $qual) {
    $attrs = [
      'course_id'    => $qual['course_id'],
      'course_level' => $qual['level']         ?? null,
      'pass_date'    => $qual['pass_date']     ?? null,
      'recognition'  => $qual['accreditation'] ?? null,
      'cert_siri'    => $qual['cert_number']   ?? null,
    ];

    // decide on attachment
    if (
      isset($qual['cert_file'])
      && $qual['cert_file'] instanceof \Illuminate\Http\UploadedFile
    ) {
      $attrs['cert_attach'] = 
        $qual['cert_file']->store('certs','public');
    } elseif (! empty($qual['existing_cert_attach'])) {
      $attrs['cert_attach'] = $qual['existing_cert_attach'];
    } else {
      $attrs['cert_attach'] = '';
    }

    if (! empty($qual['id'])) {
      // update existing
      $coach->coachCourse()
            ->where('id_cco', $qual['id'])
            ->update($attrs);
    } else {
      // insert new
      $coach->coachCourse()->create($attrs);
    }
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

        // 4) Store uploaded files if present
        if ($request->hasFile('gambar')) {
            $pic = $request->file('gambar')->store('profiles','public');
        } else {
            // fallback to hidden input
            $pic = $request->input('existing_profile_picture');
        }

        if ($request->hasFile('ic_picture')) {
            $ic = $request->file('ic_picture')->store('profiles','public');
        } else {
            $ic = $request->input('existing_ic_picture');
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
                'profile_picture' => $pic,
                'ic_picture'      => $ic,
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
// 0) collect existing qualification PKs
$existing = $coach->coachCourse
                  ->pluck('id_cco')
                  ->toArray();

// 1) pull submitted IDs out of the payload
$submitted = array_filter(array_column($data['qualification'], 'id'));

// 2) figure out which got removed
$toDelete = array_diff($existing, $submitted);

// 3) delete them in one go
if (! empty($toDelete)) {
    $coach->coachCourse()
          ->whereIn('id_cco', $toDelete)
          ->delete();
}

// 4) now proceed to update-or-create as before
foreach ($data['qualification'] as $i => $qual) {
    $attrs = [
      'course_id'    => $qual['course_id'],
      'course_level' => $qual['level']         ?? null,
      'pass_date'    => $qual['pass_date']     ?? null,
      'recognition'  => $qual['accreditation'] ?? null,
      'cert_siri'    => $qual['cert_number']   ?? null,
    ];

    // decide on attachment
    if (
      isset($qual['cert_file'])
      && $qual['cert_file'] instanceof \Illuminate\Http\UploadedFile
    ) {
      $attrs['cert_attach'] = 
        $qual['cert_file']->store('certs','public');
    } elseif (! empty($qual['existing_cert_attach'])) {
      $attrs['cert_attach'] = $qual['existing_cert_attach'];
    } else {
      $attrs['cert_attach'] = '';
    }

    if (! empty($qual['id'])) {
      // update existing
      $coach->coachCourse()
            ->where('id_cco', $qual['id'])
            ->update($attrs);
    } else {
      // insert new
      $coach->coachCourse()->create($attrs);
    }
}



    });

    return redirect()
           ->route('coach.index')
           ->with('success','Coach updated successfully.');
}



    public function show(Coach $coach)
{
        // forbid if they’re not admin AND this isn’t their coach record
        if (! Auth::user()->hasRole('admin') 
            && $coach->user_id !== Auth::id()) {
            abort(403);
        }

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
