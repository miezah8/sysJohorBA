{{-- resources/views/sanction/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Sanction Module')

@section('breadcrumbParent', 'Sanction')
@section('breadcrumbParentUrl', route('sanction.index'))
@section('breadcrumbCurrent', 'My Sanction Applications')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">List of My Sanction Applications</h5>

            <div>
                {{-- Show “Apply” only if user has the permission --}}
                {{--@can('apply sanction')--}}
                    <a href="{{ route('sanction.create') }}" class="btn btn-behance me-2">
                        <i class="fa-solid fa-file-circle-plus me-1"></i> Apply
                    </a>
                {{--@endcan--}}

                {{-- Show “Admin Review” only if user can review all sanctions --}}
                @can('review sanction')
                    <a href="{{ route('sanctions.admin.index') }}" class="btn btn-danger">
                        <i class="fa-solid fa-shield-check me-1"></i> Admin Review
                    </a>
                @endcan
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-flush" id="datatable-search-sanction">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Tournament</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mine as $index => $r)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $r->tournament_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->tournament_start_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($r->tournament_end_date)->format('d M Y') }}</td>
                            <td>
                                <span class="badge
                                    {{ $r->status === 'approved' ? 'bg-success'
                                       : ($r->status === 'rejected' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ ucfirst($r->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('sanction.show', $r) }}" class="btn btn-sm btn-outline-info">
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
            new simpleDatatables.DataTable("#datatable-search-sanction", {
                searchable: true,
                fixedHeight: true,
            });
        });
    </script>
@endpush
