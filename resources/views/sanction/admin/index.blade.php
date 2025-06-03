{{-- resources/views/sanction/admin/index.blade.php --}}
@extends('layouts.app')
@section('title', 'Sanction Review Module')

@section('breadcrumbParent', 'Sanction')
@section('breadcrumbParentUrl', route('sanctions.admin.index'))
@section('breadcrumbCurrent', 'All Sanction Application')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">All Sanction Applications</h5>
            <a href="{{ route('sanction.index') }}" class="btn btn-sm btn-secondary">← Back to List of My Sanction Applications</a>
        </div>
        
        <div class="table-responsive">
            <table class="table table-flush" id="datatable-search-sanction-admin">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Tournament</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Applicant</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($all as $r)
                      <tr>
                        <td>{{ $loop->iteration + ($all->currentPage()-1)*$all->perPage() }}</td>
                        <td>{{ $r->tournament_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->tournament_start_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($r->tournament_end_date)->format('d M Y') }}</td>
                        <td>{{ $r->user ? $r->user->name : '—' }}</td>
                        <td>
                          <span class="badge
                             {{ $r->status == 'approved' ? 'bg-success'
                                : ($r->status == 'rejected' ? 'bg-danger' : 'bg-warning') }}">
                            {{ ucfirst($r->status) }}
                          </span>
                        </td>
                        <td>
                          <a href="{{ route('sanctions.admin.edit', $r) }}" class="btn btn-sm btn-primary">
                            Review
                          </a>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center text-muted">No applications found.</td>
                      </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $all->links() }}
    </div>
    
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
            new simpleDatatables.DataTable("#datatable-search-sanction-admin", {
                searchable: true,
                fixedHeight: true,
            });
        });
    </script>
@endpush
