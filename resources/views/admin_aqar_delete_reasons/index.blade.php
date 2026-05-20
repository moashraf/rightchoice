@extends('layouts.admin')
@section('title', 'أسباب حذف العقار')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1><i class="fas fa-list-alt text-danger mr-2"></i> أسباب حذف العقار</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('sitemanagement.aqar-delete-reasons.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i> إضافة سبب جديد
                </a>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    @include('flash::message')

    <div class="card card-outline card-danger">
        <div class="card-header">
            <h5 class="mb-0">
                إجمالي الأسباب:
                <span class="badge badge-danger">{{ $reasons->total() }}</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-sm mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                             <th>العنوان (عربي)</th>
                             <th>تاريخ الإضافة</th>
                            <th style="min-width:120px;">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reasons as $reason)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td><strong>{{ $reason->title_ar }}</strong></td>
                                 <td><small>{{ $reason->created_at?->format('Y-m-d') }}</small></td>
                                <td>
                                    <a href="{{ route('sitemanagement.aqar-delete-reasons.edit', $reason->id) }}"
                                       class="btn btn-warning btn-xs">
                                        <i class="fas fa-edit"></i> تعديل
                                    </a>
                                    <form method="POST"
                                          action="{{ route('sitemanagement.aqar-delete-reasons.destroy', $reason->id) }}"
                                          style="display:inline"
                                          onsubmit="return confirm('هل تريد حذف هذا السبب؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs">
                                            <i class="fas fa-trash"></i> حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                    لا توجد أسباب مضافة بعد
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($reasons->hasPages())
            <div class="card-footer">
                {{ $reasons->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

