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
        <form action="{{ route('reports.export', $report) }}"
              method="POST" class="d-inline">
          @csrf
          <button class="btn btn-success btn-sm">Export CSV</button>
        </form>
        <a href="{{ route('reports.index') }}"
           class="btn btn-secondary btn-sm ms-2">Back</a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-striped mb-0">
        <thead>
          <tr>
            <th>Year</th>
            <th>Sanction Level</th>
            <th class="text-end"># Applications</th>
          </tr>
        </thead>
        <tbody>
          @forelse($rows as $row)
          <tr>
            <td>{{ $row->year }}</td>
            <td>{{ $row->level }}</td>
            <td class="text-end">{{ $row->total }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="3" class="text-center">No data found.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection
