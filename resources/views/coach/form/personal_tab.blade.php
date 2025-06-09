<form method="POST" action="#" enctype="multipart/form-data">
    @csrf
    <div class="tab-content">
        <div class="tab-pane fade show active" id="peribadi">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Profile Image <span class="text-danger">*</span></label>
                    <input class="form-control" name="gambar" type="file" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Full Name (as in ID Card or Passport) <span
                            class="text-danger">*</span></label>
                    <input class="form-control" name="nama_penuh" type="text" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input class="form-control" name="emel" type="email" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone No. <span class="text-danger">*</span></label>
                    <input class="form-control" name="no_tel" type="text" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nationality <span class="text-danger">*</span></label>
                    <select class="form-select" name="nationality" required>
                        <option selected disabled>Please Select</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Other">Others</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">IC Number / Passport<span class="text-danger">*</span></label>
                    <input class="form-control" name="no_kad" type="text" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Address <span class="text-danger">*</span></label>
                <textarea class="form-control" name="alamat" rows="3" required></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">State <span class="text-danger">*</span></label>
                    <select class="form-select" name="negeri" required>
                        <option selected disabled>Please Select</option>
                        <option value="Selangor">Selangor</option>
                        <option value="Johor">Johor</option>
                        <!-- Add others -->
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">District <span class="text-danger">*</span></label>
                    <select class="form-select" name="daerah" required>
                        <option selected disabled>Please Select</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Poscode <span class="text-danger">*</span></label>
                    <input class="form-control" name="poskod" type="text" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Gender <span class="text-danger">*</span></label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="jantina" type="radio" value="Lelaki" required>
                        <label class="form-check-label">Male</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" name="jantina" type="radio" value="Perempuan" required>
                        <label class="form-check-label">Female</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Race<span class="text-danger">*</span></label>
                    <select class="form-select" name="ethnicity" required>
                        <option selected disabled>Please Select</option>
                        <option value="Malay">Malay</option>
                        <option value="Chinese">Chinese</option>
                        <option value="Indian">Indian</option>
                        <option value="Other">Others</option>
                    </select>
                </div>
                {{-- <div class="col-md-4">
                    <label class="form-label">Nyatakan <span class="text-danger">*</span></label>
                    <input class="form-control" name="nyatakan" type="text" required>
                </div> --}}
            </div>
            <div class="text-end">
                <button class="btn btn-primary" type="submit">Hantar</button>
            </div>
        </div>
    </div>
</form>
