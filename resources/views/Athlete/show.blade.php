@extends('layouts.app')
@section('title', 'Athlete Details')

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Athlete Details</h4>
    </div>
    <div class="card-body">

    @php
      $detail = $athlete->user->detail; 
    @endphp

      {{-- Personal Info --}}
      <h5>Personal Info</h5>
      <dl class="row">

        <dt class="col-sm-3">Profile Picture</dt>
        <dd class="col-sm-9">
          @if($detail->profile_picture)
            <img src="{{ asset('storage/'.$detail->profile_picture) }}" 
                class="img-thumbnail" width="150" alt="Profile">
          @else
            <em>— none —</em>
          @endif
        </dd>

        <dt class="col-sm-3">Name</dt>
        <dd class="col-sm-9">{{ $athlete->athlete_fname }}</dd>

        <dt class="col-sm-3">IC / Passport</dt>
        <dd class="col-sm-9">{{ $athlete->ic_number }}</dd>

        <dt class="col-sm-3">IC / Passport Copy</dt>
        <dd class="col-sm-9">
          @if($detail->ic_picture)
            <a href="{{ asset('storage/'.$detail->ic_picture) }}" target="_blank">View Upload</a>
          @else
            <em>— none —</em>
          @endif
        </dd>

        <dt class="col-sm-3">Phone</dt>
        <dd class="col-sm-9">{{ $detail->contact_no }}</dd>

        <dt class="col-sm-3">Email</dt>
        <dd class="col-sm-9">{{ $athlete->user->email }}</dd>

        <dt class="col-sm-3">Gender</dt>
        <dd class="col-sm-9">{{ $athlete->gender === 'M' ? 'Male' : 'Female' }}</dd>

        <dt class="col-sm-3">Race</dt>
        <dd class="col-sm-9">{{ ucfirst($detail->race) }}</dd>

        <dt class="col-sm-3">Nationality</dt>
        <dd class="col-sm-9">{{ $detail->nationality->nationality_name ?? '–' }}</dd>

        <dt class="col-sm-3">Address</dt>
        <dd class="col-sm-9">{{ $detail->address }}</dd>

        <dt class="col-sm-3">Postcode / State / District</dt>
        <dd class="col-sm-9">
          {{ $detail->postcode }} 
          {{ $detail->state->state_name ?? '–' }} 
          {{ $detail->district->district_name ?? '–' }}
        </dd>

        <dt class="col-sm-3">T-Shirt Size</dt>
        <dd class="col-sm-9">{{ $athlete->tshirt_size }}</dd>

        <dt class="col-sm-3">Name on Tshirt</dt>
        <dd class="col-sm-9">{{ $athlete->shirt_name }}</dd>
      </dl>

      <hr>

      {{-- Guardian Info --}}
      <h5>Guardian Info</h5>
      @if($athlete->guardian)
        <dl class="row">
          <dt class="col-sm-3">Name</dt>
          <dd class="col-sm-9">{{ $athlete->guardian->name }}</dd>

          <dt class="col-sm-3">Phone</dt>
          <dd class="col-sm-9">{{ $athlete->guardian->phone }}</dd>

          <dt class="col-sm-3">Occupation</dt>
          <dd class="col-sm-9">{{ $athlete->guardian->occupation }}</dd>

          <dt class="col-sm-3">Relation</dt>
          <dd class="col-sm-9">{{ $athlete->guardian->relation }}</dd>
        </dl>
      @else
        <p><em>No guardian recorded.</em></p>
      @endif

      <hr>

      {{-- School Info --}}
      <h5>School Info</h5>
      @if($athlete->school)
        <dl class="row">
          <dt class="col-sm-3">Name</dt>
          <dd class="col-sm-9">{{ $athlete->school->school_name }}</dd>

          <dt class="col-sm-3">Code</dt>
          <dd class="col-sm-9">{{ $athlete->school->sch_code }}</dd>

          <dt class="col-sm-3">Address</dt>
          <dd class="col-sm-9">{{ $athlete->school->sc_address }}</dd>

          <dt class="col-sm-3">Postcode / State / District</dt>
          <dd class="col-sm-9">
            {{ $athlete->school->postcode }} 
            {{ $athlete->school->state_name }} 
            {{ $athlete->school->district_name }}
          </dd>
        </dl>
      @else
        <p><em>No school recorded.</em></p>
      @endif

      <hr>

      {{-- Achievements / Experience --}}
      <h5>Achievements</h5>
      @if($athlete->experiences->isEmpty())
        <p><em>No achievements recorded.</em></p>
      @else
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Tournament</th>
                <th>Stage</th>
                <th>Category</th>
                <th>Result</th>
                <th>Year</th>
              </tr>
            </thead>
            <tbody>
              @foreach($athlete->experiences as $exp)
                <tr>
                  <td>{{ $exp->tournament }}</td>
                  <td>
                    @switch($exp->ranking)
                      @case(1) School @break
                      @case(2) District / Zone @break
                      @case(3) State @break
                      @case(4) National @break
                      @case(5) International @break
                    @endswitch
                  </td>
                  <td>{{ $exp->category }}</td>
                  <td>{{ $exp->achievement->achieve_bi /* map via achievement lookup */ }}</td>
                  <td>{{ $exp->year }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif

      <hr>

      {{-- Coach & Club --}}
      <h5>Coach & Club</h5>
      <dl class="row">
        <dt class="col-sm-3">Coach</dt>
        <dd class="col-sm-9">
          {{ optional($athlete->coach)->coach_fname ?? '–' }}
        </dd>

        <dt class="col-sm-3">Club</dt>
        <dd class="col-sm-9">
          {{ optional($athlete->club)->club_name ?? '–' }}
        </dd>
      </dl>

    </div>

    <div class="card-footer text-end">
      <a href="{{ route('athlete.index') }}" class="btn btn-secondary btn-sm">Back to list</a>
      <a href="{{ route('athlete.edit', $athlete) }}" class="btn btn-primary btn-sm">Edit</a>
    </div>
  </div>
@endsection
