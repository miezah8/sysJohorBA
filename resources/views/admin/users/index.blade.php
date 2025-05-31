@extends('layouts.app')
@section('title', 'User Module')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of Registered Users</h5>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#userModal" data-mode="add">
                    <i class="fa-solid fa-plus me-1"></i> Add New User
                </button> 
          
        </div>

        <div class="table-responsive">
            <table class="table table-flush" id="datatable-search">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>IC Number</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Role(s)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->ic_number }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->contact_no }}</td>
                            <td>
                                @if ($user->status_user == '1')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-info">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No registered users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->links() }}
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
        document.addEventListener('DOMContentLoaded', () => {
            // Inisialisasi Simple-DataTables (sama seperti di school/index.blade.php)
            const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
                searchable: true,
                fixedHeight: true,
            });

            // Jika anda ada AJAX untuk modal tambah/edit, masukkan kod di sini.
            // Contoh:
            // const $modal = $('#userModal');
            // const $form = $('#userForm');
            // const $modalTitle = $('#userModalLabel');
            // const $submitButton = $form.find('button[type="submit"]');
            // const baseUrl = $modal.data('url');
            //
            // $modal.on('show.bs.modal', function(event) {
            //     const button = $(event.relatedTarget);
            //     const mode = button.data('mode');
            //     const id = button.data('id');
            //     // Reset form, set title sesuai mode, loading data jika edit, dsb.
            // });
            //
            // $form.on('submit', function(e) {
            //     e.preventDefault();
            //     // Kirim AJAX POST/PUT untuk simpan data
            // });
        });
    </script>
@endpush
