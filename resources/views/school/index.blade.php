@extends('layouts.app')
@section('title', 'School Module')

@section('content')
    <div class="card">
        <!-- Card header -->
        <div class="card-header">
            <h5 class="mb-0">List of School</h5>
            {{-- <p class="text-sm mb-0">
                A lightweight, extendable, dependency-free javascript HTML table plugin.
            </p> --}}
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
                    @foreach ($schoolData as $index => $school)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td>{{ $school->school_name }}</td>
                            <td>{{ $school->district_name }}</td>
                            <td><button class="btn btn-outline-info" type="button">
                                    <i class="fa-solid fa-pen-to-square"></i>
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
