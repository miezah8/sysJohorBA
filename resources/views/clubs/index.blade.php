@extends('layouts.app')
@section('title', 'Club Module')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of Clubs</h5>
            <button class="btn btn-behance" data-bs-toggle="modal" data-bs-target="#clubModal" data-mode="add">
                <i class="fa-solid fa-plus me-1"></i>Add Club
            </button>
        </div>
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
                    @foreach ($clubs as $index => $club)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $club->club_name }}</td>
                            <td>
                                <a class="{{ $club->athletes_count> 0 ? 'text-danger fw-bold':'' }}" href="{{ route('clubs.players', $club->id_club) }}">
                                    {{ $club->athletes_count }}
                                </a>
                            </td>
                            <td>
                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#clubModal"
                                    data-mode="edit" data-id="{{ $club->id_club }}">
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
<div class="modal fade" id="clubModal" tabindex="-1" aria-labelledby="clubModalLabel" aria-hidden="true"
    data-url="/clubs">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clubModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="clubForm">
                <div class="modal-body">
                <input type="hidden" name="id_club">

                <div class="row mb-3">
                    <div class="col-md-6">
                    <label for="club_name" class="form-label">Club Name *</label>
                    <input type="text" id="club_name" name="club_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                    <label for="phone" class="form-label">Phone Number *</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                    <label for="sys_id" class="form-label">System ID</label>
                    <input type="text" id="sys_id" name="sys_id" class="form-control">
                    </div>
                </div>

                <h6>Club Information</h6>
                <div class="row mb-3">
                    <div class="col-md-8">
                    <label for="address" class="form-label">Address</label>
                    <textarea id="address" name="address" class="form-control"></textarea>
                    </div>
                    <div class="col-md-4">
                    <label for="postcode" class="form-label">Postcode</label>
                    <input type="text" id="postcode" name="postcode" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                    <label for="state" class="form-label">State</label>
                    <select id="state" name="state" class="form-select">
                        <option value="">Select State</option>
                        {{-- @foreach($states as $s) <option>{{ $s }}</option> @endforeach --}}
                    </select>
                    </div>
                    <div class="col-md-6">
                    <label for="district" class="form-label">District</label>
                    <select id="district" name="district" class="form-select">
                        <option value="">Select State First</option>
                    </select>
                    </div>
                </div>

  <h6>Facilities</h6>
  <div id="facilities-container"></div>
  <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-facility">
    <i class="fa-solid fa-plus me-1"></i> Add Facility
  </button>
