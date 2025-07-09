{{-- resources/views/coach/create.blade.php --}}
@extends('layouts.app')

@php
  $editing = ! empty($coach->id_coach);
@endphp

@section('title', $editing ? 'Edit Coach' : 'Add Coach')

@push('css')
  <link
    href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css"
    rel="stylesheet"
  />
@endpush

@section('content')
  <div class="card">
    <div class="card-header">
      <h4>{{ $editing ? 'Edit Coach' : 'Add Coach' }}</h4>
    </div>
    <div class="card-body">

      <form
        id="coachForm"
        action="{{ $editing
                    ? route('coach.update', $coach->id_coach)
                    : route('coach.store') }}"
        method="POST"
        enctype="multipart/form-data"
        novalidate
      >
        @csrf
        @if($editing) @method('PUT') @endif

        {{-- keep track of the coach ID so edit knows when to PUT vs POST --}}
        <input
          type="hidden"
          name="id_coach"
          id="id_coach"
          value="{{ $coach->id_coach ?? '' }}"
        >

        {{-- Tab navigation --}}
        <ul class="nav nav-tabs mb-3" id="coachTabs" role="tablist">
          @foreach([
            'personal'=>'Personal Info',
            'academic'=>'Academic',
            'experience'=>'Experience',
            'qualification'=>'Qualification',
            'club'=>'Club Info',
            'declaration'=>'Declaration',
          ] as $id=>$label)
            <li class="nav-item" role="presentation">
              <button
                class="nav-link {{ $loop->first ? 'active' : '' }}"
                id="tab-{{ $id }}"
                data-bs-toggle="tab"
                data-bs-target="#{{ $id }}"
                type="button"
                role="tab"
              >{{ $label }}</button>
            </li>
          @endforeach
        </ul>

        <div class="tab-content">

          {{-- 1) Personal Info --}}
          <div
            class="tab-pane fade show active"
            id="personal"
            role="tabpanel"
            aria-labelledby="tab-personal"
          >
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="gambar" class="form-label">Profile Image</label>
                <input
                  type="file"
                  name="gambar"
                  id="gambar"
                  class="form-control @error('gambar') is-invalid @enderror"
                  accept="image/*"
                >
                @error('gambar')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label for="nama_penuh" class="form-label">Full Name *</label>
                <input
                  type="text"
                  name="nama_penuh"
                  id="nama_penuh"
                  class="form-control @error('nama_penuh') is-invalid @enderror"
                  value="{{ old('nama_penuh', $coach->coach_fname) }}"
                  required
                >
                @error('nama_penuh')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="emel" class="form-label">Email *</label>
                <input
                  type="email"
                  name="emel"
                  id="emel"
                  class="form-control @error('emel') is-invalid @enderror"
                  value="{{ old('emel', optional($coach->user)->email) }}"
                  required
                >
                @error('emel')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label for="no_tel" class="form-label">Phone No. *</label>
                <input
                  type="text"
                  name="no_tel"
                  id="no_tel"
                  class="form-control @error('no_tel') is-invalid @enderror"
                  value="{{ old('no_tel', optional($coach->user)->contact_no) }}"
                  required
                >
                @error('no_tel')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="no_kad" class="form-label">IC Number / Passport *</label>
                <input
                  type="text"
                  name="no_kad"
                  id="no_kad"
                  class="form-control @error('no_kad') is-invalid @enderror"
                  value="{{ old('no_kad', optional($coach->userDetail)->ic_no) }}"
                  required
                >
                @error('no_kad')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label for="ic_picture" class="form-label">Upload IC/Passport *</label>
                <input
                  type="file"
                  name="ic_picture"
                  id="ic_picture"
                  class="form-control @error('ic_picture') is-invalid @enderror"
                  accept="image/*"
                >
                @error('ic_picture')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="nationality" class="form-label">Nationality *</label>
                <select
                  name="nationality"
                  id="nationality"
                  class="form-select select2 @error('nationality') is-invalid @enderror"
                  data-placeholder="Search nationality…"
                  required
                >
                  <option value="">Please select</option>
                  {{-- If you want Malaysia first --}}
                  @if($nationalities->contains('Malaysia'))
                    <option
                      value="{{ $nationalities->search('Malaysia') }}"
                      {{ old('nationality') == $nationalities->search('Malaysia') ? 'selected' : '' }}
                    >Malaysia</option>
                  @endif
                  @foreach($nationalities as $nid => $nname)
                    @if($nname !== 'Malaysia')
                      <option
                        value="{{ $nid }}"
                        {{ old('nationality', optional($coach->userDetail)->nationality) == $nid ? 'selected' : '' }}
                      >{{ $nname }}</option>
                    @endif
                  @endforeach
                </select>
                @error('nationality')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6 mb-3">
                <label for="alamat" class="form-label">Address *</label>
                <textarea
                  name="alamat"
                  id="alamat"
                  rows="3"
                  class="form-control @error('alamat') is-invalid @enderror"
                  required
                >{{ old('alamat', optional($coach->userDetail)->address) }}</textarea>
                @error('alamat')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row">
              <div class="col-md-4 mb-3">
                <label for="state_id" class="form-label">State *</label>
                <select
                  name="negeri"
                  id="state_id"
                  class="form-select @error('negeri') is-invalid @enderror"
                  required
                >
                  <option value="">Please select</option>
                  @foreach($states as $sid=>$sname)
                    <option
                      value="{{ $sid }}"
                      {{ old('negeri', optional($coach->userDetail)->state_id) == $sid ? 'selected':'' }}
                    >{{ $sname }}</option>
                  @endforeach
                </select>
                @error('negeri')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-4 mb-3">
                <label for="district_id" class="form-label">District *</label>
                <select
                  name="daerah"
                  id="district_id"
                  class="form-select @error('daerah') is-invalid @enderror"
                  required
                >
                  <option value="">Please select state first</option>
                  {{-- AJAX will replace --}}
                </select>
                @error('daerah')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-4 mb-3">
                <label for="poskod" class="form-label">Postcode *</label>
                <input
                  type="text"
                  name="poskod"
                  id="poskod"
                  class="form-control @error('poskod') is-invalid @enderror"
                  value="{{ old('poskod', optional($coach->userDetail)->postcode) }}"
                  required
                >
                @error('poskod')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="row mb-4">
              <div class="col-md-4">
                <label class="form-label d-block">Gender *</label>
                @foreach(['M'=>'Male','F'=>'Female'] as $val=>$lbl)
                  <div class="form-check form-check-inline">
                    <input
                      class="form-check-input @error('jantina') is-invalid @enderror"
                      type="radio"
                      name="jantina"
                      id="jantina_{{ $val }}"
                      value="{{ $val }}"
                      {{ old('jantina', optional($coach->userDetail)->gender) == $val ? 'checked':'' }}
                      required
                    >
                    <label class="form-check-label" for="jantina_{{ $val }}">{{ $lbl }}</label>
                  </div>
                @endforeach
                @error('jantina')
                  <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-4">
                <label for="ethnicity" class="form-label">Race *</label>
                <select
                  name="ethnicity"
                  id="ethnicity"
                  class="form-select @error('ethnicity') is-invalid @enderror"
                  required
                >
                  <option value="">Please select</option>
                  @foreach(['Malay','Chinese','Indian','Other'] as $race)
                    <option
                      value="{{ $race }}"
                      {{ old('ethnicity', optional($coach->userDetail)->race) == $race ? 'selected':'' }}
                    >{{ $race }}</option>
                  @endforeach
                </select>
                @error('ethnicity')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="text-end mb-4">
              <button
                type="button"
                class="btn btn-primary"
                data-next="academic"
              >Next</button>
            </div>
          </div>{{-- /personal --}}


          {{-- 2) Academic --}}
          <div class="tab-pane fade" id="academic" role="tabpanel" aria-labelledby="tab-academic">
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
                  <tr>
                    <td>
                      <input
                        type="text"
                        name="academic[0][education_level]"
                        class="form-control"
                        placeholder="e.g. Diploma in Sports Science"
                        required
                      >
                    </td>
                    <td>
                      <select
                        name="academic[0][institution_id]"
                        class="form-select select2"
                        data-placeholder="Search institution…"
                        required
                      >
                        <option value=""></option>
                        @foreach($institution as $iid=>$iname)
                          <option value="{{ $iid }}">{{ $iname }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <input
                        type="text"
                        name="academic[0][year]"
                        class="form-control"
                        placeholder="YYYY"
                        pattern="\d{4}"
                        required
                      >
                    </td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-outline-danger btnRemoveAcademic">×</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <button type="button" id="btnAddAcademic" class="btn btn-sm btn-outline-primary mb-3">
                + Add Qualification
              </button>
            </div>

            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-next="personal">Prev</button>
              <button type="button" class="btn btn-primary" data-next="experience">Next</button>
            </div>
          </div>{{-- /academic --}}


          {{-- 3) Experience --}}
          <div class="tab-pane fade" id="experience" role="tabpanel" aria-labelledby="tab-experience">
            <div class="table-responsive mb-3">
              <table class="table" id="experienceTable">
                <thead>
                  <tr>
                    <th>Activity</th>
                    <th>Position</th>
                    <th>Level</th>
                    <th>Organized By</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input type="text" name="experience[0][activity]"   class="form-control" required></td>
                    <td><input type="text" name="experience[0][position]"   class="form-control"></td>
                    <td><input type="text" name="experience[0][level]"      class="form-control"></td>
                    <td><input type="text" name="experience[0][organized_by]"class="form-control"></td>
                    <td><input type="date" name="experience[0][start_date]" class="form-control"></td>
                    <td><input type="date" name="experience[0][end_date]"   class="form-control"></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-outline-danger btnRemoveExperience">×</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <button type="button" id="btnAddExperience" class="btn btn-sm btn-outline-primary mb-3">
                + Add Experience
              </button>
            </div>

            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-next="academic">Prev</button>
              <button type="button" class="btn btn-primary" data-next="qualification">Next</button>
            </div>
          </div>{{-- /experience --}}


          {{-- 4) Qualification --}}
          <div class="tab-pane fade" id="qualification" role="tabpanel" aria-labelledby="tab-qualification">
            <div class="table-responsive mb-3">
              <table class="table" id="qualificationTable">
                <thead>
                  <tr>
                    <th>Course</th>
                    <th>Level</th>
                    <th>Date Passed</th>
                    <th>Accreditation</th>
                    <th>Certificate No.</th>
                    <th>Upload Cert.</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <select
                        name="qualification[0][course_id]"
                        class="form-select select2"
                        data-placeholder="Search course…"
                        required
                      >
                        <option value=""></option>
                        @foreach($courses as $cid => $cname)
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
                    <td><input type="date" name="qualification[0][pass_date]"    class="form-control"></td>
                    <td><input type="text" name="qualification[0][accreditation]"class="form-control"></td>
                    <td><input type="text" name="qualification[0][cert_number]"  class="form-control"></td>
                    <td><input type="file" name="qualification[0][cert_file]"    class="form-control"></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-sm btn-outline-danger btnRemoveQualification">×</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <button type="button" id="btnAddQualification" class="btn btn-sm btn-outline-primary mb-3">
                + Add Certification
              </button>
            </div>

            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-next="experience">Prev</button>
              <button type="button" class="btn btn-primary" data-next="club">Next</button>
            </div>
          </div>{{-- /qualification --}}


          {{-- 5) Club Info --}}
          <div class="tab-pane fade" id="club" role="tabpanel" aria-labelledby="tab-club">
            <div class="mb-3">
              <label for="club_id" class="form-label">Select Club *</label>
              <select
                name="club_id"
                id="club_id"
                class="form-select @error('club_id') is-invalid @enderror"
                required
              >
                <option value="">Select Club</option>
                @foreach($clubs as $cid=>$cn)
                  <option
                    value="{{ $cid }}"
                    {{ old('club_id', $coach->club_id) == $cid ? 'selected':'' }}
                  >
                    {{ $cn }}
                  </option>
                @endforeach
              </select>
              @error('club_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-next="qualification">Prev</button>
              <button type="button" class="btn btn-primary" data-next="declaration">Next</button>
            </div>
          </div>{{-- /club --}}


          {{-- 6) Declaration --}}
          <div class="tab-pane fade" id="declaration" role="tabpanel" aria-labelledby="tab-declaration">
            <div class="mb-3 form-check">
              <input
                class="form-check-input @error('declaration') is-invalid @enderror"
                type="checkbox"
                name="declaration"
                id="declaration"
                {{ old('declaration') ? 'checked':'' }}
                required
              >
              <label class="form-check-label" for="declaration">
                I hereby declare that all information provided is true and correct.
              </label>
              @error('declaration')
                <div class="text-danger">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-success">Submit Coach</button>
          </div>{{-- /declaration --}}

        </div><!-- /.tab-content -->

      </form>
    </div><!-- /.card-body -->
  </div><!-- /.card -->

