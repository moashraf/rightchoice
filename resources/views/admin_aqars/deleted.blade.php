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
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th>تاريخ الحذف</th>
                            <th style="min-width:150px;">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allAqars as $aqar)
                            <tr>
                                <td>{{ $aqar->id }}</td>
                                <td>
                                    <span class="font-weight-bold">{{ Str::limit($aqar->title, 40) }}</span>
                                    @if($aqar->vip)
                                        <span class="badge badge-warning badge-sm ml-1">VIP</span>
                                    @endif
                                </td>
                                <td>
                                    @if($aqar->user)
                                        <span>{{ $aqar->user->name }}</span><br>
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
                                <td colspan="8" class="text-center py-4 text-muted">
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
@endsection
