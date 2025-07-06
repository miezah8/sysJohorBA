<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::orderBy('name')->paginate(15);
        return view('facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('facilities.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255|unique:facilities,name',
            'status' => 'required|in:active,inactive',
        ]);

        $facility = Facility::create($data);

        if ($request->ajax()) {
            return response()->json(['message' => 'Facility created successfully']);
        }
                
        return redirect()
            ->route('facilities.index')
            ->with('success','Facility created.');
    }

    // public function edit(Facility $facility)
    // {
    //     return view('facilities.edit', compact('facility'));
    // }

    public function update(Request $request, Facility $facility)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255|unique:facilities,name,'.$facility->id,
            'status' => 'required|in:active,inactive',
        ]);

        $facility->update($data);

        if ($request->ajax()) {
            return response()->json(['message' => 'Facility updated successfully']);
        }

        return redirect()
            ->route('facilities.index')
            ->with('success','Facility updated.');
    }

    public function destroy(Request $request, Facility $facility)
    {
        $facility->delete();

        if ($request->ajax()) {
            return response()->json(['message' => 'Facility deleted successfully']);
        }

        return redirect()
            ->route('facilities.index')
            ->with('success','Facility deleted.');
    }
}
