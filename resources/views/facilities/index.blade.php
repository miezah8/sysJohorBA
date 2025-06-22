@extends('layouts.app')
@section('title','Facility Module')

@section('content')
<div class="card p-2">
  <div class="card-header d-flex justify-content-between">
    <h5 class="mb-0">List of Facilities</h5>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#facilityModal" data-mode="add">
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
              <button class="btn btn-outline-info btn-edit"
                      data-bs-toggle="modal"
                      data-bs-target="#facilityModal"
                      data-mode="edit"
                      data-id="{{ $f->id }}"
                      data-name="{{ $f->name }}"
                      data-status="{{ $f->status }}">
                <i class="fa-solid fa-pen-to-square me-1"></i>Edit
              </button>
              <form action="{{ route('facilities.destroy',$f->id) }}" method="POST" class="d-inline" 
                    onsubmit="return confirm('Delete this facility?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger btn-delete"><i class="fa-solid fa-trash me-1"></i>Delete</button>
              </form>
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
          <select class="form-select" id="facility_status" name="status">
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
<script>
  document.addEventListener('DOMContentLoaded', ()=> {
    // Init DataTable
    new simpleDatatables.DataTable("#datatable-search",{searchable:true,fixedHeight:true});

    $('#facilityModal').on('show.bs.modal', function(e){
      let mode = e.relatedTarget.dataset.mode;
      let form  = document.getElementById('facilityForm');
      let title = document.getElementById('facilityModalLabel');
      let methodField = document.getElementById('form_method');

      if(mode==='add'){
        title.textContent = 'Add Facility';
        form.action = "{{ route('facilities.store') }}";
        methodField.value = 'POST';
        form.querySelector('#facility_name').value = '';
        form.querySelector('#facility_status').value = 'active';
      } else {
        let btn    = e.relatedTarget;
        let id     = btn.dataset.id;
        let name   = btn.dataset.name;
        let status = btn.dataset.status;

        title.textContent = 'Edit Facility';
        form.action = `/facilities/${id}`;
        methodField.value = 'PUT';
        form.querySelector('#facility_name').value = name;
        form.querySelector('#facility_status').value = status;
      }
    });
  });
  
</script>
@endpush

{{-- no extra css needed beyond your app’s defaults --}}
