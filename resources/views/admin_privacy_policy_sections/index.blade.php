@extends('layouts.admin')

@section('title', 'سياسة الخصوصية')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-8">
                    <h1>محتويات سياسة الخصوصية</h1>
                    <p class="text-muted mb-0">يمكنك تعديل العنوان والعنوان الفرعي والتفاصيل لكل عنصر، مع الحفاظ على الرابط الداخلي الخاص به.</p>
                </div>
                <div class="col-sm-4 text-sm-right mt-2 mt-sm-0">
                    <a href="{{ url(app()->getLocale() . '/privacy-policy') }}" target="_blank" class="btn btn-outline-primary">
                        <i class="fas fa-external-link-alt ml-1"></i>
                        معاينة الصفحة
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">العناصر الحالية ({{ $sections->count() }})</h3>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" dir="rtl">
                        <thead class="thead-light">
                        <tr>
                            <th style="width: 80px;">الترتيب</th>
                            <th>العنوان</th>
                            <th>العنوان الفرعي</th>
                            <th style="width: 150px;">الرابط الداخلي</th>
                            <th style="width: 100px;">الحالة</th>
                            <th style="width: 100px;">الإجراء</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sections as $section)
                            <tr>
                                <td class="font-weight-bold">{{ $section->sort_order }}</td>
                                <td>
                                    <strong>{{ $section->title }}</strong>
                                </td>
                                <td class="text-muted">{{ $section->subtitle ?: '—' }}</td>
                                <td>
                                    <code>#{{ $section->slug }}</code>
                                </td>
                                <td>
                                    @if($section->is_active)
                                        <span class="badge badge-success">ظاهر</span>
                                    @else
                                        <span class="badge badge-secondary">مخفي</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('sitemanagement.privacy-policy-sections.edit', $section) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                        تعديل
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">لا توجد عناصر لسياسة الخصوصية.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
