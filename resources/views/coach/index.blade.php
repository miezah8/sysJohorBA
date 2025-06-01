@extends('layouts.app')
@section('title', 'Coach Module')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of Coaches</h5>
            <button class="btn btn-behance" data-bs-toggle="modal" data-bs-target="#schoolModal" data-mode="add">
                <i class="fa-solid fa-plus me-1"></i>Add Coach
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-flush" id="datatable-search">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Coach Name</th>
                        <th>Total Players</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coachData as $index => $coach)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $coach->coach_fname }}</td>
                            <td><a class="{{ $coach->athletes_coach_count > 0 ? 'text-danger fw-bold' : '' }}" href="#">{{ $coach->athletes_coach_count }}</a></td>
                            <td>
                                {{-- <button class="btn btn-outline-info" type="button">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button> --}}
                                {{-- <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#schoolModal"
                                    data-mode="edit" data-id="{{ $school->id_school }}"
                                    data-name="{{ $school->school_name }}">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button> --}}
                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#schoolModal"
                                    data-mode="edit" data-id="{{ $coach->id_coach }}">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- modal section --}}
    <div class="modal fade" id="schoolModal" data-url="/schools" aria-labelledby="schoolModalLabel" aria-hidden="true"
        tabindex="-1">
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const dataTableSearch = new simpleDatatables.DataTable(
                "#datatable-search", {
                    searchable: true,
                    fixedHeight: true,
                }
            );

            $('.select2').select2({
                dropdownParent: $('#schoolModal'),
                theme: 'bootstrap-5',
                width: '100%'
            });


        });


        const $modal = $('#schoolModal');
        const $form = $('#schoolForm');
        const $modalTitle = $('#schoolModalLabel');
        const $submitButton = $form.find('button[type="submit"]');
        const baseUrl = $modal.data('url');
        const storeUrl = "{{ route('school.store') }}";
        const updateUrl = "{{ url('/school') }}"; // for PUT with ID appended


        $modal.on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const mode = button.data('mode');
            const id = button.data('id');

            $form.trigger('reset');
            $form.find('.is-invalid').removeClass('is-invalid');
            $submitButton.prop('disabled', false).text('Save');

            if (mode === 'edit' && id) {
                $modalTitle.text('Edit School');
                $form.find('[name="id_school"]').val(id); //NH update from id
                $submitButton.prop('disabled', true).text('Loading...');

                // Load districts first
                loadDistricts(); // Preload dropdown
                loadStates();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('school.show') }}",
                    data: {
                        selectedRecord: id
                    },
                    success: function(data) {
                        // Now populate form values
                        $.each(data, function(key, value) {
                            $form.find(`[name="${key}"]`).val(value);
                        });

                        // After setting form, set district dropdown specifically
                        loadDistricts(data.district_id);
                        loadStates(data.state_id);
                    },
                    error: function() {
                        alert('Failed to load school data.');
                        $modal.modal('hide');
                    },
                    complete: function() {
                        $submitButton.prop('disabled', false).text('Save');
                    }
                });

            } else {
                $modalTitle.text('Add School');
                loadDistricts(); // Load for Add mode
                loadStates();

            }
        });


        $('#schoolForm').on('submit', function(e) {
            e.preventDefault();

            const $form = $(this);
            const $submitButton = $form.find('button[type="submit"]');
            const id = $form.find('[name="id_school"]').val();
            const isEdit = Boolean(id);

            $submitButton.prop('disabled', true).text('Saving...');

            const formDataArray = $form.serializeArray();
            const formData = {};
            $.each(formDataArray, function(index, field) {
                formData[field.name] = field.value;
            });

            $.ajax({
                type: 'POST', // Laravel will still accept PUT via _method field
                url: isEdit ? `${updateUrl}/${id}` : storeUrl,
                data: isEdit ? {
                    ...formData,
                    _method: 'PUT'
                } : formData,
                success: function(response) {
                    console.log(isEdit ? 'Updated:' : 'Created:', response);
                    $('#schoolModal').modal('hide');
                    $form.trigger('reset');
                    window.location.reload();
                    // Optional: refresh DataTable
                },
                error: function(xhr) {
                    alert('An error occurred. Please try again.');
                },
                complete: function() {
                    $submitButton.prop('disabled', false).text('Save');
                }
            });
        });



        function loadDistricts(selectedId = null) {
            const $ddl = $('#district_id');
            $ddl.prop('disabled', true).empty().append('<option value="">Loading districts...</option>');

            $.get("{{ route('districts.list') }}", function(districts) {
                $ddl.empty().append('<option value="">-- Select District --</option>');

                $.each(districts, function(id, name) {
                    $ddl.append(new Option(name, id));
                });

                if (selectedId) {
                    $ddl.val(selectedId).trigger('change'); // trigger for select2 update
                }

                $ddl.prop('disabled', false);
            });
        }

        function loadStates(selectedId = null) {
            const $ddl = $('#state_id');
            $ddl.prop('disabled', true)
                .empty()
                .append('<option>Loading states…</option>');

            $.get("{{ route('states.list') }}", function(states) {
                $ddl.empty().append('<option value="">-- Select State --</option>');
                $.each(states, function(id, name) {
                    $ddl.append(new Option(name, id));
                });
                if (selectedId) {
                    $ddl.val(selectedId).trigger('change');
                }
                $ddl.prop('disabled', false);
            });
        }
    </script>
@endpush
