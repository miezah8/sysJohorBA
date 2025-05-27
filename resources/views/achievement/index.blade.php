@extends('layouts.app')
@section('title', 'Achievement Module')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of Achievements</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-flush" id="datatable-achievement">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Achievement BM</th>
                        <th>Achievement BI</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($achievementData as $index => $achieve)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $achieve->achieve_bm }}</td>
                            <td>{{ $achieve->achieve_bi }}</td>
                            <td>
                                <button class="btn btn-outline-info btn-edit" 
                                    data-id="{{ $achieve->id_achieve }}"
                                    data-bm="{{ $achieve->achieve_bm }}"
                                    data-bi="{{ $achieve->achieve_bi }}"
                                    data-bs-toggle="modal" data-bs-target="#achievementModal">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Edit Achievement Modal --}}
    <div class="modal fade" id="achievementModal" tabindex="-1" aria-labelledby="achievementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form id="achievementForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="achievementModalLabel">Edit Achievement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_achieve" id="id_achieve">

                        <div class="mb-3">
                            <label for="achieve_bm" class="form-label">Achievement BM</label>
                            <input type="text" class="form-control" id="achieve_bm" name="achieve_bm" required>
                        </div>

                        <div class="mb-3">
                            <label for="achieve_bi" class="form-label">Achievement BI</label>
                            <input type="text" class="form-control" id="achieve_bi" name="achieve_bi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Update</button>
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
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize datatable
            const dataTable = new simpleDatatables.DataTable("#datatable-achievement", {
                searchable: true,
                fixedHeight: true,
            });

            // When edit button clicked, populate modal inputs
            $('.btn-edit').on('click', function() {
                const id = $(this).data('id');
                const bm = $(this).data('bm');
                const bi = $(this).data('bi');

                $('#id_achieve').val(id);
                $('#achieve_bm').val(bm);
                $('#achieve_bi').val(bi);
            });

            // Handle form submit for update
            $('#achievementForm').on('submit', function(e) {
                e.preventDefault();
                $('#saveBtn').prop('disabled', true).text('Updating...');

                const id = $('#id_achieve').val();
                const data = {
                    achieve_bm: $('#achieve_bm').val(),
                    achieve_bi: $('#achieve_bi').val(),
                    _method: 'PUT',  // Laravel expects PUT for update
                    //_token: '{{ csrf_token() }}'
                };

                $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                $.ajax({
                    url: `/achievement/${id}`,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        // Close modal
                        $('#achievementModal').modal('hide');
                        alert('Achievement updated successfully!');
                        // Reload page or update row dynamically
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Update failed! Please try again.');
                        console.error(xhr.responseText);
                    },
                    complete: function() {
                        $('#saveBtn').prop('disabled', false).text('Update');
                    }
                });
            });
        });
    </script>
@endpush
