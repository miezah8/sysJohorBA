{{-- resources/views/sanction/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5>Application Details</h5>
    <a href="{{ route('sanction.index') }}" class="btn btn-sm btn-secondary">← Back to My Applications</a>
  </div>
  <div class="card-body">
    <dl class="row">
      <dt class="col-sm-3">Tournament Name</dt>
      <dd class="col-sm-9">{{ $sanction->tournament_name }}</dd>

      <dt class="col-sm-3">Start Date</dt>
      <dd class="col-sm-9">{{ \Carbon\Carbon::parse($sanction->tournament_start_date)->format('d M Y') }}</dd>

      <dt class="col-sm-3">End Date</dt>
      <dd class="col-sm-9">{{ \Carbon\Carbon::parse($sanction->tournament_end_date)->format('d M Y') }}</dd>

      <dt class="col-sm-3">Venue</dt>
      <dd class="col-sm-9">{{ $sanction->venue_name }}</dd>

      <dt class="col-sm-3">Number of Courts</dt>
      <dd class="col-sm-9">{{ $sanction->number_of_courts }}</dd>

      <dt class="col-sm-3">Venue Address</dt>
      <dd class="col-sm-9">{{ $sanction->venue_address }}</dd>

      <dt class="col-sm-3">Level</dt>
      <dd class="col-sm-9">{{ ucfirst(str_replace('_',' ',$sanction->level)) }}</dd>

      <dt class="col-sm-3">Status</dt>
      <dd class="col-sm-9">
        <span class="badge 
          {{ $sanction->status=='approved' ? 'bg-success' : 
             ($sanction->status=='rejected' ? 'bg-danger' : 'bg-warning') }}">
          {{ ucfirst($sanction->status) }}
        </span>
      </dd>

      @if($sanction->remarks)
      <dt class="col-sm-3">Remarks</dt>
      <dd class="col-sm-9">{{ $sanction->remarks }}</dd>
      @endif
    </dl>

    <h6>Documents</h6>
    @if($sanction->documents->isEmpty())
      <p class="text-muted">No documents uploaded.</p>
    @else
      <ul>
        @foreach($sanction->documents as $doc)
          <li>
            <a href="{{ asset('storage/' . $doc->path) }}" target="_blank">
              {{ $doc->filename }}
            </a>
          </li>
        @endforeach
      </ul>
    @endif
  </div>
</div>
@endsection
