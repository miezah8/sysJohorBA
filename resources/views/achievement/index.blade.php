{{-- resources/views/achievement/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Achievement Module')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of Achievements</h5>
            <button
                class="btn btn-outline-success"
                data-bs-toggle="modal"
                data-bs-target="#addAchievementModal"
            >
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
                                {{-- Edit button --}}
                                <button
                                    class="btn btn-outline-info btn-edit"
                                    data-id="{{ $achieve->id_achieve }}"
                                    data-bm="{{ $achieve->achieve_bm }}"
                                    data-bi="{{ $achieve->achieve_bi }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editAchievementModal"
                                >
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button>

                                {{-- Delete button --}}
                                <button
                                    class="btn btn-outline-danger btn-delete"
                                    data-id="{{ $achieve->id_achieve }}"
                                >
                                    <i class="fa-solid fa-trash me-1"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add Achievement Modal --}}
    <div
        class="modal fade"
        id="addAchievementModal"
        tabindex="-1"
        aria-labelledby="addAchievementModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="addAchievementForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAchievementModalLabel">Add Achievement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="achieve_bm" class="form-label">Achievement BM</label>
                            <input
                                type="text"
                                class="form-control"
                                id="achieve_bm"
                                name="achieve_bm"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="achieve_bi" class="form-label">Achievement BI</label>
                            <input
                                type="text"
                                class="form-control"
                                id="achieve_bi"
                                name="achieve_bi"
                                required
                            >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Add Achievement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Achievement Modal --}}
    <div
        class="modal fade"
        id="editAchievementModal"
        tabindex="-1"
        aria-labelledby="editAchievementModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="editAchievementForm">
                    @csrf
                    {{-- We will inject _method=PATCH in JS --}}
                    <input type="hidden" id="edit_id_achieve" name="id_achieve">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAchievementModalLabel">Edit Achievement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit_achieve_bm" class="form-label">Achievement BM</label>
                            <input
                                type="text"
                                class="form-control"
                                id="edit_achieve_bm"
                                name="achieve_bm"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="edit_achieve_bi" class="form-label">Achievement BI</label>
                            <input
                                type="text"
                                class="form-control"
                                id="edit_achieve_bi"
                                name="achieve_bi"
                                required
                            >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Update Achievement
                        </button>
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
            text-align: center; /* Prevents wrapping */
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

    // 1) Initialize Simple-DataTables
    new simpleDatatables.DataTable("#datatable-achievement", {
        searchable: true,
        fixedHeight: true,
    });

    //
    // 2) “Edit” button: fill the fields in the modal
    //
    $('#datatable-achievement').on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        const bm = $(this).data('bm');
        const bi = $(this).data('bi');

        $('#edit_id_achieve').val(id);
        $('#edit_achieve_bm').val(bm);
        $('#edit_achieve_bi').val(bi);
    });

    //
    // 3) Submit “Add Achievement” via AJAX → POST to route('achievement.store')
    //
    $('#addAchievementForm').on('submit', function(e) {
        e.preventDefault();

        const payload = {
            achieve_bm: $('#achieve_bm').val(),
            achieve_bi: $('#achieve_bi').val(),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: '{{ route('achievement.store') }}',
            method: 'POST',
            data: payload,
            success: function(response) {
                $('#addAchievementModal').modal('hide');
                alert(response.message);
                location.reload(); // reload so the new row appears
            },
            error: function(xhr) {
                console.error(xhr.responseJSON || xhr.responseText);
                alert('Error! Please try again.');
            }
        });
    });

    //
    // 4) Submit “Edit Achievement” via AJAX → PATCH to route('achievement.update', id)
    //
    $('#editAchievementForm').on('submit', function(e) {
        e.preventDefault();

        const id = $('#edit_id_achieve').val();
        const payload = {
            achieve_bm: $('#edit_achieve_bm').val(),
            achieve_bi: $('#edit_achieve_bi').val(),
            _method: 'PATCH',            // Laravel expects PATCH (or PUT) for update
            _token: '{{ csrf_token() }}'
        };

        // Construct the URL by name, so it never mistakes it:
        const updateUrl = "{{ url('achievement') }}/" + id;

        $.ajax({
            url: updateUrl,
            method: 'POST', // always POST; Laravel reads _method=PATCH
            data: payload,
            success: function(response) {
                $('#editAchievementModal').modal('hide');
                alert(response.message);
                location.reload();
            },
            error: function(xhr) {
                console.error(xhr.responseJSON || xhr.responseText);
                alert('Error! Please try again.');
            }
        });
    });

    //
    // 5) “Delete” button: show confirmation + send DELETE to route('achievement.destroy', id)
    //
    $('#datatable-achievement').on('click', '.btn-delete', function() {
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
                    url: `/achievement/${deleteId}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'The achievement has been deleted.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
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
});
</script>
@endpush
