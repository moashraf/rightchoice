@extends('layouts.admin')
@section('title', 'تعديل سبب حذف عقار')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit text-warning mr-2"></i> تعديل السبب</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('sitemanagement.aqar-delete-reasons.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right mr-1"></i> العودة للقائمة
                </a>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">
    <div class="card card-outline card-warning" style="max-width:700px; margin:auto;">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-edit mr-2"></i> بيانات السبب</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('sitemanagement.aqar-delete-reasons.update', $aqarDeleteReason->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>العنوان بالعربية <span class="text-danger">*</span></label>
                    <input type="text" name="title_ar" class="form-control @error('title_ar') is-invalid @enderror"
                           value="{{ old('title_ar', $aqarDeleteReason->title_ar) }}">
                    @error('title_ar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>العنوان بالإنجليزية <span class="text-danger">*</span></label>
                    <input type="text" name="title_en" class="form-control @error('title_en') is-invalid @enderror"
                           value="{{ old('title_en', $aqarDeleteReason->title_en) }}">
                    @error('title_en') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label>صورة السبب</label>
                    @if($aqarDeleteReason->image)
                        <div class="mb-2">
                            <img id="preview" src="{{ Storage::url($aqarDeleteReason->image) }}"
                                 style="width:120px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #ddd;"
                                 onerror="this.src='{{ asset('images/FBO.png') }}'">
                        </div>
                    @else
                        <div class="mb-2">
                            <img id="preview" src="#" alt="" style="display:none; width:120px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*"
                           onchange="previewImg(this)">
                    <small class="text-muted">اتركه فارغاً للإبقاء على الصورة الحالية</small>
                    @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>

                <div class="form-group mb-0 text-right">
                    <button type="submit" class="btn btn-warning px-4">
                        <i class="fas fa-save mr-1"></i> حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('preview');
            img.src = e.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection

