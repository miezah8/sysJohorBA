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
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label required">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label d-block required">Gender</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="Male" value="M">
                                            <label class="form-check-label" for="Male">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="Female" value="F">
                                            <label class="form-check-label" for="Female">Female</label>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label d-block required">Race</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="race" id="Malay" value="Malay">
                                            <label class="form-check-label" for="Malay">Malay</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="race" id="Cina" value="Cina">
                                            <label class="form-check-label" for="Cina">Cina</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="race" id="India" value="India">
                                            <label class="form-check-label" for="India">India</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                            <label class="form-label required">Picture</label>
                                            <input type="file" class="form-control" name="picture" accept="image/*">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Citizens</label>
                                        <select id="countryList" class="form-select select2" name="citizens">
                                            <option value="">-- Select Country --</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Address</label>
                                        <textarea class="form-control" name="address" rows="9"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required">Postcode</label>
                                                <input type="text" class="form-control" name="postcode" id="postcode">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required">State</label>
                                                <select class="form-control select2" id="schA_state" name="sch_state">
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
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
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
                                            <option value="">-- Select Relation --</option>
                                            <option value="Ibu/Bapa">Ibu/Bapa</option>
                                            <option value="Ibu/Bapa">Datuk/Nenek</option>
                                            <option value="Ibu/Bapa">Adik-beradik</option>
                                            <option value="Penjaga">Penjaga</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col text-start">
                                        <button type="button" id="btnBackPersonal" class="btn btn-secondary">Prev</button>
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
                                        <input type="text" class="form-control" id="CodeScholl" readonly>
                                    </div>

                                    <!-- Kiri: Alamat -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Alamat Sekolah</label>
                                        <textarea class="form-control" rows="8" id="AddressSchool" readonly></textarea>
                                    </div>

                                    <!-- Kanan: Kod, Poskod, Negeri, Daerah -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">Poskod</label>
                                            <input type="text" class="form-control" id="PosKod" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label required">Negeri</label>
                                            <input type="text" class="form-control" id="state" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label required">Daerah</label>
                                            <input type="text" class="form-control" id="districts" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Butang Prev & Next -->
                                <div class="row mt-4">
                                    <div class="col text-start">
                                        <button type="button" id="btnBackGuardian" class="btn btn-secondary">Prev</button>
                                    </div>
                                    <div class="col text-end">
                                        <button type="button" id="btnNextSchool" class="btn btn-primary">Next</button>
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
                                                    <th class="required">Competition</th>
                                                    <th class="required">Stage</th>
                                                    <th class="required">Category</th>
                                                    <th class="required">Achieve</th>
                                                    <th class="required">Year</th>
                                                    <th class=""></th>
                                                </tr>
                                            </thead>
                                            <tbody id="experienceTableBody">
                                                <tr>
                                                    <td>
                                                        <input type="text" class="form-control" name="tournament">
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="ranking" name="ranking[]">
                                                            <option value="">-- Select Stage --</option>
                                                            <option value="1">Sekolah</option>
                                                            <option value="2">Daerah/Zon</option>
                                                            <option value="3">Negeri</option>
                                                            <option value="4">Kebangsaan</option>
                                                            <option value="5">Antarabangsa</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="category" name="category[]">
                                                            <option value="">-- Select Category --</option>
                                                            <option value="MS">Perseorangan Lelaki</option>
                                                            <option value="WS">Perseorangan Wanita</option>
                                                            <option value="MD">Beregu Lelaki</option>
                                                            <option value="WD">Beregu Wanita</option>
                                                            <option value="MXD">Beregu Campuran</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-control" id="achieve" name="achieve[]">
															<option value="">-- Select Achieve --</option>
                                                            <option value="1">EMAS</option>
															<option value="2">PERAK</option>
															<option value="3">GANGSA</option>
															<option value="4">SEPARUH AKHIR</option>
															<option value="5">SUKU AKHIR</option>
															<option value="6">PUSINGAN 16</option>
															<option value="7">PUSINGAN 32 </option>
															<option value="8">PUSINGAN 64 </option>
															<option value="9">PENYERTAAN</option>
															<option value="11">Platinum1</option>
                                                            <option value="12">Goldlahh</option>
                                                            <option value="13">Golgol</option>
															<option value="10">TIDAK BERKENAAN</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="year">
                                                    </td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-danger btnRemoveExperience">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Butang Tambah -->
                                    <div class="mb-3 text-end">
                                        <button type="button" class="btn btn-outline-primary btnAddExperience">
                                            <i class="fa-solid fa-plus me-1"></i> Add 
                                        </button>
                                    </div>
                                </div>
                                <!-- Butang Prev & Next -->
                                <div class="row mt-4">
                                    <div class="col text-start">
                                        <button type="button" id="btnBackSch" class="btn btn-secondary">Prev</button>
                                    </div>
                                    <div class="col text-end">
                                        <button type="button" id="btnNextExperience" class="btn btn-primary">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="coach" role="tabpanel">
                            <form id="formCoach" class="mt-3">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="coachSelect" class="form-label required">Coach</label>
                                        <select id="coachSelect" class="form-select select2" >
                                            <option value="">-- Select Coach --</option>
                                            <!-- Tambah pilihan lain mengikut keperluan -->
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="clubSelect" class="form-label required">Club</label>
                                        <select id="clubSelect" class="form-select select2">
                                            <option value="">-- Select Club --</option>
                                            <!-- Tambah pilihan lain mengikut keperluan -->
                                        </select>
                                    </div>
                                </div>
                                <!-- Butang Previous -->
                                <div class="text-start">
                                    <button type="button" id="btnBackExp" class="btn btn-secondary">Prev</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="card-footer text-center">
            <button type="button" id="CancelALlForm" class="btn btn-secondary btn-sm">Cancel</button>
            <button type="button" id="btnSubmit" class="btn btn-primary btn-sm">Submit</button>
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
            loadSchool();
            loadClub();
            loadCoach();

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

            //function button next (in tab personal)
            $('#btnNext').on('click', function () {
                const form = $('#formPersonal');
                const fields = [
                    { selector: 'input[name="firstname"]', name: 'First Name' },
                    { selector: 'input[name="lastname"]', name: 'Last Name' },
                    { selector: 'input[name="idNumber"]', name: 'No. KP/Passport' },
                    { selector: 'input[name="phone"]', name: 'Phone Number' },
                    { selector: 'input[name="email"]', name: 'Email' },
                    { selector: 'input[name="gender"]', name: 'Gender', isRadio: true },
                    { selector: 'input[name="race"]', name: 'Race', isRadio: true },
                    { selector: 'input[name="picture"]', name: 'Picture' },
                    { selector: '#countryList', name: 'Citizens' },
                    { selector: 'textarea[name="address"]', name: 'Address' },
                    { selector: 'input[name="postcode"]', name: 'Postcode' },
                    { selector: '#schA_state', name: 'State' },
                    { selector: '#daerahDropdown', name: 'Districts' },
                    { selector: 'select[name="size"]', name: 'T-Shirt Size' },
                    { selector: 'input[name="NameTshirt"]', name: 'Name on T-Shirt' } 
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
                    $('#guardian-tab').click(); 
                });
            });

            //function button next (in tab family)
            $('#btnNextKeluarga').on('click', function () {
                const form = $('#formGuardian');
                const fields = [
                    { selector: 'input[name="GuardianName"]', name: 'Guardian Name' },
                    { selector: 'input[name="GuardianPhone"]', name: 'Guardian Phone' },
                    { selector: 'input[name="GuardianOccup"]', name: 'Occupation' },
                    { selector: 'select[name="GuardianRelation"]', name: 'Relation' }
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
                        return; // keluar dari loop dan fungsi jika ada error
                    }
                }

                // Jika semua input lengkap
                Swal.fire({
                    icon: 'success',
                    title: 'All Set!',
                    text: 'Proceeding to the next step.',
                    confirmButtonText: 'Continue'
                }).then(() => {
                    $('#school-tab').click(); // Buka tab seterusnya
                });
            });

            //function button back ( in tab family)
            $('#btnBackPersonal').on('click', function(){
                $('#personal-tab').click();
            });

            //dropdown sch change all data
            $('#schoolDropdown').on('change', function () {
                // const selectedId = $(this).val();
                let selectedId = $(this).val();
                let baseSchoolUrl = "{{ url('athlete/sch') }}";

                if (selectedId) {
                    $.ajax({
                        url: baseSchoolUrl + '/' + selectedId,
                        method: 'GET',
                        success: function (data) {
                            console.log(data.postcode);
                            $('#CodeScholl').val(data.sch_code);
                            $('#AddressSchool').val(data.sc_address);
                            $('#PosKod').val(data.postcode);
                            $('#state').val(data.state_name);
                            $('#districts').val(data.district_name);
                        },
                        error: function () {
                            Swal.fire('Error', 'Failed to retrieve school data.', 'error');
                        }
                    });
                } else {
                    $('#CodeScholl, #AddressSchool, #postcode, #state, #districts').val('');
                }
            });

            // function button next (in tab school)
            $('#btnNextSchool').on('click', function () {
                const form = $('#formSchool');
                const fields = [
                    { selector: '#schoolDropdown', name: 'School Name' },
                    { selector: '#CodeScholl', name: 'School Code' },
                    { selector: '#AddressSchool', name: 'School Address' },
                    { selector: '#PosKod', name: 'School Postcode' },
                    { selector: '#districts', name: 'School District' },
                    { selector: '#state', name: 'School State' }
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
                        return; // keluar dari loop dan fungsi jika ada error
                    }
                }
                // Jika semua input lengkap
                Swal.fire({
                    icon: 'success',
                    title: 'All Set!',
                    text: 'Proceeding to the next step.',
                    confirmButtonText: 'Continue'
                }).then(() => {
                    $('#experience-tab').click(); // Buka tab seterusnya
                });
            });

            //function button back (in tab school)
            $('#btnBackGuardian').on('click', function(){
                $('#guardian-tab').click();
            });

            //function button add row tab experience
            $('#experienceTableBody').on('click', '.btnRemoveExperience', function () {
                let $rows = $('#experienceTableBody').find('tr');
                if ($rows.length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Warning',
                        text: 'At least one row is required.',
                        confirmButtonText: 'OK'
                    });
                }
            });

            //function button remove row tab experience
            $('.btnAddExperience').on('click', function () {
                let row = $('#experienceTableBody tr:first').clone();
                row.find('input, select').val('');
                $('#experienceTableBody').append(row);
            });

            // // function button next (in tab experience)
            $('#btnNextExperience').on('click', function () {
                const $form = $('#formExperience');
                const $rows = $('#experienceTableBody tr');
                let isValid = true;
                let showMessage = null;

                // Reset semua is-invalid
                $form.find('input, select').removeClass('is-invalid');

                $rows.each(function () {
                    const $row = $(this);

                    const tournament = $row.find('input[name="tournament"]');
                    const ranking = $row.find('select[name="ranking[]"]');
                    const category = $row.find('select[name="category[]"]');
                    const achieve = $row.find('select[name="achieve[]"]');
                    const year = $row.find('input[name="year"]');

                    if (!tournament.val().trim()) {
                        tournament.addClass('is-invalid');
                        showMessage = 'Please enter tournament name.';
                        isValid = false;
                        return false;
                    }
                    if (!ranking.val()) {
                        ranking.addClass('is-invalid');
                        showMessage = 'Please enter stage.';
                        isValid = false;
                        return false;
                    }
                    if (!category.val()) {
                        category.addClass('is-invalid');
                        showMessage = 'Please enter category.';
                        isValid = false;
                        return false;
                    }
                    if (!achieve.val()) {
                        achieve.addClass('is-invalid');
                        showMessage = 'Please enter achieve.';
                        isValid = false;
                        return false;
                    }
                    if (!year.val().trim()) {
                        year.addClass('is-invalid');
                        showMessage = 'Please enter year.';
                        isValid = false;
                        return false;
                    }
                });

                if (!isValid && showMessage) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Information',
                        text: showMessage,
                        confirmButtonText: 'OK'
                    });
                    return;
                }
                Swal.fire({
                    icon: 'success',
                    title: 'All Set!',
                    text: 'Proceeding to the next step.',
                    confirmButtonText: 'Continue'
                }).then(() => {
                    $('#coach-tab').click(); // Buka tab seterusnya
                });
            });

            //function button back (in tab experience)
            $('#btnBackSch').on('click', function(){
                $('#school-tab').click();
            });

            //function button back (in tab coach & club)
            $('#btnBackExp').on('click', function(){
                $('#experience-tab').click();
            });

            $('#btnSubmit').on('click', function () {
                // Tentukan sama ada user guna form multiplayer atau form tab individu
                let isMultiple = !$('#formMultiple').hasClass('d-none');
                let players = [];
                let allData = {};
                if (isMultiple) {
                    // ======================
                    // VALIDASI FORM MULTIPLAYER
                    // ======================
                    const rows = $('#multiPlayerForm .multi-row .row');
                    let isValid = true;

                    for (let i = 0; i < rows.length; i++) {
                        const row = $(rows[i]);
                        const firstName = row.find('input[name="firstName[]"]').val()?.trim();
                        const lastName = row.find('input[name="lastName[]"]').val()?.trim();
                        const email = row.find('input[name="email[]"]').val()?.trim();
                        const phone = row.find('input[name="phone[]"]').val()?.trim();

                        // Reset dahulu semua invalid
                        row.find('input').removeClass('is-invalid');

                        if (!firstName) {
                            row.find('input[name="firstName[]"]').addClass('is-invalid');
                            Swal.fire({
                                icon: 'warning',
                                title: `Warning`,
                                text: `Please enter First Name.`,
                                confirmButtonText: 'OK'
                            });
                            isValid = false;
                            break;
                        }

                        if (!lastName) {
                            row.find('input[name="lastName[]"]').addClass('is-invalid');
                            Swal.fire({
                                icon: 'warning',
                                title: `Warning`,
                                text: `Please enter Family Name.`,
                                confirmButtonText: 'OK'
                            });
                            isValid = false;
                            break;
                        }

                        if (!email) {
                            row.find('input[name="email[]"]').addClass('is-invalid');
                            Swal.fire({
                                icon: 'warning',
                                title: `Warning`,
                                text: `Please enter Email.`,
                                confirmButtonText: 'OK'
                            });
                            isValid = false;
                            break;
                        }

                        if (!phone) {
                            row.find('input[name="phone[]"]').addClass('is-invalid');
                            Swal.fire({
                                icon: 'warning',
                                title: `Warning`,
                                text: `Please enter Phone Number.`,
                                confirmButtonText: 'OK'
                            });
                            isValid = false;
                            break;
                        }
                    }

                    if (!isValid) {
                        return; // stop here if any player field is incomplete
                    }

                    // ======================
                    // AMBIL DATA MULTIPLAYER
                    // ======================
                   
                    rows.each(function () {
                        players.push({
                            firstName: $(this).find('input[name="firstName[]"]').val().trim(),
                            lastName: $(this).find('input[name="lastName[]"]').val().trim(),
                            email: $(this).find('input[name="email[]"]').val().trim(),
                            phone: $(this).find('input[name="phone[]"]').val().trim()
                        });
                    });

                    console.log("Multi Player Data:", players);

                    // Kalau mahu terus submit, letakkan post/ajax di sini
                }
                else {
                    // ======================
                    // VALIDASI FORM INDIVIDU (semua tab)
                    // ======================
                    const validations = [
                        {
                            form: $('#formPersonal'),
                            fields: [
                                { selector: 'input[name="firstname"]', name: 'First Name' },
                                { selector: 'input[name="lastname"]', name: 'Last Name' },
                                { selector: 'input[name="idNumber"]', name: 'No. KP/Passport' },
                                { selector: 'input[name="phone"]', name: 'Phone Number' },
                                { selector: 'input[name="email"]', name: 'Email' },
                                { selector: 'input[name="gender"]', name: 'Gender', isRadio: true },
                                { selector: 'input[name="race"]', name: 'Race', isRadio: true },
                                { selector: 'input[name="picture"]', name: 'Picture' },
                                { selector: '#countryList', name: 'Citizens' },
                                { selector: 'textarea[name="address"]', name: 'Address' },
                                { selector: 'input[name="postcode"]', name: 'Postcode' },
                                { selector: '#schA_state', name: 'State' },
                                { selector: '#daerahDropdown', name: 'Districts' },
                                { selector: 'select[name="size"]', name: 'T-Shirt Size' },
                                { selector: 'input[name="NameTshirt"]', name: 'Name on T-Shirt' }
                            ]
                        },
                        {
                            form: $('#formGuardian'),
                            fields: [
                                { selector: 'input[name="GuardianName"]', name: 'Guardian Name' },
                                { selector: 'input[name="GuardianPhone"]', name: 'Guardian Phone' },
                                { selector: 'input[name="GuardianOccup"]', name: 'Occupation' },
                                { selector: 'select[name="GuardianRelation"]', name: 'Relation' }
                            ]
                        },
                        {
                            form: $('#formSchool'),
                            fields: [
                                { selector: '#schoolDropdown', name: 'School Name' },
                                { selector: '#CodeScholl', name: 'School Code' },
                                { selector: '#AddressSchool', name: 'School Address' },
                                { selector: '#PosKod', name: 'School Postcode' },
                                { selector: '#districts', name: 'School District' },
                                { selector: '#state', name: 'School State' }
                            ]
                        },
                        {
                            form: $('#formExperience'),
                            isTable: true,
                            tableSelector: '#experienceTableBody'
                        },
                        {
                            form: $('#formCoach'),
                            fields: [
                                { selector: '#coachSelect', name: 'Coach' },
                                { selector: '#clubSelect', name: 'Club' }
                            ]
                        }
                    ];

                    let allValid = true;

                    for (let block of validations) {
                        block.form.find('input, select, textarea').removeClass('is-invalid');

                        if (block.isTable) {
                            let tableValid = true;
                            $(block.tableSelector + ' tr').each(function () {
                                const tournament = $(this).find('input[name="tournament"]');
                                const ranking = $(this).find('select[name="ranking[]"]');
                                const category = $(this).find('select[name="category[]"]');
                                const achieve = $(this).find('select[name="achieve[]"]');
                                const year = $(this).find('input[name="year"]');

                                if (!tournament.val()?.trim() || !ranking.val() || !category.val() || !achieve.val() || !year.val()?.trim()) {
                                    tournament.addClass('is-invalid');
                                    ranking.addClass('is-invalid');
                                    category.addClass('is-invalid');
                                    achieve.addClass('is-invalid');
                                    year.addClass('is-invalid');

                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Missing Information',
                                        text: 'Please complete experience fields.',
                                        confirmButtonText: 'OK'
                                    });
                                    tableValid = false;
                                    return false; // break out of .each loop
                                }
                            });
                            if (!tableValid) {
                                allValid = false;
                                break; // stop validation loop
                            }
                        } else {
                            for (let field of block.fields) {
                                const el = block.form.find(field.selector);
                                let value = field.isRadio ? el.filter(':checked').val() : (el.val()?.trim() || '');

                                if (!value) {
                                    el.addClass('is-invalid');
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Missing Information',
                                        text: `Please enter ${field.name}`,
                                        confirmButtonText: 'OK'
                                    });
                                    allValid = false;
                                    break;
                                }
                            }
                            if (!allValid) break;
                        }
                    }

                    if (!allValid) return;

                    // Jika semua lengkap
                    Swal.fire({
                        icon: 'success',
                        title: 'All Done!',
                        text: 'Form is complete and ready for submission.',
                        confirmButtonText: 'Submit'
                    }).then(() => {
                        // ===========================
                        // KUMPUL SEMUA DATA
                        // ===========================

                        

                        // ===========================
                        // Data MULTI PLAYER (optional)
                        // ===========================
                        const players = [];
                        $('#multiPlayerForm .multi-row .row').each(function () {
                            players.push({
                                firstName: $(this).find('input[name="firstName[]"]').val().trim(),
                                lastName: $(this).find('input[name="lastName[]"]').val().trim(),
                                email: $(this).find('input[name="email[]"]').val().trim(),
                                phone: $(this).find('input[name="phone[]"]').val().trim()
                            });
                        });
                        allData.players = players;

                        // ===========================
                        // Data formPersonal
                        // ===========================
                        allData.formPersonal = {
                            firstname: $('input[name="firstname"]').val()?.trim(),
                            lastname: $('input[name="lastname"]').val()?.trim(),
                            idNumber: $('input[name="idNumber"]').val()?.trim(),
                            phone: $('input[name="phone"]').val()?.trim(),
                            email: $('input[name="email"]').val()?.trim(),
                            gender: $('input[name="gender"]:checked').val(),
                            race: $('input[name="race"]:checked').val(),
                            picture: $('input[name="picture"]').val()?.trim(),
                            citizen: $('#countryList').val()?.trim(),
                            address: $('textarea[name="address"]').val()?.trim(),
                            postcode: $('input[name="postcode"]').val()?.trim(),
                            state: $('#schA_state').val()?.trim(),
                            district: $('#daerahDropdown').val()?.trim(),
                            size: $('select[name="size"]').val()?.trim(),
                            nameTshirt: $('input[name="NameTshirt"]').val()?.trim()
                        };

                        // ===========================
                        // Data formGuardian
                        // ===========================
                        allData.formGuardian = {
                            name: $('input[name="GuardianName"]').val()?.trim(),
                            phone: $('input[name="GuardianPhone"]').val()?.trim(),
                            occupation: $('input[name="GuardianOccup"]').val()?.trim(),
                            relation: $('select[name="GuardianRelation"]').val()?.trim()
                        };

                        // ===========================
                        // Data formSchool
                        // ===========================
                        allData.formSchool = {
                            schoolId: $('#schoolDropdown').val()?.trim(),
                            schoolCode: $('#CodeScholl').val()?.trim(),
                            schoolAddress: $('#AddressSchool').val()?.trim(),
                            schoolPostcode: $('#PosKod').val()?.trim(),
                            schoolDistrict: $('#districts').val()?.trim(),
                            schoolState: $('#state').val()?.trim()
                        };

                        // ===========================
                        // Data formExperience
                        // ===========================
                        const experience = [];
                        $('#experienceTableBody tr').each(function () {
                            experience.push({
                                tournament: $(this).find('input[name="tournament"]').val()?.trim(),
                                ranking: $(this).find('select[name="ranking[]"]').val(),
                                category: $(this).find('select[name="category[]"]').val(),
                                achieve: $(this).find('select[name="achieve[]"]').val(),
                                year: $(this).find('input[name="year"]').val()?.trim()
                            });
                        });
                        allData.formExperience = experience;

                        // ===========================
                        // Data formClubCoach (jika ada)
                        // ===========================
                        allData.formClubCoach = {
                            ClubId: $('#clubSelect').val()?.trim(),
                            CoachId: $('#coachSelect').val()?.trim()
                        };

                        // ===========================
                        // Akhir sekali, log semua data
                        // ===========================
                        console.log("Data lengkap dari semua tab boleh dihantar:", allData);
                        
                        // Submit data to server example:
                        // $.post('/api/save', allData, function(response) {
                        //     // handle response
                        // });
                    });
                }
                console.log(allData);
                console.log(players);
                //SaveData(allData, players);
            });


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

        function SaveData(AllData, MultipleData) {
            const isMultiple = !$('#formMultiple').hasClass('d-none');
            const url = isMultiple ? saveMultipleUrl : saveSingleUrl;
            const dataToSend = isMultiple ? { players: MultipleData } : { allData: AllData };

            $.ajax({
                url,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify(dataToSend),
                success: (res) => alert('Berjaya!'),
                error: (err) => alert('Ralat!')
            });
        }

    </script>
@endpush
