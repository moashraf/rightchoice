<!-- Name (URL) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'الرابط (URL):') !!}
    {!! Form::url('name', null, ['class' => 'form-control', 'placeholder' => 'https://example.com']) !!}
    <small class="text-muted">رابط الصفحة التي سيتم التوجيه إليها عند الضغط على الإعلان</small>
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<!-- Current Image (Edit mode) -->
@if(isset($ad) && !empty($ad->img))
<div class="form-group col-sm-12">
    <label>الصورة الحالية:</label><br>
    <a href="{{ url('images/' . $ad->img) }}" data-toggle="lightbox">
        <img src="{{ url('images/' . $ad->img) }}" height="100"  width="150" class="img-thumbnail" alt="ad">
    </a>
</div>
@endif

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('img_file', 'الصورة:') !!}
    @if($type == 'add')
        <span class="text-danger">*</span>
    @else
        <small class="text-muted">(اتركه فارغاً للإبقاء على الصورة الحالية)</small>
    @endif
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('img_file', ['class' => 'custom-file-input', 'accept' => 'image/*']) !!}
            {!! Form::label('img_file', 'اختر ملف', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
    <small class="text-danger">{{ $errors->first('img_file') }}</small>
</div>

<div class="clearfix"></div>
