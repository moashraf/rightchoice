<!-- Filter Form -->
<form action="{{ route('sitemanagement.aqars.index') }}" class="row align-items-end mb-3">
    <div class="col-md-2">
        <label>الحالة</label>
        <select class="form-control" name="filter_status">
            <option value="">اختر</option>
            @foreach(\App\Enums\StatusEnumAqar::values() as $key => $case)
                <option
                    value="{{ $case }}" {{ request('filter_status') !== null ? (request('filter_status') == $case ? 'selected' : '') : '' }}>{{ $key }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label>تمييز</label>
        <select class="form-control" name="filter_vip">
            <option value="">اختر</option>
            @foreach(\App\Enums\VIPEnum::values() as $key => $case)
                <option
                    value="{{ $case }}" {{ request('filter_vip') !== null ? (request('filter_vip') == $case ? 'selected' : '') : '' }}>{{ $key }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label>نوع الوحدة</label>
        <select class="form-control" name="filter_property_type">
            <option value="">الكل</option>
            @foreach($propertyTypes as $pt)
                <option value="{{ $pt->id }}" {{ request('filter_property_type') == $pt->id ? 'selected' : '' }}>
                    {{ $pt->property_type }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label>المحافظة</label>
        <select class="form-control" name="filter_governrate">
            <option value="">الكل</option>
            @foreach($governrates as $gov)
                <option value="{{ $gov->id }}" {{ request('filter_governrate') == $gov->id ? 'selected' : '' }}>
                    {{ $gov->governrate }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label>نوع العرض</label>
        <select class="form-control" name="filter_offer_type">
            <option value="">الكل</option>
            @foreach($offerTypes as $ot)
                <option value="{{ $ot->id }}" {{ request('filter_offer_type') == $ot->id ? 'selected' : '' }}>
                    {{ $ot->type_offer }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <label>ترتيب حسب</label>
        <select class="form-control" name="sortBy">
            <option value="">اختر</option>
            <option value="0" {{ request('sortBy') == '0' ? 'selected' : '' }}>من الاحدث للاقدم</option>
            <option value="1" {{ request('sortBy') == '1' ? 'selected' : '' }}>من الاقدم للاحدث</option>
        </select>
    </div>
    <div class="col-md-3">
        <label>بحث</label>
        <input type="search" name="key_word" class="form-control" placeholder="بحث: اسم العقار / الكود المرجعي / اسم المالك / موبايل / إيميل"
               value="{{ request('key_word') }}">
    </div>
    <div class="col-md-2">
        <label>من تاريخ</label>
        <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
    </div>
    <div class="col-md-2">
        <label>إلى تاريخ</label>
        <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
    </div>
    <div class="col-md-1 mt-2">
        <button class="btn btn-success btn-block">
            <i class="fa fa-filter"></i> فلتر
        </button>
    </div>

    @if(request()->filled('filter_user_id'))
        <input type="hidden" name="filter_user_id" value="{{ request('filter_user_id') }}">
    @endif
    <div class="col-md-1 mt-2">
        <a href="{{ route('sitemanagement.aqars.index') }}" class="btn btn-secondary btn-block">
            <i class="fa fa-times"></i>
        </a>
    </div>
</form>

<!-- Table -->
<div class="table-responsive">
    <table class="table" id="datatable">
        <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>الاسم</th>
            <th>محافظه</th>
            <th>نوع الوحده</th>
            <th>نوع العرض</th>
            <th>التمييز</th>
            <th>الحاله</th>
            <th>اسم المالك</th>
            <th>المشاهدات</th>
            <th>تاريخ الاضافه</th>
            <th>التنفيذ</th>
        </tr>
        </thead>
        <tbody>
        @foreach($allAqars as $allAqars_val)
            <tr>
                <td>
                    {{ $allAqars_val->id }}
                    @if($allAqars_val->ref_code)
                        <br>
                        <small>
                            <a href="#" class="badge badge-secondary aqar-stats-btn"
                               data-id="{{ $allAqars_val->id }}"
                               data-url="{{ route('sitemanagement.aqars.stats', $allAqars_val->id) }}"
                               title="إحصائيات الإعلان">
                                <i class="fas fa-chart-bar ml-1"></i>{{ $allAqars_val->ref_code }}
                            </a>
                        </small>
                    @endif
                </td>
                <td>{{ \Illuminate\Support\Str::limit($allAqars_val->title, 30, '') }}</td>
                <td>
                    {{ $allAqars_val->governrateq->governrate ?? '' }}
                    @if($allAqars_val->districte)
                        <br>
                        <small class="text-muted">{{ $allAqars_val->districte->district }}</small>
                    @endif
                </td>
                <td>{{ $allAqars_val->propertyType->property_type ?? '' }}</td>
                <td>{{ $allAqars_val->offerTypes->type_offer ?? '' }}</td>
                <td>{{ $allAqars_val->getVIP() }}</td>
                <td>{{ $allAqars_val->getStatus() }}</td>
                <td>
                    @if($allAqars_val->user)
                        <a href="{{ route('sitemanagement.users.index', ['filter_user_id' => $allAqars_val->user->id]) }}" target="_blank" title="عرض المستخدم في صفحة المستخدمين">
                            {{ $allAqars_val->user->name }}
                        </a>
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $allAqars_val->views }}
                    <small>
                        <a href="#" class="badge badge-secondary aqar-stats-btn"
                           data-id="{{ $allAqars_val->id }}"
                           data-url="{{ route('sitemanagement.aqars.stats', $allAqars_val->id) }}"
                           title="إحصائيات الإعلان">
                            <i class="fas fa-chart-bar ml-1"></i> التعامل مع العقار
                        </a>
                    </small>
                </td>
                <td>{{ $allAqars_val->created_at ? date_format($allAqars_val->created_at, "Y/m/d") : '' }}</td>
                <td>
                    @php $authUser = auth()->guard('admin')->user() ?? auth()->user(); @endphp
                    <div class="btn-group gap-2">

                        {{-- عرض: يظهر دائماً لمن عنده aqars.view --}}
                        <a href="{{ route('sitemanagement.aqars.show', [$allAqars_val->id]) }}"
                           class="btn btn-info btn-sm" title="عرض">
                            <i class="fas fa-eye"></i>
                        </a>

                        {{-- تعديل: aqars.update فقط --}}
                        @if($authUser && $authUser->hasPermission('aqars.update'))
                            <a href="{{ route('sitemanagement.aqars.edit', [$allAqars_val->id]) }}"
                               class="btn btn-primary btn-sm" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                        @endif

                        {{-- حذف: aqars.delete فقط --}}
                        @if($authUser && $authUser->hasPermission('aqars.delete'))
                            {!! Form::open(['route' => ['sitemanagement.aqars.destroy', $allAqars_val->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                {!! Form::button('<i class="fas fa-trash"></i>', [
                                    'type'    => 'submit',
                                    'class'   => 'btn btn-danger btn-sm',
                                    'title'   => 'حذف',
                                    'onclick' => "return confirm('هل أنت متأكد من الحذف؟')"
                                ]) !!}
                            {!! Form::close() !!}
                        @endif

                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div class="card-footer clearfix">
    <div class="float-right">
        {{ $allAqars->appends(request()->query())->links() }}
    </div>
</div>

{{-- ── Modal إحصائيات العقار ─────────────────────────────── --}}
<div class="modal fade" id="aqarStatsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">
                    <i class="fas fa-chart-bar ml-1"></i>
                    إحصائيات الإعلان — <span id="statsRefCode"></span>
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                {{-- Loading --}}
                <div id="statsLoading" class="text-center py-4">
                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                </div>

                <div id="statsContent" style="display:none;">
                    {{-- بطاقات الإحصائيات --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-eye"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">عدد المشاهدات العامة</span>
                                    <span class="info-box-number" id="statsViews">0</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-success">
                                <span class="info-box-icon"><i class="fas fa-phone"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">من فتح رقم العميل</span>
                                    <span class="info-box-number" id="statsContactsCount">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- جدول من فتح رقم العميل --}}
                    <h6 class="font-weight-bold mb-2"><i class="fas fa-users ml-1"></i>تفاصيل من فتح رقم العميل</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>اسم المستخدم</th>
                                    <th>رقم الهاتف</th>
                                    <th>واتساب</th>
                                    <th>التاريخ</th>
                                </tr>
                            </thead>
                            <tbody id="statsContactsTable">
                                <tr><td colspan="5" class="text-center text-muted">لا توجد بيانات</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.aqar-stats-btn').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            var url = this.dataset.url;

            // reset modal
            document.getElementById('statsLoading').style.display  = 'block';
            document.getElementById('statsContent').style.display  = 'none';
            document.getElementById('statsRefCode').textContent     = '';
            document.getElementById('statsViews').textContent       = '0';
            document.getElementById('statsContactsCount').textContent = '0';
            document.getElementById('statsContactsTable').innerHTML = '<tr><td colspan="5" class="text-center"><i class="fas fa-spinner fa-spin"></i></td></tr>';

            $('#aqarStatsModal').modal('show');

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                document.getElementById('statsRefCode').textContent        = data.ref_code || '';
                document.getElementById('statsViews').textContent          = data.views;
                document.getElementById('statsContactsCount').textContent  = data.contacts_count;

                var tbody = '';
                if (data.contacts && data.contacts.length > 0) {
                    data.contacts.forEach(function (c, i) {
                        tbody += '<tr>' +
                            '<td>' + (i + 1) + '</td>' +
                            '<td><a href="/sitemanagement/users?filter_user_id=' + c.user_id + '" target="_blank">' + c.name + '</a></td>' +
                            '<td><span class="badge badge-primary">' + c.phone + '</span></td>' +
                            '<td>' + (c.via_whats ? '<span class="badge badge-success">نعم</span>' : '<span class="badge badge-secondary">لا</span>') + '</td>' +
                            '<td>' + c.date + '</td>' +
                        '</tr>';
                    });
                } else {
                    tbody = '<tr><td colspan="5" class="text-center text-muted">لم يفتح أحد رقم العميل بعد</td></tr>';
                }
                document.getElementById('statsContactsTable').innerHTML = tbody;

                document.getElementById('statsLoading').style.display = 'none';
                document.getElementById('statsContent').style.display = 'block';
            })
            .catch(function () {
                document.getElementById('statsLoading').style.display = 'none';
                document.getElementById('statsContent').innerHTML = '<div class="alert alert-danger">حدث خطأ أثناء تحميل البيانات</div>';
                document.getElementById('statsContent').style.display = 'block';
            });
        });
    });
});
</script>

