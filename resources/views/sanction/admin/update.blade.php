{{-- resources/views/sanction/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Sanction Module')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of My Sanction Applications</h5>
            <a href="{{ route('sanction.create') }}" class="btn btn-behance">
                <i class="fa-solid fa-file-circle-plus me-1"></i> Apply Sanction
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-flush" id="datatable-search">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Tournament</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mine as $index => $r)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $r->tournament_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->tournament_date)->format('d M Y') }}</td>
                            <td>
                                <span class="badge 
                                    {{ $r->status === 'approved' ? 'bg-success' 
                                       : ($r->status === 'rejected' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('sanctions.show', $r) }}" class="btn btn-sm btn-outline-info">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $mine->links() }}
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
            new simpleDatatables.DataTable("#datatable-search", {
                searchable: true,
                fixedHeight: true,
            });
        });
    </script>
@endpush
