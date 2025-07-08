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
        <input class="form-check-input" type="checkbox" id="switchMode">
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
          <li class="nav-item">
            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button">Personal Info</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" id="guardian-tab" data-bs-toggle="tab" data-bs-target="#guardian" type="button">Guardian Info</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" id="school-tab" data-bs-toggle="tab" data-bs-target="#school" type="button">School Info</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" id="experience-tab" data-bs-toggle="tab" data-bs-target="#experience" type="button">Achievements</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" id="coach-tab" data-bs-toggle="tab" data-bs-target="#coach" type="button">Coach & Club Info</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" id="declaration-tab" data-bs-toggle="tab" data-bs-target="#declaration" type="button">Declaration</button>
          </li>
        </ul>

        <div class="tab-content pt-3">

          {{-- Personal Info --}}
          <div class="tab-pane fade show active" id="personal" role="tabpanel">
            @php [$first] = [auth()->user()->name]; @endphp
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label required">Full Name</label>
                <input type="text" name="firstname" class="form-control" value="{{ old('firstname',$first) }}" >
              </div>
              {{-- Profile Picture Upload --}}
              <div class="col-md-6 mb-3">
                <label class="form-label required">Upload Profile Picture</label>
                <input type="file"
                       name="profile_picture"
                       class="form-control"
                       accept="image/*">
                @error('profile_picture')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>              
              <div class="col-md-6 mb-3">
                <label class="form-label required">No. IC/Passport</label>
                <input type="text" class="form-control" name="idNumber" value="{{ auth()->user()->ic_number }}" >
                {{-- no @error here --}}
              </div>

              {{-- IC/Passport Upload --}}
              <div class="col-md-6 mb-3">
                <label class="form-label required">Upload IC/Passport</label>
                <input type="file"
                       name="ic_picture"
                       class="form-control"
                       accept="image/*">
                @error('ic_picture')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label required">Email</label>
                <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" >
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">Phone Number</label>
                <input type="tel" name="phone" class="form-control" value="{{ old('phone',auth()->user()->contact_no) }}">
                @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label required d-block">Gender</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" value="M" {{ old('gender')=='M'?'checked':'' }}>
                  <label class="form-check-label">Male</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" value="F" {{ old('gender')=='F'?'checked':'' }}>
                  <label class="form-check-label">Female</label>
                </div>
                @error('gender')<div class="text-danger">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label required d-block">Race</label>
                @foreach(['Malay','Cina','India','Others'] as $race)
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="race" value="{{ $race }}" {{ old('race')==$race?'checked':'' }}>
                    <label class="form-check-label">{{ $race }}</label>
                  </div>
                @endforeach
                @error('race')<div class="text-danger">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label required">Nationality</label>
                <select name="citizens" class="form-select select2">
                  <option value="">-- Select Nationality --</option>
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
                <select id="schA_state" name="sch_state" class="form-select">
                  <option value="">-- Select State --</option>
                  @foreach($states as $id=>$nm)
                    <option value="{{ $id }}" {{ old('sch_state')==$id?'selected':'' }}>{{ $nm }}</option>
                  @endforeach
                </select>
                @error('sch_state')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label required">District</label>
                <select id="daerahDropdown" name="districts" class="form-select">
                  <option value="">-- Select District --</option>
                  @foreach($districts as $id=>$nm)
                    <option value="{{ $id }}" {{ old('districts')==$id?'selected':'' }}>{{ $nm }}</option>
                  @endforeach
                </select>
                @error('districts')<div class="text-danger">{{ $message }}</div>@enderror
              </div>

              <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label required">T-Shirt Size</label>
                                            <select class="form-select" name="tshirt_size">
                                                <option value="">-- Select Size --</option>
                                                <option value="XS">XS</option>
                                                <option value="S">S</option>
                                                <option value="M">M</option>
                                                <option value="L">L</option>
                                                <option value="XL">XL</option>
                                                <option value="XXL">XXL</option>
                                                <option value="3XL">3XL</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required">Name on T-Shirt</label>
                                            <input type="text" class="form-control" name="NameTshirt">
                                        </div>  
              </div>          
              <div class="col text-end">
                <button type="button" class="btn btn-primary" data-next="guardian-tab">Next</button>
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
                <select name="GuardianRelation" class="form-select">
                  <option value="">-- Select Relation --</option>
                  <option value="Parent"   {{ old('GuardianRelation')=='Parent'?'selected':'' }}>Parent</option>
                  <option value="Siblings" {{ old('GuardianRelation')=='Siblings'?'selected':'' }}>Siblings</option>
                  <option value="Guardian" {{ old('GuardianRelation')=='Guardian'?'selected':'' }}>Guardian</option>
                </select>
                @error('GuardianRelation')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-next="personal-tab">Prev</button>
              <button type="button" class="btn btn-primary"  data-next="school-tab">Next</button>
            </div>
          </div>

          {{-- School Info --}}
          <div class="tab-pane fade" id="school" role="tabpanel">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label required">School Name</label>
                <select id="schoolDropdown" name="schoolDropdown" class="form-select select2" data-placeholder="Search School…">
                  <option value="">-- Select School --</option>
                  @foreach($schools as $id=>$nm)
                    <option value="{{ $id }}" {{ old('schoolDropdown')==$id?'selected':'' }}>{{ $nm }}</option>
                  @endforeach
                </select>
                @error('schoolDropdown')<div class="text-danger">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">School Code</label>
                <input type="text" id="CodeScholl" readonly class="form-control">
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">School Address</label>
                <textarea id="AddressSchool" rows="3" readonly class="form-control"></textarea>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label required">Postcode</label>
                <input type="text" id="PosKod" readonly class="form-control">
              </div>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-next="guardian-tab">Prev</button>
              <button type="button" class="btn btn-primary"  data-next="experience-tab">Next</button>
            </div>
          </div>

          {{-- Achievements --}}
          <div class="tab-pane fade" id="experience" role="tabpanel">
            <div class="table-responsive mb-3">
              <table class="table">
                <thead>
                  <tr><th>Tournament</th><th>Stage</th><th>Category</th><th>Achieve</th><th>Year</th><th></th></tr>
                </thead>
                <tbody id="experienceTableBody">
                  <tr>
                    <td><input type="text" name="tournament[]" class="form-control"></td>
                    <td>
                      <select name="ranking[]" class="form-select">
                        <option value="">-- Stage --</option>
                        @foreach([1=>'Sekolah',2=>'Daerah/Zon',3=>'Negeri',4=>'Kebangsaan',5=>'Antarabangsa'] as $v=>$lbl)
                          <option value="{{ $v }}">{{ $lbl }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select name="category[]" class="form-select">
                        <option value="">-- Category --</option>
                        @foreach(['MS','WS','MD','WD','MXD'] as $c)
                          <option value="{{ $c }}">{{ $c }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select name="achieve[]" class="form-select">
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
                </tbody>
              </table>
            </div>
            <div class="mb-3 text-end">
              <button type="button" class="btn btn-outline-primary btnAddExperience">
                <i class="fa-solid fa-plus me-1"></i> Add
              </button>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-next="school-tab">Prev</button>
              <button type="button" class="btn btn-primary"  data-next="coach-tab">Next</button>
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
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-next="experience-tab">Prev</button>
              <button type="button" class="btn btn-primary"  data-next="declaration-tab">Next</button>
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
  .is-invalid   { border-color: red !important; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- 2) Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
  $(function(){
      // Flash messages
      @if(session('success'))
        Swal.fire('Success','{{ session('success') }}','success');
      @endif
      @if(session('error'))
        Swal.fire('Error','{{ session('error') }}','error');
      @endif 

    // Initialize Select2 once it’s loaded
    $('.select2').select2({
      placeholder: function(){ return $(this).data('placeholder') },
      allowClear: true,
      width: '100%'
    });

    // Toggle multiple vs single
    $('#switchMode').on('change', () => {
      $('#formMultiple').toggleClass('d-none');
      $('#formSingle').toggleClass('d-none');
    });

    // Next/Prev tab navigation
    $('button[data-next]').click(function(){
      let target = $(this).data('next');
      $('#athleteTabs button#'+ target).trigger('click');
    });

    // Load districts when state changes
    /*function loadDistricts(){
      let stateId = $('#schA_state').val();
      let $ddl = $('#daerahDropdown');
      $ddl.prop('disabled',true)
          .html('<option>Loading…</option>');
      $.get("{{ route('districts.list') }}", {state_id:stateId}, data=>{
        let html = '<option value="">-- Select District --</option>';
        $.each(data,(i,n)=> html+=`<option value="${i}">${n}</option>`);
        $ddl.html(html).prop('disabled',false);
      });
      .fail(function(xhr){
      console.error('Districts load failed:', xhr);
      $ddl.html('<option value="">Error loading</option>');
    });
    }*/
  
  // District loader
  const districtUrl = "{{ route('districts.list') }}";

  function loadDistricts() {
    const stateId = $('#schA_state').val();
    const $ddl    = $('#daerahDropdown');

    $ddl
      .prop('disabled', true)
      .html('<option>Loading…</option>');

    // CALL the absolute URL, not a relative one
    $.get(districtUrl, { state_id: stateId })
      .done(function(districts) {
        let html = '<option value="">-- Select District --</option>';
        $.each(districts, function(id, name) {
          html += `<option value="${id}">${name}</option>`;
        });
        $ddl.html(html).prop('disabled', false);
      })
      .fail(function(xhr) {
        console.error('Failed to load districts:', xhr);
        $ddl.html('<option value="">Error loading</option>');
      });
  }

  //$(function(){
    // fire it on page‐load (in case old('sch_state') was set)
    $('#schA_state').on('change', loadDistricts).trigger('change');
  //});

    // Multiple‐invite add/remove
    $('#addRow').click(()=>{
      let $row = $('.athlete-row').first().clone();
      $row.find('input').val('');
      $('.multi-row').append($row);
    });
    $(document).on('click','.removeRow',function(){
      if($('.athlete-row').length>1) $(this).closest('.athlete-row').remove();
    });

    // Achievements add/remove
    $('.btnAddExperience').click(()=>{
      let $r = $('#experienceTableBody tr:first').clone();
      $r.find('input,select').val('');
      $('#experienceTableBody').append($r);
    });
    $(document).on('click','.btnRemoveExperience',function(){
      if($('#experienceTableBody tr').length>1) $(this).closest('tr').remove();
    });

    // School Info AJAX
    // School AJAX fill-in
    $('#schoolDropdown').change(function(){
      const id = $(this).val();
      const base = "{{ route('school.list') }}";    // <-- use your named route
      if (!id) {
        $('#CodeScholl,#AddressSchool,#PosKod').val('');
        return;
      }
      $.getJSON(base, { school_id: id }, function(data){
        $('#CodeScholl').val(data.sch_code);
        $('#AddressSchool').val(data.sc_address);
        $('#PosKod').val(data.postcode);
      });
    });

    // AJAX form-submit
    $('#athleteForm').on('submit', function(e){
      e.preventDefault();
      let $form    = $(this);
      let formData = new FormData(this);

      // clear old errors
      $form.find('.is-invalid').removeClass('is-invalid');
      $form.find('.invalid-feedback').remove();

      $.ajax({
        url:         $form.attr('action'),
        method:      $form.attr('method'),
        data:        formData,
        processData: false,
        contentType: false,
        dataType:    'json'
      })
      .done(function(res){
        Swal.fire('Success', res.message, 'success')
          .then(() => window.location.href = res.redirect);
      })
      .fail(function(xhr){
        if (xhr.status === 422) {
          let errors = xhr.responseJSON.errors;
          // show validation errors
          $.each(errors, function(field, msgs){
            // handle array fields like tournament.0 → use name="tournament[]"
            let inputName = field.replace(/\.\d+$/, '[]');
            let $el = $form.find(`[name="${field}"], [name="${inputName}"]`).first();
            $el.addClass('is-invalid')
               .after(`<div class="invalid-feedback">${msgs[0]}</div>`);
          });
          // switch to the first tab containing an error
          let $first = $form.find('.is-invalid').first();
          if ($first.length) {
            let paneId = $first.closest('.tab-pane').attr('id');
            $(`#athleteTabs button[data-bs-target="#${paneId}"]`).trigger('click');
          }
        } else {
          Swal.fire('Error','Something went wrong.','error');
        }
      });
    });    
   
  });
</script>
@endpush
