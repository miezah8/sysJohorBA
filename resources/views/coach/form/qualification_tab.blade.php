<form class="tab-form" id="form-qualification" method="POST" action="#" enctype="multipart/form-data">
    @csrf
    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="qualification-table">
            <thead class="table-light">
                <tr>
                    <th>Course/Certificate</th>
                    <th>Level</th>
                    <th>Date Passed</th>
                    <th>Accreditation/Recognition</th>
                    <th>Certificate Number (If Any)</th>
                    <th>Lampiran Sijil</th>
                    <th>
                        <button class="btn btn-sm btn-success" id="add-qualification-row" type="button" title="Add Row">+</button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $qualifications = old('qualification', $coach->qualifications ?? []);
                @endphp

                @forelse ($qualifications as $index => $qual)
                    <tr>
                        <td>
                            <select class="form-select" name="qualification[{{ $index }}][course]" required>
                                <option value="">Select</option>
                                <option value="Cert A" {{ ($qual['course'] ?? '') == 'Cert A' ? 'selected' : '' }}>Cert A</option>
                                <option value="Cert B" {{ ($qual['course'] ?? '') == 'Cert B' ? 'selected' : '' }}>Cert B</option>
                                <option value="Cert C" {{ ($qual['course'] ?? '') == 'Cert C' ? 'selected' : '' }}>Cert C</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select" name="qualification[{{ $index }}][level]" required>
                                <option value="">Select</option>
                                <option value="Level 1" {{ ($qual['level'] ?? '') == 'Level 1' ? 'selected' : '' }}>Level 1</option>
                                <option value="Level 2" {{ ($qual['level'] ?? '') == 'Level 2' ? 'selected' : '' }}>Level 2</option>
                                <option value="Level 3" {{ ($qual['level'] ?? '') == 'Level 3' ? 'selected' : '' }}>Level 3</option>
                            </select>
                        </td>
                        <td><input type="date" class="form-control" name="qualification[{{ $index }}][date_passed]" value="{{ $qual['date_passed'] ?? '' }}" required></td>
                        <td><input type="text" class="form-control" name="qualification[{{ $index }}][accreditation]" value="{{ $qual['accreditation'] ?? '' }}" required></td>
                        <td><input type="text" class="form-control" name="qualification[{{ $index }}][cert_number]" value="{{ $qual['cert_number'] ?? '' }}"></td>
                        <td><input type="file" class="form-control" name="qualification[{{ $index }}][certificate_file]"></td>
                        <td><button type="button" class="btn btn-sm btn-danger remove-row" title="Remove Row">×</button></td>
                    </tr>
                @empty
                    <tr>
                        <td>
                            <select class="form-select" name="qualification[0][course]" required>
                                <option value="">Select</option>
                                <option value="Cert A">Cert A</option>
                                <option value="Cert B">Cert B</option>
                                <option value="Cert C">Cert C</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select" name="qualification[0][level]" required>
                                <option value="">Select</option>
                                <option value="Level 1">Level 1</option>
                                <option value="Level 2">Level 2</option>
                                <option value="Level 3">Level 3</option>
                            </select>
                        </td>
                        <td><input type="date" class="form-control" name="qualification[0][date_passed]" required></td>
                        <td><input type="text" class="form-control" name="qualification[0][accreditation]" required></td>
                        <td><input type="text" class="form-control" name="qualification[0][cert_number]"></td>
                        <td><input type="file" class="form-control" name="qualification[0][certificate_file]"></td>
                        <td><button type="button" class="btn btn-sm btn-danger remove-row" title="Remove Row">×</button></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="text-end mt-3">
        <button class="btn btn-primary" type="submit">Save & Next</button>
    </div>
</form>

@push('scripts')
<script>
    $(document).ready(function () {
        function reindexQualificationRows() {
            $('#qualification-table tbody tr').each(function (index) {
                $(this).find('input, select').each(function () {
                    const name = $(this).attr('name');
                    if (!name) return;
                    const newName = name.replace(/qualification\[\d+\]/, `qualification[${index}]`);
                    $(this).attr('name', newName);
                });
            });
        }

        function validateQualificationRows() {
            let valid = true;
            $('#qualification-table tbody tr').each(function () {
                $(this).find('input, select').each(function () {
                    if ($(this).prop('required') && !$(this).val()) {
                        valid = false;
                        $(this).addClass('is-invalid').attr('title', 'This field is required');
                    } else {
                        $(this).removeClass('is-invalid').removeAttr('title');
                    }
                });
            });
            return valid;
        }

        $('#add-qualification-row').click(function () {
            if (!validateQualificationRows()) {
                alert('Please fill all existing rows before adding a new one.');
                return;
            }

            const currentIndex = $('#qualification-table tbody tr').length;

            const newRow = $(`
                <tr>
                    <td>
                        <select class="form-select" name="qualification[${currentIndex}][course]" required>
                            <option value="">Select</option>
                            <option value="Cert A">Cert A</option>
                            <option value="Cert B">Cert B</option>
                            <option value="Cert C">Cert C</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-select" name="qualification[${currentIndex}][level]" required>
                            <option value="">Select</option>
                            <option value="Level 1">Level 1</option>
                            <option value="Level 2">Level 2</option>
                            <option value="Level 3">Level 3</option>
                        </select>
                    </td>
                    <td><input type="date" class="form-control" name="qualification[${currentIndex}][date_passed]" required></td>
                    <td><input type="text" class="form-control" name="qualification[${currentIndex}][accreditation]" required></td>
                    <td><input type="text" class="form-control" name="qualification[${currentIndex}][cert_number]"></td>
                    <td><input type="file" class="form-control" name="qualification[${currentIndex}][certificate_file]"></td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-row" title="Remove Row">×</button></td>
                </tr>
            `);

            $('#qualification-table tbody').append(newRow);
            reindexQualificationRows();
        });

        $('#qualification-table tbody').on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            reindexQualificationRows();
        });

        $('#form-qualification').on('submit', function (e) {
            if (!validateQualificationRows()) {
                e.preventDefault();
                alert('Please complete all required fields.');
            }
        });
    });
</script>
@endpush
