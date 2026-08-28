@extends('layouts.admin')

@section('title', 'سجلات النظام')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1><i class="fas fa-file-alt text-warning"></i> سجلات النظام</h1>
            </div>
            <div class="col-sm-6 text-left">
                <small class="text-muted">عرض ملفات Laravel الموجودة داخل storage/logs</small>
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

    <div class="row mb-3">
        <div class="col-md-4 mb-2">
            <div class="small-box bg-info mb-0">
                <div class="inner"><h3>{{ number_format($levelCounts['info']) }}</h3><p>Info</p></div>
                <div class="icon"><i class="fas fa-info-circle"></i></div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="small-box bg-warning mb-0">
                <div class="inner"><h3>{{ number_format($levelCounts['warning']) }}</h3><p>Warning</p></div>
                <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="small-box bg-danger mb-0">
                <div class="inner"><h3>{{ number_format($levelCounts['error']) }}</h3><p>Error</p></div>
                <div class="icon"><i class="fas fa-times-circle"></i></div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter"></i> فلاتر البحث</h3>
        </div>
        <form method="GET" action="{{ route('sitemanagement.systemLogs.index') }}">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 form-group">
                        <label for="file">ملف اللوج</label>
                        <select name="file" id="file" class="form-control">
                            @forelse($files as $file)
                                <option value="{{ $file['name'] }}" @selected($selectedFile === $file['name'])>
                                    {{ $file['name'] }} — {{ number_format($file['size'] / 1024, 1) }} KB
                                </option>
                            @empty
                                <option value="">لا توجد ملفات لوج</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6 form-group">
                        <label for="level">المستوى</label>
                        <select name="level" id="level" class="form-control">
                            <option value="">الكل</option>
                            <option value="info" @selected(request('level') === 'info')>Info</option>
                            <option value="warning" @selected(request('level') === 'warning')>Warning</option>
                            <option value="error" @selected(request('level') === 'error')>Error</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6 form-group">
                        <label for="search">بحث في الرسالة</label>
                        <input type="text" name="search" id="search" class="form-control"
                               value="{{ request('search') }}" placeholder="مثال: Fawry callback">
                    </div>
                    <div class="col-lg-2 col-md-6 form-group">
                        <label for="date_from">من تاريخ</label>
                        <input type="date" name="date_from" id="date_from" class="form-control"
                               value="{{ request('date_from') }}">
                    </div>
                    <div class="col-lg-2 col-md-6 form-group">
                        <label for="date_to">إلى تاريخ</label>
                        <input type="date" name="date_to" id="date_to" class="form-control"
                               value="{{ request('date_to') }}">
                    </div>
                    <div class="col-lg-2 col-md-6 form-group">
                        <label for="per_page">عدد النتائج</label>
                        <select name="per_page" id="per_page" class="form-control">
                            @foreach([25, 50, 100] as $count)
                                <option value="{{ $count }}" @selected((int) request('per_page', 50) === $count)>{{ $count }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> تطبيق الفلاتر
                </button>
                <a href="{{ route('sitemanagement.systemLogs.index') }}" class="btn btn-default">
                    <i class="fas fa-redo"></i> إعادة ضبط
                </a>
            </div>
        </form>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                النتائج
                @if($selectedFile)
                    <span class="badge badge-secondary">{{ $selectedFile }}</span>
                @endif
            </h3>
            <div class="card-tools">
                <span class="badge badge-dark">{{ number_format($logs->total()) }} سجل</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead>
                    <tr>
                        <th style="width: 165px">التاريخ</th>
                        <th style="width: 100px">المستوى</th>
                        <th style="width: 110px">البيئة</th>
                        <th>الرسالة والبيانات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($logs as $index => $log)
                        @php
                            $badgeClass = [
                                'info' => 'badge-info',
                                'warning' => 'badge-warning',
                                'error' => 'badge-danger',
                            ][$log['level_group']] ?? 'badge-secondary';
                            $collapseId = 'system-log-' . $logs->firstItem() . '-' . $index;
                            $messageLines = preg_split('/\R/', $log['message']);
                            $summary = $messageLines[0] ?? '';
                        @endphp
                        <tr>
                            <td dir="ltr" class="text-nowrap">{{ $log['datetime'] }}</td>
                            <td><span class="badge {{ $badgeClass }}">{{ strtoupper($log['level']) }}</span></td>
                            <td><code>{{ $log['environment'] }}</code></td>
                            <td style="min-width: 420px">
                                <div class="font-weight-bold text-break">{{ IlluminateSupportStr::limit($summary, 220) }}</div>
                                @if(count($messageLines) > 1 || mb_strlen($summary) > 220)
                                    <button class="btn btn-link btn-sm px-0 mt-1" type="button"
                                            data-toggle="collapse" data-target="#{{ $collapseId }}"
                                            aria-expanded="false">
                                        عرض التفاصيل كاملة
                                    </button>
                                    <div class="collapse mt-2" id="{{ $collapseId }}">
                                        <pre class="mb-0 p-3 rounded bg-dark text-light"
                                             style="direction:ltr;text-align:left;white-space:pre-wrap;max-height:450px;overflow:auto;">{{ $log['message'] }}</pre>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="fas fa-inbox fa-2x d-block mb-2"></i>
                                لا توجد سجلات مطابقة للفلاتر المحددة.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($logs->hasPages())
            <div class="card-footer">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
