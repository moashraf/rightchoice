@extends('layouts.admin')
@section('title', 'Meta Conversions API')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fab fa-facebook-square text-primary"></i> Meta Conversions API</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href=" ">الرئيسية</a></li>
                    <li class="breadcrumb-item active">Meta Conversions API</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            {!! session('success') !!}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            {!! session('error') !!}
        </div>
    @endif

    {{-- Status Banner --}}
    <div class="alert {{ ($setting && $setting->fb_conversions_api_enabled && $setting->fb_pixel_id && $setting->fb_access_token) ? 'alert-success' : 'alert-warning' }}">
        <i class="fas fa-circle mr-1"></i>
        @if($setting && $setting->fb_conversions_api_enabled && $setting->fb_pixel_id && $setting->fb_access_token)
            <strong>Meta Conversions API مفعّل</strong> — البيكسل والـ API يعملان معاً لتحسين دقة التتبع.
        @else
            <strong>Meta Conversions API غير مفعّل</strong> — قم بإدخال البيانات وتفعيل الخدمة أدناه.
        @endif
    </div>

    <div class="row">

        {{-- ═══════════════════════════════════════════════ --}}
        {{-- SETTINGS FORM                                   --}}
        {{-- ═══════════════════════════════════════════════ --}}
        <div class="col-lg-7">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-sliders-h mr-1"></i> إعدادات Meta Pixel & Conversions API</h3>
                </div>

                <form action="{{ route('sitemanagement.meta-conversions.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        {{-- Enable Toggle --}}
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-lg">
                                <input type="checkbox" class="custom-control-input" id="fb_conversions_api_enabled"
                                    name="fb_conversions_api_enabled" value="1"
                                    {{ ($setting && $setting->fb_conversions_api_enabled) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="fb_conversions_api_enabled">
                                    تفعيل Meta Pixel & Conversions API
                                </label>
                            </div>
                        </div>

                        <hr>

                        {{-- Pixel ID --}}
                        <div class="form-group">
                            <label for="fb_pixel_id">
                                <i class="fab fa-facebook mr-1 text-primary"></i>
                                Facebook Pixel ID
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('fb_pixel_id') is-invalid @enderror"
                                id="fb_pixel_id" name="fb_pixel_id"
                                value="{{ old('fb_pixel_id', $setting?->fb_pixel_id) }}"
                                placeholder="مثال: 1234567890123456">
                            @error('fb_pixel_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                تجده في: <strong>Meta Business Suite → Events Manager → Pixels</strong>
                            </small>
                        </div>

                        {{-- Access Token --}}
                        <div class="form-group">
                            <label for="fb_access_token">
                                <i class="fas fa-key mr-1 text-warning"></i>
                                Conversions API Access Token
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('fb_access_token') is-invalid @enderror"
                                    id="fb_access_token" name="fb_access_token"
                                    value="{{ old('fb_access_token', $setting?->fb_access_token) }}"
                                    placeholder="EAAxxxxx...">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="toggleToken">
                                        <i class="fas fa-eye" id="toggleTokenIcon"></i>
                                    </button>
                                </div>
                                @error('fb_access_token')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">
                                تجده في: <strong>Events Manager → الـ Pixel → إعدادات → Conversions API → إنشاء Access Token</strong>
                            </small>
                        </div>

                        {{-- Test Event Code --}}
                        <div class="form-group">
                            <label for="fb_test_event_code">
                                <i class="fas fa-vial mr-1 text-info"></i>
                                Test Event Code
                                <small class="text-muted">(اختياري — للاختبار فقط)</small>
                            </label>
                            <input type="text" class="form-control @error('fb_test_event_code') is-invalid @enderror"
                                id="fb_test_event_code" name="fb_test_event_code"
                                value="{{ old('fb_test_event_code', $setting?->fb_test_event_code) }}"
                                placeholder="مثال: TEST12345">
                            @error('fb_test_event_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                استخدمه فقط أثناء الاختبار. أفرغه في بيئة الإنتاج.
                            </small>
                        </div>

                        {{-- GTM ID --}}
                        <div class="form-group">
                            <label for="gtm_id">
                                <i class="fab fa-google mr-1 text-danger"></i>
                                Google Tag Manager ID
                                <small class="text-muted">(اختياري)</small>
                            </label>
                            <input type="text" class="form-control @error('gtm_id') is-invalid @enderror"
                                id="gtm_id" name="gtm_id"
                                value="{{ old('gtm_id', $setting?->gtm_id) }}"
                                placeholder="مثال: GTM-XXXXXXX">
                            @error('gtm_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Google Ads ID --}}
                        <div class="form-group">
                            <label for="google_ads_id">
                                <i class="fab fa-google mr-1 text-success"></i>
                                Google Ads ID (gtag.js)
                                <small class="text-muted">(اختياري)</small>
                            </label>
                            <input type="text" class="form-control @error('google_ads_id') is-invalid @enderror"
                                id="google_ads_id" name="google_ads_id"
                                value="{{ old('google_ads_id', $setting?->google_ads_id) }}"
                                placeholder="مثال: AW-XXXXXXXXXXXXXXXXX">
                            @error('google_ads_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                تجده في: <strong>Google Ads → الأدوات → تتبع التحويلات → علامة Google</strong>
                            </small>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> حفظ الإعدادات
                        </button>
                    </div>
                </form>
            </div>

            {{-- Test Connection --}}
            @if($setting && $setting->fb_pixel_id && $setting->fb_access_token)
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-paper-plane mr-1"></i> اختبار الاتصال بـ Meta CAPI</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">اضغط الزر لإرسال حدث <code>PageView</code> تجريبي إلى Meta والتحقق من صحة الاتصال.</p>
                    <button type="button" class="btn btn-info" id="testEventBtn">
                        <i class="fas fa-satellite-dish mr-1"></i> إرسال حدث تجريبي
                    </button>
                    <div id="testEventResult" class="mt-3" style="display:none;"></div>
                </div>
            </div>
            @endif
        </div>

        {{-- ═══════════════════════════════════════════════ --}}
        {{-- DOCUMENTATION / HOW IT WORKS                   --}}
        {{-- ═══════════════════════════════════════════════ --}}
        <div class="col-lg-5">

            {{-- Current Status --}}
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> الوضع الحالي</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <tbody>
                            <tr>
                                <td><i class="fab fa-facebook text-primary mr-1"></i> Pixel ID</td>
                                <td>
                                    @if($setting?->fb_pixel_id)
                                        <code>{{ $setting->fb_pixel_id }}</code>
                                        <span class="badge badge-success ml-1">محدد</span>
                                    @else
                                        <span class="badge badge-danger">غير محدد</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-key text-warning mr-1"></i> Access Token</td>
                                <td>
                                    @if($setting?->fb_access_token)
                                        <span class="badge badge-success">محدد ✓</span>
                                    @else
                                        <span class="badge badge-danger">غير محدد</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-vial text-info mr-1"></i> Test Code</td>
                                <td>
                                    @if($setting?->fb_test_event_code)
                                        <code>{{ $setting->fb_test_event_code }}</code>
                                        <span class="badge badge-warning ml-1">وضع الاختبار</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fab fa-google text-danger mr-1"></i> GTM ID</td>
                                <td>
                                    @if($setting?->gtm_id)
                                        <code>{{ $setting->gtm_id }}</code>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fab fa-google text-success mr-1"></i> Google Ads ID</td>
                                <td>
                                    @if($setting?->google_ads_id)
                                        <code>{{ $setting->google_ads_id }}</code>
                                        <span class="badge badge-success ml-1">محدد</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fas fa-toggle-on mr-1"></i> الحالة</td>
                                <td>
                                    @if($setting?->fb_conversions_api_enabled)
                                        <span class="badge badge-success"><i class="fas fa-check mr-1"></i> مفعّل</span>
                                    @else
                                        <span class="badge badge-secondary">معطّل</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- How it works --}}
            <div class="card card-light card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-book mr-1"></i> كيف يعمل النظام؟</h3>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-inverse">
                        <div class="time-label">
                            <span class="bg-primary">Browser Pixel</span>
                        </div>
                        <div>
                            <i class="fas fa-code bg-blue"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header">Meta Pixel (Frontend)</h3>
                                <div class="timeline-body">
                                    يُحمَّل كود الـ JavaScript في متصفح الزائر ويُرسل أحداث مثل <code>PageView</code> و<code>ViewContent</code> مباشرةً.
                                    <br><small class="text-muted">قد يُحجب بواسطة Ad Blockers.</small>
                                </div>
                            </div>
                        </div>
                        <div class="time-label">
                            <span class="bg-success">Server CAPI</span>
                        </div>
                        <div>
                            <i class="fas fa-server bg-success"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header">Conversions API (Backend)</h3>
                                <div class="timeline-body">
                                    يُرسل السيرفر الأحداث مباشرةً إلى Meta بدون المرور بالمتصفح — <strong>لا يمكن حجبه</strong>.
                                    <br>يستخدم <code>event_id</code> مشترك للـ Deduplication تلقائياً.
                                </div>
                            </div>
                        </div>
                        <div class="time-label">
                            <span class="bg-warning">الفائدة</span>
                        </div>
                        <div>
                            <i class="fas fa-chart-line bg-warning"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header">تحسين دقة البيانات</h3>
                                <div class="timeline-body">
                                    دمج الـ Pixel مع CAPI يرفع دقة قياس التحويلات ويحسّن أداء الحملات الإعلانية.
                                </div>
                            </div>
                        </div>
                        <div><i class="fas fa-clock bg-gray"></i></div>
                    </div>
                </div>
            </div>

            {{-- Events tracked --}}
            <div class="card card-light card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list-check mr-1"></i> الأحداث المُتتبَّعة في الموقع</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>الحدث</th>
                                <th>أين يُطلق؟</th>
                                <th>Browser</th>
                                <th>Server</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>PageView</code></td>
                                <td>كل صفحة</td>
                                <td><i class="fas fa-check text-success"></i></td>
                                <td><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td><code>ViewContent</code></td>
                                <td>صفحة العقار</td>
                                <td><i class="fas fa-check text-success"></i></td>
                                <td><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td><code>Search</code></td>
                                <td>نتائج البحث</td>
                                <td><i class="fas fa-check text-success"></i></td>
                                <td><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td><code>Lead</code></td>
                                <td>نماذج التواصل</td>
                                <td><i class="fas fa-check text-success"></i></td>
                                <td><i class="fas fa-check text-success"></i></td>
                            </tr>
                            <tr>
                                <td><code>CompleteRegistration</code></td>
                                <td>تسجيل مستخدم</td>
                                <td><i class="fas fa-check text-success"></i></td>
                                <td><i class="fas fa-check text-success"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Steps Guide --}}
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tasks mr-1"></i> خطوات الإعداد</h3>
                </div>
                <div class="card-body">
                    <ol class="pl-3">
                        <li>اذهب إلى <a href="https://business.facebook.com/events_manager" target="_blank">Events Manager</a></li>
                        <li>اختر الـ Pixel وانسخ الـ <strong>Pixel ID</strong></li>
                        <li>افتح <strong>Settings → Conversions API</strong></li>
                        <li>اضغط <strong>Generate access token</strong> وانسخه</li>
                        <li>الصق القيم أعلاه واحفظ</li>
                        <li>في وضع الاختبار: انسخ <strong>Test Event Code</strong> من Events Manager → Test Events</li>
                        <li>اضغط <strong>"إرسال حدث تجريبي"</strong> للتحقق</li>
                        <li>عند الانتهاء من الاختبار: <strong>أفرغ</strong> حقل Test Event Code</li>
                    </ol>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Toggle access token visibility
document.getElementById('toggleToken')?.addEventListener('click', function () {
    const input = document.getElementById('fb_access_token');
    const icon  = document.getElementById('toggleTokenIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});

// Test Event button
document.getElementById('testEventBtn')?.addEventListener('click', function () {
    const btn    = this;
    const result = document.getElementById('testEventResult');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> جاري الإرسال...';
    result.style.display = 'none';

    fetch('{{ route("sitemanagement.meta-conversions.test-event") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({})
    })
    .then(r => r.json())
    .then(data => {
        result.style.display = 'block';
        result.innerHTML = `<div class="alert alert-${data.success ? 'success' : 'danger'}">
            ${data.message}
            ${data.response ? '<pre class="mt-2 mb-0 small">' + JSON.stringify(data.response, null, 2) + '</pre>' : ''}
        </div>`;
    })
    .catch(err => {
        result.style.display = 'block';
        result.innerHTML = `<div class="alert alert-danger">خطأ غير متوقع: ${err.message}</div>`;
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-satellite-dish mr-1"></i> إرسال حدث تجريبي';
    });
});
</script>
@endsection

