<form class="tab-form" id="form-achievement" method="POST" action="#" enctype="multipart/form-data">
    @csrf
    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="achievement-table">
            <thead class="table-light">
                <tr>
                    <th>Tournament</th>
                    <th>Level</th>
                    <th>Category</th>
                    <th>Achievement</th>
                    <th>
                        <button class="btn btn-sm btn-success" id="add-achievement-row" type="button" title="Add Row">+</button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $achievements = old('achievement', $coach->achievements ?? []);
                @endphp

                @forelse ($achievements as $index => $ach)
                    <tr>
                        <td><input type="text" class="form-control" name="achievement[{{ $index }}][tournament]" value="{{ $ach['tournament'] ?? '' }}" required></td>
                        <td>
                            <select class="form-select" name="achievement[{{ $index }}][level]" required>
                                <option value="">Select</option>
                                <option value="District" {{ ($ach['level'] ?? '') == 'District' ? 'selected' : '' }}>District</option>
                                <option value="State" {{ ($ach['level'] ?? '') == 'State' ? 'selected' : '' }}>State</option>
                                <option value="National" {{ ($ach['level'] ?? '') == 'National' ? 'selected' : '' }}>National</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select" name="achievement[{{ $index }}][category]" required>
                                <option value="">Select</option>
                                <option value="Men" {{ ($ach['category'] ?? '') == 'Men' ? 'selected' : '' }}>Men</option>
                                <option value="Women" {{ ($ach['category'] ?? '') == 'Women' ? 'selected' : '' }}>Women</option>
                                <option value="Mixed" {{ ($ach['category'] ?? '') == 'Mixed' ? 'selected' : '' }}>Mixed</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select" name="achievement[{{ $index }}][achievement]" required>
                                <option value="">Select</option>
                                <option value="Champion" {{ ($ach['achievement'] ?? '') == 'Champion' ? 'selected' : '' }}>Champion</option>
                                <option value="Runner-up" {{ ($ach['achievement'] ?? '') == 'Runner-up' ? 'selected' : '' }}>Runner-up</option>
                                <option value="Semi-finalist" {{ ($ach['achievement'] ?? '') == 'Semi-finalist' ? 'selected' : '' }}>Semi-finalist</option>
                            </select>
                        </td>
                        <td><button type="button" class="btn btn-sm btn-danger remove-row" title="Remove Row">×</button></td>
                    </tr>
                @empty
                    <tr>
                        <td><input type="text" class="form-control" name="achievement[0][tournament]" required></td>
                        <td>
                            <select class="form-select" name="achievement[0][level]" required>
                                <option value="">Select</option>
                                <option value="District">District</option>
                                <option value="State">State</option>
                                <option value="National">National</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select" name="achievement[0][category]" required>
                                <option value="">Select</option>
                                <option value="Men">Men</option>
                                <option value="Women">Women</option>
                                <option value="Mixed">Mixed</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-select" name="achievement[0][achievement]" required>
                                <option value="">Select</option>
                                <option value="Champion">Champion</option>
                                <option value="Runner-up">Runner-up</option>
                                <option value="Semi-finalist">Semi-finalist</option>
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
        function reindexAchievementRows() {
            $('#achievement-table tbody tr').each(function (index) {
                $(this).find('input, select').each(function () {
                    const name = $(this).attr('name');
                    if (!name) return;
                    const newName = name.replace(/achievement\[\d+\]/, `achievement[${index}]`);
                    $(this).attr('name', newName);
                });
            });
        }

        function validateAchievementRows() {
            let valid = true;
            $('#achievement-table tbody tr').each(function () {
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

        $('#add-achievement-row').click(function () {
            if (!validateAchievementRows()) {
                alert('Please fill all existing rows before adding a new one.');
                return;
            }

            const currentIndex = $('#achievement-table tbody tr').length;

            const newRow = $(`
                <tr>
                    <td><input type="text" class="form-control" name="achievement[${currentIndex}][tournament]" required></td>
                    <td>
                        <select class="form-select" name="achievement[${currentIndex}][level]" required>
                            <option value="">Select</option>
                            <option value="District">District</option>
                            <option value="State">State</option>
                            <option value="National">National</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-select" name="achievement[${currentIndex}][category]" required>
                            <option value="">Select</option>
                            <option value="Men">Men</option>
                            <option value="Women">Women</option>
                            <option value="Mixed">Mixed</option>
                        </select>
                    </td>
                    <td>
                        <select class="form-select" name="achievement[${currentIndex}][achievement]" required>
                            <option value="">Select</option>
                            <option value="Champion">Champion</option>
                            <option value="Runner-up">Runner-up</option>
                            <option value="Semi-finalist">Semi-finalist</option>
                        </select>
                    </td>
                    <td><button type="button" class="btn btn-sm btn-danger remove-row" title="Remove Row">×</button></td>
                </tr>
            `);

            $('#achievement-table tbody').append(newRow);
            reindexAchievementRows();
        });

        $('#achievement-table tbody').on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            reindexAchievementRows();
        });

        $('#form-achievement').on('submit', function (e) {
            if (!validateAchievementRows()) {
                e.preventDefault();
                alert('Please complete all required fields.');
                $('.is-invalid').first().focus();
            }
        });
    });
</script>
@endpush
