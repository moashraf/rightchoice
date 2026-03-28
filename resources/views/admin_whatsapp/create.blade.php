{{-- WhatsApp Compose & Send Page --}}
@extends('layouts.admin')

@section('title', 'إرسال رسائل واتساب')

@section('third_party_stylesheets')
    @include('layouts.datatables_css')
    <style>
        .user-selection-table { max-height: 400px; overflow-y: auto; }
        .placeholder-tag { display: inline-block; background: #e9ecef; padding: 2px 8px; border-radius: 4px; margin: 2px; cursor: pointer; font-size: 13px; }
        .placeholder-tag:hover { background: #25D366; color: #fff; }
        .preview-box { background: #DCF8C6; border: 1px dashed #25D366; padding: 15px; border-radius: 5px; min-height: 60px; }
        .stats-card { text-align: center; padding: 15px; }
        .stats-card h3 { margin: 0; font-size: 28px; font-weight: bold; }
        .stats-card p { margin: 5px 0 0; font-size: 13px; color: #6c757d; }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fab fa-whatsapp text-success"></i> إرسال رسائل واتساب</h1>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('sitemanagement.whatsapp.index') }}" class="btn btn-default float-right">
                        <i class="fas fa-list"></i> سجل الرسائل
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @include('flash::message')

        <form id="whatsappForm" action="{{ route('sitemanagement.whatsapp.store') }}" method="POST">
            @csrf

            <div class="row">
                {{-- Left Column: Message Composition --}}
                <div class="col-md-8">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-edit"></i> كتابة الرسالة</h3>
                        </div>
                        <div class="card-body">
                            {{-- Message Template --}}
                            <div class="form-group">
                                <label for="message_template">نص الرسالة <span class="text-danger">*</span></label>
                                <textarea
                                    name="message_template"
                                    id="message_template"
                                    class="form-control"
                                    rows="5"
                                    maxlength="4096"
                                    placeholder="اكتب نص رسالة واتساب هنا... يمكنك استخدام {name} لإدراج اسم المستخدم"
                                    dir="rtl"
                                >{{ old('message_template') }}</textarea>
                                <small class="form-text text-muted">
                                    <span id="charCount">0</span> / 4096 حرف
                                </small>
                            </div>

                            {{-- Placeholders Help --}}
                            <div class="form-group">
                                <label>المتغيرات المتاحة:</label>
                                <div>
                                    @foreach($placeholders as $placeholder => $description)
                                        <span class="placeholder-tag" onclick="insertPlaceholder('{{ $placeholder }}')" title="{{ $description }}">
                                            {{ $placeholder }} - {{ $description }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Message Preview --}}
                            <div class="form-group">
                                <label>معاينة الرسالة (مثال: محمد):</label>
                                <div class="preview-box" id="messagePreview" dir="rtl">
                                    <em class="text-muted">اكتب الرسالة لرؤية المعاينة...</em>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Send Type Selection --}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-users"></i> اختيار المستلمين</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-radio mb-2">
                                    <input type="radio" id="sendTypeAll" name="send_type" value="all_users"
                                           class="custom-control-input"
                                           {{ old('send_type', 'all_users') === 'all_users' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="sendTypeAll">
                                        <i class="fas fa-globe"></i> إرسال لجميع المستخدمين
                                        <span class="badge badge-primary">{{ $totalUsers }} مستخدم</span>
                                    </label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="sendTypeSelected" name="send_type" value="selected_users"
                                           class="custom-control-input"
                                           {{ old('send_type') === 'selected_users' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="sendTypeSelected">
                                        <i class="fas fa-user-check"></i> إرسال لمستخدمين محددين
                                    </label>
                                </div>
                            </div>

                            {{-- User Selection Panel --}}
                            <div id="userSelectionPanel" style="display: none;">
                                <hr>
                                <div class="form-group">
                                    <label>بحث عن مستخدم:</label>
                                    <input type="text" id="userSearchInput" class="form-control"
                                           placeholder="ابحث بالاسم أو رقم الهاتف أو البريد الإلكتروني...">
                                </div>

                                <div class="mb-2">
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="selectAllBtn">
                                        <i class="fas fa-check-double"></i> تحديد الكل
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllBtn">
                                        <i class="fas fa-times"></i> إلغاء تحديد الكل
                                    </button>
                                    <span class="ml-2">
                                        المحدد: <strong id="selectedCount">0</strong> مستخدم
                                    </span>
                                </div>

                                <div class="user-selection-table">
                                    <table class="table table-sm table-hover table-bordered" id="usersTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="40"><input type="checkbox" id="checkAll"></th>
                                                <th>#</th>
                                                <th>الاسم</th>
                                                <th>الهاتف</th>
                                                <th>البريد</th>
                                            </tr>
                                        </thead>
                                        <tbody id="usersTableBody">
                                            <tr><td colspan="5" class="text-center text-muted">جاري تحميل المستخدمين...</td></tr>
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Pagination --}}
                                <div class="d-flex justify-content-center mt-2" id="usersPagination"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Summary & Actions --}}
                <div class="col-md-4">
                    {{-- Recipient Preview Stats --}}
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-chart-pie"></i> ملخص المستلمين</h3>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4 stats-card">
                                    <h3 class="text-primary" id="previewTotal">0</h3>
                                    <p>الإجمالي</p>
                                </div>
                                <div class="col-4 stats-card">
                                    <h3 class="text-success" id="previewValid">0</h3>
                                    <p>أرقام صالحة</p>
                                </div>
                                <div class="col-4 stats-card">
                                    <h3 class="text-danger" id="previewInvalid">0</h3>
                                    <p>أرقام غير صالحة</p>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-outline-info btn-block" id="refreshPreviewBtn">
                                    <i class="fas fa-sync-alt"></i> تحديث المعاينة
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Send Button --}}
                    <div class="card card-warning">
                        <div class="card-body text-center">
                            <button type="button" class="btn btn-lg btn-success btn-block" id="sendBtn">
                                <i class="fab fa-whatsapp"></i> إرسال رسائل واتساب
                            </button>
                            <small class="form-text text-muted mt-2">
                                سيتم إرسال الرسائل في الخلفية عبر واتساب. يمكنك متابعة الحالة من صفحة التقارير.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Confirmation Modal --}}
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="fab fa-whatsapp"></i> تأكيد إرسال واتساب</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>هل أنت متأكد من إرسال رسائل واتساب؟</p>
                        <table class="table table-sm">
                            <tr>
                                <td>نوع الإرسال:</td>
                                <td><strong id="confirmSendType"></strong></td>
                            </tr>
                            <tr>
                                <td>عدد المستلمين:</td>
                                <td><strong id="confirmTotal"></strong></td>
                            </tr>
                            <tr>
                                <td>أرقام صالحة:</td>
                                <td><strong id="confirmValid" class="text-success"></strong></td>
                            </tr>
                            <tr>
                                <td>أرقام غير صالحة:</td>
                                <td><strong id="confirmInvalid" class="text-danger"></strong></td>
                            </tr>
                        </table>
                        <div class="alert alert-info">
                            <strong>ملاحظة:</strong> سيتم إرسال الرسائل فقط للأرقام الصالحة عبر واتساب.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="button" class="btn btn-success" id="confirmSendBtn">
                            <i class="fab fa-whatsapp"></i> تأكيد الإرسال
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
    @include('layouts.datatables_js')
