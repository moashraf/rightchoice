@extends('layouts.admin')

@section('title', 'إدارة المستردات')

@section('third_party_stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6"><h1 class="m-0">إدارة المستردات</h1></div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('sitemanagement.payments.index') }}">المدفوعات</a></li>
                    <li class="breadcrumb-item active">المستردات</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    {{-- Refund Summary --}}
    <div class="row">
        <div class="col-lg-2 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $refundStats['total'] }}</h3>
                    <p>إجمالي الطلبات</p>
                </div>
                <div class="icon"><i class="fas fa-list"></i></div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $refundStats['pending'] }}</h3>
                    <p>قيد المراجعة</p>
                </div>
                <div class="icon"><i class="fas fa-clock"></i></div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $refundStats['approved'] }}</h3>
                    <p>موافق عليها</p>
                </div>
                <div class="icon"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $refundStats['rejected'] }}</h3>
                    <p>مرفوضة</p>
                </div>
                <div class="icon"><i class="fas fa-times-circle"></i></div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $refundStats['refunded'] }}</h3>
                    <p>تم الاسترداد</p>
                </div>
                <div class="icon"><i class="fas fa-undo"></i></div>
            </div>
        </div>
        <div class="col-lg-2 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ number_format($refundStats['totalAmount'], 2) }}</h3>
                    <p>إجمالي المبالغ (ج.م)</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill"></i></div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card card-outline card-warning collapsed-card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter"></i> فلاتر البحث</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <form id="filter-form" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>حالة الاسترداد</label>
                            <select name="filter_refund_status" class="form-control form-control-sm">
                                <option value="">الكل</option>
                                @foreach($refundStatuses as $key => $label)
                                    <option value="{{ $key }}" {{ request('filter_refund_status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>من تاريخ</label>
                            <input type="date" name="filter_date_from" class="form-control form-control-sm" value="{{ request('filter_date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>إلى تاريخ</label>
                            <input type="date" name="filter_date_to" class="form-control form-control-sm" value="{{ request('filter_date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> بحث</button>
                                <a href="{{ route('sitemanagement.payments.refunds') }}" class="btn btn-secondary btn-sm"><i class="fas fa-redo"></i> إعادة تعيين</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-undo"></i> قائمة المستردات</h3>
        </div>
        <div class="card-body">
            {!! $dataTable->table(['width' => '100%', 'class' => 'table table-bordered table-striped table-sm']) !!}
        </div>
    </div>
</div>

{{-- Refund Action Modal --}}
<div class="modal fade" id="refundActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="refundActionTitle">إجراء الاسترداد</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>ملاحظة المشرف</label>
                    <textarea id="refundAdminNote" class="form-control" rows="3" maxlength="1000"></textarea>
                </div>
                <div class="form-group" id="refundRefGroup" style="display:none;">
                    <label>رقم مرجع الاسترداد</label>
                    <input type="text" id="refundRefNumber" class="form-control" maxlength="255">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="refundActionSubmit">تأكيد</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('third_party_scripts')
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {!! $dataTable->scripts() !!}

    <script>
    $(function() {
        var currentRefundId = null;
        var currentAction = null;

        function openModal(refundId, action, title) {
            currentRefundId = refundId;
            currentAction = action;
            $('#refundActionTitle').text(title);
            $('#refundAdminNote').val('');
            $('#refundRefNumber').val('');
            $('#refundRefGroup').toggle(action === 'mark-refunded');
            $('#refundActionModal').modal('show');
        }

        $(document).on('click', '.btn-approve-refund', function() {
            openModal($(this).data('id'), 'approve', 'الموافقة على الاسترداد');
        });
        $(document).on('click', '.btn-reject-refund', function() {
            openModal($(this).data('id'), 'reject', 'رفض الاسترداد');
        });
        $(document).on('click', '.btn-mark-refunded', function() {
            openModal($(this).data('id'), 'mark-refunded', 'تنفيذ الاسترداد');
        });

        $('#refundActionSubmit').on('click', function() {
            var url = '/sitemanagement/refunds/' + currentRefundId + '/' + currentAction;
            var data = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                admin_note: $('#refundAdminNote').val()
            };
            if (currentAction === 'mark-refunded') {
                data.refund_reference_number = $('#refundRefNumber').val();
            }

            $.post(url, data)
                .done(function(res) {
                    $('#refundActionModal').modal('hide');
                    if (res.success) {
                        alert(res.message);
                        window.LaravelDataTables && window.LaravelDataTables['adminrefunddatatable-table'] && window.LaravelDataTables['adminrefunddatatable-table'].ajax.reload();
                    }
                })
                .fail(function(xhr) {
                    alert('حدث خطأ: ' + (xhr.responseJSON?.message || 'خطأ غير معروف'));
                });
        });
    });
    </script>
@endsection
