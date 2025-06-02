@extends('layouts.app')
@section('title', 'Athlete Module Form')

@section('content')
    <!-- Begin: Card Pendaftaran Athlete -->
    <div class="card">
        <!-- Begin : Card header -->
        <div class="card-header d-flex justify-content-between">
            <h4 class="mb-0">Pendaftaran Athlete</h4>
        </div>
        <!-- End: Card header -->
        <div class="table-responsive">
            <!-- Begin: Card body -->
            <div class="card-body">
                <!-- Begin : Switch Button -->
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch" id="switchMode">
                    <label class="form-check-label" for="switchMode">Pemain lebih dari 1</label>
                </div>
                <!-- End : Switch Button -->
                <!-- Begin: Body Pemain Lebih Dari 1 -->
                <div id="formMultiple" class="d-none">
                    <!-- Begin : Form Multiplayer -->
                    <form id="multiPlayerForm">
                        <div class="multi-row">
                            <!-- Row untuk player input -->
                            <div class="row align-items-end mb-2">
                                <div class="col-md-3">
                                    <label class="form-label required">Name</label>
                                    <input type="text" class="form-control" name="firstName[]" id="NameMultiple">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label required">Family Name</label>
                                    <input type="text" class="form-control" name="lastName[]" id="FamNameMultiple">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label required">Email</label>
                                    <input type="email" class="form-control" name="email[]" id="emailMultiple">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label required">Phone Number</label>
                                    <input type="tel" class="form-control" name="phone[]" id="phoneMultiple">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger w-100 removeRow">Remove</button>
                                </div>
                            </div>
                        </div>
                        <!-- Row baru untuk butang Add Player -->
                            <div class="row mb-3">
                                <div class="col-md-2 offset-md-10 d-flex justify-content-end">
                                    <button type="button" id="addRow" class="btn btn-outline-primary">
                                        <i class="fa-solid fa-plus me-1"></i> Add Player
                                    </button>
                                </div>
                            </div>
                    </form>

                    <!-- End : Form Multiplayer -->
                </div>
                <!-- End: Body Pemain Lebih Dari 1 -->

                <!-- Begin: 1 Pemain (Tabbed) -->
                <div id="formSingle" class="">
                    <!-- Begin: Tab Form -->
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button">Maklumat Peribadi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="guardian-tab" data-bs-toggle="tab" data-bs-target="#guardian" type="button">Maklumat Penjaga</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="school-tab" data-bs-toggle="tab" data-bs-target="#school" type="button">Maklumat Sekolah</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="experience-tab" data-bs-toggle="tab" data-bs-target="#experience" type="button">Maklumat Pengalaman</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="coach-tab" data-bs-toggle="tab" data-bs-target="#coach" type="button">Maklumat Jurulatih & Kelab</button>
                        </li>
                    </ul>
                    <!-- End: Tab Form -->

                    <!-- Begin: Form Maklumat Peribadi -->
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <!-- Begin: Maklumat Peribadi Form -->
                            <form id="formPersonal">
                                <!-- Begin: Row -->
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">First Name</label>
                                        <input type="text" class="form-control" name="firstname">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Last Name</label>
                                        <input type="text" class="form-control" name="lastname">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">No. KP/Passport</label>
                                        <input type="text" class="form-control" name="idNumber">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Phone Number</label>
                                        <input type="tel" name="phone" id="phone" class="form-control">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label d-block required">Gender</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="lelaki" value="Lelaki">
                                            <label class="form-check-label" for="lelaki">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="perempuan" value="Perempuan">
                                            <label class="form-check-label" for="perempuan">Female</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label required">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label required">Citizens</label>
                                        <select id="countryList" class="form-select select2" name="citizens">
                                            <option value="">-- Select Country --</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Address</label>
                                        <textarea class="form-control" name="address" rows="8"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required">Postcode</label>
                                                <input type="text" class="form-control" name="postcode" id="postcode">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required">State</label>
                                                <select class="form-control select2" id="schA_state" name="sch_state" onchange="stateSch_change(this.value);">
									                <option value="">-- Select State --</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required">Districts</label>
                                                <select class="form-select select2" id="daerahDropdown" name="districts">
                                                    <option value="">-- Select Districts --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label required">Picture</label>
                                            <input type="file" class="form-control" name="picture" accept="image/*">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label required">T-Shirt Size</label>
                                            <select class="form-select select2" name="size">
                                                <option value="">-- Select Size --</option>
                                                <option value="XS">XS</option>
                                                <option value="S">S</option>
                                                <option value="M">M</option>
                                                <option value="L">L</option>
                                                <option value="XL">XL</option>
                                                <option value="XXL">XXL</option>
                                                <option value="3XL">3XL</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label required">Name on T-Shirt</label>
                                            <input type="text" class="form-control" name="NameTshirt">
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary" id="btnNext">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="guardian" role="tabpanel">
                            <form id="formGuardian">
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Guardian's Name</label>
                                        <input type="text" class="form-control" name="GuardianName">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Guardian's Phone Number</label>
                                        <input type="text" class="form-control" name="GuardianPhone">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Occupation</label>
                                        <input type="text" class="form-control" name="GuardianOccup">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Relation</label>
                                        <select name="GuardianRelation" class="form-control">
                                            <option value="Ibu/Bapa">Ibu/Bapa</option>
                                            <option value="Ibu/Bapa">Datuk/Nenek</option>
                                            <option value="Ibu/Bapa">Adik-beradik</option>
                                            <option value="Penjaga">Penjaga</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col text-start">
                                        <button type="button" class="btn btn-secondary">Prev</button>
                                    </div>
                                    <div class="col text-end">
                                        <button type="button" id="btnNextKeluarga" class="btn btn-primary">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="tab-pane fade" id="school" role="tabpanel">
                            <form id="formSchool">
                                <div class="row mt-3">
                                    <!-- Dropdown Nama Sekolah -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Nama Sekolah</label>
                                        <select id="schoolDropdown" class="form-select select2">
                                            <option value="">-- Pilih Sekolah --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Kod Sekolah</label>
                                        <input type="text" class="form-control" disabled>
                                    </div>

                                    <!-- Kiri: Alamat -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Alamat Sekolah</label>
                                        <textarea class="form-control" rows="8" disabled></textarea>
                                    </div>

                                    <!-- Kanan: Kod, Poskod, Negeri, Daerah -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Poskod</label>
                                            <input type="text" class="form-control" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label required">Negeri</label>
                                            <input type="text" class="form-control" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label required">Daerah</label>
                                            <input type="text" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>

                                <!-- Butang Prev & Next -->
                                <div class="row mt-4">
                                    <div class="col text-start">
                                        <button type="button" class="btn btn-secondary">Prev</button>
                                    </div>
                                    <div class="col text-end">
                                        <button type="button" class="btn btn-primary">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="experience" role="tabpanel">
                            <form id="formExperience">
                                <div class="table-responsive mt-3">
                                    <div class="row">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="required">Pertandingan</th>
                                                    <th class="required">Peringkat</th>
                                                    <th class="required">Kategori</th>
                                                    <th class="required">Pencapaian</th>
                                                    <th class=""></th>
                                                </tr>
                                            </thead>
                                            <tbody id="experienceTableBody">
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control" placeholder="Contoh: Kejohanan Bola Sepak">
                                                    </td>
                                                    <td>
                                                        <select class="form-select select2">
                                                            <option>Sila pilih pering</option>
                                                            <option>Daerah</option>
                                                            <option>Negeri</option>
                                                            <option>Kebangsaan</option>
                                                            <option>Antarabangsa</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-select select2">
                                                            <option>Sila pilih kategori</option>
                                                            <option>Bawah 12</option>
                                                            <option>Bawah 15</option>
                                                            <option>Terbuka</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-select select2">
                                                            <option>Sila pilih pencapaian</option>
                                                            <option>Johan</option>
                                                            <option>Naib Johan</option>
                                                            <option>Tempat Ketiga</option>
                                                            <option>Penyertaan</option>
                                                        </select>
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger removeRow">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Butang Tambah -->
                                    <div class="mb-3 text-end">
                                        <button type="button" id="addRow" class="btn btn-outline-primary">
                                            <i class="fa-solid fa-plus me-1"></i> Add 
                                        </button>
                                    </div>
                                </div>
                                <!-- Butang Previous & Next -->
                                <div class="row">
                                    <div class="col text-start">
                                        <button type="button" class="btn" style="background-color: #f4b942; color: white;">Previous</button>
                                    </div>
                                    <div class="col text-end">
                                        <button type="button" class="btn" style="background-color: #00cfe8; color: white;">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="coach" role="tabpanel">
                            <form id="formCoach" class="mt-3">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="coachSelect" class="form-label required">Jurulatih</label>
                                        <select id="coachSelect" class="form-select select2">
                                            <option value="">-- Sila pilih Jurulatih --</option>
                                            <option value="Coach A">Coach A</option>
                                            <option value="Coach B">Coach B</option>
                                            <option value="Coach C">Coach C</option>
                                            <!-- Tambah pilihan lain mengikut keperluan -->
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="clubSelect" class="form-label required">Kelab</label>
                                        <select id="clubSelect" class="form-select select2">
                                            <option value="">-- Sila pilih Kelab --</option>
                                            <option value="Kelab A">Kelab A</option>
                                            <option value="Kelab B">Kelab B</option>
                                            <option value="Kelab C">Kelab C</option>
                                            <!-- Tambah pilihan lain mengikut keperluan -->
                                        </select>
                                    </div>
                                </div>
                                <!-- Butang Previous -->
                                <div class="text-start">
                                    <button type="button" class="btn" style="background-color: #f4b942; color: white;">Previous</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer text-center">
            <button type="button" id="CancelALlForm" class="btn btn-secondary btn-sm">Cancel</button>
            <button type="button" id="SubmitAllForm" class="btn btn-primary btn-sm">Submit</button>
        </div>
    </div>
