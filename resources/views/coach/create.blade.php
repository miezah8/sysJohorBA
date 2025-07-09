{{-- resources/views/coach/create.blade.php --}}
@extends('layouts.app')

@php
  // editing if we have an existing coach record
  $editing = ! empty($coach->id_coach);
@endphp

@section('title', $editing ? 'Edit Coach' : 'Add Coach')

@push('css')
  <!-- SELECT2 CSS (after your app.css) -->
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

        <input
          type="hidden"
          id="id_coach"
          name="id_coach"
          value="{{ $coach->id_coach ?? '' }}"
        >

        {{-- Nav Tabs --}}
        <ul class="nav nav-tabs" id="coachTabs" role="tablist">
          @foreach([
            'personal'=>'Personal Info',
            'academic'=>'Academic',
            'experience'=>'Experience',
            'qualification'=>'Qualification',
            'club'=>'Club Info',
            'declaration'=>'Declaration'
          ] as $id=>$label)
            <li class="nav-item">
              <button
                class="nav-link {{ $loop->first ? 'active' : '' }}"
                data-bs-toggle="tab"
                data-bs-target="#{{ $id }}"
                type="button"
              >
                {{ $label }}
              </button>
            </li>
          @endforeach
        </ul>

        <div class="tab-content pt-3">

          {{-- 1) Personal Info --}}
          <div class="tab-pane fade show active" id="personal" role="tabpanel">
            <div class="row mb-3">
              <div class="col-md-6">
                <label>Profile Image *</label>
                <input
                  type="file"
                  name="gambar"
                  class="form-control"
                  accept="image/*"
                  {{-- {{ $editing ? '' : 'required' }} --}}
                >
              </div>
              <div class="col-md-6">
                <label>Full Name *</label>
                <input
                  type="text"
                  name="nama_penuh"
                  value="{{ old('nama_penuh',$coach->userDetail->nama_penuh) }}"
                  class="form-control"
                  required
                >
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label>Email *</label>
                <input
                  type="email"
                  name="emel"
                  value="{{ old('emel',$coach->user->email) }}"
                  class="form-control"
                  required
                >
              </div>
              <div class="col-md-6">
                <label>Phone No. *</label>
                <input
                  type="text"
                  name="no_tel"
                  value="{{ old('no_tel',$coach->user->contact_no) }}"
                  class="form-control"
                  required
                >
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label>IC Number / Passport *</label>
                <input
                  type="text"
                  name="no_kad"
                  value="{{ old('no_kad',$coach->userDetail->ic_no) }}"
                  class="form-control"
                  required
                >
              </div>
              <div class="col-md-6">
                <label>Upload IC/Passport *</label>
                <input
                  type="file"
                  name="ic_picture"
                  class="form-control"
                  accept="image/*"
                  {{ $editing ? '' : 'required' }}
                >
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label>Nationality *</label>
<select name="nationality" class="form-select select2" required>
  <option value="">Please select</option>

  {{-- Malaysia first --}}
  @if($nationalities->contains('Malaysia'))
    @php
      $malayId = $nationalities->search('Malaysia');
    @endphp
    <option
      value="{{ $malayId }}"
      {{ old('nationality',$coach->userDetail->nationality)==$malayId ? 'selected':'' }}
    >Malaysia</option>
  @endif

  {{-- then the rest --}}
  @foreach($nationalities as $nid => $nname)
    @if($nname!=='Malaysia')
      <option
        value="{{ $nid }}"
        {{ old('nationality',$coach->userDetail->nationality)==$nid ? 'selected':'' }}
      >{{ $nname }}</option>
    @endif
  @endforeach
