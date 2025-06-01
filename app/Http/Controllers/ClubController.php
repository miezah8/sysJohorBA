<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubFacilities;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view club')->only(['index','show','players']);
        $this->middleware('permission:add club')->only(['create','store']);
        $this->middleware('permission:edit club')->only(['edit','update']);
        $this->middleware('permission:delete club')->only('destroy');
    }
    /**
     * Display a listing of clubs.
     */
    public function index()
    {
        $clubs = Club::withCount('athletes')->get();
        return view('clubs.index', compact('clubs'));
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
        $validated = $request->validate([
            'club_name' => 'required|string|max:255|unique:club',
            'sys_id' => 'nullable|string|max:50',
            'facilities' => 'sometimes|array'
        ]);

        $club = Club::create([
            'club_name' => $validated['club_name'],
            'sys_id' => $validated['sys_id'] ?? null,
            'created_at' => now(),
            'modified_on' => now()
        ]);

        // Save facilities if provided
        if ($request->has('facilities')) {
            foreach ($request->facilities as $facility) {
                if (!empty($facility['type'])) {
                    ClubFacilities::create([
                        'club_id' => $club->id_club,
                        'facility_type' => $facility['type'],
                        'quantity' => $facility['quantity'] ?? 1,
                        'created_at' => now(),
                        'modified_on' => now()
                    ]);
                }
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
                'club_name' => 'required|string|max:255|unique:club,club_name,'.$club->id_club.',id_club',
                'sys_id' => 'nullable|string|max:50',
                'facilities' => 'sometimes|array'
            ]);

            $club->update([
                'club_name' => $validated['club_name'],
                'sys_id' => $validated['sys_id'] ?? null,
                'modified_on' => now()
            ]);

        // Update facilities - first delete existing ones
        $club->facilities()->delete();
        
        // Add new facilities if provided
        if ($request->has('facilities')) {
            foreach ($request->facilities as $facility) {
                if (!empty($facility['type'])) {
                    ClubFacilities::create([
                        'club_id' => $club->id_club,
                        'facility_type' => $facility['type'],
                        'quantity' => $facility['quantity'] ?? 1,
                        'created_at' => now(),
                        'modified_on' => now()
                    ]);
                }
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
