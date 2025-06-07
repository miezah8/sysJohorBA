@extends('layouts.app')
@section('title', 'Coach Module Form')

@section('content')
    <div class="card p-2">
        <div class="card-header d-flex justify-content-between">
            <h5>{{ isset($coach) ? 'Edit Coach' : 'Add Coach' }}</h5>
            <a class="btn btn-sm btn-secondary" href="{{ route('coach.index') }}">← Back to Coach</a>
        </div>

        <div class="table-responsive">
            <div class="card-body">

                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#peribadi" role="tab"
                            aria-controls="peribadi" aria-selected="true">Personal Info</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#pengalaman" role="tab"
                            aria-controls="pengalaman" aria-selected="false">Experience</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#kelayakan" role="tab"
                            aria-controls="kelayakan" aria-selected="false">Qualification Info</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#kelulusan" role="tab"
                            aria-controls="kelulusan" aria-selected="false">Academic Qualification</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#pencapaian" role="tab"
                            aria-controls="pencapaian" aria-selected="false">Achievement Info</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#kelab" role="tab"
                            aria-controls="kelab" aria-selected="false">Club Info</a></li>
                </ul>

                <div class="tab-content pt-4 bg-white rounded shadow-sm ">
                    <div class="tab-pane fade show active" id="peribadi" role="tabpanel" aria-labelledby="peribadi-tab">
                        @include('coach.form.personal_tab')
                    </div>
                    <div class="tab-pane fade" id="pengalaman" role="tabpanel" aria-labelledby="pengalaman-tab">
                        @include('coach.form.experience_tab')
                    </div>
                    <div class="tab-pane fade" id="kelayakan" role="tabpanel" aria-labelledby="kelayakan-tab">
                        @include('coach.form.qualification_tab')
                    </div>
                    <div class="tab-pane fade" id="kelulusan" role="tabpanel" aria-labelledby="kelulusan-tab">
                        @include('coach.form.academic_tab')
                    </div>
                    <div class="tab-pane fade" id="pencapaian" role="tabpanel" aria-labelledby="pencapaian-tab">
                        @include('coach.form.achievement_tab')
                    </div>
                    <div class="tab-pane fade" id="kelab" role="tabpanel" aria-labelledby="kelab-tab">
                        @include('coach.form.club_tab')
                    </div>
                </div>

            </div>
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

    
        /* .card-body {
            background: #ffffff;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 1px 4px rgb(0 0 0 / 0.1);
        }

        .nav-tabs .nav-link {
            color: #6b7280;
            font-weight: 600;
            padding: 0.75rem 1rem;
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            color: #111827;
            background-color: transparent;
            border-bottom: 3px solid #2563eb;
        }

        .nav-tabs .nav-link:hover {
            color: #2563eb;
        }

        .tab-content {
            color: #374151;
            font-size: 16px;
            line-height: 1.6;
        } */
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
        });
    </script>
@endpush
