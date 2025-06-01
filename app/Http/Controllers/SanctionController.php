<?php

namespace App\Http\Controllers;

use App\Models\SanctionRequest;
use App\Models\SanctionDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SanctionController extends Controller
{
    // 1. List permohonan sendiri
    public function index()
    {
        $mine = SanctionRequest::where('user_id', Auth::id())
                 ->latest()->paginate(10);
        return view('sanction.index', compact('mine'));
    }

    // 2. Form apply
    public function create()
    {
        return view('sanction.create');
    }

    // 3. Simpan permohonan
    public function store(Request $r)
    {
        $r->validate([
          'tournament_name'=>'required|string',
          'tournament_date'=>'required|date',
          'venue_name'=>'required|string',
          'number_of_courts'=>'required|integer',
          'venue_address'=>'required|string',
          'level'=>'required|in:state_junior,state_adult,national_junior,national_adult',
          'documents.*'=>'file|mimes:pdf,jpg,png|max:2048'
        ]);

        $req = SanctionRequest::create(array_merge(
          $r->only([
            'tournament_name','tournament_date','venue_name',
            'number_of_courts','venue_address','level'
          ]),
          ['user_id'=>Auth::id()]
        ));

        // Upload dokumen
        if($r->hasFile('documents')){
          foreach($r->file('documents') as $file){
            $path = $file->store("sanction/{$req->id}");
            SanctionDocument::create([
              'sanction_request_id'=>$req->id,
              'type'=>$file->getClientOriginalExtension(),
              'filename'=>$file->getClientOriginalName(),
              'path'=>$path
            ]);
          }
        }

        return redirect()->route('sanction.index')
                         ->with('success','Permohonan dihantar.');
    }

    // 4. Lihat detail sendiri
    public function show(SanctionRequest $sanction)
    {
        $this->authorize('view', $sanction);
        $sanction->load('documents');
        return view('sanction.show', compact('sanction'));
    }

    // 5. Reviewer: semak semua permohonan
    public function adminIndex()
    {
        $all = SanctionRequest::latest()->paginate(10);
        return view('sanction.admin.index', compact('all'));
    }

    // 6. Reviewer: form edit status
    public function edit(SanctionRequest $sanction)
    {
        return view('sanction.admin.edit', compact('sanction'));
    }

    // 7. Reviewer: update status
    public function update(Request $r, SanctionRequest $sanction)
    {
        $r->validate([
          'status'=>'required|in:approved,rejected',
          'remarks'=>'nullable|string'
        ]);
        $sanction->update($r->only('status','remarks'));
        return redirect()->route('sanction.admin.index')
                         ->with('success','Status dikemas kini.');
    }
}
