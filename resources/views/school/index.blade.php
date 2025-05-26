@extends('layouts.app')
@section('title', 'School Module')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of School</h5>
            <button class="btn btn-behance" data-bs-toggle="modal" data-bs-target="#schoolModal" data-mode="add">
                <i class="fa-solid fa-plus me-1"></i>Add
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
                                {{-- <button class="btn btn-outline-info" type="button">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button> --}}
                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#schoolModal"
                                    data-mode="edit" data-id="{{ $school->id_school }}">
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
    <div class="modal fade" id="schoolModal" tabindex="-1" aria-labelledby="schoolModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="schoolModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="schoolForm">
                    <div class="modal-body">
                        <input type="hidden" id="schoolId" name="id">
                        <div class="mb-3">
                            <label for="schoolName" class="form-label">School Name</label>
                            <input type="text" class="form-control" id="schoolName" name="name" required>
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
            const dataTableSearch = new simpleDatatables.DataTable(
                "#datatable-search", {
                    searchable: true,
                    fixedHeight: true,
                }
            );

            const $schoolModal = $('#schoolModal');
            const $schoolForm = $('#schoolForm');
            const $modalTitle = $('#schoolModalLabel');
            const $schoolIdInput = $('#schoolId');
            const $schoolNameInput = $('#schoolName');

            $schoolModal.on('show.bs.modal', function(event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const mode = button.data('mode');

                if (mode === 'edit') {
                    const id = button.data('id');
                    const name = button.data('name');

                    $modalTitle.text('Edit School');
                    $schoolIdInput.val(id);
                    $schoolNameInput.val(name);
                } else {
                    $modalTitle.text('Add School');
                    $schoolForm.trigger('reset');
                    $schoolIdInput.val('');
                }
            });

            $schoolForm.on('submit', function(e) {
                e.preventDefault();

                const id = $schoolIdInput.val();
                const name = $schoolNameInput.val();

                if (id) {
                    console.log('Editing school:', {
                        id,
                        name
                    });
                    // AJAX PUT or PATCH request here
                } else {
                    console.log('Adding new school:', {
                        name
                    });
                    // AJAX POST request here
                }

                $schoolModal.modal('hide');
                $schoolForm.trigger('reset');
            });
        });
    </script>
@endpush
