@extends('layouts.admin')
@section('title', 'العقارات المحذوفة')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1>
                    <i class="fas fa-trash-restore text-danger mr-2"></i>
                    العقارات المحذوفة
                </h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('sitemanagement.aqars.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right mr-1"></i> العودة للعقارات
                </a>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    @include('flash::message')

    {{-- Search bar --}}
    <div class="card card-outline card-danger mb-3">
        <div class="card-body p-2">
            <form method="GET" action="{{ route('sitemanagement.aqars.deleted') }}" class="form-inline">
                <div class="input-group w-100">
                    <input type="text" name="key_word" class="form-control"
                           placeholder="🔍 بحث بالعنوان أو اسم المستخدم..."
                           value="{{ request('key_word') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-danger">بحث</button>
                        @if(request('key_word'))
                            <a href="{{ route('sitemanagement.aqars.deleted') }}" class="btn btn-secondary">مسح</a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card card-outline card-danger">
        <div class="card-header">
            <h5 class="mb-0 text-danger">
                <i class="fas fa-trash mr-1"></i>
                إجمالي العقارات المحذوفة:
                <span class="badge badge-danger">{{ $allAqars->total() }}</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>العنوان</th>
                            <th>المستخدم</th>
                            <th>المحافظة</th>
                            <th>حاله   العقار </th>
                            <th>تاريخ الإنشاء</th>
                            <th>تاريخ الحذف</th>
                            <th>تم الحذف بواسطة</th>
                            <th style="min-width:150px;">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allAqars as $aqar)
                            <tr>
                                <td>{{ $aqar->id }}</td>
                                <td>
                                    <a href="#" class="font-weight-bold"
                                       data-toggle="modal"
                                       data-target="#aqarModal{{ $aqar->id }}">
                                        {{ Str::limit($aqar->title, 40) }}
                                    </a>
                                    @if($aqar->vip)
                                        <span class="badge badge-warning badge-sm ml-1">VIP</span>
                                    @endif
                                </td>
                                <td>
                                    @if($aqar->user)
                                        <a href="{{ url('sitemanagement/users/' . $aqar->user->id) }}" target="_blank">
                                            {{ $aqar->user->name }}
                                        </a><br>
                                        <small class="text-muted">{{ $aqar->user->MOP }}</small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $aqar->governrateq->governrate ?? '—' }}</td>
                                <td>
                                    @if($aqar->status == 1)
                                        <span class="badge badge-success">نشط</span>
                                    @elseif($aqar->status == 0)
                                        <span class="badge badge-warning">معلق</span>
                                    @else
                                        <span class="badge badge-secondary">متوقف</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $aqar->created_at?->format('Y-m-d') }}</small>
                                </td>
                                <td>
                                    <small class="text-danger">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $aqar->deleted_at?->diffForHumans() }}
                                        <br>
                                        {{ $aqar->deleted_at?->format('Y-m-d H:i') }}
                                    </small>
                                </td>
                                <td>
                                    @if($aqar->updatedBy)
                                        <a href="{{ url('sitemanagement/users/' . $aqar->updatedBy->id) }}" target="_blank">
                                            <span class="badge badge-danger">
                                                <i class="fas fa-user-times mr-1"></i>
                                                {{ $aqar->updatedBy->name }}
                                            </span>
                                        </a>
                                        <br>
                                        <small class="text-muted">{{ $aqar->updatedBy->MOP ?? '' }}</small>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Restore --}}
                                    <form method="POST"
                                          action="{{ route('sitemanagement.aqars.restore', $aqar->id) }}"
                                          style="display:inline"
                                          onsubmit="return confirm('هل تريد استعادة هذا العقار؟')">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-xs" title="استعادة">
                                            <i class="fas fa-trash-restore"></i> استعادة
                                        </button>
                                    </form>

                                    {{-- Force Delete --}}
                                    <form method="POST"
                                          action="{{ route('sitemanagement.aqars.forceDelete', $aqar->id) }}"
                                          style="display:inline"
                                          onsubmit="return confirm('تحذير! سيتم حذف العقار نهائياً ولا يمكن التراجع. هل أنت متأكد؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs" title="حذف نهائي">
                                            <i class="fas fa-times"></i> حذف نهائي
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="fas fa-check-circle fa-2x text-success mb-2 d-block"></i>
                                    لا توجد عقارات محذوفة
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($allAqars->hasPages())
            <div class="card-footer">
                {{ $allAqars->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

</div>

{{-- ========== Modals ========== --}}
@foreach($allAqars as $aqar)
<div class="modal fade" id="aqarModal{{ $aqar->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-building mr-2"></i>
                    {{ $aqar->title }}
                    @if($aqar->vip) <span class="badge badge-warning">VIP</span> @endif
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">

                {{-- صور العقار --}}
                @if($aqar->images && $aqar->images->count())
                <div class="mb-3">
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($aqar->images->take(6) as $img)
                            <img src="{{ asset('images/' . $img->img_url) }}"
                                 style="width:120px;height:90px;object-fit:cover;border-radius:6px;border:2px solid #ddd;"
                                 onerror="this.style.display='none'">
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="row">
                    {{-- بيانات أساسية --}}
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr><th colspan="2" class="bg-light text-center">البيانات الأساسية</th></tr>
                            <tr><td><strong>رقم العقار</strong></td><td>#{{ $aqar->id }}</td></tr>
                            <tr><td><strong>نوع العرض</strong></td><td>{{ $aqar->offerTypes->type_offer ?? '—' }}</td></tr>
                            <tr><td><strong>الفئة</strong></td><td>{{ $aqar->categoryRel->name ?? '—' }}</td></tr>
                            <tr><td><strong>نوع العقار</strong></td><td>{{ $aqar->propertyType->property_type ?? '—' }}</td></tr>
                            <tr><td><strong>حاله   العقار </strong></td>
                                <td>
                                    @if($aqar->status == 1) <span class="badge badge-success">نشط</span>
                                    @elseif($aqar->status == 0) <span class="badge badge-warning">معلق</span>
                                    @else <span class="badge badge-secondary">متوقف</span>
                                    @endif
                                </td>
                            </tr>
                            <tr><td><strong>المحافظة</strong></td><td>{{ $aqar->governrateq->governrate ?? '—' }}</td></tr>
                            <tr><td><strong>المنطقة</strong></td><td>{{ $aqar->districte->district ?? '—' }}</td></tr>
                            <tr><td><strong>المنطقة الفرعية</strong></td><td>{{ $aqar->subAreaa->sub_area ?? '—' }}</td></tr>
                            <tr><td><strong>الكمبوند</strong></td><td>{{ $aqar->compounds->compound ?? '—' }}</td></tr>
                            <tr><td><strong>نوع التشطيب</strong></td><td>{{ $aqar->finishType->finish_type ?? '—' }}</td></tr>
                        </table>
                    </div>

                    {{-- تفاصيل --}}
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr><th colspan="2" class="bg-light text-center">التفاصيل والأسعار</th></tr>
                            <tr><td><strong>المساحة الإجمالية</strong></td><td>{{ $aqar->total_area ?? '—' }} م²</td></tr>
                            <tr><td><strong>مساحة الأرض</strong></td><td>{{ $aqar->land_area ?? '—' }} م²</td></tr>
                            <tr><td><strong>الغرف</strong></td><td>{{ $aqar->rooms ?? '—' }}</td></tr>
                            <tr><td><strong>الحمامات</strong></td><td>{{ $aqar->baths ?? '—' }}</td></tr>
                            <tr><td><strong>الدور</strong></td><td>{{ $aqar->floor ?? '—' }}</td></tr>
                            <tr><td><strong>عدد الطوابق</strong></td><td>{{ $aqar->number_of_floors ?? '—' }}</td></tr>
                            <tr><td><strong>السعر الإجمالي</strong></td><td>{{ $aqar->total_price ? number_format($aqar->total_price) . ' ج.م' : '—' }}</td></tr>
                            <tr><td><strong>سعر المتر</strong></td><td>{{ $aqar->mtr_price ? number_format($aqar->mtr_price) . ' ج.م' : '—' }}</td></tr>
                            <tr><td><strong>المقدم</strong></td><td>{{ $aqar->downpayment ? number_format($aqar->downpayment) . ' ج.م' : '—' }}</td></tr>
                            <tr><td><strong>القسط الشهري</strong></td><td>{{ $aqar->installment_value ? number_format($aqar->installment_value) . ' ج.م' : '—' }}</td></tr>
                            <tr><td><strong>مدة التقسيط</strong></td><td>{{ $aqar->installment_time ? $aqar->installment_time . ' شهر' : '—' }}</td></tr>
                            <tr><td><strong>الإيجار الشهري</strong></td><td>{{ $aqar->monthly_rent ? number_format($aqar->monthly_rent) . ' ج.م' : '—' }}</td></tr>
                        </table>
                    </div>

                    {{-- بيانات المالك --}}
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr><th colspan="2" class="bg-light text-center">بيانات المالك</th></tr>
                            <tr><td><strong>الاسم</strong></td>
                                <td>
                                    @if($aqar->user)
                                        <a href="{{ url('sitemanagement/users/' . $aqar->user->id) }}" target="_blank">{{ $aqar->user->name }}</a>
                                    @else — @endif
                                </td>
                            </tr>
                            <tr><td><strong>الهاتف</strong></td><td>{{ $aqar->user->MOP ?? '—' }}</td></tr>
                            <tr><td><strong>البريد</strong></td><td>{{ $aqar->user->email ?? '—' }}</td></tr>
                        </table>
                    </div>

                    {{-- بيانات الحذف --}}
                    <div class="col-md-6">
                        <table class="table table-sm table-bordered">
                            <tr><th colspan="2" class="bg-light text-center">بيانات الحذف</th></tr>
                            <tr><td><strong>تاريخ الإنشاء</strong></td><td>{{ $aqar->created_at?->format('Y-m-d H:i') }}</td></tr>
                            <tr><td><strong>تاريخ الحذف</strong></td><td class="text-danger">{{ $aqar->deleted_at?->format('Y-m-d H:i') }}</td></tr>
                            <tr><td><strong>تم الحذف بواسطة</strong></td>
                                <td>
                                    @if($aqar->updatedBy)
                                        <a href="{{ url('sitemanagement/users/' . $aqar->updatedBy->id) }}" target="_blank">
                                            <span class="badge badge-danger">{{ $aqar->updatedBy->name }}</span>
                                        </a>
                                        {{ $aqar->updatedBy->MOP ?? '' }}
                                    @else — @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- الوصف --}}
                    @if($aqar->description)
                    <div class="col-12">
                        <div class="card card-outline card-secondary">
                            <div class="card-header py-1"><strong>الوصف</strong></div>
                            <div class="card-body py-2">{{ $aqar->description }}</div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
