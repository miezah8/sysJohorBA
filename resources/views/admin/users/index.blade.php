@extends('layouts.app')
@section('title', 'User Module')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">List of Registered Users</h5>
        </div>

        @if(session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive mt-2">
            <table class="table table-hover table-flush" id="datatable-search">
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
                                <!-- Only “Assign Role” button now -->
                                <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#assignRoleModal"
                                        data-user-id="{{ $user->id }}"
                                        data-user-name="{{ $user->name }}"
                                        data-user-roles='@json($user->getRoleNames())'>
                                    <i class="fa-solid fa-user-gear me-1"></i> Assign Role
                                </button>
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


    <!-- Assign Roles Modal (same as before) -->
    <div class="modal fade" id="assignRoleModal" tabindex="-1" aria-labelledby="assignRoleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.assignRole') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" id="modalUserId">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignRoleLabel">
                            Assign Roles to <span id="modalUserName"></span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <label class="form-label">Select Roles</label>
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input role-checkbox"
                                       type="checkbox"
                                       name="roles[]"
                                       value="{{ $role->name }}"
                                       id="role_{{ $role->id }}">
                                <label class="form-check-label" for="role_{{ $role->id }}">
                                    {{ ucfirst($role->name) }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update Roles</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
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
            width: 18%;
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
            const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
                searchable: true,
                fixedHeight: true,
            });

            const assignModal = document.getElementById('assignRoleModal');
            assignModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const userId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');
                const userRoles = JSON.parse(button.getAttribute('data-user-roles'));

                document.getElementById('modalUserId').value = userId;
                document.getElementById('modalUserName').textContent = userName;

                document.querySelectorAll('.role-checkbox').forEach(cb => cb.checked = false);

                userRoles.forEach(role => {
                    const checkbox = document.querySelector('.role-checkbox[value="' + role + '"]');
                    if (checkbox) checkbox.checked = true;
                });
            });
        });
    </script>
@endpush
