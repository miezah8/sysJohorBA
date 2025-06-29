@extends('layouts.app')
@section('title', 'Athlete Module Form')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h4 class="mb-0">Athlete Registration</h4>
  </div>
  <div class="card-body">
    <form id="athleteForm" action="{{ route('athlete.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      {{-- Switch to invite multiple athletes --}}
      {{--<div class="form-check form-switch mb-4">
        <input class="form-check-input" type="checkbox" role="switch" id="switchMode">
        <label class="form-check-label" for="switchMode">Invite Athlete</label>
      </div>--}}

      {{-- Multiple Invite Form --}}
      <div id="formMultiple" class="d-none">
        <div class="multi-row">
          <div class="row align-items-end mb-2 athlete-row">
            <div class="col-md-4">
              <label class="form-label required">Name</label>
              <input type="text" class="form-control" name="firstName[]">
            </div>
            <div class="col-md-3">
              <label class="form-label required">Email</label>
              <input type="email" class="form-control" name="email[]">
            </div>
            <div class="col-md-3">
              <label class="form-label required">Phone Number</label>
              <input type="tel" class="form-control" name="phone[]">
            </div>
            <div class="col-md-2 d-flex align-items-end">
              <button type="button" class="btn btn-danger w-100 removeRow">Remove</button>
            </div>
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-md-2 offset-md-10 text-end">
            <button type="button" id="addRow" class="btn btn-outline-primary">
              <i class="fa-solid fa-plus me-1"></i> Invite Athlete
            </button>
          </div>
        </div>
      </div>

      {{-- Single Athlete: Multi-step Tabs --}}
      <div id="formSingle">
        <ul class="nav nav-tabs" id="athleteTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button">Personal Info</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="guardian-tab" data-bs-toggle="tab" data-bs-target="#guardian" type="button">Guardian Info</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="school-tab" data-bs-toggle="tab" data-bs-target="#school" type="button">School Info</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="experience-tab" data-bs-toggle="tab" data-bs-target="#experience" type="button">Achievements</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="coach-tab" data-bs-toggle="tab" data-bs-target="#coach" type="button">Coach & Club Info</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="declaration-tab" data-bs-toggle="tab" data-bs-target="#declaration" type="button">Declaration</button>
          </li>
        </ul>

        <div class="tab-content pt-3">
          {{-- Personal Info --}}
          <div class="tab-pane fade show active" id="personal" role="tabpanel">
            @php
              // split the name into first and last
              [$first] = [auth()->user()->name];
            @endphp
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label required">Full Name</label>
                <input type="text" class="form-control" name="firstname" value="{{ old('firstname',$first) }}" readonly>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">No. IC/Passport</label>
                <input type="text" class="form-control" name="idNumber" value="{{ old('idNumber', auth()->user()->ic_number) }}">
                @error('idNumber')<div class="text-danger">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label required">Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', auth()->user()->email) }}" readonly>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">Phone Number</label>
                <input type="tel" class="form-control" name="phone" value="{{ old('phone', auth()->user()->contact_no) }}">
                @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label d-block required">Gender</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="Male" value="M" {{ old('gender')=='M'?'checked':'' }}>
                  <label class="form-check-label" for="Male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="Female" value="F" {{ old('gender')=='F'?'checked':'' }}>
                  <label class="form-check-label" for="Female">Female</label>
                </div>
                @error('gender')<div class="text-danger">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label d-block required">Race</label>
                @foreach(['Malay','Cina','India','Others'] as $race)
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="race" id="race_{{ $race }}" value="{{ $race }}" {{ old('race')==$race?'checked':'' }}>
                    <label class="form-check-label" for="race_{{ $race }}">{{ $race }}</label>
                  </div>
                @endforeach
                @error('race')<div class="text-danger">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label required">Nationality</label>
                <select name="citizens" class="form-select select2">
                  <option value="">-- Select Country --</option>
                  @foreach($nationalities as $id=>$name)
                    <option value="{{ $id }}" {{ old('citizens')==$id?'selected':'' }}>{{ $name }}</option>
                  @endforeach
                </select>
                @error('citizens')<div class="text-danger">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-12 mb-3">
                <label class="form-label required">Address</label>
                <textarea name="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                @error('address')<div class="text-danger">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-4 mb-3">
                <label class="form-label required">Postcode</label>
                <input type="text" name="postcode" class="form-control" value="{{ old('postcode') }}">
                @error('postcode')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label required">State</label>
                <select id="schA_state" name="sch_state" class="form-select select2">
                  <option value="">-- Select State --</option>
                  @foreach($states as $id=>$nm)
                    <option value="{{ $id }}" {{ old('sch_state')==$id?'selected':'' }}>{{ $nm }}</option>
                  @endforeach
                </select>
                @error('sch_state')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label required">District</label>
                <select id="daerahDropdown" name="districts" class="form-select select2">
                  <option value="">-- Select District --</option>
                  @foreach($districts as $id=>$nm)
                    <option value="{{ $id }}" {{ old('districts')==$id?'selected':'' }}>{{ $nm }}</option>
                  @endforeach
                </select>
                @error('districts')<div class="text-danger">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-6 text-end">
                <button type="button" class="btn btn-primary" data-next="#guardian-tab">Next</button>
              </div>
            </div>
          </div>

          {{-- Guardian Info --}}
          <div class="tab-pane fade" id="guardian" role="tabpanel">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label required">Guardian Name</label>
                <input type="text" name="GuardianName" class="form-control" value="{{ old('GuardianName') }}">
                @error('GuardianName')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">Guardian Phone</label>
                <input type="text" name="GuardianPhone" class="form-control" value="{{ old('GuardianPhone') }}">
                @error('GuardianPhone')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">Occupation</label>
                <input type="text" name="GuardianOccup" class="form-control" value="{{ old('GuardianOccup') }}">
                @error('GuardianOccup')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">Relation</label>
                <select name="GuardianRelation" class="form-select select2">
                  <option value="">-- Select Relation --</option>
                  <option value="Parent" {{ old('GuardianRelation')=='Parent'?'selected':'' }}>Parent</option>
                  <option value="Siblings" {{ old('GuardianRelation')=='Siblings'?'selected':'' }}>Siblings</option>
                  <option value="Guardian" {{ old('GuardianRelation')=='Guardian'?'selected':'' }}>Guardian</option>
                </select>
                @error('GuardianRelation')<div class="text-danger">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-6 text-start">
                <button type="button" class="btn btn-secondary" data-next="#personal-tab">Prev</button>
              </div>
              <div class="col-md-6 text-end">
                <button type="button" class="btn btn-primary" data-next="#school-tab">Next</button>
              </div>
            </div>
          </div>

          {{-- School Info --}}
          <div class="tab-pane fade" id="school" role="tabpanel">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label required">School Name</label>
                <select name="schoolDropdown" class="form-select select2" id="schoolDropdown">
                  <option value="">-- Select School --</option>
                  @foreach($schools as $id=>$nm)
                    <option value="{{ $id }}" {{ old('schoolDropdown')==$id?'selected':'' }}>{{ $nm }}</option>
                  @endforeach
                </select>
                @error('schoolDropdown')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">School Code</label>
                <input type="text" class="form-control" id="CodeScholl" readonly>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">School Address</label>
                <textarea class="form-control" rows="3" id="AddressSchool" readonly></textarea>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">Postcode</label>
                <input type="text" class="form-control" id="PosKod" readonly>
              </div>
              <div class="col-md-6 text-start">
                <button type="button" class="btn btn-secondary" data-next="#guardian-tab">Prev</button>
              </div>
              <div class="col-md-6 text-end">
                <button type="button" class="btn btn-primary" data-next="#experience-tab">Next</button>
              </div>
            </div>
          </div>

          {{-- Achievements --}}
          <div class="tab-pane fade" id="experience" role="tabpanel">
            <div class="table-responsive mb-3">
              <table class="table">
                <thead><tr>
                  <th>Tournament</th><th>Stage</th><th>Category</th><th>Achieve</th><th>Year</th><th></th>
                </tr></thead>
                <tbody id="experienceTableBody">
                  <tr>
                    <td><input type="text" name="tournament[]" class="form-control" value="{{ old('tournament.0') }}"></td>
                    <td>
                      <select name="ranking[]" class="form-select select2">
                        <option value="">-- Stage --</option>
                        @foreach([1=>'Sekolah',2=>'Daerah/Zon',3=>'Negeri',4=>'Kebangsaan',5=>'Antarabangsa'] as $v=>$label)
                          <option value="{{ $v }}" {{ old('ranking.0')==$v?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select name="category[]" class="form-select select2">
                        <option value="">-- Category --</option>
                        @foreach(['MS'=>'MS','WS'=>'WS','MD'=>'MD','WD'=>'WD','MXD'=>'MXD'] as $v=>$label)
                          <option value="{{ $v }}" {{ old('category.0')==$v?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select name="achieve[]" class="form-select select2">
                        <option value="">-- Achieve --</option>
                        @foreach($achievement as $id=>$nm)
                          <option value="{{ $id }}" {{ old('achieve.0')==$id?'selected':'' }}>{{ $nm }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td><input type="number" name="year[]" class="form-control" value="{{ old('year.0') }}"></td>
                    <td class="text-center"><button type="button" class="btn btn-sm btn-danger btnRemoveExperience">×</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="mb-3 text-end">
              <button type="button" class="btn btn-outline-primary btnAddExperience">
                <i class="fa-solid fa-plus me-1"></i> Add
              </button>
            </div>

            <div class="row">
              <div class="col-md-6 text-start">
                <button type="button" class="btn btn-secondary" data-next="#school-tab">Prev</button>
              </div>
              <div class="col-md-6 text-end">
                <button type="button" class="btn btn-primary" data-next="#coach-tab">Next</button>
              </div>
            </div>
          </div>

          {{-- Coach & Club --}}
          <div class="tab-pane fade" id="coach" role="tabpanel">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label required">Coach</label>
                <select name="coachSelect" class="form-select select2">
                  <option value="">-- Select Coach --</option>
                  @foreach($coaches as $id=>$nm)
                    <option value="{{ $id }}" {{ old('coachSelect')==$id?'selected':'' }}>{{ $nm }}</option>
                  @endforeach
                </select>
                @error('coachSelect')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">Club</label>
                <select name="clubSelect" class="form-select select2">
                  <option value="">-- Select Club --</option>
                  @foreach($clubs as $id=>$nm)
                    <option value="{{ $id }}" {{ old('clubSelect')==$id?'selected':'' }}>{{ $nm }}</option>
                  @endforeach
                </select>
                @error('clubSelect')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 text-start">
                <button type="button" class="btn btn-secondary" data-next="#experience-tab">Prev</button>
              </div>
              <div class="col-md-6 text-end">
                <button type="button" class="btn btn-primary" data-next="#declaration-tab">Next</button>
              </div>
            </div>
          </div>

          {{-- Declaration & Submit --}}
          <div class="tab-pane fade text-center" id="declaration" role="tabpanel">
            <div class="form-check mt-3 mb-3">
              <input class="form-check-input" type="checkbox" name="declaration" id="declarationCheck" {{ old('declaration')?'checked':'' }}>
              <label class="form-check-label" for="declarationCheck">
                I hereby declare that the information provided is true and correct.
              </label>
              @error('declaration')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-success">Submit Registration</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.17/css/intlTelInput.min.css" />
<style>
  .required::after { content: " *"; color: red; }
  .is-invalid { border-color: red !important; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // AJAX load for states/districts
  function loadDistricts() {
    const stateId = $('#schA_state').val();
    const $ddl = $('#daerahDropdown');
    $ddl.prop('disabled', true).html('<option>Loading...</option>');
    $.get("{{ route('districts.list') }}", { state_id: stateId }, function(data) {
      $ddl.html('<option value="">-- Select District --</option>');
      $.each(data, function(id,name){ $ddl.append(new Option(name,id)); });
      $ddl.prop('disabled', false);
    });
  }
  $(document).ready(function(){
    // initial
    loadDistricts();
    // on state change
    $('#schA_state').on('change', loadDistricts);

    // Next/Prev tab navigation
    $('button[data-next]').click(function(){
      const target = $(this).data('next');
      $(`#athleteTabs button[id="${target}"]`).click();
    });

    // multiple invite logic
    $('#addRow').click(function(){
      const $clone = $('.athlete-row').first().clone();
      $clone.find('input').val('');
      $('.multi-row').append($clone);
    });
    $(document).on('click','.removeRow',function(){
      if($('.athlete-row').length>1) $(this).closest('.athlete-row').remove();
    });

    // experience rows
    $('.btnAddExperience').click(function(){
      const $row = $('#experienceTableBody tr:first').clone();
      $row.find('input,select').val('');
      $('#experienceTableBody').append($row);
    });
    $(document).on('click','.btnRemoveExperience',function(){
      if($('#experienceTableBody tr').length>1) $(this).closest('tr').remove();
    });
  });
</script>
@endpush
