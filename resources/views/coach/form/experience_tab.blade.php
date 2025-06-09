<form class="tab-form" id="form-experience" method="POST" action="#">
    @csrf
    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="experience-table">
            <thead class="table-light">
                <tr>
                    <th>Activity/Competition</th>
                    <th>Position</th>
                    <th>Level</th>
                    <th>Organized By</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>
                        <button class="btn btn-sm btn-success" id="add-experience-row" type="button"
                            title="Add Row">+</button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $experiences = old('experience', $coach->experiences ?? []);
                @endphp

                @forelse ($experiences as $index => $exp)
                    <tr>
                        <td><input class="form-control" name="experience[{{ $index }}][activity]" type="text"
                                value="{{ $exp['activity'] ?? '' }}" required></td>
                        <td>
                            <select class="form-select" name="experience[{{ $index }}][position]" required>
                                <option value="">Select</option>
                                <option value="Coach" {{ ($exp['position'] ?? '') == 'Coach' ? 'selected' : '' }}>Coach</option>
                                <option value="Assistant" {{ ($exp['position'] ?? '') == 'Assistant' ? 'selected' : '' }}>Assistant</option>
                                <option value="Player" {{ ($exp['position'] ?? '') == 'Player' ? 'selected' : '' }}>Player</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select" name="experience[{{ $index }}][level]" required>
                                <option value="">Select</option>
                                <option value="State" {{ ($exp['level'] ?? '') == 'State' ? 'selected' : '' }}>State</option>
                                <option value="National" {{ ($exp['level'] ?? '') == 'National' ? 'selected' : '' }}>National</option>
                                <option value="International" {{ ($exp['level'] ?? '') == 'International' ? 'selected' : '' }}>International</option>
                            </select>
                        </td>
                        <td><input class="form-control" name="experience[{{ $index }}][organized_by]" type="text"
                                value="{{ $exp['organized_by'] ?? '' }}" required></td>
                        <td><input class="form-control" name="experience[{{ $index }}][start_date]" type="date"
                                value="{{ $exp['start_date'] ?? '' }}" required></td>
                        <td><input class="form-control" name="experience[{{ $index }}][end_date]" type="date"
                                value="{{ $exp['end_date'] ?? '' }}" required></td>
                        <td><button class="btn btn-sm btn-danger remove-row" type="button"
                                title="Remove Row">×</button></td>
                    </tr>
                @empty
                    <tr>
                        <td><input class="form-control" name="experience[0][activity]" type="text" required></td>
                        <td>
                            <select class="form-select" name="experience[0][position]" required>
                                <option value="">Select</option>
                                <option value="Coach">Coach</option>
                                <option value="Assistant">Assistant</option>
                                <option value="Player">Player</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select" name="experience[0][level]" required>
                                <option value="">Select</option>
                                <option value="State">State</option>
                                <option value="National">National</option>
                                <option value="International">International</option>
                            </select>
                        </td>
                        <td><input class="form-control" name="experience[0][organized_by]" type="text" required></td>
                        <td><input class="form-control" name="experience[0][start_date]" type="date" required></td>
                        <td><input class="form-control" name="experience[0][end_date]" type="date" required></td>
                        <td><button class="btn btn-sm btn-danger remove-row" type="button"
                                title="Remove Row">×</button></td>
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
        function reindexRows() {
            $('#experience-table tbody tr').each(function (index) {
                $(this).find('input, select').each(function () {
                    const name = $(this).attr('name');
                    if (!name) return;
                    const newName = name.replace(/experience\[\d+\]/, `experience[${index}]`);
                    $(this).attr('name', newName);
                });
            });
        }

        function validateCurrentRows() {
            let valid = true;
            $('#experience-table tbody tr').each(function () {
                $(this).find('input, select').each(function () {
                    if (!$(this).val()) {
                        valid = false;
                        $(this).addClass('is-invalid').attr('title', 'This field is required');
                    } else {
                        $(this).removeClass('is-invalid').removeAttr('title');
                    }
                });
            });
            return valid;
        }

        $('#add-experience-row').click(function () {
            if (!validateCurrentRows()) {
                alert('Please fill all existing rows before adding a new one.');
                return;
            }

            const currentIndex = $('#experience-table tbody tr').length;

            const newRow = $(`
                <tr>
                    <td><input type="text" name="experience[${currentIndex}][activity]" class="form-control" required></td>
                    <td>
                        <select name="experience[${currentIndex}][position]" class="form-select" required>
                            <option value="">Select</option>
                            <option value="Coach">Coach</option>
                            <option value="Assistant">Assistant</option>
                            <option value="Player">Player</option>
                        </select>
                    </td>
                    <td>
                        <select name="experience[${currentIndex}][level]" class="form-select" required>
                            <option value="">Select</option>
                            <option value="State">State</option>
                            <option value="National">National</option>
                            <option value="International">International</option>
                        </select>
                    </td>
                    <td><input type="text" name="experience[${currentIndex}][organized_by]" class="form-control" required></td>
                    <td><input type="date" name="experience[${currentIndex}][start_date]" class="form-control" required></td>
                    <td><input type="date" name="experience[${currentIndex}][end_date]" class="form-control" required></td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-row" title="Remove Row">×</button></td>
                </tr>
            `);

            $('#experience-table tbody').append(newRow);
            reindexRows();
        });

        $('#experience-table tbody').on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            reindexRows();
        });

        $('#form-experience').on('submit', function (e) {
            let valid = true;
            $('#experience-table tbody tr').each(function () {
                const start = new Date($(this).find('[name$="[start_date]"]').val());
                const end = new Date($(this).find('[name$="[end_date]"]').val());
                if (start > end) {
                    alert('Start Date must not be after End Date.');
                    valid = false;
                    return false;
                }
            });
            if (!valid) e.preventDefault();
        });
    });
</script>
@endpush
