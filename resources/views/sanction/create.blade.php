{{-- resources/views/sanction/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <h5>Apply for Tournament Sanction</h5>
  </div>
  <div class="card-body">
    <form action="{{ route('sanctions.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      {{-- Tournament Name --}}
      <div class="mb-3">
        <label for="tournament_name" class="form-label">Tournament Name *</label>
        <input
          type="text"
          id="tournament_name"
          name="tournament_name"
          class="form-control @error('tournament_name') is-invalid @enderror"
          value="{{ old('tournament_name') }}"
          required
        >
        @error('tournament_name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Tournament Date --}}
      <div class="mb-3">
        <label for="tournament_date" class="form-label">Tournament Date *</label>
        <input
          type="date"
          id="tournament_date"
          name="tournament_date"
          class="form-control @error('tournament_date') is-invalid @enderror"
          value="{{ old('tournament_date') }}"
          required
        >
        @error('tournament_date')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Venue Name --}}
      <div class="mb-3">
        <label for="venue_name" class="form-label">Venue Name *</label>
        <input
          type="text"
          id="venue_name"
          name="venue_name"
          class="form-control @error('venue_name') is-invalid @enderror"
          value="{{ old('venue_name') }}"
          required
        >
        @error('venue_name')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Number of Courts --}}
      <div class="mb-3">
        <label for="number_of_courts" class="form-label">Number of Courts *</label>
        <input
          type="number"
          id="number_of_courts"
          name="number_of_courts"
          class="form-control @error('number_of_courts') is-invalid @enderror"
          value="{{ old('number_of_courts') }}"
          min="1"
          required
        >
        @error('number_of_courts')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Venue Address --}}
      <div class="mb-3">
        <label for="venue_address" class="form-label">Venue Address *</label>
        <textarea
          id="venue_address"
          name="venue_address"
          class="form-control @error('venue_address') is-invalid @enderror"
          rows="3"
          required
        >{{ old('venue_address') }}</textarea>
        @error('venue_address')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Level --}}
      <div class="mb-3">
        <label for="level" class="form-label">Level *</label>
        <select
          id="level"
          name="level"
          class="form-select @error('level') is-invalid @enderror"
          required
        >
          <option value="">-- Select Level --</option>
          <option value="state_junior"   {{ old('level')=='state_junior'?'selected':'' }}>State Junior</option>
          <option value="state_adult"    {{ old('level')=='state_adult'   ?'selected':'' }}>State Adult</option>
          <option value="national_junior"{{ old('level')=='national_junior'?'selected':'' }}>National Junior</option>
          <option value="national_adult" {{ old('level')=='national_adult' ?'selected':'' }}>National Adult</option>
        </select>
        @error('level')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      {{-- Supporting Documents --}}
      <div class="mb-3">
        <label for="documents" class="form-label">Supporting Documents (PDF/JPG/PNG)</label>
        <input
          type="file"
          id="documents"
          name="documents[]"
          class="form-control @error('documents.*') is-invalid @enderror"
          multiple
        >
        @error('documents.*')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Submit Application</button>
      <a href="{{ route('sanctions.index') }}" class="btn btn-secondary ms-2">Cancel</a>
    </form>
  </div>
</div>
@endsection
