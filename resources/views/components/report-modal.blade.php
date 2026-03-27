{{-- Report Modal Component - include this in any page that needs reporting --}}
<div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-flag text-danger"></i> {{ trans('langsite.report_user') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="reportForm">
                <div class="modal-body">
                    <input type="hidden" name="reported_id" id="reportUserId">
                    <input type="hidden" name="reported_type" id="reportType" value="user">
                    <input type="hidden" name="reported_content_id" id="reportContentId" value="">

                    <div class="mb-3">
                        <label class="form-label">{{ trans('langsite.report_reason') }}</label>
                        <select name="reason" class="form-select" required>
                            <option value="">{{ trans('langsite.select') }}...</option>
                            <option value="spam">{{ trans('langsite.report_spam') }}</option>
                            <option value="harassment">{{ trans('langsite.report_harassment') }}</option>
                            <option value="inappropriate">{{ trans('langsite.report_inappropriate') }}</option>
                            <option value="fake">{{ trans('langsite.report_fake') }}</option>
                            <option value="other">{{ trans('langsite.report_other') }}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ trans('langsite.details') }} ({{ trans('langsite.optional') }})</label>
                        <textarea name="details" class="form-control" rows="3" maxlength="1000" placeholder="{{ trans('langsite.add_details') }}..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('langsite.cancel') }}</button>
                    <button type="submit" class="btn btn-danger">{{ trans('langsite.submit_report') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function reportUserModal(userId, type, contentId) {
    document.getElementById('reportUserId').value = userId;
    document.getElementById('reportType').value = type || 'user';
    document.getElementById('reportContentId').value = contentId || '';

    var reportModalEl = document.getElementById('reportModal');
    var modal = bootstrap.Modal.getOrCreateInstance ? bootstrap.Modal.getOrCreateInstance(reportModalEl) : new bootstrap.Modal(reportModalEl);
    modal.show();
}

document.getElementById('reportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const data = {};
    formData.forEach((val, key) => data[key] = val);

    fetch('{{ route("report.store", app()->getLocale()) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(r => r.json())
    .then(result => {
        var modalEl = document.getElementById('reportModal');
        var modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();

        if (result.success) {
            toastr.success(result.message);
        } else {
            toastr.error(result.error || '{{ trans("langsite.error_occurred") }}');
        }
        document.getElementById('reportForm').reset();
    })
    .catch(() => toastr.error('{{ trans("langsite.error_occurred") }}'));
});
</script>
