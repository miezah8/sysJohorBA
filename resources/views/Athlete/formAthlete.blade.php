@extends('layouts.app')
@section('title', 'Athlete Module')

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
                <div id="formMultiple" style="display: none;">
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
                                    <button type="button" id="addRow" class="btn btn-outline-primary w-100">
                                        <i class="fa-solid fa-plus me-1"></i> Add Player
                                    </button>
                                </div>
                            </div>
                    </form>

                    <!-- End : Form Multiplayer -->
                </div>
                <!-- End: Body Pemain Lebih Dari 1 -->

                <!-- Begin: 1 Pemain (Tabbed) -->
                <div id="formSingle">
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
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Last Name</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">No. KP/Passport</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Phone Number</label>
                                        <input type="tel" class="form-control">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label d-block required">Jantina</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jantina" id="lelaki" value="Lelaki">
                                            <label class="form-check-label" for="lelaki">Lelaki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jantina" id="perempuan" value="Perempuan">
                                            <label class="form-check-label" for="perempuan">Perempuan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label required">Emel</label>
                                        <input type="email" class="form-control">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label required">Warganegara</label>
                                        <select id="countryList" class="form-select">
                                            <option value="">-- Pilih Negara --</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Alamat</label>
                                        <textarea class="form-control" rows="8"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required">Poskod</label>
                                                <input type="text" class="form-control">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required">Negeri</label>
                                                <select class="form-control" id="schA_state" name="sch_state" onchange="stateSch_change(this.value);">
									                <option value="">Please choose state</option>
                                                    <option value="1">JOHOR</option>
                                                    <option value="2">KEDAH</option>
                                                    <option value="3">KELANTAN</option>
                                                    <option value="4">MELAKA</option>
                                                    <option value="5">NEGERI SEMBILAN</option>
                                                    <option value="6">PAHANG</option>
                                                    <option value="8">PERAK</option>
                                                    <option value="9">PERLIS</option>
                                                    <option value="7">PULAU PINANG</option>
                                                    <option value="12">SABAH</option>
                                                    <option value="13">SARAWAK</option>
                                                    <option value="10">SELANGOR</option>
                                                    <option value="11">TERENGGANU</option>
                                                    <option value="14">W.P KUALA LUMPUR</option>
                                                    <option value="15">W.P LABUAN</option>
                                                    <option value="16">W.P PUTRAJAYA</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required">Daerah</label>
                                                <select class="form-select" id="daerahDropdown">
                                                    <option value="">-- Pilih Daerah --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label required">Gambar</label>
                                            <input type="file" class="form-control" accept="image/*">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label required">Saiz T-Shirt</label>
                                            <select class="form-select">
                                                <option value="">-- Pilih Saiz --</option>
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
                                            <label class="form-label required">Nama di T-Shirt</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="guardian" role="tabpanel">
                            <form id="formGuardian">
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Nama Penjaga</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">No Telefon Penjaga</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Pekerjaan</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Perhubungan</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
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
                        
                        <div class="tab-pane fade" id="school" role="tabpanel">
                            <form id="formSchool">
                                <div class="row mt-3">
                                    <!-- Dropdown Nama Sekolah -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Nama Sekolah</label>
                                        <select id="schoolDropdown" class="form-select">
                                            <option value="">-- Pilih Sekolah --</option>
                                            <!-- Contoh pilihan, nanti boleh populate dari JS -->
                                            <option value="SK Taman Bukit">SK Taman Bukit</option>
                                            <option value="SMK Seri Indah">SMK Seri Indah</option>
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
                                                        <select class="form-select">
                                                            <option>Sila pilih pering</option>
                                                            <option>Daerah</option>
                                                            <option>Negeri</option>
                                                            <option>Kebangsaan</option>
                                                            <option>Antarabangsa</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-select">
                                                            <option>Sila pilih kategori</option>
                                                            <option>Bawah 12</option>
                                                            <option>Bawah 15</option>
                                                            <option>Terbuka</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-select">
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
                                        <select id="coachSelect" class="form-select">
                                            <option value="">-- Sila pilih Jurulatih --</option>
                                            <option value="Coach A">Coach A</option>
                                            <option value="Coach B">Coach B</option>
                                            <option value="Coach C">Coach C</option>
                                            <!-- Tambah pilihan lain mengikut keperluan -->
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="clubSelect" class="form-label required">Kelab</label>
                                        <select id="clubSelect" class="form-select">
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
            <button type="button" class="btn btn-secondary btn-sm">Cancel</button>
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            <button type="button" id="SubmitAll" class="btn btn-primary btn-sm">Submit</button>

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

        .required::after {
            content: " *";
            color: red;
        }

    </style>
