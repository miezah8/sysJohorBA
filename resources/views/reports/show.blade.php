@extends('layouts.app')
@section('title','New Report')
@section('content')
<form action="{{ route('reports.store') }}" method="POST" class="card p-4">
  @csrf
  <div class="mb-3">
    <label class="form-label">Report Name</label>
    <input name="name" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Parameters (JSON)</label>
    <textarea name="parameters" class="form-control" rows="3"></textarea>
  </div>
  <button class="btn btn-success">Save</button>
</form>
@endsection
