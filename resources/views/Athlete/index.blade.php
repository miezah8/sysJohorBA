@extends('layouts.app')
@section('title','Athlete Module')

@section('content')
  <div class="card">
    <div class="card-header d-flex justify-content-between">
      <h5>List of Athletes</h5>
      {{-- now this matches athlete.create --}}
      <a href="{{ route('athlete.create') }}" class="btn btn-behance">
        <i class="fa-solid fa-plus me-1"></i> Add Athlete
      </a>
    </div>
    <div class="table-responsive">
      <table class="table table-flush" id="datatable-search">
        <thead class="thead-light">
          <tr>
            <th>No</th>
            <th>Athlete Name</th>
            <th>Club</th>
            <th>School</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($athleteData as $i => $a)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>{{ $a->full_name }}</td>
              <td>{{ $a->club_name }}</td>
              <td>{{ $a->school_name }}</td>
              <td>
                {{-- View button --}}
                <a href="{{ route('athlete.show',$a->id_athlete) }}"
                   class="btn btn-outline-secondary btn-sm me-1">
                  <i class="fa-solid fa-eye me-1"></i> View
                </a>

                {{-- Edit button --}}
                <a href="{{ route('athlete.edit',$a->id_athlete) }}"
                   class="btn btn-outline-info btn-sm">
                  <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  new simpleDatatables.DataTable("#datatable-search",{searchable:true,fixedHeight:true});
</script>
@endpush
