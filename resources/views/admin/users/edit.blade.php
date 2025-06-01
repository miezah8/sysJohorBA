@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Assign Roles to {{ $user->name }}</h4>

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Roles:</label><br>
            @foreach ($roles as $role)
                <label class="form-check-label me-3">
                    <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                        {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                    {{ ucfirst($role->name) }}
                </label>
            @endforeach
        </div>

        <button class="btn btn-success">Update Roles</button>
    </form>
</div>
@endsection
