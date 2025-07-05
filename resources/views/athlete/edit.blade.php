@extends('layouts.app')
@section('title','Edit Athlete')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between">
    <h4 class="mb-0">Edit Athlete</h4>
  </div>
  <div class="card-body">
    <form id="athleteForm"
          action="{{ route('athlete.update',$athlete) }}"
          method="POST"
          enctype="multipart/form-data">
      @csrf
      @method('PUT')

      {{-- Tabs --}}
      <ul class="nav nav-tabs" id="athleteTabs" role="tablist">
        <li class="nav-item"><button class="nav-link active"    id="personal-tab"      data-bs-toggle="tab" data-bs-target="#personal">Personal Info</button></li>
        <li class="nav-item"><button class="nav-link"           id="guardian-tab"      data-bs-toggle="tab" data-bs-target="#guardian">Guardian Info</button></li>
        <li class="nav-item"><button class="nav-link"           id="school-tab"        data-bs-toggle="tab" data-bs-target="#school">School Info</button></li>
        <li class="nav-item"><button class="nav-link"           id="experience-tab"    data-bs-toggle="tab" data-bs-target="#experience">Achievements</button></li>
        <li class="nav-item"><button class="nav-link"           id="coach-tab"         data-bs-toggle="tab" data-bs-target="#coach">Coach & Club Info</button></li>
        <li class="nav-item"><button class="nav-link"           id="declaration-tab"   data-bs-toggle="tab" data-bs-target="#declaration">Declaration</button></li>
      </ul>

      <div class="tab-content pt-3">
        {{-- PERSONAL INFO --}}
        <div class="tab-pane fade show active" id="personal" role="tabpanel">
          <div class="row">
            {{-- Full Name --}}
            <div class="col-md-6 mb-3">
              <label class="form-label required">Full Name</label>
              <input type="text" name="firstname"
                     class="form-control"
                     value="{{ old('firstname',$athlete->athlete_fname) }}">
            </div>
            {{-- Profile Picture --}}
            <div class="col-md-6 mb-3">
              <label class="form-label">Profile Picture</label>
              <input type="file" name="profile_picture" class="form-control" accept="image/*">
              @if($athlete->user->detail->profile_picture)
                <small>Current: 
                  <a href="{{ asset('storage/'.$athlete->user->detail->profile_picture) }}" target="_blank">view</a>
                </small>
              @endif
              @error('profile_picture')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            {{-- IC/Passport # --}}
            <div class="col-md-6 mb-3">
              <label class="form-label required">No. IC/Passport</label>
              <input type="text" name="idNumber"
                     class="form-control"
                     value="{{ $athlete->user->ic_number }}"
                     >
            </div>
            {{-- IC/Passport upload --}}
            <div class="col-md-6 mb-3">
              <label class="form-label">Upload IC/Passport</label>
              <input type="file" name="ic_picture" class="form-control" accept="image/*">
              @if($athlete->user->detail->ic_picture)
                <small>Current: 
                  <a href="{{ asset('storage/'.$athlete->user->detail->ic_picture) }}" target="_blank">view</a>
                </small>
              @endif
              @error('ic_picture')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            {{-- Email --}}
            <div class="col-md-6 mb-3">
              <label class="form-label required">Email</label>
              <input type="email" name="email"
                     class="form-control"
                     value="{{ $athlete->user->email }}"
                     readonly>
            </div>
            {{-- Phone --}}
            <div class="col-md-6 mb-3">
              <label class="form-label required">Phone Number</label>
              <input type="tel" name="phone"
                     class="form-control"
                     value="{{ old('phone',$athlete->user->contact_no) }}">
              @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            {{-- Gender --}}
            <div class="col-md-6 mb-3">
              <label class="form-label required d-block">Gender</label>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="M"
                  {{ old('gender',$athlete->user->detail->gender)=='M'?'checked':'' }}>
                <label class="form-check-label">Male</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="F"
                  {{ old('gender',$athlete->user->detail->gender)=='F'?'checked':'' }}>
                <label class="form-check-label">Female</label>
              </div>
              @error('gender')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            {{-- Race --}}
            <div class="col-md-6 mb-3">
              <label class="form-label required d-block">Race</label>
              @foreach(['Malay','Cina','India','Others'] as $race)
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="race" value="{{ $race }}"
                    {{ old('race',$athlete->user->detail->race)==$race?'checked':'' }}>
                  <label class="form-check-label">{{ $race }}</label>
                </div>
              @endforeach
              @error('race')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            {{-- Nationality --}}
            <div class="col-md-6 mb-3">
              <label class="form-label required">Nationality</label>
              <select name="citizens" class="form-select select2">
                <option value="">-- Select Country --</option>
                @foreach($nationalities as $id=>$name)
                  <option value="{{ $id }}"
                    {{ old('citizens',$athlete->user->detail->nationality)==$id?'selected':'' }}>
                    {{ $name }}
                  </option>
                @endforeach
              </select>
              @error('citizens')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            {{-- Address --}}
            <div class="col-md-12 mb-3">
              <label class="form-label required">Address</label>
              <textarea name="address" class="form-control" rows="3">{{ old('address',$athlete->user->detail->address) }}</textarea>
              @error('address')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            {{-- Postcode --}}
            <div class="col-md-4 mb-3">
              <label class="form-label required">Postcode</label>
              <input type="text" name="postcode"
                     class="form-control"
                     value="{{ old('postcode',$athlete->user->detail->postcode) }}">
              @error('postcode')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            {{-- State --}}
            <div class="col-md-4 mb-3">
              <label class="form-label required">State</label>
              <select id="schA_state" name="sch_state" class="form-select select2">
                <option value="">-- Select State --</option>
                @foreach($states as $id=>$nm)
                  <option value="{{ $id }}"
                    {{ old('sch_state',$athlete->user->detail->state_id)==$id?'selected':'' }}>
                    {{ $nm }}
                  </option>
                @endforeach
              </select>
              @error('sch_state')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            {{-- District --}}
            <div class="col-md-4 mb-3">
              <label class="form-label required">District</label>
              <select id="daerahDropdown" name="districts" class="form-select select2">
                <option value="">-- Select District --</option>
                @foreach($districts as $id=>$nm)
                  <option value="{{ $id }}"
                    {{ old('districts',$athlete->user->detail->district_id)==$id?'selected':'' }}>
                    {{ $nm }}
                  </option>
                @endforeach
              </select>
              @error('districts')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            {{-- T-shirt Size --}}
            <div class="col-md-6 mb-3">
              <label class="form-label required">T-Shirt Size</label>
              <select name="size" class="form-select select2">
                <option value="">-- Select Size --</option>
                @foreach(['XS','S','M','L','XL','XXL','3XL'] as $s)
                  <option value="{{ $s }}" {{ old('size',$athlete->tshirt_size)==$s ? 'selected':'' }}>
                    {{ $s }}
                  </option>
                @endforeach
              </select>
              @error('size')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            {{-- Name on T-shirt --}}
            <div class="col-md-6 mb-3">
              <label class="form-label required">Name on T-Shirt</label>
              <input type="text"
                    name="NameTshirt"
                    class="form-control"
                    value="{{ old('NameTshirt',$athlete->shirt_name) }}">
              @error('NameTshirt')<div class="text-danger">{{ $message }}</div>@enderror
            </div>

            {{-- Next --}}
            <div class="col text-end">
              <button type="button" class="btn btn-primary" data-next="#guardian">Next</button>
            </div>
          </div>
        </div>

        {{-- GUARDIAN INFO --}}
        <div class="tab-pane fade" id="guardian" role="tabpanel">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Guardian Name</label>
              <input type="text" name="GuardianName"
                     class="form-control"
                     value="{{ old('GuardianName',optional($athlete->guardian)->name) }}">
              @error('GuardianName')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Guardian Phone</label>
              <input type="text" name="GuardianPhone"
                     class="form-control"
                     value="{{ old('GuardianPhone',optional($athlete->guardian)->phone) }}">
              @error('GuardianPhone')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Occupation</label>
              <input type="text" name="GuardianOccup"
                     class="form-control"
                     value="{{ old('GuardianOccup',optional($athlete->guardian)->occupation) }}">
              @error('GuardianOccup')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Relation</label>
              <select name="GuardianRelation" class="form-select select2">
                <option value="">-- Select Relation --</option>
                @foreach(['Parent','Siblings','Guardian'] as $rel)
                  <option value="{{ $rel }}"
                    {{ old('GuardianRelation',optional($athlete->guardian)->relation)==$rel?'selected':'' }}>
                    {{ $rel }}
                  </option>
                @endforeach
              </select>
              @error('GuardianRelation')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-next="#personal">Prev</button>
            <button type="button" class="btn btn-primary"  data-next="#school">Next</button>
          </div>
        </div>

        {{-- SCHOOL INFO --}}
        <div class="tab-pane fade" id="school" role="tabpanel">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">School Name</label>
              <select id="schoolDropdown" name="schoolDropdown" class="form-select select2">
                <option value="">-- Select School --</option>
                @foreach($schools as $id=>$nm)
                  <option value="{{ $id }}"
                    {{ old('schoolDropdown',$athlete->school_id)==$id?'selected':'' }}>
                    {{ $nm }}
                  </option>
                @endforeach
              </select>
              @error('schoolDropdown')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">School Code</label>
              <input type="text" id="CodeScholl" readonly class="form-control"
                     value="{{ old('',$athlete->school->sch_code) }}">
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">School Address</label>
              <textarea id="AddressSchool" readonly rows="3" class="form-control">{{ old('',$athlete->school->sc_address) }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Postcode</label>
              <input type="text" id="PosKod" readonly class="form-control"
                     value="{{ old('',$athlete->school->postcode) }}">
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-next="#guardian">Prev</button>
            <button type="button" class="btn btn-primary"  data-next="#experience">Next</button>
          </div>
        </div>

        {{-- Achievements --}}
        <div class="tab-pane fade" id="experience" role="tabpanel">
          <div class="table-responsive mb-3" >
            <table class="table">
              <thead>
                <tr>
                  <th></th> {{-- for the hidden ID --}}
                  <th>Tournament</th>
                  <th>Stage</th>
                  <th>Category</th>
                  <th>Achieve</th>
                  <th>Year</th>
                  <th></th>
                </tr>
              </thead>
<tbody id="experienceTableBody">
  @forelse($athlete->experiences as $exp)
    <tr>
      {{-- Hidden PK so we know which record to update or delete --}}
      <input type="hidden"
             name="experience_id[]"
             value="{{ $exp->id_exp }}">

      <td>
        <input type="text"
               name="tournament[]"
               class="form-control"
               value="{{ old('tournament.' . $loop->index, $exp->tournament) }}">
      </td>
      <td>
        <select name="ranking[]" class="form-select select2">
          <option value="">-- Stage --</option>
          @foreach([1=>'Sekolah',2=>'Daerah/Zon',3=>'Negeri',4=>'Kebangsaan',5=>'Antarabangsa'] as $v=>$lbl)
            <option value="{{ $v }}"
              {{ old('ranking.' . $loop->index, $exp->ranking)==$v ? 'selected':'' }}>
              {{ $lbl }}
            </option>
          @endforeach
        </select>
      </td>
      <td>
        <select name="category[]" class="form-select select2">
          <option value="">-- Category --</option>
          @foreach(['MS','WS','MD','WD','MXD'] as $c)
            <option value="{{ $c }}"
              {{ old('category.' . $loop->index, $exp->category)==$c ? 'selected':'' }}>
              {{ $c }}
            </option>
          @endforeach
        </select>
      </td>
      <td>
        <select name="achieve[]" class="form-select select2">
          <option value="">-- Achieve --</option>
          @foreach($achievement as $aid=>$aname)
            <option value="{{ $aid }}"
              {{ old('achieve.' . $loop->index, $exp->achieve_id)==$aid ? 'selected':'' }}>
              {{ $aname }}
            </option>
          @endforeach
        </select>
      </td>
      <td>
        <input type="number"
               name="year[]"
               class="form-control"
               value="{{ old('year.' . $loop->index, $exp->year) }}">
      </td>
      <td class="text-center">
        <button type="button" class="btn btn-sm btn-danger btnRemoveExperience">×</button>
      </td>
    </tr>
  @empty
    {{-- If no existing experiences, render one blank “template” row --}}
    <tr>
      <input type="hidden" name="experience_id[]" value="">
      <td><input type="text" name="tournament[]" class="form-control"></td>
      <td>
        <select name="ranking[]" class="form-select select2">
          <option value="">-- Stage --</option>
          @foreach([1=>'Sekolah',2=>'Daerah/Zon',3=>'Negeri',4=>'Kebangsaan',5=>'Antarabangsa'] as $v=>$lbl)
            <option value="{{ $v }}">{{ $lbl }}</option>
          @endforeach
        </select>
      </td>
      <td>
        <select name="category[]" class="form-select select2">
          <option value="">-- Category --</option>
          @foreach(['MS','WS','MD','WD','MXD'] as $c)
            <option value="{{ $c }}">{{ $c }}</option>
          @endforeach
        </select>
      </td>
      <td>
        <select name="achieve[]" class="form-select select2">
          <option value="">-- Achieve --</option>
          @foreach($achievement as $aid=>$aname)
            <option value="{{ $aid }}">{{ $aname }}</option>
          @endforeach
        </select>
      </td>
      <td><input type="number" name="year[]" class="form-control"></td>
      <td class="text-center">
        <button type="button" class="btn btn-sm btn-danger btnRemoveExperience">×</button>
      </td>
    </tr>
  @endforelse
</tbody>

            </table>
          </div>
          <div class="mb-3 text-end">
            <button type="button" class="btn btn-outline-primary btnAddExperience">
              <i class="fa-solid fa-plus me-1"></i> Add
            </button>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-next="#school">Prev</button>
            <button type="button" class="btn btn-primary"  data-next="#coach">Next</button>
          </div>
        </div>
        {{-- COACH & CLUB INFO --}}
        <div class="tab-pane fade" id="coach" role="tabpanel">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label required">Coach</label>
              <select name="coachSelect" class="form-select select2">
                <option value="">-- Select Coach --</option>
                @foreach($coaches as $id=>$nm)
                  <option value="{{ $id }}" {{ old('coachSelect',$athlete->coach_id)==$id?'selected':'' }}>{{ $nm }}</option>
                @endforeach
              </select>
              @error('coachSelect')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label required">Club</label>
              <select name="clubSelect" class="form-select select2">
                <option value="">-- Select Club --</option>
                @foreach($clubs as $id=>$nm)
                  <option value="{{ $id }}" {{ old('clubSelect',$athlete->club_id)==$id?'selected':'' }}>{{ $nm }}</option>
                @endforeach
              </select>
              @error('clubSelect')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" data-next="#experience">Prev</button>
            <button type="button" class="btn btn-primary" data-next="#declaration">Next</button>
          </div>
        </div>

        {{-- DECLARATION --}}
        <div class="tab-pane fade text-center" id="declaration" role="tabpanel">
          <div class="form-check mt-3 mb-3">
            <input class="form-check-input" type="checkbox" name="declaration" id="declarationCheck"
                   {{ old('declaration')?'checked':'' }}>
            <label class="form-check-label" for="declarationCheck">
              I hereby declare that the information provided is true and correct.
            </label>
            @error('declaration')<div class="text-danger">{{ $message }}</div>@enderror
          </div>
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.17/css/intlTelInput.min.css"/>
<style>
  .required::after { content: " *"; color: red; }
  .is-invalid { border-color: red !important; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(function(){
    // Flash
    @if(session('success'))
      Swal.fire('Success','{{ session('success') }}','success');
    @endif
    @if(session('error'))
      Swal.fire('Error','{{ session('error') }}','error');
    @endif

    // Next/Prev
    $('button[data-next]').click(function(){
      let tgt = $(this).data('next');
      $('#athleteTabs button[data-bs-target="'+tgt+'"]').tab('show');
    });

    // Districts AJAX
    function loadDistricts(){
      let url   = "{{ route('districts.list') }}",
          sid   = $('#schA_state').val(),
          $ddl  = $('#daerahDropdown');
      $ddl.prop('disabled',true).html('<option>Loading…</option>');
      $.get(url,{state_id:sid})
        .done(d=>{
          let h='<option value="">-- Select District --</option>';
          $.each(d,(i,n)=>h+=`<option value="${i}">${n}</option>`);
          $ddl.html(h).prop('disabled',false)
                       .val("{{ old('districts',$athlete->user->detail->district_id) }}");
        });
    }
    $('#schA_state').on('change',loadDistricts).trigger('change');

    // School AJAX
    function fillSchool(){
      let sid  = $('#schoolDropdown').val(),
          url  = "{{ route('school.list') }}";
      if(!sid){
        $('#CodeScholl,#AddressSchool,#PosKod').val('');
        return;
      }
      $.get(url,{school_id:sid})
       .done(d=>{
         $('#CodeScholl').val(d.sch_code);
         $('#AddressSchool').val(d.sc_address);
         $('#PosKod').val(d.postcode);
       });
    }
    $('#schoolDropdown').on('change',fillSchool).trigger('change');

    // on Add Experience, clear out both visible inputs and the hidden id
    $('.btnAddExperience').click(()=>{
      let $row = $('#experienceTableBody tr:first').clone();
      // clear only non-hidden inputs
      $row.find('input[type=text], input[type=number], select').val('');
      // clear the hidden PK so new row has no ID
      $row.find('input[type=hidden][name="experience_id[]"]').val('');
      $('#experienceTableBody').append($row);
    });

    $(document).on('click','.btnRemoveExperience',function(){
      if($('#experienceTableBody tr').length>1)
        $(this).closest('tr').remove();
    });
    
  });
</script>
@endpush
