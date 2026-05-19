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
        <label>ترتيب حسب</label>
        <select class="form-control" name="sortBy">
            <option value="">اختر</option>
            <option value="0" {{ request('sortBy') == '0' ? 'selected' : '' }}>من الاحدث للاقدم</option>
            <option value="1" {{ request('sortBy') == '1' ? 'selected' : '' }}>من الاقدم للاحدث</option>
        </select>
    </div>
    <div class="col-md-3">
        <label>بحث</label>
        <input type="search" name="key_word" class="form-control" placeholder="بحث بالاسم أو المالك"
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
                <td>{{ $allAqars_val->id }}</td>
                <td>{{ \Illuminate\Support\Str::limit($allAqars_val->title, 30, '') }}</td>
                <td>{{ $allAqars_val->governrateq->governrate ?? '' }}</td>
                <td>{{ $allAqars_val->propertyType->property_type ?? '' }}</td>
                <td>{{ $allAqars_val->getVIP() }}</td>
                <td>{{ $allAqars_val->getStatus() }}</td>
                <td>
                    @if($allAqars_val->user)
                        <a href="{{ route('sitemanagement.aqars.show', $allAqars_val->id) }}">
                            {{ $allAqars_val->user->name }}
                        </a>
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $allAqars_val->views }}</td>
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
