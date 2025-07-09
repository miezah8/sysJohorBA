{{-- resources/views/coach/edit.blade.php --}}
@extends('layouts.app')

@if(session('error'))
  <div class="alert alert-danger">
    <strong>Error:</strong><br>
    {{ nl2br(e(session('error'))) }}
  </div>
@endif

@php
  $editing = true;
  // Pull old-input or existing arrays
  $academics  = old('academic',  $coach->educations->toArray());
  $experiences = old('experience',$coach->coachExperience->toArray());
  $quals      = old('qualification',$coach->coachCourse->toArray());
@endphp

@section('title','Edit Coach')

@push('css')
  <link
    href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css"
    rel="stylesheet"
  />
@endpush

@section('content')
  <div class="card">
    <div class="card-header"><h4>Edit Coach</h4></div>
    <div class="card-body">
      <form
        id="coachForm"
        action="{{ route('coach.update',$coach->id_coach) }}"
        method="POST"
        enctype="multipart/form-data"
        novalidate
      >
        @csrf @method('PUT')
        <input type="hidden" name="id_coach" value="{{ $coach->id_coach }}">

        {{-- Nav Tabs --}}
        <ul class="nav nav-tabs" id="coachTabs" role="tablist">
          @foreach(['personal'=>'Personal Info','academic'=>'Academic','experience'=>'Experience','qualification'=>'Qualification','club'=>'Club Info','declaration'=>'Declaration'] as $id=>$label)
            <li class="nav-item">
              <button
                class="nav-link {{ $loop->first ? 'active':'' }}"
                data-bs-toggle="tab"
                data-bs-target="#{{ $id }}"
                type="button"
              >{{ $label }}</button>
            </li>
          @endforeach
        </ul>

        <div class="tab-content pt-3">

          {{-- PERSONAL --}}
          <div class="tab-pane fade show active" id="personal" role="tabpanel">
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="gambar">Profile Image</label>
                <input
                  id="gambar"
                  type="file" name="gambar"
                  class="form-control"
                  accept="image/*"
                >
                  @if(optional($coach->userDetail)->profile_picture)
                  <div class="mt-2">
                    <a
                      href="{{ asset('storage/'.$coach->userDetail->profile_picture) }}"
                      target="_blank"
                    >
                      <img
                        src="{{ asset('storage/'.$coach->userDetail->profile_picture) }}"
                        class="img-thumbnail"
                        width="50"
                        alt="Current profile"
                      >
                      View current
                    </a>
                  </div>
                @endif
              </div>
              <div class="col-md-6">
                <label for="nama_penuh">Full Name *</label>
                <input
                  id="nama_penuh"
                  type="text" name="nama_penuh"
                  value="{{ old('nama_penuh',$coach->coach_fname) }}"
                  class="form-control" required
                >
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="emel">Email *</label>
                <input
                  id="emel" type="email" name="emel"
                  value="{{ old('emel',$coach->user->email) }}"
                  class="form-control" required
                >
              </div>
              <div class="col-md-6">
                <label for="no_tel">Phone No. *</label>
                <input
                  id="no_tel" type="text" name="no_tel"
                  value="{{ old('no_tel',$coach->user->contact_no) }}"
                  class="form-control" required
                >
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="no_kad">IC Number / Passport *</label>
                <input
                  id="no_kad" type="text" name="no_kad"
                  value="{{ old('no_kad',$coach->userDetail->ic_no) }}"
                  class="form-control" required
                >
              </div>
              <div class="col-md-6">
                <label for="ic_picture">Upload IC/Passport</label>
                <input
                  id="ic_picture"
                  type="file" name="ic_picture"
                  class="form-control"
                  accept="image/*"
                >
                @if(optional($coach->userDetail)->ic_picture)
                  <div class="mt-2">
                    <a
                      href="{{ asset('storage/'.$coach->userDetail->ic_picture) }}"
                      target="_blank"
                    >
                      View current copy
                    </a>
                  </div>
                @endif                
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="nationality">Nationality *</label>
                <select
                  id="nationality"
                  name="nationality"
                  class="form-select select2"
                  required
                >
                  <option value="">Please select</option>
                  {{-- Malaysia first --}}
                  @if($nationalities->contains('Malaysia'))
                    @php $mid = $nationalities->search('Malaysia'); @endphp
                    <option value="{{ $mid }}"
                      {{ old('nationality',$coach->userDetail->nationality)==$mid?'selected':'' }}
                    >Malaysia</option>
                  @endif
                  {{-- rest --}}
                  @foreach($nationalities as $nid=>$n)
                    @if($n!=='Malaysia')
                      <option value="{{ $nid }}"
                        {{ old('nationality',$coach->userDetail->nationality)==$nid?'selected':'' }}
                      >{{ $n }}</option>
                    @endif
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label for="alamat">Address *</label>
                <textarea
                  id="alamat" name="alamat"
                  class="form-control" rows="3" required
                >{{ old('alamat',$coach->userDetail->address) }}</textarea>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-4">
                <label for="state_id">State *</label>
                <select
                  id="state_id" name="negeri"
                  class="form-select" required
                >
                  <option value="">Please select</option>
                  @foreach($states as $sid=>$sname)
                    <option value="{{ $sid }}"
                      {{ old('negeri',$coach->userDetail->state_id)==$sid?'selected':'' }}
                    >{{ $sname }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label for="district_id">District *</label>
                <select
                  id="district_id" name="daerah"
                  class="form-select" required
                >
                  <option value="">Please select</option>
                  @foreach($districts as $did=>$dname)
                    <option value="{{ $did }}"
                      {{ old('daerah',$coach->userDetail->district_id)==$did?'selected':'' }}
                    >{{ $dname }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label for="poskod">Postcode *</label>
                <input
                  id="poskod" type="text" name="poskod"
                  value="{{ old('poskod',$coach->userDetail->postcode) }}"
                  class="form-control" required
                >
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-4">
                <label>Gender *</label><br>
                @foreach(['M'=>'Male','F'=>'Female'] as $val=>$lbl)
                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input"
                      type="radio"
                      name="jantina" value="{{ $val }}"
                      {{ old('jantina',$coach->userDetail->gender)==$val?'checked':'' }}
                      required
                    >
                    <label class="form-check-label">{{ $lbl }}</label>
                  </div>
                @endforeach
              </div>
              <div class="col-md-4">
                <label for="ethnicity">Race *</label>
                <select id="ethnicity" name="ethnicity" class="form-select" required>
                  <option value="">Please select</option>
                  @foreach(['Malay','Chinese','Indian','Other'] as $race)
                    <option value="{{ $race }}"
                      {{ old('ethnicity',$coach->userDetail->race)==$race?'selected':'' }}
                    >{{ $race }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="text-end">
              <button
                type="button"
                class="btn btn-primary"
                data-next="academic"
                data-bs-toggle="tab"
                data-bs-target="#academic"
              >Next</button>
            </div>
          </div>

          {{-- ACADEMIC --}}
          <div class="tab-pane fade" id="academic" role="tabpanel">
            <div class="table-responsive mb-3">
              <table class="table" id="academicTable">
                <thead>
                  <tr>
                    <th>Qualification</th>
                    <th>Institution</th>
                    <th>Year</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @if(count($academics))
                    @foreach($academics as $i => $acad)
                      <tr>
                        <td>
                          <input
                            type="text"
                            name="academic[{{ $i }}][education_level]"
                            class="form-control"
                            value="{{ $acad['education_level'] }}"
                            required
                          >
                        </td>
                        <td>
                          <select
                            name="academic[{{ $i }}][institution_id]"
                            class="form-select select2"
                            data-placeholder="Search institution…"
                            required
                          >
                            <option value=""></option>
                            @foreach($institution as $iid=>$iname)
                              <option
                                value="{{ $iid }}"
                                {{ $acad['institution_id']==$iid?'selected':'' }}
                              >{{ $iname }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                          <input
                            type="text"
                            name="academic[{{ $i }}][year]"
                            class="form-control"
                            value="{{ $acad['year'] }}"
                            pattern="\d{4}"
                            required
                          >
                        </td>
                        <td class="text-center">
                          <button type="button" class="btn btn-sm btn-outline-danger btnRemoveAcademic">×</button>
                        </td>
                      </tr>
                    @endforeach
                  @else
                    {{-- blank row --}}
                    <tr>
                      <td><input type="text" name="academic[0][education_level]" class="form-control" required></td>
                      <td>
                        <select name="academic[0][institution_id]" class="form-select select2" data-placeholder="Search institution…" required>
                          <option value=""></option>
                          @foreach($institution as $iid=>$iname)
                            <option value="{{ $iid }}">{{ $iname }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td><input type="text" name="academic[0][year]" class="form-control" pattern="\d{4}" required></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger btnRemoveAcademic">×</button>
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
              <button type="button" id="btnAddAcademic" class="btn btn-sm btn-outline-primary mb-3">
                <i class="fa-solid fa-plus"></i> Add Qualification
              </button>
            </div>
            <div class="d-flex justify-content-between">
              <button
                type="button"
                class="btn btn-secondary"
                data-next="personal"
                data-bs-toggle="tab"
                data-bs-target="#personal"
              >Prev</button>
              <button
                type="button"
                class="btn btn-primary"
                data-next="experience"
                data-bs-toggle="tab"
                data-bs-target="#experience"
              >Next</button>
            </div>
          </div>

          {{-- EXPERIENCE --}}
          <div class="tab-pane fade" id="experience" role="tabpanel">
            <div class="table-responsive mb-3">
              <table class="table" id="experienceTable">
                <thead>
                  <tr>
                    <th>Activity</th><th>Position</th><th>Level</th><th>Organized By</th><th>Start</th><th>End</th><th></th>
                  </tr>
                </thead>
                <tbody>
                  @if(count($experiences))
                    @foreach($experiences as $i => $exp)
                      <tr>
                        @foreach(['activity','position','level','organized_by','start_date','end_date'] as $field)
                          <td>
                            <input
                              type="{{ $field==='start_date'||$field==='end_date'?'date':'text' }}"
                              name="experience[{{ $i }}][{{ $field }}]"
                              class="form-control"
                              value="{{ $exp[$field] ?? '' }}"
                              {{ $field==='activity'?'required':'' }}
                            >
                          </td>
                        @endforeach
                        <td class="text-center">
                          <button type="button" class="btn btn-sm btn-outline-danger btnRemoveExperience">×</button>
                        </td>
                      </tr>
                    @endforeach
                  @else
                    <tr>
                      <td><input type="text" name="experience[0][activity]"     class="form-control" required></td>
                      <td><input type="text" name="experience[0][position]"     class="form-control"></td>
                      <td><input type="text" name="experience[0][level]"        class="form-control"></td>
                      <td><input type="text" name="experience[0][organized_by]" class="form-control"></td>
                      <td><input type="date" name="experience[0][start_date]"   class="form-control"></td>
                      <td><input type="date" name="experience[0][end_date]"     class="form-control"></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger btnRemoveExperience">×</button>
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
              <button type="button" id="btnAddExperience" class="btn btn-sm btn-outline-primary mb-3">
                <i class="fa-solid fa-plus"></i> Add Experience
              </button>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-next="academic" data-bs-toggle="tab" data-bs-target="#academic">Prev</button>
              <button type="button" class="btn btn-primary"  data-next="qualification" data-bs-toggle="tab" data-bs-target="#qualification">Next</button>
            </div>
          </div>

          {{-- QUALIFICATION --}}
          <div class="tab-pane fade" id="qualification" role="tabpanel">
            <div class="table-responsive mb-3">
              <template id="qualification-row-template">
                <tr>
                  <td>
                    <select name="qualification[INDEX][course_id]" …>
                      <option value=""></option>
                      @foreach($courses as $cid => $cname)
                        <option value="{{ $cid }}">{{ $cname }}</option>
                      @endforeach
                    </select>
                  </td>
                  <!-- …and so on for level, pass_date, accreditation, cert_number, cert_file… -->
                  <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger btnRemoveQualification">×</button>
                  </td>
                </tr>
              </template>
              
              <table class="table" id="qualificationTable">
               
                <thead>
                  <tr>
                    <th>Course</th><th>Level</th><th>Date Passed</th><th>Accreditation</th><th>Cert No.</th><th>Upload</th><th></th>
                  </tr>
                </thead>
                <tbody>
                   
                  @if(count($quals))
                    @foreach($quals as $i => $q)
                      <tr>
                        {{-- course --}}
                        <td>
                          <select
                            name="qualification[{{ $i }}][course_id]"
                            class="form-select select2"
                            data-placeholder="Search course…"
                            required
                          >
                            <option value=""></option>
                            @foreach($courses as $cid=>$cname)
                              <option value="{{ $cid }}" {{ $q['course_id']==$cid?'selected':'' }}>
                                {{ $cname }}
                              </option>
                            @endforeach
                          </select>
                        </td>
                        {{-- level --}}
                        <td>
                          <select name="qualification[{{ $i }}][level]" class="form-select" required>
                            <option value="NA"    {{ $q['course_level']=='NA'?'selected':'' }}>NA</option>
                            <option value="Level 1"{{ $q['course_level']=='Level 1'?'selected':'' }}>Level 1</option>
                            <option value="Level 2"{{ $q['course_level']=='Level 2'?'selected':'' }}>Level 2</option>
                            <option value="Level 3"{{ $q['course_level']=='Level 3'?'selected':'' }}>Level 3</option>
                          </select>
                        </td>
                        {{-- pass_date --}}
                        <td><input type="date" name="qualification[{{ $i }}][pass_date]"    class="form-control" value="{{ $q['pass_date'] }}"></td>
                        {{-- accreditation --}}
                        <td><input type="text" name="qualification[{{ $i }}][accreditation]"class="form-control" value="{{ $q['recognition'] }}"></td>
                        {{-- cert_number --}}
                        <td><input type="text" name="qualification[{{ $i }}][cert_number]"  class="form-control" value="{{ $q['cert_siri'] }}"></td>
                        {{-- cert_file --}}
                        <td><input type="file" name="qualification[{{ $i }}][cert_file]" class="form-control">
                        @if(! empty($q['cert_attach']))
                          <input 
                            type="hidden"
                            name="qualification[{{ $i }}][existing_cert_attach]"
                            value="{{ $q['cert_attach'] }}"
                          >      
                        <a
                         href="{{ asset('storage/'.$q['cert_attach']) }}"
                         target="_blank"
                         class="d-block mt-1"
                       >View Upload</a>
                        @endif
                        </td>
                        <td class="text-center">
                          <button type="button" class="btn btn-sm btn-outline-danger btnRemoveQualification">×</button>
                        </td>
                      </tr>
                    @endforeach
                  @else
                    <tr>
                      <td>
                        <select name="qualification[0][course_id]" class="form-select select2" data-placeholder="Search course…" required>
                          <option value=""></option>
                          @foreach($courses as $cid=>$cname)
                            <option value="{{ $cid }}">{{ $cname }}</option>
                          @endforeach
                        </select>
                      </td>
                      <td>
                        <select name="qualification[0][level]" class="form-select" required>
                          <option value="NA">NA</option>
                          <option value="Level 1">Level 1</option>
                          <option value="Level 2">Level 2</option>
                          <option value="Level 3">Level 3</option>
                        </select>
                      </td>
                      <td><input type="date" name="qualification[0][pass_date]" class="form-control"></td>
                      <td><input type="text" name="qualification[0][accreditation]" class="form-control"></td>
                      <td><input type="text" name="qualification[0][cert_number]"   class="form-control"></td>
                      <td><input type="file" name="qualification[0][cert_file]"     class="form-control"></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger btnRemoveQualification">X</button>
                      </td>
                    </tr>
                  @endif
                  
                </tbody>
                 
               </table>
             
              <button type="button" id="btnAddQualification" class="btn btn-sm btn-outline-primary mb-3">
                <i class="fa-solid fa-plus"></i> Add Certification
              </button>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-next="experience" data-bs-toggle="tab" data-bs-target="#experience">Prev</button>
              <button type="button" class="btn btn-primary"  data-next="club"       data-bs-toggle="tab" data-bs-target="#club">Next</button>
            </div>
          </div>

          {{-- CLUB --}}
          <div class="tab-pane fade" id="club" role="tabpanel">
            <div class="mb-3">
              <label for="club_id">Select Club *</label>
              <select id="club_id" name="club_id" class="form-select" required>
                <option value="">Select Club</option>
                @foreach($clubs as $cid=>$cn)
                  <option value="{{ $cid }}" {{ old('club_id',$coach->club_id)==$cid?'selected':'' }}>
                    {{ $cn }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-next="qualification" data-bs-toggle="tab" data-bs-target="#qualification">Prev</button>
              <button type="button" class="btn btn-primary"  data-next="declaration" data-bs-toggle="tab" data-bs-target="#declaration">Next</button>
            </div>
          </div>

          {{-- DECLARATION --}}
          <div class="tab-pane fade" id="declaration" role="tabpanel">
            <div class="form-check mb-3">
              <input
                class="form-check-input"
                type="checkbox"
                name="declaration" id="decl"
                {{ old('declaration')?'checked':'' }}
                required
              >
              <label class="form-check-label" for="decl">
                I hereby declare that all information provided is true and correct.
              </label>
            </div>
            <button type="submit" class="btn btn-success">Update Coach</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  $(function(){
    // init select2
    $('.select2').select2({ placeholder: i=>$(i).data('placeholder'), allowClear:true, width:'100%' });

    // state→district AJAX
    $('#state_id').on('change',function(){
      let sid = this.value, $dd = $('#district_id');
      if(!sid) return $dd.html('<option value="">Select state first</option>');
      $dd.prop('disabled',true).html('<option>Loading…</option>');
      $.getJSON(`{{ url('coach/districts') }}/${sid}`)
        .done(list=>{
          let html = '<option value="">Please select</option>';
          $.each(list,(id,name)=> html+=`<option value="${id}">${name}</option>`);
          $dd.html(html).prop('disabled',false);

          // **pre-select** either old() or the existing district
          const selected = "{{ old('daerah', $coach->userDetail->district_id) }}";
          if (selected) {
            $dd.val(selected);
          }
        })
        .fail(_=> $dd.html('<option>Error loading</option>'));
    });
    if($('#state_id').val()) $('#state_id').trigger('change');

    // repeater helper
function repeater(btn, table, removeClass, templateId) {
  const tpl = $(templateId).html();

  // adding new row
  $(btn).on('click', function(e){
    e.preventDefault();
    let idx = $(`${table} tbody tr`).length;        // e.g. 0, 1, 2…
    let rowHtml = tpl.replace(/INDEX/g, idx);       // bump all names to [0], [1], [2], etc.
    let $row = $(rowHtml);

    // init select2 on new row
    $row.find('select.select2').select2({
      placeholder: function(){ return $(this).data('placeholder') },
      allowClear: true,
      width: '100%'
    });

    // append it
    $(`${table} tbody`).append($row);
  });

  // removing a row
  $(document).on('click', removeClass, function(e){
    e.preventDefault();
    e.stopPropagation();

    let $rows = $(`${table} tbody tr`);
    if ($rows.length > 1) {
      $(this).closest('tr').remove();
    } else {
      // if you only want to clear the last row rather than remove it:
      $(this).closest('tr').find('input,select').val('');
    }
  });
}
    repeater('#btnAddAcademic','#academicTable','.btnRemoveAcademic');
    repeater('#btnAddExperience','#experienceTable','.btnRemoveExperience');
    repeater('#btnAddQualification','#qualificationTable','.btnRemoveQualification', '#qualification-row-template');
    

    // Next/Prev
    $(document).on('click','button[data-next]',function(){
      let tgt = $(this).data('next'),
          btn = document.querySelector(`.nav-link[data-bs-target="#${tgt}"]`);
      if(btn) bootstrap.Tab.getOrCreateInstance(btn).show();
    });
  });
  </script>
@endpush
