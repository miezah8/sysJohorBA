@extends('layouts.app')
@section('title',"Players in {$club->club_name}")

@section('content')
  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <h5>Players in “{{ $club->club_name }}”</h5>
      <a href="{{ route('clubs.index') }}" class="btn btn-sm btn-secondary">← Back to Clubs</a>
    </div>
    <div class="card-body">
      @if($players->count())
        <table class="table">
          <thead>
            <tr><th>#</th><th>First Name</th><th>Last Name</th><!-- … --></tr>
          </thead>
          <tbody>
            @foreach($players as $i => $p)
              <tr>
                <td>{{ $i + $players->firstItem() }}</td>
                <td>{{ $p->athlete_fname }}</td>
                <td>{{ $p->athlete_lname }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
        {{ $players->links() }}
      @else
        <p>No players in this club yet.</p>
      @endif
    </div>
  </div>
@endsection
@push('css')
    <style>


        td {
            font-size: 0.875em;
        }

        .text-danger {
            color: #f44336 !important;
        }
    </style>
@endpush
