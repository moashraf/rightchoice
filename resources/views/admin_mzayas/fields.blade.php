<!-- Mzaya Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mzaya_type', 'Mzaya Type:') !!} <span class="text-danger">*</span>
    {!! Form::text('mzaya_type', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('mzaya_type') }}</small>
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('img', 'Image:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('img', ['class' => 'custom-file-input']) !!}
            {!! Form::label('img', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
    <small class="text-danger">{{ $errors->first('img') }}</small>
</div>

<div class="clearfix"></div>