</select>
              </div>
              <div class="col-md-6">
                <label>Address *</label>
                <textarea
                  name="alamat"
                  class="form-control"
                  rows="3"
                  required
                >{{ old('alamat',$coach->userDetail->address) }}</textarea>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-4">
                <label>State *</label>
                <select
                  id="state_id"
                  name="negeri"
                  class="form-select"
                  required
                >
                  <option value="">Please select</option>
                  @foreach($states as $sid=>$sname)
                    <option
                      value="{{ $sid }}"
                      {{ old('negeri',$coach->userDetail->state_id)==$sid?'selected':'' }}
                    >
                      {{ $sname }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label>District *</label>
                <select
                  id="district_id"
                  name="daerah"
                  class="form-select"
                  required
                >
                  <option value="">Please select state first</option>
                </select>
              </div>
              <div class="col-md-4">
                <label>Postcode *</label>
                <input
                  type="text"
                  name="poskod"
                  value="{{ old('poskod',$coach->userDetail->postcode) }}"
                  class="form-control"
                  required
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
                      name="jantina"
                      value="{{ $val }}"
                      {{ old('jantina',$coach->userDetail->gender)==$val?'checked':'' }}
                      required
                    >
                    <label class="form-check-label">{{ $lbl }}</label>
                  </div>
                @endforeach
              </div>
              <div class="col-md-4">
                <label>Race *</label>
                <select name="ethnicity" class="form-select" required>
                  <option value="">Please select</option>
                  @foreach(['Malay','Chinese','Indian','Other'] as $race)
                    <option
                      value="{{ $race }}"
                      {{ old('ethnicity',$coach->userDetail->race)==$race?'selected':'' }}
                    >
                      {{ $race }}
                    </option>
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

          {{-- 2) Academic --}}
          <div class="tab-pane fade" id="academic" role="tabpanel">
            <div class="table-responsive mb-3">
              <table class="table" id="academicTable">
                <thead>
                  <tr>
                    <th style="width:40%">
                      Qualification (e.g. Diploma in Sports Science)
                    </th>
                    <th style="width:40%">Institution Attended</th>
                    <th style="width:15%">Year</th>
                    <th style="width:5%"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <input
                        type="text"
                        name="academic[0][education_level]"
                        class="form-control"
                        placeholder="Enter qualification"
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
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-danger btnRemoveAcademic"
                      >×</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <button
                type="button"
                id="btnAddAcademic"
                class="btn btn-sm btn-outline-primary mb-3"
              >
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

          {{-- 3) Experience --}}
          <div class="tab-pane fade" id="experience" role="tabpanel">
            <div class="table-responsive mb-3">
              <table class="table" id="experienceTable">
                <thead>
                  <tr>
                    <th>Activity/Competition</th>
                    <th>Position</th>
                    <th>Level</th>
                    <th>Organized By</th>
                    <th>Start</th>
                    <th>End</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <input
                        type="text"
                        name="experience[0][activity]"
                        class="form-control"
                        required
                      >
                    </td>
                    <td><input type="text" name="experience[0][position]"     class="form-control"></td>
                    <td><input type="text" name="experience[0][level]"        class="form-control"></td>
                    <td><input type="text" name="experience[0][organized_by]" class="form-control"></td>
                    <td><input type="date" name="experience[0][start_date]"   class="form-control"></td>
                    <td><input type="date" name="experience[0][end_date]"     class="form-control"></td>
                    <td class="text-center">
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-danger btnRemoveExperience"
                      >×</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <button
                type="button"
                id="btnAddExperience"
                class="btn btn-sm btn-outline-primary mb-3"
              >
                <i class="fa-solid fa-plus"></i> Add Experience
              </button>
            </div>
            <div class="d-flex justify-content-between">
              <button
                type="button"
                class="btn btn-secondary"
                data-next="academic"
                data-bs-toggle="tab"
                data-bs-target="#academic"
              >Prev</button>
              <button
                type="button"
                class="btn btn-primary"
                data-next="qualification"
                data-bs-toggle="tab"
                data-bs-target="#qualification"
              >Next</button>
            </div>
          </div>

          {{-- 4) Qualification --}}
          <div class="tab-pane fade" id="qualification" role="tabpanel">
            <div class="table-responsive mb-3">
              <table class="table" id="qualificationTable">
                <thead>
                  <tr>
                    <th>Course/Certificate</th>
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
                    <td>  <select
                          name="qualification[0][course_id]"
                          class="form-select select2"
                          data-placeholder="Search course…"
                          required
                        >
                          <option value=""></option>
                          @foreach($courses as $cid => $cname)
                            <option value="{{ $cid }}">
                              {{ $cname }}
                            </option>
                          @endforeach
                        </select></td>
                    <td>    <select name="qualification[0][level]" class="form-select" required>
      <option value="NA">NA</option>
      <option value="Level 1">Level 1</option>
      <option value="Level 2">Level 2</option>
      <option value="Level 3">Level 3</option>
    </select></td>
                    <td><input type="date" name="qualification[0][pass_date]"    class="form-control"></td>
                    <td><input type="text" name="qualification[0][accreditation]"class="form-control"></td>
                    <td><input type="text" name="qualification[0][cert_number]"  class="form-control"></td>
                    <td><input type="file" name="qualification[0][cert_file]"    class="form-control"></td>
                    <td class="text-center">
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-danger btnRemoveQualification"
                      >×</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <button
                type="button"
                id="btnAddQualification"
                class="btn btn-sm btn-outline-primary mb-3"
              >
                <i class="fa-solid fa-plus"></i> Add Certification
              </button>
            </div>
            <div class="d-flex justify-content-between">
              <button
                type="button"
                class="btn btn-secondary"
                data-next="experience"
                data-bs-toggle="tab"
                data-bs-target="#experience"
              >Prev</button>
              <button
                type="button"
                class="btn btn-primary"
                data-next="club"
                data-bs-toggle="tab"
                data-bs-target="#club"
              >Next</button>
            </div>
          </div>

          {{-- 5) Club Info --}}
          <div class="tab-pane fade" id="club" role="tabpanel">
            <div class="mb-3">
              <label>Select Club *</label>
              <select name="club_id" class="form-select" required>
                <option value="">Select Club</option>
                @foreach($clubs as $cid=>$cn)
                  <option
                    value="{{ $cid }}"
                    {{ old('club_id',$coach->club_id)==$cid?'selected':'' }}
                  >
                    {{ $cn }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="d-flex justify-content-between">
              <button
                type="button"
                class="btn btn-secondary"
                data-next="qualification"
                data-bs-toggle="tab"
                data-bs-target="#qualification"
              >Prev</button>
              <button
                type="button"
                class="btn btn-primary"
                data-next="declaration"
                data-bs-toggle="tab"
                data-bs-target="#declaration"
              >Next</button>
            </div>
          </div>

          {{-- 6) Declaration --}}
          <div class="tab-pane fade" id="declaration" role="tabpanel">
            <div class="form-check mb-3">
              <input
                class="form-check-input"
                type="checkbox"
                name="declaration"
                id="decl"
                {{ old('declaration')?'checked':'' }}
                required
              >
              <label class="form-check-label" for="decl">
                I hereby declare that all information provided is true and correct.
              </label>
            </div>
            <button type="submit" class="btn btn-success">Submit Coach</button>
          </div>

        </div><!-- /.tab-content -->

      </form>
    </div><!-- /.card-body -->
  </div><!-- /.card -->
