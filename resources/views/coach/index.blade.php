@extends('layouts.app')
@section('title', 'Coach Module')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of Coaches</h5>
            <button class="btn btn-behance" data-bs-toggle="modal" data-bs-target="#schoolModal" data-mode="add">
                <i class="fa-solid fa-plus me-1"></i>Add
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-flush" id="datatable-search">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>School Name</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coachData as $index => $coach)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $coach->coach_fname }}</td>
                            <td><a class="{{ $coach->athletes_coach_count > 0 ? 'text-danger fw-bold' : '' }}"
                                    href="{{ route('coach.players', $coach->id_coach) }}">{{ $coach->athletes_coach_count }}</a>
                            </td>
                            <td>
                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#coachModal"
                                    data-mode="edit" data-id="{{ $coach->id_coach }}">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                </button>
                                {{-- <button class="btn btn-outline-danger btn-delete" data-id="{{ $coach->id_coach }}">
                                    <i class="fa-solid fa-trash me-1"></i> Delete
                                </button> --}}
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
            text-align: center
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            const dataTableSearch = new simpleDatatables.DataTable(
                "#datatable-search", {
                    searchable: true,
                    fixedHeight: true,
                }
            );
        });
    </script>
@endpush
