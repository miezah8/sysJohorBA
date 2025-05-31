@extends('layouts.app')

@section('content')
<div class="container">
  <h1>Edit User: {{ $user->name }}</h1>

  <form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Papar maklumat asas (readonly) --}}
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" value="{{ $user->name }}" disabled>
      </div>
      <div class="col-md-6">
        <label class="form-label">IC Number</label>
        <input type="text" class="form-control" value="{{ $user->ic_number }}" disabled>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" class="form-control-plaintext" value="{{ $user->email }}" readonly>
      </div>
      <div class="col-md-6">
        <label class="form-label">Phone No.</label>
        <input type="text" class="form-control" value="{{ $user->contact_no }}" disabled>
      </div>
    </div>

    {{-- Pilih Status (Pending vs Active) --}}
    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status_user" class="form-control">
          <option value="0" {{ $user->status_user == '0' ? 'selected' : '' }}>
            Pending
          </option>
          <option value="1" {{ $user->status_user == '1' ? 'selected' : '' }}>
            Active
          </option>
        </select>
      </div>

      {{-- Pilih Role --}}
      <div class="col-md-4">
        <label class="form-label">Role</label>
        <select name="role" class="form-control">
          @foreach($roles as $role)
            <option value="{{ $role->name }}"
              {{ $user->hasRole($role->name) ? 'selected' : '' }}>
              {{ ucfirst($role->name) }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    {{-- Tabel Permissions (untuk assign akses modul) --}}
    <h5 class="mt-4">Assign Module Access (Permissions)</h5>
    <table class="table table-bordered table-sm">
      <thead>
        <tr>
          <th>Module</th>
          @foreach($actions as $act)
            <th class="text-center">{{ ucfirst($act) }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach($modules as $mod)
        <tr>
          <td>{{ ucfirst($mod) }}</td>
          @foreach($actions as $act)
          @php
            // Check sama ada user ada permission "{$act} {$mod}"
            $permName = "{$act} {$mod}";
          @endphp
          <td class="text-center">
            <input
              type="checkbox"
              name="permissions[{{ $mod }}][]"
              value="{{ $act }}"
              {{ $user->hasPermissionTo($permName) ? 'checked' : '' }}
            >
          </td>
          @endforeach
        </tr>
        @endforeach
      </tbody>
    </table>

    <button class="btn btn-success">Save Changes</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
