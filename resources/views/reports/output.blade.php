@extends('layouts.app')
@section('title',$report->name)

@section('content')
  <div class="card p-2">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5>{{ $report->name }}</h5>
    <div>
      {{-- Export CSV --}}
      <form action="{{ route('reports.export', $report) }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-success btn-sm">
          Export CSV
        </button>
      </form>

      {{-- Back to Reports Index --}}
      <a href="{{ route('reports.index') }}"
         class="btn btn-secondary btn-sm ms-2">
        Back
      </a>
    </div>
  </div>

    <div class="table-responsive">
      @if($registrations->isEmpty())
        <p class="text-center text-muted mt-4">No data for this period.</p>
      @else
        <table class="table table-flush" id="datatable-search">
          <thead>
            <tr>
              <th>No</th>
              <th>Name</th>
              <th>Email</th>
              <th>Registered At</th>
            </tr>
          </thead>
          <tbody>
            @foreach($registrations as $i => $u)
              <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->created_at->format('d M, Y H:i') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    new simpleDatatables.DataTable("#datatable-search", {
      searchable: true,
      fixedHeight: true,
    });
  </script>
@endpush