</div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('css')
    <style>
        table th:first-child,
        table td:first-child {
            width: 1%;
            white-space: nowrap;
            text-align: center;
        }

        table th:last-child,
        table td:last-child {
            width: 15%;
            white-space: nowrap;
        }

        td {
            font-size: 0.875em;
        }

        .text-danger {
            color: #f44336 !important;
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

        // Initialize DataTable
        const dataTableSearch = new simpleDatatables.DataTable(
            "#datatable-search", {
                searchable: true,
                fixedHeight: true,
            }
        );

        // Facility management
        $('#add-facility').click(function() {
            const facilityHtml = `
                <div class="facility-entry mb-2 d-flex align-items-center">
                    <div class="flex-grow-1 me-2">
                        <input type="text" class="form-control" name="facilities[][type]" placeholder="Facility Type" required>
                    </div>
                    <div class="me-2" style="width: 100px;">
                        <input type="number" class="form-control" name="facilities[][quantity]" placeholder="Qty" min="1" value="1" required>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-facility">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            `;
            $('#facilities-container').append(facilityHtml);
        });

        $(document).on('click', '.remove-facility', function() {
            $(this).closest('.facility-entry').remove();
        });
    });

    // Modal handling
    const $modal = $('#clubModal');
    const $form = $('#clubForm');
    const $modalTitle = $('#clubModalLabel');
    const $submitButton = $form.find('button[type="submit"]');
    const baseUrl = $modal.data('url');
    const storeUrl = "{{ route('clubs.store') }}";
    const updateUrl = "{{ url('/clubs') }}";

    $modal.on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const mode = button.data('mode');
        const id = button.data('id');

        $form.trigger('reset');
        $('#facilities-container').empty();
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.invalid-feedback').remove();
        $submitButton.prop('disabled', false).text('Save');

        if (mode === 'edit' && id) {
            $modalTitle.text('Edit Club');
            $submitButton.text('Save Changes');
            $form.find('[name="id_club"]').val(id);
            $submitButton.prop('disabled', true).text('Loading...');

            $.ajax({
                type: 'GET',
                url: `${ baseUrl }/${ id}`,   // baseUrl is '/clubs'
                data: {
                    selectedRecord: id
                },
                success: function(data) {
                    // Populate main form fields
                    $form.find('[name="club_name"]').val(data.club.club_name);
                    $form.find('[name="sys_id"]').val(data.club.sys_id);

                    // Populate facilities
                    if (data.facilities && data.facilities.length > 0) {
                        data.facilities.forEach(function(facility) {
                            const facilityHtml = `
                                <div class="facility-entry mb-2 d-flex align-items-center">
                                    <div class="flex-grow-1 me-2">
                                        <input type="text" class="form-control" name="facilities[][type]" 
                                            value="${facility.facility_type}" placeholder="Facility Type" required>
                                    </div>
                                    <div class="me-2" style="width: 100px;">
                                        <input type="number" class="form-control" name="facilities[][quantity]" 
                                            value="${facility.quantity}" placeholder="Qty" min="1" required>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-facility">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            `;
                            $('#facilities-container').append(facilityHtml);
                        });
                    }
                },
                error: function(xhr) {
                    alert('Failed to load club data: ' + xhr.responseJSON.message);
                    $modal.modal('hide');
                },
                complete: function() {
                    $submitButton.prop('disabled', false).text('Save');
                }
            });
        } else {
            $modalTitle.text('Add Club');
            $submitButton.text('Add Club');
        }
    });

    // Form submission
    $('#clubForm').on('submit', function(e) {
        e.preventDefault();

        const $form = $(this);
        const $submitButton = $form.find('button[type="submit"]');
        const id = $form.find('[name="id_club"]').val();
        const isEdit = Boolean(id);

        $submitButton.prop('disabled', true).text('Saving...');

        // Clear previous validation errors
        $form.find('.is-invalid').removeClass('is-invalid');
        $form.find('.invalid-feedback').remove();

        // Prepare form data
        const formData = {
            club_name: $form.find('[name="club_name"]').val(),
            sys_id: $form.find('[name="sys_id"]').val(),
            facilities: []
        };

        // Collect facilities data
        $('.facility-entry').each(function() {
            const type = $(this).find('input[name*="[type]"]').val();
            const quantity = $(this).find('input[name*="[quantity]"]').val();
            if (type && quantity) {
                formData.facilities.push({
                    type: type,
                    quantity: quantity
                });
            }
        });

        $.ajax({
            type: 'POST',
            url: isEdit ? `${updateUrl}/${id}` : storeUrl,
            data: isEdit ? {...formData, _method: 'PUT'} : formData,
            success: function(response) {
                if (response.success) {
                    $modal.modal('hide');
                    window.location.reload(); // Refresh to show changes
                } else {
                    alert(response.message || 'Operation failed');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        const input = $form.find(`[name="${key}"]`);
                        if (input.length) {
                            input.addClass('is-invalid');
                            input.after(`<div class="invalid-feedback">${value[0]}</div>`);
                        } else {
                            // Handle array fields (like facilities)
                            const match = key.match(/^facilities\.(\d+)\.(.+)$/);
                            if (match) {
                                const index = match[1];
                                const field = match[2];
                                const facilityEntry = $('.facility-entry').eq(index);
                                if (facilityEntry.length) {
                                    const input = facilityEntry.find(`input[name*="[${field}]"]`);
                                    input.addClass('is-invalid');
                                    input.after(`<div class="invalid-feedback">${value[0]}</div>`);
                                }
                            }
                        }
                    });
                } else {
                    alert('An error occurred. Please try again.');
                }
            },
            complete: function() {
                $submitButton.prop('disabled', false).text('Save');
            }
        });
    });
</script>
@endpush