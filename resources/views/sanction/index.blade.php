@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>My Sanction Applications</h4>
  
    <a href="{{ route('sanctions.create') }}"
       class="btn btn-primary">
      <i class="fa-solid fa-file-circle-plus me-1"></i>
      Apply for Sanction
    </a>
  
</div>

<table class="table table-striped">
  <thead>
    <tr>
      <th>#</th>
      <th>Tournament</th>
      <th>Date</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @forelse($mine as $r)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $r->tournament_name }}</td>
        <td>{{ \Carbon\Carbon::parse($r->tournament_date)->format('d M Y') }}</td>
        <td>
          <span class="badge 
            {{ $r->status=='approved' ? 'bg-success' : 
               ($r->status=='rejected' ? 'bg-danger' : 'bg-warning') }}">
            {{ ucfirst($r->status) }}
          </span>
        </td>
        <td>
          <a href="{{ route('sanctions.show', $r) }}"
             class="btn btn-sm btn-info">
            View
          </a>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="5" class="text-center text-muted">
          You have not submitted any sanction applications yet.
        </td>
      </tr>
    @endforelse
  </tbody>
</table>

{{ $mine->links() }}
@endsection
