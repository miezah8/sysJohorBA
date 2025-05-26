@extends('layouts.app')
@section('title', 'Athlete Module')

@section('content')
    <div class="card">
        <!-- Card header -->
        <div class="card-header d-flex justify-content-between">
            <h5 class="mb-0">Pendaftaran Athlete</h5>
        </div>
        <div class="table-responsive">
            <div class="card-body">
                <!-- Switch Button -->
            <div class="form-check form-switch mb-4">
                <input class="form-check-input" type="checkbox" role="switch" id="switchMode">
                <label class="form-check-label" for="switchMode">Pemain lebih dari 1</label>
            </div>

                <!-- Form: Pemain Lebih Dari 1 -->
                <div id="formMultiple" style="display: none;">
                    <form id="multiPlayerForm">
                        <div class="multi-row">
                            <div class="row align-items-end mb-2">
                                <div class="col-md-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="firstName[]">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Family Name</label>
                                    <input type="text" class="form-control" name="lastName[]">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email[]">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" name="phone[]">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger removeRow">Remove</button>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mb-3">
                            <button type="button" id="addRow" class="btn btn-outline-primary">
                                <i class="fa-solid fa-plus me-1"></i> Add Player
                            </button>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <!-- Form: 1 Pemain (Tabbed) -->

                <div id="formSingle">
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
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <!-- Maklumat Peribadi Form -->
                            <form id="formPersonal">
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">First Name</label>
                                        <input type="text" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Last Name</label>
                                        <input type="text" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">No. KP/Passport</label>
                                        <input type="text" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Phone Number</label>
                                        <input type="tel" class="form-control" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label d-block required">Jantina</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jantina" id="lelaki" value="Lelaki" required>
                                            <label class="form-check-label" for="lelaki">Lelaki</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="jantina" id="perempuan" value="Perempuan">
                                            <label class="form-check-label" for="perempuan">Perempuan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <label class="form-label required">Emel</label>
                                        <input type="email" class="form-control" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label required">Warganegara</label>
                                        <select id="countryList" class="form-select" required>
                                            <option value="">-- Pilih Negara --</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Alamat</label>
                                        <textarea class="form-control" rows="8" required></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required">Poskod</label>
                                                <input type="text" class="form-control" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required">Negeri</label>
                                                <select class="form-select" id="negeriDropdown" required>
                                                    <option value="">-- Pilih Negeri --</option>
                                                </select>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label required">Daerah</label>
                                                <select class="form-select" id="daerahDropdown" required>
                                                    <option value="">-- Pilih Daerah --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label class="form-label required">Gambar</label>
                                            <input type="file" class="form-control" accept="image/*" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label required">Saiz T-Shirt</label>
                                            <select class="form-select" required>
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
                                            <input type="text" class="form-control" required>
                                        </div>
                                        
                                    </div>

                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Other tab forms will go here... -->

                    </div>
                </div>

            </div>
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

@endpush
