@extends('layouts.app')
@section('content')
<h4>Review: {{ $sanction->tournament_name }}</h4>
<form action="{{ route('sanctions.update',$sanction) }}" method="POST">
  @csrf @method('PUT')
  <div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <option value="approved">Approve</option>
      <option value="rejected">Reject</option>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Remarks</label>
    <textarea name="remarks" class="form-control">{{ old('remarks',$sanction->remarks) }}</textarea>
  </div>
  <button class="btn btn-primary">Save</button>
</form>
@endsection
