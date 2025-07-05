{{-- resources/views/clubs/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Club Module')

@section('breadcrumbParent', 'Club')
@section('breadcrumbParentUrl', route('clubs.index'))
@section('breadcrumbCurrent', 'List of Clubs')

@section('content')
  <div class="card p-2">
    <div class="card-header d-flex justify-content-between">
      <h5 class="mb-0">List of Clubs</h5>
      <button class="btn btn-behance"
              data-bs-toggle="modal"
              data-bs-target="#clubModal"
              data-mode="add">
        <i class="fa-solid fa-plus me-1"></i>Add Club
      </button>
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">
      <table class="table table-flush" id="datatable-search">
        <thead class="thead-light">
          <tr>
            <th>No</th>
            <th>Club Name</th>
            <th>Total Players</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($clubs as $i => $club)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td>{{ $club->club_name }}</td>
              <td>
                <a href="{{ route('clubs.players', $club->id_club) }}"
                   class="{{ $club->athletes_count>0?'text-danger fw-bold':'' }}">
                  {{ $club->athletes_count }}
                </a>
              </td>
              <td>
                <button class="btn btn-outline-info"
                        data-bs-toggle="modal"
                        data-bs-target="#clubModal"
                        data-mode="edit"
                        data-id="{{ $club->id_club }}">
                  <i class="fa-solid fa-pen-to-square me-1"></i>Edit
                </button>
                <button class="btn btn-outline-danger btn-delete"
                        data-id="{{ $club->id_club }}">
                  <i class="fa-solid fa-trash me-1"></i>Delete
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- CLUB MODAL --}}
  <div class="modal fade" id="clubModal" tabindex="-1"
       aria-labelledby="clubModalLabel" aria-hidden="true"
       data-url="/clubs">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="clubModalLabel"></h5>
          <button type="button" class="btn-close"
                  data-bs-dismiss="modal"></button>
        </div>
        <form id="clubForm">
          <div class="modal-body">
            <input type="hidden" name="id_club">

            {{-- Club Name & Email --}}
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Club Name *</label>
                <input name="club_name" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email *</label>
                <input name="email" type="email" class="form-control" required>
              </div>
            </div>

            {{-- Phone --}}
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Phone Number *</label>
                <input name="phone" class="form-control" required>
              </div>
            </div>

            {{-- Information --}}
            <h6>Club Information</h6>
            <div class="row mb-3">
              <div class="col-md-8">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control"></textarea>
              </div>
              <div class="col-md-4">
                <label class="form-label">Postcode</label>
                <input name="postcode" class="form-control">
              </div>
            </div>

            {{-- State & District --}}
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">State</label>
                <select name="state_id" id="state" class="form-select" required>
                  <option value="">Select State</option>
                  @foreach($states as $s)
                    <option value="{{ $s->id_state }}">{{ $s->state_name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">District</label>
                <select name="district_id" id="district" class="form-select" required>
                  <option value="">Select State First</option>
                </select>
              </div>
            </div>

            {{-- Facilities --}}
            <h6>Facilities</h6>
            <div id="facilities-container"></div>
            <button type="button"
                    id="add-facility"
                    class="btn btn-sm btn-outline-primary mt-2">
              <i class="fa-solid fa-plus me-1"></i>Add Facility
            </button>
          </div>

          <div class="modal-footer">
            <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">Cancel</button>
            <button type="submit"
                    class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('css')
<style>
  table th:first-child, table td:first-child {
    width:1%; white-space:nowrap; text-align:center;
  }
  table th:last-child, table td:last-child {
    width:15%; white-space:nowrap;
  }
  td { font-size:.875em; }
  .text-danger { color:#f44336!important; }
</style>
@endpush

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function(){
  // CSRF for AJAX
  $.ajaxSetup({
    headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
  });

  // Data from server
  const STATES        = @json($states);
  const FACILITY_NAMES= @json($facilityNames);
  const DISTRICTS_URL = "{{ url('api/districts') }}";

  const $modal     = $('#clubModal');
  const $form      = $('#clubForm');
  const $submitBtn = $form.find('button[type="submit"]');
  const baseUrl    = $modal.data('url');       // '/clubs'
  const storeUrl   = "{{ route('clubs.store') }}";
  const updateUrl  = "{{ url('clubs') }}";

  // 1) Init DataTable
  new simpleDatatables.DataTable("#datatable-search", {
    searchable:true, fixedHeight:true
  });

  // 2) Add Facility
  $('#add-facility').click(function(){
    let options = FACILITY_NAMES.map(f=>
      `<option value="${f.id}">${f.name}</option>`
    ).join('');
    $('#facilities-container').append(`
      <div class="facility-entry mb-2 d-flex align-items-center">
        <select name="facilities[][facility_id]" class="form-select me-2" required>
          <option value="">Select Facility</option>${options}
        </select>
        <input name="facilities[][quantity]" type="number" min="1"
               class="form-control me-2" style="width:100px" value="1" required>
        <button type="button" class="btn btn-sm btn-outline-danger remove-facility">
          <i class="fa-solid fa-trash"></i>
        </button>
      </div>
    `);
  });

  // Remove one
  $(document).on('click','.remove-facility',function(){
    $(this).closest('.facility-entry').remove();
  });

    // Populate the State <select> on modal show
  function loadStates(selected=null) {
    let html = '<option value="">Select State</option>';
    STATES.forEach(s => {
      html += `<option value="${s.id_state}"${s.id_state==selected?' selected':''}>${s.state_name}</option>`;
    });
    $('#state').html(html);
  }

  // 3) State → District AJAX
  $('#state').change(function(){
    let sid = this.value;
    if(!sid){
      return $('#district').html('<option value="">Select State First</option>');
    }
    fetch(`${DISTRICTS_URL}/${sid}`)
      .then(r=>r.json())
      .then(list=>{
        let opts = '<option value="">Select District</option>';
        list.forEach(d=>{
          opts += `<option value="${d.id_district}">${d.district_name}</option>`;
        });
        $('#district').html(opts);
      });
  });

  // 4) Modal show: add vs edit
  $modal.on('show.bs.modal', function(e){
    let btn  = $(e.relatedTarget),
        mode = btn.data('mode'),
        id   = btn.data('id');

    // reset
    $form.trigger('reset');
    $('#facilities-container').empty();
    $form.find('.is-invalid').removeClass('is-invalid');
    $form.find('.invalid-feedback').remove();
    $submitBtn.prop('disabled',false);

    // Reset district select
    $('#district').html('<option value="">Select State First</option>');

    if(mode==='edit' && id){
      $modal.find('.modal-title').text('Edit Club');
      $submitBtn.text('Save Changes').prop('disabled',true);
      // fetch data
      $.getJSON(`${baseUrl}/${id}`, function(res){
        let c = res.club;
        $form.find('[name="id_club"]').val(c.id_club);
        $form.find('[name="club_name"]').val(c.club_name);
        $form.find('[name="email"]').val(c.email);
        $form.find('[name="phone"]').val(c.phone);
        $form.find('[name="address"]').val(c.address);
        $form.find('[name="postcode"]').val(c.postcode);

        // select state & then load districts
        $('#state').val(c.state_id).trigger('change');
        setTimeout(()=>$('#district').val(c.district_id),300);

        // facilities
        res.facilities.forEach(fac=>{
          let options = FACILITY_NAMES.map(f=>
            `<option value="${f.id}"${f.id==fac.facility_id?' selected':''}>${f.name}</option>`
          ).join('');
          $('#facilities-container').append(`
            <div class="facility-entry mb-2 d-flex align-items-center">
              <select name="facilities[][facility_id]" class="form-select me-2" required>
                <option value="">Select Facility</option>
                ${options}
              </select>
              <input name="facilities[][quantity]" type="number" min="1"
                     class="form-control me-2" style="width:100px"
                     value="${fac.quantity}" required>
              <button type="button" class="btn btn-sm btn-outline-danger remove-facility">
                <i class="fa-solid fa-trash"></i>
              </button>
            </div>
          `);
        });
      })
      .fail(()=>alert('Failed to load club data'))
      .always(()=>$submitBtn.prop('disabled',false));
    }
    else {
      $modal.find('.modal-title').text('Add Club');
      $submitBtn.text('Add Club');
    }
  });

  // 5) Form submit AJAX
  $form.submit(function(ev){
    ev.preventDefault();
    let id   = $form.find('[name="id_club"]').val(),
        isEd = Boolean(id),
        url  = isEd ? `${updateUrl}/${id}` : storeUrl,
        payload = {
          club_name: $form.find('[name="club_name"]').val(),
          email:     $form.find('[name="email"]').val(),
          phone:     $form.find('[name="phone"]').val(),
          address:   $form.find('[name="address"]').val(),
          postcode:  $form.find('[name="postcode"]').val(),
          state_id:  $form.find('[name="state_id"],[name="state"]').val(),
          district_id:$form.find('[name="district_id"],[name="district"]').val(),
          facilities:[]
        };

    $('.facility-entry').each(function(){
      let id = $(this).find('select').val(),
          qty  = $(this).find('input').val();
      if(id && qty) payload.facilities.push({facility_id:id,quantity:qty});
    });

    $submitBtn.prop('disabled',true).text('Saving...');
    $.ajax({
      url, method:'POST',
      data: isEd?{...payload,_method:'PUT'}:payload,
        success(res) {
        if (res.success) {
            // show a green “success” popup with your message
            Swal.fire({
            icon: 'success',
            title: res.message || (isEd ? 'Club updated!' : 'New club added!'),
            showConfirmButton: false,
            timer: 1500
            }).then(() => {
            // only after the toast disappears do we hide & reload
            $modal.modal('hide');
            location.reload();
            });
        } else {
            Swal.fire('Oops', res.message || 'Something went wrong', 'error');
        }
        },
      error(xhr){
        if(xhr.status===422){
          let errs = xhr.responseJSON.errors;
          Object.keys(errs).forEach(k=>{
            let el = $form.find(`[name="${k}"]`);
            if(el.length){
              el.addClass('is-invalid')
                .after(`<div class="invalid-feedback">${errs[k][0]}</div>`);
            }
          });
        } else alert('Error occurred');
      },
      complete(){
        $submitBtn.prop('disabled',false).text(isEd?'Save Changes':'Add Club');
      }


      
    });
  });

  // 6) Delete handler
  $(document).on('click','.btn-delete',function(){
    if(!confirm('Delete this club?')) return;
    let id = $(this).data('id');
    $.post(`${baseUrl}/${id}`,{_method:'DELETE'},()=>{
      location.reload();
    });
  });
});
</script>
@endpush