@endsection

@push('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  $(document).ready(function(){
    // Initialize Select2
    $('.select2').select2({ placeholder: (_, element) => $(element).data('placeholder'), allowClear:true, width:'100%' });

    // AJAX load districts
    $('#state_id').on('change', function(){
      let sid = this.value, $dd = $('#district_id');
      if(!sid) return $dd.html('<option value="">Please select state first</option>');
      $dd.prop('disabled',true).html('<option>Loading…</option>');
      $.getJSON(`{{ url('coach/districts') }}/${sid}`)
        .done(list=>{
          let html = '<option value="">Please select</option>';
          $.each(list,(i,name)=> html += `<option value="${i}">${name}</option>`);
          $dd.html(html).prop('disabled',false);
        })
        .fail(_=> $dd.html('<option>Error loading</option>'));
    });
    // if old or editing
    if($('#state_id').val()) $('#state_id').trigger('change');

    // row repeater
    function repeater(btn, table, removeBtn){
      $(btn).on('click',function(){
        let $first = $(`${table} tbody tr:first`),
            idx    = $(`${table} tbody tr`).length,
            $row   = $first.clone();
        $row.find('input,select').each(function(){
          let nm = $(this).attr('name').replace(/\[\d+\]/,`[${idx}]`);
          $(this).attr('name',nm).val('');
          if($(this).is('select')) $(this).next('.select2-container').remove();
        });
        // re-init selects
        $row.find('select.select2').select2({ placeholder: (_,el)=>$(el).data('placeholder'), allowClear:true, width:'100%' });
        $(`${table} tbody`).append($row);
      });
      $(document).on('click', removeBtn, function(){
        if($(`${table} tbody tr`).length>1) $(this).closest('tr').remove();
      });
    }
    repeater('#btnAddAcademic','#academicTable','.btnRemoveAcademic');
    repeater('#btnAddExperience','#experienceTable','.btnRemoveExperience');
    repeater('#btnAddQualification','#qualificationTable','.btnRemoveQualification');

    // Next/Prev
    $('[data-next]').click(function(){
      let next = $(this).data('next'),
          tab  = document.querySelector(`.nav-link[data-bs-target="#${next}"]`);
      bootstrap.Tab.getOrCreateInstance(tab).show();
    });
  });
  </script>
@endpush
