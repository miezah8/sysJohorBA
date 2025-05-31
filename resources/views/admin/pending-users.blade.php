@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pending User Approvals</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($users->count() > 0)
        @foreach($users as $user)
            <div class="card mb-4">
                <div class="card-header">
                    <strong>{{ $user->name }}</strong> ({{ $user->email }})
                </div>
                <div class="card-body">
                    <p><strong>Phone:</strong> {{ $user->phone }}</p>
                    <p><strong>IC Number:</strong> {{ $user->ic_number }}</p>
                    <p><strong>Uploaded IC:</strong><br>
                        <img src="{{ asset('storage/' . $user->ic_photo) }}" width="200" class="img-thumbnail">
                    </p>

                    <form action="{{ route('admin.approve-user', $user->id) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label><strong>Assign Role(s):</strong></label><br>
                            <label><input type="checkbox" name="roles[]" value="admin"> Admin</label><br>
                            <label><input type="checkbox" name="roles[]" value="coach"> Coach</label><br>
                            <label><input type="checkbox" name="roles[]" value="club"> Club</label><br>
                            <label><input type="checkbox" name="roles[]" value="athlete"> Athlete</label>
                        </div>

                        <button type="submit" class="btn btn-success mt-2">Approve User</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <p>No pending users at the moment.</p>
    @endif
</div>
@endsection
