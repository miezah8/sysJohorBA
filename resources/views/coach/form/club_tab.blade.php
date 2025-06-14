<form method="POST" action="#" enctype="multipart/form-data">
    @csrf
    <div class="tab-content">
        <div class="tab-pane fade show active" id="peribadi">
            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Club <span class="text-danger">*</span></label>
                    {{-- <input class="form-control" name="gambar" type="file" required> --}}
                    <select class="form-select" name="achievement[${currentIndex}][level]" required>
                        <option value="">Select</option>
                        <option value="District">District</option>
                        <option value="State">State</option>
                        <option value="National">National</option>
                    </select>
                </div>
            </div>
            <div class="text-end">
                <button class="btn btn-primary" type="submit">Hantar</button>
            </div>
        </div>
    </div>
</form>

{{-- test --}}