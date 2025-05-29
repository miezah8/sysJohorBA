@extends('layouts.app')
@section('title', 'Sanction Module')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of Sanction</h5>
            <button class="btn btn-behance" data-bs-toggle="modal" data-bs-target="#sanctionModal" data-mode="add">
                <i class="fa-solid fa-plus me-1"></i>Add
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-flush" id="datatable-search">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Sanction</th>
                        <th>Applicant</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($SanctionData as $index => $sanction)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sanction->sanction_name }}</td>
                            <td>{{ $sanction->sanction_name }}</td>
                            <td>
                                {{-- <button class="btn btn-outline-info" type="button">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button> --}}
                                {{-- <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#schoolModal"
                                    data-mode="edit" data-id="{{ $school->id_school }}"
                                    data-name="{{ $school->school_name }}">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button> --}}
                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#sanctionModal"
                                    data-mode="edit" data-id="{{ $sanction->id_sanction }}">
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
    <div class="modal fade" id="sanctionModal" tabindex="-1" aria-labelledby="sanctionModalLabel" aria-hidden="true"
        data-url="/sanction">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sanctionModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="sanctionForm">
                    <div class="modal-body">
                        <input type="hidden" name="id_sanction">

                        <div class="row mb-2">
                            <div class="col">
                                <label for="sanction_name" class="form-label">Sanction</label>
                                <input type="text" class="form-control" id="sanction_name" name="sanction_name" >
                            </div>
                            <div class="col">
                                <label for="sch_code" class="form-label">School Code</label>
                                <input type="text" class="form-control" id="sch_code" name="sch_code" >
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <label for="sc_address" class="form-label">School Address</label>
                                <textarea type="text" class="form-control" id="sc_address" name="sc_address" ></textarea>
                            </div>
                            <div class="col">
                                <label for="postcode" class="form-label">Postcode</label>
                                <input type="text" class="form-control" id="postcode" name="postcode" >
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col">
                                <label for="district_id" class="form-label">City</label>
                                <select class="form-select select2" id="district_id" name="district_id" >
                                    <option value="">-- Select District --</option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="state_id" class="form-label">State</label>
                                <select class="form-select select2" id="state_id" name="state_id">
                                    <option value="">-- Select State --</option>
                                </select>
                            </div>
                        </div>


                        <div class="row mb-2">
                            <div class="col">
                                <label for="no_tel" class="form-label">Telephone No.</label>
                                <input type="text" class="form-control" id="no_tel" name="no_tel" >
                            </div>
                            <div class="col">
                                <label for="no_fax" class="form-label">Fax No.</label>
                                <input type="text" class="form-control" id="no_fax" name="no_fax">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="email_sch" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_sch" name="email_sch" >
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
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


        const $modal = $('#sanctionModal');
        const $form = $('#sanctionForm');
        const $modalTitle = $('#sanctionModalLabel');
        const $submitButton = $form.find('button[type="submit"]');
        const baseUrl = $modal.data('url');
        const storeUrl = "{{ route('sanction.store') }}";
        const updateUrl = "{{ url('/sanction') }}"; // for PUT with ID appended


        $modal.on('show.bs.modal', function(event) {
            const button = $(event.relatedTarget);
            const mode = button.data('mode');
            const id = button.data('id');

            $form.trigger('reset');
            $form.find('.is-invalid').removeClass('is-invalid');
            $submitButton.prop('disabled', false).text('Save');

            if (mode === 'edit' && id) {
                $modalTitle.text('Edit Sanction');
                $form.find('[name="id_sanction"]').val(id); 
                $submitButton.prop('disabled', true).text('Loading...');

                // Load districts first
                loadDistricts(); // Preload dropdown
                loadStates();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('sanction.show') }}",
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
                $modalTitle.text('Add Sanction');
                loadDistricts(); // Load for Add mode
                loadStates();
                
            }
        });


        $('#sanctionForm').on('submit', function(e) {
            e.preventDefault();

            const $form = $(this);
            const $submitButton = $form.find('button[type="submit"]');
            const id = $form.find('[name="id_sanction"]').val();
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
                data: isEdit ? {...formData, _method: 'PUT'} : formData,
                success: function(response) {
                    console.log(isEdit ? 'Updated:' : 'Created:', response);
                    $('#sanctionModal').modal('hide');
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