@endsection

@push('css')
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.17/css/intlTelInput.min.css" />

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

        .required::after {
            content: " *";
            color: red;
        }

        .is-invalid {
            border-color: red !important;
        }
    </style>
@endpush

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function loadNationality(selectedId = null) {
            const $ddl = $('#countryList');
            $ddl.prop('disabled', true)
                .empty()
                .append('<option>Loading citizens</option>');

            $.get("{{ route('nationality.list') }}", function(nationality) {
                $ddl.empty().append('<option value="">-- Select Citizens --</option>');
                $.each(nationality, function(id, name) {
                $ddl.append(new Option(name, id));
                });
                if (selectedId) {
                $ddl.val(selectedId).trigger('change');
                }
                $ddl.prop('disabled', false);
            });
        }

        function loadDistricts(selectedId = null) {
            const $ddl = $('#daerahDropdown');
            $ddl.prop('disabled', true).empty().append('<option value="">Loading districts...</option>');

            $.get("{{ route('districts.list') }}", function(districts) {
                $ddl.empty().append('<option value="">-- Select District --</option>');

                $.each(districts, function(id, name) {
                    $ddl.append(new Option(name, id));
                });

                if (selectedId) {
                    $ddl.val(selectedId).trigger('change'); // trigger for select2 update
                }

                $ddl.prop('disabled', false);
            });
        }

        function loadStates(selectedId = null) {
            const $ddl = $('#schA_state');
            $ddl.prop('disabled', true)
                .empty()
                .append('<option>Loading states…</option>');

            $.get("{{ route('states.list') }}", function(states) {
                $ddl.empty().append('<option value="">-- Select State --</option>');
                $.each(states, function(id, name) {
                $ddl.append(new Option(name, id));
                });
                if (selectedId) {
                $ddl.val(selectedId).trigger('change');
                }
                $ddl.prop('disabled', false);
            });
        }

        function loadSchool(selectedId = null) {
            const $ddl = $('#schoolDropdown');
            $ddl.prop('disabled', true)
                .empty()
                .append('<option>Loading school</option>');

            $.get("{{ route('school.list') }}", function(school) {
                $ddl.empty().append('<option value="">-- Select School --</option>');
                $.each(school, function(id, name) {
                $ddl.append(new Option(name, id));
                });
                if (selectedId) {
                $ddl.val(selectedId).trigger('change');
                }
                $ddl.prop('disabled', false);
            });
        }

        function loadClub(selectedId = null) {
            const $ddl = $('#clubSelect');
            $ddl.prop('disabled', true)
                .empty()
                .append('<option>Loading club</option>');

            $.get("{{ route('club.list') }}", function(club) {
                $ddl.empty().append('<option value="">-- Select Club --</option>');
                $.each(club, function(id, name) {
                $ddl.append(new Option(name, id));
                });
                if (selectedId) {
                $ddl.val(selectedId).trigger('change');
                }
                $ddl.prop('disabled', false);
            });
        }

        function loadCoach(selectedId = null) {
            const $ddl = $('#coachSelect');
            $ddl.prop('disabled', true)
                .empty()
                .append('<option>Loading coach</option>');

            $.get("{{ route('coach.list') }}", function(coach) {
                $ddl.empty().append('<option value="">-- Select Coach --</option>');
                $.each(coach, function(id, name) {
                $ddl.append(new Option(name, id));
                });
                if (selectedId) {
                $ddl.val(selectedId).trigger('change');
                }
                $ddl.prop('disabled', false);
            });
        }

        $(document).ready(function () {
            //load ddl
            loadDistricts();
            loadStates();
            loadNationality();

            loadNationality();//list nationality
            loadStates(); //list state
            loadDistricts(); //list district

            //Switch function
            $('#switchMode').change(function() {
                if ($(this).is(':checked')) {
                    $('#formMultiple').removeClass('d-none').addClass('d-block');
                    $('#formSingle').removeClass('d-block').addClass('d-none');
                } else {
                    $('#formMultiple').removeClass('d-block').addClass('d-none');
                    $('#formSingle').removeClass('d-none').addClass('d-block');
                }
            });

            //function add multiple form
            const $form = $('#multiPlayerForm');
            const $container = $form.find('.multi-row');
            const $addButton = $('#addRow');

            //multiple add button
            $addButton.on('click', function () {
                const $row = $container.find('.row').first();
                const $newRow = $row.clone();

                $newRow.find('input').val('');
                $container.append($newRow);
            });

            //multiple remove buntton
            $form.on('click', '.removeRow', function () {
                const $rows = $container.find('.row');
                if ($rows.length > 1) {
                    $(this).closest('.row').remove();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'At least one row is required.',
                        confirmButtonText: 'OK'
                    });
                }
            });

            //function button next
            $('#btnNext').on('click', function () {
                const form = $('#formPersonal');
                const fields = [
                    { selector: 'input[name="firstname"]', name: 'First Name' },
                    { selector: 'input[name="lastname"]', name: 'Last Name' },
                    { selector: 'input[name="idNumber"]', name: 'No. KP/Passport' },
                    { selector: 'input[name="phone"]', name: 'Phone Number' },
                    { selector: 'input[name="gender"]', name: 'Gender', isRadio: true },
                    { selector: 'input[name="email"]', name: 'Email' },
                    { selector: '#countryList', name: 'Citizens' },
                    { selector: 'textarea[name="address"]', name: 'Address' },
                    { selector: 'input[name="postcode"]', name: 'Postcode' },
                    { selector: '#schA_state', name: 'State' },
                    { selector: '#daerahDropdown', name: 'Districts' },
                    { selector: 'input[name="picture"]', name: 'Picture' },
                    { selector: 'select[name="size"]', name: 'T-Shirt Size' },
                    { selector: 'input[name="NameTshirt"]', name: 'Name on T-Shirt' } // ni awak tak letak name dalam HTML, kena tambah
                ];

                // Reset semua error state
                form.find('input, select, textarea').removeClass('is-invalid');

                for (let field of fields) {
                    const el = form.find(field.selector);
                    let value;

                    if (field.isRadio) {
                        value = el.filter(':checked').val();
                    } else {
                        value = el.val() ? el.val().trim() : '';
                    }

                    if (!value) {
                        el.addClass('is-invalid');

                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Information',
                            text: `Please enter ${field.name}`,
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                }

                Swal.fire({
                    icon: 'success',
                    title: 'All Set!',
                    text: 'Proceeding to the next step.',
                    confirmButtonText: 'Continue'
                }).then(() => {
                    $('#guardian-tab').click(); // Buka tab seterusnya
                });
            });

            $('#btnNextKeluarga').on('click', function () {
                const form = $('#formPersonal');
                const fields = [
                    { selector: 'input[name="GuardianName"]', name: 'Guardian Name' },
                    { selector: 'input[name="GuardianPhone"]', name: 'Guardian Phone' },
                    { selector: 'input[name="GuardianOccup"]', name: 'Occupation' },
                    { selector: 'input[name="GuardianRelation"]', name: 'Relation' }
                ];
                // Reset semua error state
                form.find('input, select, textarea').removeClass('is-invalid');
                for (let field of fields) {
                    const el = form.find(field.selector);
                    let value;
                    if (field.isRadio) {
                        value = el.filter(':checked').val();
                    } else {
                        value = el.val() ? el.val().trim() : '';
                    }
                    if (!value) {
                        el.addClass('is-invalid');
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Information',
                            text: `Please enter ${field.name}`,
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                }
                Swal.fire({
                    icon: 'success',
                    title: 'All Set!',
                    text: 'Proceeding to the next step.',
                    confirmButtonText: 'Continue'
                }).then(() => {
                    $('#school-tab').click(); // Buka tab seterusnya
                });
            )};





            // Auto clear error when typing/selecting
            $('#formPersonal input, #formPersonal select, #formPersonal textarea').on('input change', function () {
                if ($(this).val().trim() !== '') {
                    $(this).removeClass('is-invalid');
                    $(this).closest('.mb-3').removeClass('border border-danger p-2');
                }
            });

            //cancel button
            $('#CancelALlForm').click(function() {
                const container = $('#formSingle');
                container.find('input[type="text"], input[type="number"], input[type="email"], textarea, select').val('');
                container.find('input[type="checkbox"], input[type="radio"]').prop('checked', false);
            });

            //submit button
            $('#SubmitAll').on('click', function () {
                let isValid = true;
                let showMessage = null;

                // Untuk debug selepas loop, kita simpan contoh
                let validName = '';
                let validEmail = '';

                $('input[name="firstName[]"]').each(function (index) {
                    let name = $(this).val().trim();
                    let familyName = $('input[name="lastName[]"]').eq(index).val().trim();
                    let email = $('input[name="email[]"]').eq(index).val().trim();
                    let phone = $('input[name="phone[]"]').eq(index).val().trim();

                    if (!name) {
                        isValid = false;
                        showMessage = `Please enter the name`;
                        return false;
                    }
                    if (!familyName) {
                        isValid = false;
                        showMessage = `Please enter the family name`;
                        return false;
                    }
                    if (!email) {
                        isValid = false;
                        showMessage = `Please enter the email`;
                        return false;
                    }
                    if (!phone) {
                        isValid = false;
                        showMessage = `Please enter the phone number`;
                        return false;
                    }

                    // Simpan satu contoh data untuk debug
                    validName = name;
                    validFamilyName = familyName;
                    validEmail = email;
                    validPhone = phone;
                });

                if (!isValid && showMessage) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning ',
                        text: showMessage
                    });
                    return;
                } else {
                    console.log(validName, validFamilyName, validEmail, validPhone); // Kini name dan email ada nilai
                }

                // proceedNextStep();
            });

            
        });
    </script>
@endpush
