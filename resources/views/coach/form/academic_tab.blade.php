<form class="tab-form" id="form-academic" method="POST" action="#" enctype="multipart/form-data">
    @csrf
    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="academic-table">
            <thead class="table-light">
                <tr>
                    <th>Qualification</th>
                    <th>Date</th>
                    <th>Institution</th>
                    <th>
                        <button class="btn btn-sm btn-success" id="add-academic-row" type="button" title="Add Row">+</button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $academics = old('academic', $coach->academics ?? []);
                @endphp

                @forelse ($academics as $index => $item)
                    <tr>
                        <td><input type="text" class="form-control" name="academic[{{ $index }}][qualification]" value="{{ $item['qualification'] ?? '' }}" required></td>
                        <td><input type="date" class="form-control" name="academic[{{ $index }}][date]" value="{{ $item['date'] ?? '' }}" required></td>
                        <td>
                            <select class="form-select" name="academic[{{ $index }}][institution]" required>
                                <option value="">Select</option>
                                <option value="Institution A" {{ ($item['institution'] ?? '') == 'Institution A' ? 'selected' : '' }}>Institution A</option>
                                <option value="Institution B" {{ ($item['institution'] ?? '') == 'Institution B' ? 'selected' : '' }}>Institution B</option>
                                <option value="Institution C" {{ ($item['institution'] ?? '') == 'Institution C' ? 'selected' : '' }}>Institution C</option>
                            </select>
                        </td>
                        <td><button type="button" class="btn btn-sm btn-danger remove-row" title="Remove Row">×</button></td>
                    </tr>
                @empty
                    <tr>
                        <td><input type="text" class="form-control" name="academic[0][qualification]" required></td>
                        <td><input type="date" class="form-control" name="academic[0][date]" required></td>
                        <td>
                            <select class="form-select" name="academic[0][institution]" required>
                                <option value="">Select</option>
                                <option value="Institution A">Institution A</option>
                                <option value="Institution B">Institution B</option>
                                <option value="Institution C">Institution C</option>
                            </select>
                        </td>
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
        function reindexAcademicRows() {
            $('#academic-table tbody tr').each(function (index) {
                $(this).find('input, select').each(function () {
                    const name = $(this).attr('name');
                    if (!name) return;
                    const newName = name.replace(/academic\[\d+\]/, `academic[${index}]`);
                    $(this).attr('name', newName);
                });
            });
        }

        function validateAcademicRows() {
            let valid = true;
            $('#academic-table tbody tr').each(function () {
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

        $('#add-academic-row').click(function () {
            if (!validateAcademicRows()) {
                alert('Please fill all existing rows before adding a new one.');
                return;
            }

            const currentIndex = $('#academic-table tbody tr').length;

            const newRow = $(`
                <tr>
                    <td><input type="text" class="form-control" name="academic[${currentIndex}][qualification]" required></td>
                    <td><input type="date" class="form-control" name="academic[${currentIndex}][date]" required></td>
                    <td>
                        <select class="form-select" name="academic[${currentIndex}][institution]" required>
                            <option value="">Select</option>
                            <option value="Institution A">Institution A</option>
                            <option value="Institution B">Institution B</option>
                            <option value="Institution C">Institution C</option>
                        </select>
                    </td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-row" title="Remove Row">×</button></td>
                </tr>
            `);

            $('#academic-table tbody').append(newRow);
            reindexAcademicRows();
        });

        $('#academic-table tbody').on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            reindexAcademicRows();
        });

        $('#form-academic').on('submit', function (e) {
            if (!validateAcademicRows()) {
                e.preventDefault();
                alert('Please complete all required fields.');
                $('.is-invalid').first().focus();
            }
        });
    });
</script>
@endpush

