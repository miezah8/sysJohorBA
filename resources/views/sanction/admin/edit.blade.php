@extends('layouts.app')

@section('content')
  <h4>Review Sanction Application: {{ $sanction->tournament_name }}</h4>

  <div class="card mt-3">
    <div class="card-body">
      
    <dl class="row">
      <dt class="col-sm-3">Tournament Name:</dt>
      <dd class="col-sm-9">{{ $sanction->tournament_name }}</dd>

      <dt class="col-sm-3">Start Date:</dt>
      <dd class="col-sm-9">{{ \Carbon\Carbon::parse($sanction->tournament_start_date)->format('d M Y') }}</dd>

      <dt class="col-sm-3">End Date:</dt>
      <dd class="col-sm-9">{{ \Carbon\Carbon::parse($sanction->tournament_end_date)->format('d M Y') }}</dd>

      <dt class="col-sm-3">Venue:</dt>
      <dd class="col-sm-9">{{ $sanction->venue_name }}</dd>

      <dt class="col-sm-3">Number of Courts:</dt>
      <dd class="col-sm-9">{{ $sanction->number_of_courts }}</dd>

      <dt class="col-sm-3">Venue Address:</dt>
      <dd class="col-sm-9">{{ $sanction->venue_address }}</dd>

      <dt class="col-sm-3">Level:</dt>
      <dd class="col-sm-9">{{ ucfirst(str_replace('_',' ',$sanction->level)) }}</dd>

      <dt class="col-sm-3">Brief History of Tournament:</dt>
      <dd class="col-sm-9">{{ $sanction->tournament_history }}</dd>
    </dl>

    <h6>Documents</h6>
    @if($sanction->documents->isEmpty())
      <p class="text-muted">No documents uploaded.</p>
    @else
      <ul>
        @foreach($sanction->documents as $doc)
          <li>
            <a href="{{ Storage::url($doc->path) }}" target="_blank">
              {{ $doc->filename }}
            </a>
          </li>
        @endforeach
      </ul>
    @endif
  
      <form action="{{ route('sanctions.admin.update', $sanction) }}" method="POST">
        @csrf 
        @method('PUT')

        <div class="mb-3">
          <label class="form-label">Status</label>
          <select name="status" class="form-select @error('status') is-invalid @enderror">
            <option value="">-- Choose --</option>
            <option value="approved" {{ $sanction->status=='approved' ? 'selected':'' }}>Approve</option>
            <option value="rejected" {{ $sanction->status=='rejected' ? 'selected':'' }}>Reject</option>
          </select>
          @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Remarks (optional)</label>
          <textarea name="remarks" class="form-control @error('remarks') is-invalid @enderror" rows="3">{{ old('remarks', $sanction->remarks) }}</textarea>
          @error('remarks')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button class="btn btn-primary">Save Decision</button>
        <a href="{{ route('sanctions.admin.index') }}" class="btn btn-secondary ms-2">Cancel</a>
      </form>
    </div>
  </div>
  
@endsection
