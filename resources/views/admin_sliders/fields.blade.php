<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title']) !!}
    <small class="text-danger">{{ $errors->first('title') }}</small>
</div>

<!-- Sub Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sub_title', 'Sub Title:') !!}
    {!! Form::text('sub_title', null, ['class' => 'form-control', 'placeholder' => 'Sub Title']) !!}
    <small class="text-danger">{{ $errors->first('sub_title') }}</small>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
    <small class="text-danger">{{ $errors->first('description') }}</small>
</div>

<!-- Current Image (Edit mode) -->
@if(isset($slider) && !empty($slider->image))
<div class="form-group col-sm-12">
    <label>Current Image:</label><br>
    <a href="{{ url($slider->image) }}" data-toggle="lightbox">
        <img src="{{ url($slider->image) }}" height="100" class="img-thumbnail">
    </a>
</div>
@endif

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('img', 'Image:') !!}
    @if($type == 'add')
        <span class="text-danger">*</span>
    @else
        <small class="text-muted">(اتركه فارغاً للإبقاء على الصورة الحالية)</small>
    @endif
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('img', ['class' => 'custom-file-input', 'accept' => 'image/*']) !!}
            {!! Form::label('img', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
    <small class="text-danger">{{ $errors->first('img') }}</small>
</div>

<div class="clearfix"></div>
