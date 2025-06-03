<?php

namespace App\Http\Controllers;

use App\Models\SanctionRequest;
use App\Models\SanctionDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SanctionController extends Controller
{
    // 1. List the current user’s own applications
    public function index()
    {
        $mine = SanctionRequest::where('user_id', Auth::id())
                 ->latest()->paginate(10);
        return view('sanction.index', compact('mine'));
    }

    // 2. Show “Apply” form
    public function create()
    {
        return view('sanction.create');
    }

    // 3. Save a new application
    public function store(Request $r)
    {
        $r->validate([
          'tournament_name'=>'required|string',
          'tournament_start_date'=>'required|date',
          'tournament_end_date'   => 'required|date|after_or_equal:tournament_start_date',
          'venue_name'=>'required|string',
          'number_of_courts'=>'required|integer',
          'venue_address'=>'required|string',
          'level'                 => [
            'required',
            'in:State Level Junior (under 18),State Level Adult / Open,National Level Junior (under 18),National Level Adult / Open'
          ],
          'tournament_history'    => 'required|string',
          'documents.*'=>'file|mimes:pdf,jpg,png|max:2048'
        ]);

        // 3a) Create the sanction_request
        $req = SanctionRequest::create(array_merge(
          $r->only([
            'tournament_name','tournament_start_date','tournament_end_date','venue_name',
            'number_of_courts','venue_address','level','tournament_history'
            // `status` will default to 'pending'
          ]),
          ['user_id'=>Auth::id()]
        ));

        // 3b) Upload each document if present
        if($r->hasFile('documents')){
          foreach($r->file('documents') as $file){
            // “public” disk means files go to storage/app/public/…
            $path = $file->store("{$req->id}", 'public');   // e.g. $path = "1/prospectus_city_champ.pdf"
            SanctionDocument::create([
              'sanction_request_id' =>$req->id,
              'type'                =>$file->getClientOriginalExtension(),
              'filename'            =>$file->getClientOriginalName(),
              'path'                =>$path
            ]);
          }
        }

        return redirect()->route('sanction.index')
                         ->with('success','Application has Successfully submitted.');
    }

    // 4. Show details of your own application
    public function show(SanctionRequest $sanction)
    {
        $this->authorize('view', $sanction);
        $sanction->load('documents');
        return view('sanction.show', compact('sanction'));
    }

    // 5. Admin: list ALL applications
    public function adminIndex()
    {
        // Eager-load the `user` relation so that $r->user is never null at view time.
        $all = SanctionRequest::with('user')
        ->latest()
        ->paginate(10);

    return view('sanction.admin.index', compact('all'));
    }

    // 6. Reviewer: form edit status
    public function edit(SanctionRequest $sanction)
    {
        return view('sanction.admin.edit', compact('sanction'));
    }

    // 7. Admin: update status and remarks
    public function update(Request $r, SanctionRequest $sanction)
    {
        $r->validate([
          'status'=>'required|in:approved,rejected',
          'remarks'=>'nullable|string'
        ]);
        $sanction->update($r->only('status','remarks'));
        return redirect()->route('sanctions.admin.index')
                         ->with('success','Status has updated.');
    }
}
