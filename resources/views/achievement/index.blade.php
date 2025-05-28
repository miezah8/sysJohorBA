@extends('layouts.app')
@section('title', 'Achievement Module')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of Achievements</h5>
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#addAchievementModal">
                <i class="fa-solid fa-plus me-1"></i> Add Achievement
            </button>
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
                                    data-bs-toggle="modal" data-bs-target="#editAchievementModal">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Achievement Modal --}}
    <div class="modal fade" id="addAchievementModal" tabindex="-1" aria-labelledby="addAchievementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="addAchievementForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAchievementModalLabel">Add Achievement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                        <button type="submit" class="btn btn-primary">Add Achievement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Achievement Modal --}}
    <div class="modal fade" id="editAchievementModal" tabindex="-1" aria-labelledby="editAchievementModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editAchievementForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAchievementModalLabel">Edit Achievement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id_achieve" name="id_achieve">

                        <div class="mb-3">
                            <label for="edit_achieve_bm" class="form-label">Achievement BM</label>
                            <input type="text" class="form-control" id="edit_achieve_bm" name="achieve_bm" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_achieve_bi" class="form-label">Achievement BI</label>
                            <input type="text" class="form-control" id="edit_achieve_bi" name="achieve_bi" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Achievement</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

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

                $('#edit_id_achieve').val(id);
                $('#edit_achieve_bm').val(bm);
                $('#edit_achieve_bi').val(bi);
            });

            // Handle form submit for adding a new achievement
            $('#addAchievementForm').on('submit', function(e) {
                e.preventDefault();

                const data = {
                    achieve_bm: $('#achieve_bm').val(),
                    achieve_bi: $('#achieve_bi').val(),
                    _token: '{{ csrf_token() }}' // Include CSRF token here
                };

                $.ajax({
                    url: '{{ route('achievement.store') }}',
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        $('#addAchievementModal').modal('hide');
                        location.reload();  // Reload the page to show updated data
                        alert(response.message);
                    },
                    error: function(xhr) {
                        alert('Error! Please try again.');
                        console.error(xhr.responseText);  // Log the error response
                    }
                });
            });

            // Handle form submit for updating achievement
            $('#editAchievementForm').on('submit', function(e) {
                e.preventDefault();

                const id = $('#edit_id_achieve').val();
                const data = {
                    achieve_bm: $('#edit_achieve_bm').val(),
                    achieve_bi: $('#edit_achieve_bi').val(),
                    _method: 'PUT',
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    url: `/achievement/${id}`,
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        $('#editAchievementModal').modal('hide');
                        location.reload();
                        alert(response.message);
                    },
                    error: function(xhr) {
                        alert('Error! Please try again.');
                    }
                });
            });
        });
    </script>
@endpush
