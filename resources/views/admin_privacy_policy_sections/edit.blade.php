@extends('layouts.admin')

@section('title', 'تعديل سياسة الخصوصية')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-8">
                    <h1>تعديل عنصر سياسة الخصوصية</h1>
                    <p class="text-muted mb-0">#{{ $privacyPolicySection->slug }}</p>
                </div>
                <div class="col-sm-4 text-sm-right mt-2 mt-sm-0">
                    <a href="{{ route('sitemanagement.privacy-policy-sections.index') }}" class="btn btn-default">
                        رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3" dir="rtl">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('sitemanagement.privacy-policy-sections.update', $privacyPolicySection) }}">
            @csrf
            @method('PUT')

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">العنوان <span class="text-danger">*</span></label>
                        <input id="title" type="text" name="title" class="form-control"
                               value="{{ old('title', $privacyPolicySection->title) }}" required maxlength="255">
                    </div>

                    <div class="form-group">
                        <label for="subtitle">العنوان الفرعي</label>
                        <input id="subtitle" type="text" name="subtitle" class="form-control"
                               value="{{ old('subtitle', $privacyPolicySection->subtitle) }}" maxlength="500">
                    </div>

                    <div class="form-group">
                        <label for="details">التفاصيل <span class="text-danger">*</span></label>
                        <textarea id="details" name="details" rows="18" class="form-control" required>{{ old('details', $privacyPolicySection->details) }}</textarea>
                        <small class="form-text text-muted">
                            يمكنك استخدام HTML بسيط مثل &lt;p&gt; و &lt;ul&gt; و &lt;li&gt; و &lt;strong&gt; و &lt;a&gt; لتنسيق المحتوى.
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sort_order">الترتيب</label>
                                <input id="sort_order" type="number" min="1" max="999" name="sort_order"
                                       class="form-control" value="{{ old('sort_order', $privacyPolicySection->sort_order) }}" required>
                            </div>
                        </div>
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="custom-control custom-switch mt-3">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                       {{ old('is_active', $privacyPolicySection->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">إظهار هذا العنصر في صفحة سياسة الخصوصية</label>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light border mb-0">
                        <strong>الرابط الداخلي ثابت:</strong>
                        <code>#{{ $privacyPolicySection->slug }}</code>
                        <br>
                        <small class="text-muted">لا يتم تعديل الـ slug من لوحة الإدارة حتى لا تتعطل الروابط المنشورة.</small>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    <a href="{{ route('sitemanagement.privacy-policy-sections.index') }}" class="btn btn-default">إلغاء</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save ml-1"></i>
                        حفظ التعديلات
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
