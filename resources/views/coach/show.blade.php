{{-- resources/views/coach/show.blade.php --}}
@extends('layouts.app')
@section('title','Coach Details')

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>Coach Details</h4>
    </div>
    <div class="card-body">
      @php
        $detail = $coach->userDetail;
      @endphp

      {{-- Personal Info --}}
      <h5>Personal Info</h5>
      <dl class="row">
        <dt class="col-sm-3">Profile Picture</dt>
        <dd class="col-sm-9">
          @if(optional($coach->userDetail)->profile_picture)
            <img src="{{ asset('storage/'.$detail->profile_picture) }}"
                 class="img-thumbnail" width="150" alt="Profile">
          @else
            <em>— none —</em>
          @endif
        </dd>

        <dt class="col-sm-3">Name</dt>
        <dd class="col-sm-9">{{ $coach->coach_fname }}</dd>

        <dt class="col-sm-3">IC / Passport No.</dt>
        <dd class="col-sm-9">{{  optional($coach->userDetail)->ic_no }}</dd>

        <dt class="col-sm-3">IC / Passport Copy</dt>
        <dd class="col-sm-9">
          @if( optional($coach->userDetail)->ic_picture)
            <a href="{{ asset('storage/'.$detail->ic_picture) }}" target="_blank">View Upload</a>
          @else
            <em>— none —</em>
          @endif
        </dd>

        <dt class="col-sm-3">Email</dt>
        <dd class="col-sm-9">{{ optional($coach->user)->email }}</dd>

        <dt class="col-sm-3">Phone</dt>
        <dd class="col-sm-9">{{ optional($coach->user)->contact_no }}</dd>

        <dt class="col-sm-3">Gender</dt>
        <dd class="col-sm-9">
          {{ optional($detail)->gender === 'M' ? 'Male' : (optional($detail)->gender === 'F' ? 'Female' : '–') }}
        </dd>

        <dt class="col-sm-3">Race</dt>
        <dd class="col-sm-9">{{ ucfirst(optional($detail)->race) }}</dd>

        <dt class="col-sm-3">Nationality</dt>
        <dd class="col-sm-9">
          {{ optional($detail)->nationalityRelation->nationality_name ?? optional($detail)->nationality ?? '–' }}
        </dd>

        <dt class="col-sm-3">Address</dt>
        <dd class="col-sm-9">{{ optional($detail)->address }}</dd>

        <dt class="col-sm-3">Postcode / State / District</dt>
        <dd class="col-sm-9">
          {{ optional($detail)->postcode }}
          {{ optional($detail)->state->state_name ?? '–' }}
          {{ optional($detail)->district->district_name ?? '–' }}
        </dd>
      </dl>

      <hr>

      {{-- Academic --}}
      <h5>Academic Qualifications</h5>
      @if($coach->educations->isEmpty())
        <p><em>No qualifications recorded.</em></p>
      @else
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Qualification</th>
                <th>Institution</th>
                <th>Year</th>
              </tr>
            </thead>
            <tbody>
              @foreach($coach->educations as $edu)
                <tr>
                  <td>{{ $edu->education_level }}</td>
                  <td>{{ optional($edu->institution)->ipt_name ?? '–' }}</td>
                  <td>{{ $edu->year }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif

      <hr>

      {{-- Experience --}}
      <h5>Coaching Experience</h5>
      @if($coach->coachExperience->isEmpty())
        <p><em>No experience recorded.</em></p>
      @else
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Activity/Competition</th>
                <th>Position</th>
                <th>Level</th>
                <th>Organized By</th>
                <th>Start Date</th>
                <th>End Date</th>
              </tr>
            </thead>
            <tbody>
              @foreach($coach->coachExperience as $exp)
                <tr>
                  <td>{{ $exp->activity }}</td>
                  <td>{{ $exp->position ?? '–' }}</td>
                  <td>{{ $exp->level ?? '–' }}</td>
                  <td>{{ $exp->organized_by ?? '–' }}</td>
                  <td>{{ $exp->start_date }}</td>
                  <td>{{ $exp->end_date }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif

      <hr>

      {{-- Qualifications / Courses --}}
      <h5>Certificates & Courses</h5>
      @if($coach->coachCourse->isEmpty())
        <p><em>No courses/certifications recorded.</em></p>
      @else
        <div class="table-responsive">
          <table class="table table-sm">
            <thead>
              <tr>
                <th>Course</th>
                <th>Level</th>
                <th>Date Passed</th>
                <th>Accreditation</th>
                <th>Certificate No.</th>
                <th>Attachment</th>
              </tr>
            </thead>
            <tbody>
              @foreach($coach->coachCourse as $c)
                <tr>
                  <td>{{ optional($c->course)->course_name ?? '–' }}</td>
                  <td>{{ $c->course_level ?? '–' }}</td>
                  <td>{{ $c->pass_date ?? '–' }}</td>
                  <td>{{ $c->recognition ?? '–' }}</td>
                  <td>{{ $c->cert_siri ?? '–' }}</td>
                  <td>
                    @if($c->cert_attach)
                      <a href="{{ asset('storage/'.$c->cert_attach) }}" target="_blank">View</a>
                    @else
                      <em>— none —</em>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif

      <hr>

      {{-- Club --}}
      <h5>Club</h5>
      <dl class="row">
        <dt class="col-sm-3">Club</dt>
        <dd class="col-sm-9">{{ optional($coach->club)->club_name ?? '–' }}</dd>
      </dl>

    </div>

    <div class="card-footer text-end">
      <a href="{{ route('coach.index') }}" class="btn btn-secondary btn-sm">Back to list</a>
      <a href="{{ route('coach.edit', $coach->id_coach) }}" class="btn btn-primary btn-sm">Edit</a>
    </div>
  </div>
@endsection
