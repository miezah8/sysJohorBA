<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubFacilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Facility;
use App\Models\State;

class ClubController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view club')->only(['index','show','players']);
    //     $this->middleware('permission:add club')->only(['create','store']);
    //     $this->middleware('permission:edit club')->only(['edit','update']);
    //     $this->middleware('permission:delete club')->only('destroy');
    // }
    /**
     * Display a listing of clubs.
     */
    public function index()
    {
        $clubs          = Club::withCount('athletes')->get();
        $states         = State::orderBy('state_name')->get();
        // pluck the facility *names* into $facilityNames
        $facilityNames  = Facility::where('status',1)->orderBy('name')->get();
        return view('clubs.index', compact('clubs','states','facilityNames'));
    }

    /**
     * Show all athletes for a given club.
     */
    public function players(Club $club)
    {
        // eager-load any relations you need on Athlete
        $players = $club->athletes()->paginate(25);
        return view('clubs.players', compact('club','players'));
    }

    /**
     * Show the form for creating a new club.
     */
    public function create()
    {
        return view('clubs.create');
    }

    /**
     * Store a newly created club.
     */
    public function store(Request $request)
    {
    // 1) Validate everything
    $validated = $request->validate([
        'club_name'    => 'required|string|max:255|unique:club,club_name',
        'email'        => 'required|email|max:255',
        'phone'        => 'required|string|max:50',
        'address'      => 'nullable|string',
        'postcode'     => 'nullable|string|max:20',
        'state_id'     => 'required|exists:state,id_state',
        'district_id'  => 'required|exists:district,id_district',
        'facilities'   => 'sometimes|array',
        'facilities.*.facility_id'     => 'required|exists:facilities,id',
        'facilities.*.quantity' => 'required|integer|min:1',
        ]);

        // 2) Create club with user_id from the logged-in user
        $club = Club::create([
        'user_id'     => Auth::id(),
        'club_name'   => $validated['club_name'],
        'email'       => $validated['email'],
        'phone'       => $validated['phone'],
        'address'     => $validated['address'] ?? null,
        'postcode'    => $validated['postcode'] ?? null,
        'state_id'    => $validated['state_id'],
        'district_id' => $validated['district_id'],
        'created_at'  => now(),
        'modified_on' => now(),
        ]);

        // 3) Save facilities if provided
        if (! empty($validated['facilities'])) {
            foreach ($validated['facilities'] as $f) {
                ClubFacilities::create([
                    'club_id'     => $club->id_club,
                    'facility_id' => $f['facility_id'],   
                    'quantity'    => $f['quantity'],
                    'created_at'  => now(),
                    'modified_on' => now(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Club created successfully',
            'data' => $club
        ]);
    }

        /**
         * Display club data for editing (AJAX)
         */
        public function show(Club $club)
        {
            $club->load('facilities');
            return response()->json([
                'success'    => true,
                'club'       => $club,
                'facilities' => $club->facilities,
            ]);
        }

        /**
         * Show the form for editing a club.
         */
        public function edit(Club $club)
        {
            $club->load('facilities');
            return view('clubs.edit', compact('club'));
        }

        /**
         * Update the specified club.
         */
        public function update(Request $request, Club $club)  // Changed to model binding
        {
            $validated = $request->validate([
                'club_name'    => "required|string|max:255|unique:club,club_name,{$club->id_club},id_club",
                'email'        => 'required|email|max:255',
                'phone'        => 'required|string|max:50',
                'address'      => 'nullable|string',
                'postcode'     => 'nullable|string|max:20',
                'state_id'     => 'required|exists:state,id_state',
                'district_id'  => 'required|exists:district,id_district',
                'facilities'   => 'sometimes|array',
                'facilities.*.facility_id'     => 'required|exists:facilities,id',
                'facilities.*.quantity' => 'required|integer|min:1',
            ]);

            // Update main club data
            $club->update([
                'club_name'   => $validated['club_name'],
                'email'       => $validated['email'],
                'phone'       => $validated['phone'],
                'address'     => $validated['address'] ?? null,
                'postcode'    => $validated['postcode'] ?? null,
                'state_id'    => $validated['state_id'],
                'district_id' => $validated['district_id'],
                'modified_on' => now(),
            ]);

        // Update facilities - first delete existing ones
        $club->facilities()->delete();
        
        // Add new facilities if provided
        if (! empty($validated['facilities'])) {
            foreach ($validated['facilities'] as $f) {
                ClubFacilities::create([
                    'club_id'     => $club->id_club,
                    'facility_id' => $f['facility_id'],
                    'quantity'    => $f['quantity'],
                    'created_at'  => now(),
                    'modified_on' => now(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Club updated successfully',
            'data' => $club
        ]);
    }

    /**
     * Remove the specified club.
     */
    public function destroy(Club $club)
    {
        $club->delete();
        return redirect()->route('clubs.index')
                        ->with('success', 'Club deleted successfully');
    }

    
}
