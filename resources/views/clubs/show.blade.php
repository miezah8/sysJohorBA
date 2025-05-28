// resources/views/clubs/show.blade.php
@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Maklumat Kelab</h4>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('clubs.index') }}">Kelab</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $club->club_name }}</li>
        </ol>
    </nav>

    <div class="card p-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Maklumat Asas</h5>
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Nama Kelab</th>
                        <td>{{ $club->club_name }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Pemain</th>
                        <td>{{ $club->athletes_count }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h5>Senarai Pemain</h5>
                @if($club->athletes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Pemain</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($club->athletes as $index => $athlete)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $athlete->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">Tiada pemain berdaftar dengan kelab ini.</div>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('clubs.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection