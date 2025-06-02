@extends('layouts.app')
@section('title', "Players under Coach {$coach->coach_fname}")

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Players under Coach “{{ $coach->coach_fname }}”</h5>
            <a class="btn btn-sm btn-secondary" href="{{ route('coach.index') }}">← Back to Coach</a>
        </div>
        <div class="card-body">
            @if ($players->count())

                <div class="table-responsive">
                    <table class="table table-flush" id="datatable-search">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($players as $i => $p)
                                {{-- //index //player --}}
                                <tr>
                                    <td>{{ $i + $players->firstItem() }}</td>
                                    <td>{{ $p->athlete_fname }}</td>
                                    <td>{{ $p->athlete_lname }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $players->links() }}
            @else
                <p>No players in this club yet.</p>
            @endif
        </div>
    </div>
@endsection
@push('css')
    <style>
        td {
            font-size: 0.875em;
        }

        .text-danger {
            color: #f44336 !important;
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

            $('.select2').select2({
                dropdownParent: $('#schoolModal'),
                theme: 'bootstrap-5',
                width: '100%'
            });


        });
    </script>
@endpush
