@extends('layouts.app')
@section('title','Reports')

@section('content')
  <div class="card p-2">
    <div class="card-header d-flex justify-content-between">
      <h5 class="mb-0">Reports</h5>
    </div>

    <div class="list-group">
      @foreach($reports as $r)
        <div class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong>{{ $r->name }}</strong><br>
            <small>Created by {{ $r->creator->name }} on {{ $r->created_at->format('d M, Y') }}</small>
          </div>
          <div>
            <form action="{{ route('reports.run',$r) }}" method="POST" class="d-inline">
              @csrf
              <button class="btn btn-primary btn-sm">Run</button>
            </form>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
