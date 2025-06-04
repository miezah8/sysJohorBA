@extends('layouts.app')
@section('title', 'User Module')

@section('breadcrumbParent', 'User')
{{-- @section('breadcrumbParentUrl', route('clubs.index'))  --}}
@section('breadcrumbCurrent', 'Registered Users')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">List of Registered Users</h5>

            {{-- Invite User button --}}
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inviteUserModal">
                <i class="fa-solid fa-envelope me-1"></i> Invite User
            </button>
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
                                {{-- Only “Assign Roles” --}}
                                <button class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#assignRoleModal"
                                        data-user-id="{{ $user->id }}"
                                        data-user-name="{{ $user->name }}"
                                        data-user-roles='@json($user->getRoleNames())'>
                                    <i class="fa-solid fa-user-gear me-1"></i> Assign Roles
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


    <!--====================================-->
    <!-- Modal: Invite User -->
    <!--====================================-->
    <div class="modal fade" id="inviteUserModal" tabindex="-1" aria-labelledby="inviteUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.users.invite') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="inviteUserLabel">Invite New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p>Enter the email address of the person you want to invite. They will receive an email with registration instructions.</p>

                        <div class="mb-3">
                            <label for="invite_email" class="form-label">Email</label>
                            <input type="email"
                                   class="form-control @error('invite_email') is-invalid @enderror"
                                   id="invite_email"
                                   name="invite_email"
                                   value="{{ old('invite_email') }}"
                                   required>
                            @error('invite_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="invite_role" class="form-label">Default Role</label>
                            <select class="form-select @error('invite_role') is-invalid @enderror"
                                    id="invite_role"
                                    name="invite_role"
                                    required>
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('invite_role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('invite_role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send Invitation</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!--====================================-->
    <!-- Modal: Assign Roles -->
    <!--====================================-->
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
            // Initialize Simple-DataTables
            new simpleDatatables.DataTable("#datatable-search", {
                searchable: true,
                fixedHeight: true,
            });

            // Prefill “Assign Roles” modal with current user data
            const assignModal = document.getElementById('assignRoleModal');
            assignModal.addEventListener('show.bs.modal', function (event) {
                const button    = event.relatedTarget;
                const userId    = button.getAttribute('data-user-id');
                const userName  = button.getAttribute('data-user-name');
                const userRoles = JSON.parse(button.getAttribute('data-user-roles'));

                document.getElementById('modalUserId').value = userId;
                document.getElementById('modalUserName').textContent = userName;

                // Uncheck all first
                document.querySelectorAll('.role-checkbox').forEach(cb => cb.checked = false);

                // Then check only those roles the user already has
                userRoles.forEach(role => {
                    const checkbox = document.querySelector('.role-checkbox[value="' + role + '"]');
                    if (checkbox) checkbox.checked = true;
                });
            });
        });
    </script>
@endpush