@endsection

@push('page_scripts')
<script>
$(function () {
    var selectedUserIds = [];
    var currentPage = 1;

    // ─── Character count & preview ──────────────────────────────────
    $('#message_template').on('input', function () {
        var text = $(this).val();
        $('#charCount').text(text.length);

        var preview = text.replace(/\{name\}/g, 'محمد');
        if (preview.trim() === '') {
            $('#messagePreview').html('<em class="text-muted">اكتب الرسالة لرؤية المعاينة...</em>');
        } else {
            $('#messagePreview').text(preview);
        }
    }).trigger('input');

    // ─── Insert placeholder into textarea ───────────────────────────
    window.insertPlaceholder = function (placeholder) {
        var textarea = document.getElementById('message_template');
        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;
        var text = textarea.value;
        textarea.value = text.substring(0, start) + placeholder + text.substring(end);
        textarea.selectionStart = textarea.selectionEnd = start + placeholder.length;
        textarea.focus();
        $(textarea).trigger('input');
    };

    // ─── Send type toggle ───────────────────────────────────────────
    $('input[name="send_type"]').on('change', function () {
        if ($(this).val() === 'selected_users') {
            $('#userSelectionPanel').slideDown();
            loadUsers(1);
        } else {
            $('#userSelectionPanel').slideUp();
        }
    }).filter(':checked').trigger('change');

    // ─── Load users via AJAX ────────────────────────────────────────
    function loadUsers(page) {
        currentPage = page;
        var search = $('#userSearchInput').val();

        $.ajax({
            url: '{{ route("sitemanagement.whatsapp.searchUsers") }}',
            data: { search: search, page: page },
            success: function (response) {
                var tbody = $('#usersTableBody');
                tbody.empty();

                if (response.data.length === 0) {
                    tbody.html('<tr><td colspan="5" class="text-center text-muted">لا توجد نتائج</td></tr>');
                    return;
                }

                response.data.forEach(function (user) {
                    var checked = selectedUserIds.indexOf(user.id) > -1 ? 'checked' : '';
                    tbody.append(
                        '<tr>' +
                        '<td><input type="checkbox" class="user-checkbox" value="' + user.id + '" ' + checked + '></td>' +
                        '<td>' + user.id + '</td>' +
                        '<td>' + escapeHtml(user.name || '—') + '</td>' +
                        '<td>' + escapeHtml(user.MOP || '—') + '</td>' +
                        '<td>' + escapeHtml(user.email || '—') + '</td>' +
                        '</tr>'
                    );
                });

                renderPagination(response);
                updateSelectedCount();
            }
        });
    }

    // ─── User search debounce ───────────────────────────────────────
    var searchTimer;
    $('#userSearchInput').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () { loadUsers(1); }, 400);
    });

    // ─── Pagination renderer ────────────────────────────────────────
    function renderPagination(response) {
        var container = $('#usersPagination');
        container.empty();

        if (response.last_page <= 1) return;

        var nav = '<nav><ul class="pagination pagination-sm">';
        for (var i = 1; i <= response.last_page; i++) {
            nav += '<li class="page-item ' + (i === response.current_page ? 'active' : '') + '">';
            nav += '<a class="page-link user-page-link" href="#" data-page="' + i + '">' + i + '</a>';
            nav += '</li>';
        }
        nav += '</ul></nav>';
        container.html(nav);
    }

    $(document).on('click', '.user-page-link', function (e) {
        e.preventDefault();
        loadUsers($(this).data('page'));
    });

    // ─── Checkbox handling ──────────────────────────────────────────
    $(document).on('change', '.user-checkbox', function () {
        var userId = parseInt($(this).val());
        if ($(this).is(':checked')) {
            if (selectedUserIds.indexOf(userId) === -1) selectedUserIds.push(userId);
        } else {
            selectedUserIds = selectedUserIds.filter(function (id) { return id !== userId; });
        }
        updateSelectedCount();
    });

    $('#checkAll').on('change', function () {
        var isChecked = $(this).is(':checked');
        $('.user-checkbox').each(function () {
            $(this).prop('checked', isChecked).trigger('change');
        });
    });

    $('#selectAllBtn').on('click', function () {
        $('.user-checkbox').prop('checked', true).trigger('change');
    });
    $('#deselectAllBtn').on('click', function () {
        selectedUserIds = [];
        $('.user-checkbox').prop('checked', false);
        updateSelectedCount();
    });

    function updateSelectedCount() {
        $('#selectedCount').text(selectedUserIds.length);
    }

    // ─── Preview recipients ─────────────────────────────────────────
    $('#refreshPreviewBtn').on('click', refreshPreview);

    function refreshPreview() {
        var sendType = $('input[name="send_type"]:checked').val();
        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            send_type: sendType,
            user_ids: sendType === 'selected_users' ? selectedUserIds : []
        };

        $.ajax({
            url: '{{ route("sitemanagement.whatsapp.previewRecipients") }}',
            method: 'POST',
            data: data,
            success: function (r) {
                $('#previewTotal').text(r.total);
                $('#previewValid').text(r.valid);
                $('#previewInvalid').text(r.invalid);
            }
        });
    }

    // ─── Send button → show confirmation ────────────────────────────
    $('#sendBtn').on('click', function () {
        var message = $('#message_template').val().trim();
        if (!message) {
            alert('يرجى كتابة نص الرسالة أولاً');
            return;
        }

        var sendType = $('input[name="send_type"]:checked').val();
        if (sendType === 'selected_users' && selectedUserIds.length === 0) {
            alert('يرجى اختيار مستخدم واحد على الأقل');
            return;
        }

        var data = {
            _token: $('meta[name="csrf-token"]').attr('content'),
            send_type: sendType,
            user_ids: sendType === 'selected_users' ? selectedUserIds : []
        };

        $.ajax({
            url: '{{ route("sitemanagement.whatsapp.previewRecipients") }}',
            method: 'POST',
            data: data,
            success: function (r) {
                $('#previewTotal').text(r.total);
                $('#previewValid').text(r.valid);
                $('#previewInvalid').text(r.invalid);

                $('#confirmSendType').text(sendType === 'all_users' ? 'جميع المستخدمين' : 'مستخدمين محددين');
                $('#confirmTotal').text(r.total);
                $('#confirmValid').text(r.valid);
                $('#confirmInvalid').text(r.invalid);

                if (r.total === 0) {
                    alert('لا يوجد مستلمين للإرسال');
                    return;
                }

                $('#confirmModal').modal('show');
            }
        });
    });

    // ─── Confirm send ───────────────────────────────────────────────
    $('#confirmSendBtn').on('click', function () {
        $('input[name="user_ids[]"]').remove();
        if ($('input[name="send_type"]:checked').val() === 'selected_users') {
            selectedUserIds.forEach(function (id) {
                $('<input>').attr({ type: 'hidden', name: 'user_ids[]', value: id }).appendTo('#whatsappForm');
            });
        }

        $('#confirmModal').modal('hide');
        $('#sendBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...');
        $('#whatsappForm').submit();
    });

    // ─── HTML escape helper ─────────────────────────────────────────
    function escapeHtml(text) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(text));
        return div.innerHTML;
    }
});
</script>
@endpush
