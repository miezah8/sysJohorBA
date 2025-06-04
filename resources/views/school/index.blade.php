@extends('layouts.app')
@section('title', 'School Module')

@section('breadcrumbParent', 'School')
{{-- @section('breadcrumbParentUrl', route('clubs.index'))  --}}
@section('breadcrumbCurrent', 'List of School')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of School</h5>
            <button class="btn btn-behance" data-bs-toggle="modal" data-bs-target="#schoolModal" data-mode="add">
                <i class="fa-solid fa-plus me-1"></i>Add School
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-flush" id="datatable-search">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>School Name</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schoolData as $index => $school)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $school->school_name }}</td>
                            <td>{{ $school->district_name }}</td>
                            <td>
                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#schoolModal"
                                    data-mode="edit" data-id="{{ $school->id_school }}">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button>
                                <button class="btn btn-outline-danger btn-delete" data-id="{{ $school->id_school }}">
                                    <i class="fa-solid fa-trash me-1"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- modal section --}}
    <div class="modal fade" id="schoolModal" aria-labelledby="schoolModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="schoolModalLabel"></h5>
                    <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"></button>
                </div>

                <form id="schoolForm">
                    <div class="modal-body">
                        <input name="id_school" type="hidden">

                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label" for="school_name">School Name</label>
                                <input class="form-control" id="school_name" name="school_name" type="text">
                            </div>
                            <div class="col">
                                <label class="form-label" for="sch_code">School Code</label>
                                <input class="form-control" id="sch_code" name="sch_code" type="text">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label" for="sc_address">School Address</label>
                                <textarea class="form-control" id="sc_address" name="sc_address" type="text"></textarea>
                            </div>
                            <div class="col">
                                <label class="form-label" for="postcode">Postcode</label>
                                <input class="form-control" id="postcode" name="postcode" type="text">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label" for="district_id">City</label>
                                <select class="form-select select2" id="district_id" name="district_id">
                                    <option value="">-- Select District --</option>
                                </select>
                            </div>

                            <div class="col">
                                <label class="form-label" for="state_id">State</label>
                                <select class="form-select select2" id="state_id" name="state_id">
                                    <option value="">-- Select State --</option>
                                </select>
                            </div>
                        </div>


                        <div class="row mb-2">
                            <div class="col">
                                <label class="form-label" for="no_tel">Telephone No.</label>
                                <input class="form-control" id="no_tel" name="no_tel" type="text">
                            </div>
                            <div class="col">
                                <label class="form-label" for="no_fax">Fax No.</label>
                                <input class="form-control" id="no_fax" name="no_fax" type="text">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label" for="email_sch">Email</label>
                            <input class="form-control" id="email_sch" name="email_sch" type="email">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                        <button class="btn btn-primary" id="saveBtn" type="submit">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- modal section --}}
@endsection

@push('css')
    <style>
        table th:first-child,
        table td:first-child {
            width: 1%;
            white-space: nowrap;
            text-align: center
                /* Prevents wrapping */
        }

        table th:last-child,
        table td:last-child {
            width: 15%;
            white-space: nowrap;
            /* Optional, depending on content */
        }

        td {
            font-size: 0.875em;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
                searchable: true,
                fixedHeight: true,
            });

            $('.select2').select2({
                dropdownParent: $('#schoolModal'),
                theme: 'bootstrap-5',
                width: '100%'
            });

            var $modal = $('#schoolModal');
            var $form = $('#schoolForm');
            var $modalTitle = $('#schoolModalLabel');
            var $submitBtn = $form.find('button[type="submit"]');
            var saveUrl = "{{ route('school.store') }}"; // for both create & update


            // Handle modal open
            $modal.on('show.bs.modal', function(e) {
                var button = $(e.relatedTarget);
                var mode = button.data('mode');
                var id = button.data('id');

                $form[0].reset();
                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();
                $submitBtn.prop('disabled', false).text('Save');

                if (mode === 'edit' && id) {
                    $modalTitle.text('Edit School');
                    $form.find('[name="id_school"]').val(id);
                    $submitBtn.prop('disabled', true).text('Loading...');

                    loadDistricts();
                    loadStates();

                    $.ajax({
                        url: '/school/' + id,
                        method: 'GET',
                        success: function(data) {
                            $.each(data, function(key, val) {
                                $form.find('[name="' + key + '"]').val(val);
                            });

                            loadDistricts(data.district_id);
                            loadStates(data.state_id);
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to load school data.'
                            });
                            $modal.modal('hide');
                        },
                        complete: function() {
                            $submitBtn.prop('disabled', false).text('Save');
                        }
                    });
                } else {
                    $modalTitle.text('Add School');
                    loadDistricts();
                    loadStates();
                }
            });

            // Handle form submission
            $form.on('submit', function(e) {
                e.preventDefault();

                var id = $form.find('[name="id_school"]').val();
                var isEdit = !!id;
                var method = isEdit ? 'PUT' : 'POST';
                var url = isEdit ? '/school/' + id : saveUrl;

                $form.find('.is-invalid').removeClass('is-invalid');
                $form.find('.invalid-feedback').remove();
                $submitBtn.prop('disabled', true).text('Saving...');

                var formData = $form.serializeArray();
                var postData = {};

                $.each(formData, function(i, field) {
                    postData[field.name] = field.value;
                });

                if (isEdit) postData._method = 'PUT';

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: postData,
                    success: function(response) {
                        $('#schoolModal').modal('hide');
                        $form[0].reset();

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'School saved successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, messages) {
                                var $input = $form.find('[name="' + field + '"]');
                                $input.addClass('is-invalid');
                                $input.after('<div class="invalid-feedback">' +
                                    messages[0] + '</div>');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message ||
                                    'An unexpected error occurred.',
                            });
                        }
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false).text('Save');
                    }
                });
            });

            function loadDistricts(selectedId) {
                var $ddl = $('#district_id');
                $ddl.prop('disabled', true).html('<option>Loading districts…</option>');

                $.get("{{ route('districts.list') }}", function(data) {
                    $ddl.empty().append('<option value="">-- Select District --</option>');
                    $.each(data, function(id, name) {
                        $ddl.append('<option value="' + id + '">' + name + '</option>');
                    });
                    if (selectedId) $ddl.val(selectedId).trigger('change');
                    $ddl.prop('disabled', false);
                });
            }

            function loadStates(selectedId) {
                var $ddl = $('#state_id');
                $ddl.prop('disabled', true).html('<option>Loading states…</option>');

                $.get("{{ route('states.list') }}", function(data) {
                    $ddl.empty().append('<option value="">-- Select State --</option>');
                    $.each(data, function(id, name) {
                        $ddl.append('<option value="' + id + '">' + name + '</option>');
                    });
                    if (selectedId) $ddl.val(selectedId).trigger('change');
                    $ddl.prop('disabled', false);
                });
            }
        });
    </script>

    <script>
        $(document).on('click', '.btn-delete', function() {
            const deleteId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/school/${deleteId}`,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'The school has been deleted.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to delete. Please try again.'
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