@endpush

@push('scripts')
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const dataTableSearch = new simpleDatatables.DataTable(
            "#datatable-search", {
                searchable: true,
                fixedHeight: true,
            }
        );
    </script>

    <script>
        const switchMode = document.getElementById('switchMode');
        const formMultiple = document.getElementById('formMultiple');
        const formSingle = document.getElementById('formSingle');

        switchMode.addEventListener('change', function () {
            if (this.checked) {
                formMultiple.style.display = 'block';
                formSingle.style.display = 'none';
            } else {
                formMultiple.style.display = 'none';
                formSingle.style.display = 'block';
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('#multiPlayerForm');
            const container = form.querySelector('.multi-row');
            const addButton = document.querySelector('#addRow');

            addButton.addEventListener('click', function () {
                const row = container.querySelector('.row');
                const newRow = row.cloneNode(true);

                newRow.querySelectorAll('input').forEach(input => input.value = '');
                container.appendChild(newRow);
            });

            form.addEventListener('click', function (e) {
                if (e.target.classList.contains('removeRow')) {
                    const rows = container.querySelectorAll('.row');
                    if (rows.length > 1) {
                        e.target.closest('.row').remove();
                    } else {
                        alert('Sekurang-kurangnya satu baris mesti ada.');
                    }
                }
            });
        });
    </script>

    <script>
        fetch('https://restcountries.com/v3.1/all')
        .then(res => res.json())
        .then(data => {
            const countrySelect = document.getElementById('countryList');
            const countries = data.map(c => c.name.common).sort();
            countries.forEach(name => {
            const opt = document.createElement('option');
            opt.value = name;
            opt.textContent = name;
            countrySelect.appendChild(opt);
            });
        });
    </script>

    <script>
    // Penuhkan dropdown Negeri
    fetch('proxy.php?endpoint=negeri')
        .then(response => response.json())
        .then(data => {
        const negeriSelect = document.getElementById('negeriDropdown');
        negeriSelect.innerHTML = '<option value="">-- Pilih Negeri --</option>';
        data.forEach(negeri => {
            const option = document.createElement('option');
            option.value = negeri.name;
            option.textContent = negeri.name;
            negeriSelect.appendChild(option);
        });
        });

    // Bila negeri berubah, penuhkan Daerah
    document.getElementById('negeriDropdown').addEventListener('change', function () {
        const negeri = this.value;
        const daerahSelect = document.getElementById('daerahDropdown');
        daerahSelect.innerHTML = '<option value="">-- Pilih Daerah --</option>';

        if (negeri) {
        fetch(`proxy.php?endpoint=daerah&negeri=${encodeURIComponent(negeri)}`)
            .then(response => response.json())
            .then(data => {
            data.forEach(daerah => {
                const option = document.createElement('option');
                option.value = daerah;
                option.textContent = daerah;
                daerahSelect.appendChild(option);
            });
            });
        }
    });
    </script>

    <script>
        $('#SubmitAll').on('click', function () {
            let isValid = true;
            let data = [];

            $('input[name="firstName[]"]').each(function (index) {
                let firstName = $(this).val().trim();
                let lastName = $('input[name="lastName[]"]').eq(index).val().trim();
                let email = $('input[name="email[]"]').eq(index).val().trim();
                let phone = $('input[name="phone[]"]').eq(index).val().trim();

                if (!firstName || !lastName || !email || !phone) {
                    isValid = false;
                    return false; // keluar dari .each
                }

                data.push({
                    firstName: firstName,
                    lastName: lastName,
                    email: email,
                    phone: phone
                });
            });

            if (!isValid) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Maklumat tidak lengkap',
                    text: 'Sila pastikan semua medan diisi sebelum meneruskan.'
                });
                return;
            }

            console.log(data);

        });

    </script>


@endpush
