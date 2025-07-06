@extends('layouts.app')
@section('title','Facility Module')

@section('content')
<div class="card p-2">
  <div class="card-header d-flex justify-content-between">
    <h5 class="mb-0">List of Facilities</h5>
    <button class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#facilityModal"
            data-mode="add">
      <i class="fa-solid fa-plus me-1"></i> Add Facility
    </button>
  </div>
  <div class="table-responsive">
    <table class="table table-flush" id="datatable-search">
      <thead class="thead-light">
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Status</th>
          <th style="width:15%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($facilities as $i => $f)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $f->name }}</td>
            <td>
              <span class="badge {{ $f->status=='active'?'bg-success':'bg-secondary' }}">
                {{ ucfirst($f->status) }}
              </span>
            </td>
            <td>
              <button type="button" class="btn btn-outline-info btn-edit"
                      data-bs-toggle="modal"
                      data-bs-target="#facilityModal"
                      data-mode="edit"
                      data-id="{{ $f->id }}"
                      data-name="{{ $f->name }}"
                      data-status="{{ $f->status }}">
                <i class="fa-solid fa-pen-to-square me-1"></i>Edit
              </button>
              <button type="button" class="btn btn-outline-danger btn-delete"
                      data-id="{{ $f->id }}">
                <i class="fa-solid fa-trash me-1"></i>Delete
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="facilityModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="facilityForm" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="facilityModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        @csrf
        <input type="hidden" name="_method" id="form_method" value="POST">
        <div class="mb-3">
          <label for="facility_name" class="form-label">Name</label>
          <input type="text" class="form-control" id="facility_name" name="name" required>
        </div>
        <div class="mb-3">
          <label for="facility_status" class="form-label">Status</label>
          <select class="form-select" id="facility_status" name="status" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
  {{-- jQuery (needed for AJAX) --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  {{-- SweetAlert2 for toasts --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
  $(function(){
    // 1) CSRF for AJAX
    $.ajaxSetup({ headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // 2) Init DataTable
    new simpleDatatables.DataTable("#datatable-search",{ searchable:true, fixedHeight:true });

    // 3) Modal show: configure add vs edit
    $('#facilityModal').on('show.bs.modal', function(e){
      const btn         = $(e.relatedTarget);
      const mode        = btn.data('mode');
      const form        = $('#facilityForm');
      const title       = $('#facilityModalLabel');
      const methodField = $('#form_method');

      form[0].reset();  
      if(mode === 'add'){
        title.text('Add Facility');
        form.attr('action', "{{ route('facilities.store') }}");
        methodField.val('POST');
      } else {
        title.text('Edit Facility');
        const id     = btn.data('id');
        const name   = btn.data('name');
        const status = btn.data('status');
        form.attr('action', `/facilities/${id}`);
        methodField.val('PUT');           // or 'PATCH'
        $('#facility_name').val(name);
        $('#facility_status').val(status);
      }
    });

    // 4) Handle Add/Edit submit via AJAX
    $('#facilityForm').submit(function(ev){
      ev.preventDefault();
      const form   = $(this);
      const action = form.attr('action');
      const data   = form.serialize();

      $('#saveBtn').prop('disabled',true).text('Saving...');
      $.post(action, data)
        .done(res => {
          $('#facilityModal').modal('hide');
          Swal.fire('Success', res.message, 'success')
               .then(()=> location.reload());
        })
        .fail(xhr => {
          const msg = xhr.status === 422
                    ? xhr.responseJSON.errors.name[0]
                    : 'An error occurred';
          Swal.fire('Error', msg, 'error');
        })
        .always(() => $('#saveBtn').prop('disabled',false).text('Save'));
    });

    // 5) Handle Delete via delegated AJAX
    $(document).on('click', '.btn-delete', function(ev){
      ev.preventDefault();
      if(!confirm('Delete this facility?')) return;

      const id = $(this).data('id');
      $.post(`/facilities/${id}`, { _method:'DELETE' })
        .done(res => {
          Swal.fire('Deleted', res.message, 'success')
               .then(()=> location.reload());
        })
        .fail(() => Swal.fire('Error','Failed to delete facility','error'));
    });
  });
  </script>
@endpush