@endsection

@push('scripts')
  <!-- 1) jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- 2) Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
  <!-- 3) Bootstrap bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  $(function(){
    //
    // Initialize Select2 once it’s loaded
    $('.select2').select2({
      placeholder: function(){ return $(this).data('placeholder') },
      allowClear: true,
      width: '100%'
    });

    //
    // State → District AJAX loader
    $('#state_id').on('change', function(){
      const sid = this.value;
      const $dd = $('#district_id');

      if (! sid) {
        return $dd.html('<option value="">Select state first</option>');
      }

      $dd.prop('disabled', true).html('<option>Loading…</option>');

      // must match your route: /coach/districts/{stateId}
      $.getJSON(`{{ url('coach/districts') }}/${sid}`)
       .done(function(list){
         let html = '<option value="">Please select district</option>';
         $.each(list, function(id,name){
           html += `<option value="${id}">${name}</option>`;
         });
         $dd.html(html).prop('disabled', false);
       })
       .fail(function(){
         $dd.html('<option value="">Error loading districts</option>');
       });
    });

    // If editing or old-input present, fire once on load
    if ($('#state_id').val()) {
      $('#state_id').trigger('change');
    }

    //
    // Row‐repeater helper
    function repeater(btn, table, removeClass) {
      $(btn).on('click', function(){
        let $first = $(`${table} tbody tr:first`);
        let idx    = $(`${table} tbody tr`).length;
        let $row   = $first.clone();

        // reset names & values
        $row.find('input, select').each(function(){
          let name = $(this).attr('name')
                           .replace(/\[\d+\]/, `[${idx}]`);
          $(this).attr('name', name).val('');
        });

        // re-init any select2 in the clone
        $row.find('select.select2').each(function(){
          $(this).next('.select2-container').remove();
          $(this).select2({
            placeholder: $(this).data('placeholder'),
            allowClear: true,
            width: '100%'
          });
        });

        $(`${table} tbody`).append($row);
      });

      // removal
      $(document).on('click', removeClass, function(){
        if ($(`${table} tbody tr`).length > 1) {
          $(this).closest('tr').remove();
        }
      });
    }

    repeater('#btnAddAcademic',     '#academicTable',     '.btnRemoveAcademic');
    repeater('#btnAddExperience',   '#experienceTable',   '.btnRemoveExperience');
    repeater('#btnAddQualification','#qualificationTable','.btnRemoveQualification');

    // Next/Prev buttons
    $(document).on('click', 'button[data-next]', function(){
      // do your client‐side validation here if you want…

      // figure out the ID of the next pane
      const nextId = $(this).data('next');                    // e.g. 'academic'
      // find the corresponding tab button
      const tabButton = document.querySelector(
        `.nav-link[data-bs-target="#${nextId}"]`
      );
      if (! tabButton) return console.warn("No tab for", nextId);

      // use Bootstrap's Tab API to show it
      bootstrap.Tab.getOrCreateInstance(tabButton).show();
    });    
    //
    // Next/Prev buttons: validate current pane, AJAX‐save, Bootstrap auto‐tabs
  //   $(document).on('click','button[data-next]',function(){
  //     let $pane = $('.tab-pane.show.active');
  //     let valid = true;

  //     // 1) Client-side HTML5 validation
  //     $pane.find('input, select, textarea').each(function(){
  //       if (! this.checkValidity()) {
  //         this.reportValidity();
  //         valid = false;
  //         return false;
  //       }
  //     });
  //     if (! valid) return;

  //     // 2) Build payload BUT SKIP file inputs
  //     let cid    = $('#id_coach').val(),
  //         url    = $('#coachForm').attr('action'),
  //         method = cid ? 'PUT' : 'POST',
  //         data   = { _token: $('meta[name="csrf-token"]').attr('content') };

  //     if (method!=='POST') data._method = method;

  //     // gather just this pane’s fields
  //     $pane.find('input:not([type=file]), select, textarea').each(function(){
  //       data[ this.name ] = $(this).val();
  //     });

  //     $.post(url, data)
  //      .done(function(res){
  //        if (! cid && res.data?.id_coach) {
  //          cid = res.data.id_coach;
  //          $('#id_coach').val(cid);
  //          $('#coachForm').attr('action', `/coach/${cid}`);
  //        }
  //        // Bootstrap toggles to target tab automatically
  //      })
  //      .fail(function(xhr){
  //        alert(xhr.responseJSON?.message || 'Save failed');
  //      });
  //   });
   });
  </script>
@endpush
