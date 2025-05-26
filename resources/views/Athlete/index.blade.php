@extends('layouts.app')
@section('title', 'Athlete Module')

@section('content')
    <div class="card">
        <!-- Card header -->
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of Athlete</h5>
            <a href="{{ route('athlete.create') }}" class="btn btn-behance">
                <i class="fa-solid fa-plus me-1"></i> Add
            </a>

        </div>
        <div class="table-responsive">
            <table class="table table-flush" id="datatable-search">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Athlete Name</th>
                        <th>Club</th>
                        <th>School</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($AthleteList as $index => $data)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $data->full_name }}</td>
                            <td>{{ $data->club_name }}</td>
                            <td>{{ $data->school_name }}</td>
                            <td>
                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#schoolModal"
                                    data-mode="edit" data-id="{{ $data->id_athlete }}">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('css')
    <style>
        table th:first-child,
        table td:first-child {
            width: 1%;
            white-space: nowrap;
            /* Prevents wrapping */
        }

        table th:last-child,
        table td:last-child {
            width: 15%;
            white-space: nowrap;
            /* Optional, depending on content */
        }

        td {
            font-size: 0.875em;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const dataTableSearch = new simpleDatatables.DataTable(
            "#datatable-search", {
                searchable: true,
                fixedHeight: true,
            }
        );
    </script>
@endpush
