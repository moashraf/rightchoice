@extends('layouts.admin')
@section('title', 'إدارة الصور')

@section('third_party_stylesheets')
<style>
    .media-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 16px;
    }
    .media-item {
        position: relative;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
        background: #f8f9fa;
        transition: border-color .2s;
    }
    .media-item.selected {
        border-color: #007bff;
    }
    .media-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        display: block;
    }
    .media-item .overlay {
        position: absolute;
        top: 6px;
        right: 6px;
    }
    .media-item .overlay input[type=checkbox] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }
    .media-item .media-footer {
        padding: 6px 8px;
        font-size: 12px;
        background: rgba(255,255,255,.9);
    }
    .media-item .badge-main {
        position: absolute;
        top: 6px;
        left: 6px;
        font-size: 10px;
    }
    .media-item .btn-delete {
        position: absolute;
        bottom: 36px;
        left: 50%;
        transform: translateX(-50%);
        display: none;
        z-index: 10;
    }
    .media-item:hover .btn-delete {
        display: block;
    }
    .media-item:hover {
        border-color: #adb5bd;
    }
</style>
@endsection

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1><i class="fas fa-images mr-2"></i>إدارة الصور</h1>
            </div>
            <div class="col-sm-6 text-right">
                <span class="badge badge-secondary badge-lg p-2">
                    إجمالي الصور: {{ $images->total() }}
                </span>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <!-- Filter Bar -->
    <div class="card card-outline card-primary mb-3">
        <div class="card-body py-2">
            <form method="GET" action="{{ route('sitemanagement.images.index') }}" class="form-inline">
                <label class="mr-2">تصفية بالعقار:</label>
                <input type="number" name="aqar_id" class="form-control form-control-sm mr-2"
                       placeholder="رقم العقار" value="{{ request('aqar_id') }}">
                <button class="btn btn-sm btn-primary mr-2">
                    <i class="fas fa-search"></i> بحث
                </button>
                <a href="{{ route('sitemanagement.images.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-times"></i> مسح
                </a>
            </form>
        </div>
    </div>

    <!-- Bulk Delete Form -->
    <form id="bulkForm" method="POST" action="{{ route('sitemanagement.images.bulk-delete') }}">
        @csrf
        @method('DELETE')

        <!-- Toolbar -->
        <div class="d-flex align-items-center mb-3 gap-2" style="gap:8px;">
            <button type="button" id="selectAllBtn" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-check-square"></i> تحديد الكل
            </button>
            <button type="button" id="deselectAllBtn" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-square"></i> إلغاء التحديد
            </button>
            <button type="submit" id="bulkDeleteBtn" class="btn btn-sm btn-danger" disabled
                    onclick="return confirm('هل أنت متأكد من حذف الصور المحددة؟')">
                <i class="fas fa-trash"></i> حذف المحدد (<span id="selectedCount">0</span>)
            </button>
        </div>

        <!-- Media Grid -->
        @if($images->count())
        <div class="media-grid">
            @foreach($images as $image)
            <div class="media-item" data-id="{{ $image->id }}">
                <!-- Checkbox -->
                <div class="overlay">
                    <input type="checkbox" name="ids[]" value="{{ $image->id }}"
                           class="img-checkbox" title="تحديد">
                </div>

                <!-- Main Image Badge -->
                @if($image->main_img)
                    <span class="badge badge-warning badge-main">رئيسية</span>
                @endif

                <!-- Image -->
                <a href="{{ URL::to('/') . '/images/' . $image->img_url }}" target="_blank">
                    <img src="{{ URL::to('/') . '/images/' . $image->img_url }}"
                         alt="صورة عقار"
                         onerror="this.src='{{ asset('images/no-image.png') }}'">
                </a>

                <!-- Delete Single -->
                <form method="POST"
                      action="{{ route('sitemanagement.images.destroy', $image->id) }}"
                      onsubmit="return confirm('هل أنت متأكد من حذف هذه الصورة؟')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-xs btn-delete">
                        <i class="fas fa-trash"></i> حذف
                    </button>
                </form>

                <!-- Footer Info -->
                <div class="media-footer">
                    <div class="text-truncate" title="{{ $image->img_url }}">
                        <i class="fas fa-file-image text-muted"></i>
                        {{ Str::limit($image->img_url, 20) }}
                    </div>
                    @if($image->aqar)
                    <div class="text-muted text-truncate">
                        <i class="fas fa-home"></i>
                        <a href="{{ route('sitemanagement.aqars.show', $image->aqar_id) }}"
                           class="text-muted" target="_blank"
                           title="{{ $image->aqar->title }}">
                            {{ Str::limit($image->aqar->title, 18) }}
                        </a>
                    </div>
                    @endif
                    <div class="text-muted">ID: {{ $image->id }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-images fa-2x mb-2"></i><br>
                لا توجد صور
            </div>
        @endif
    </form>

    <!-- Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-4">
        <div class="text-muted">
            عرض {{ $images->firstItem() }} - {{ $images->lastItem() }}
            من أصل {{ $images->total() }} صورة
        </div>
        <div>
            {{ $images->links() }}
        </div>
    </div>
</div>
@endsection

@section('third_party_scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.img-checkbox');
    const selectedCount = document.getElementById('selectedCount');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const mediaItems = document.querySelectorAll('.media-item');

    function updateCount() {
        const checked = document.querySelectorAll('.img-checkbox:checked').length;
        selectedCount.textContent = checked;
        bulkDeleteBtn.disabled = checked === 0;
    }

    checkboxes.forEach(function (cb) {
        cb.addEventListener('change', function () {
            const item = this.closest('.media-item');
            item.classList.toggle('selected', this.checked);
            updateCount();
        });
    });

    // Click on image area to toggle checkbox
    mediaItems.forEach(function (item) {
        item.querySelector('a img')?.addEventListener('click', function (e) {
            // allow opening in new tab - do not toggle
        });
    });

    document.getElementById('selectAllBtn').addEventListener('click', function () {
        checkboxes.forEach(function (cb) {
            cb.checked = true;
            cb.closest('.media-item').classList.add('selected');
        });
        updateCount();
    });

    document.getElementById('deselectAllBtn').addEventListener('click', function () {
        checkboxes.forEach(function (cb) {
            cb.checked = false;
            cb.closest('.media-item').classList.remove('selected');
        });
        updateCount();
    });
});
</script>
@endsection

