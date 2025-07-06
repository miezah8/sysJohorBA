@extends('layouts.app')
@section('title', $report->name)

@section('breadcrumbParent','Reports')
@section('breadcrumbParentUrl', route('reports.index'))
@section('breadcrumbCurrent', $report->name)

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
      <table class="table table-striped">
        <thead>
          <tr>
            <th>NAME</th>
            <th>IC</th>
            <th>SCHOOL</th>
          </tr>
        </thead>
        <tbody>
          @forelse($rows as $a)
          <tr>
            <td>{{ strtoupper($a->athlete_fname) }}</td>
            <td>{{ $a->user->ic_number }}</td>
            <td>{{ optional($a->school)->school_name }}</td>
          </tr>
          @empty
          <tr><td colspan="3" class="text-center">No athletes found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
