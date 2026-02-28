<!-- Service (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Service', 'Service (Arabic):') !!} <span class="text-danger">*</span>
    {!! Form::text('Service', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('Service') }}</small>
</div>

<!-- Service (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Service_en', 'Service (English):') !!}
    {!! Form::text('Service_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('Service_en') }}</small>
</div>

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('title') }}</small>
</div>

<!-- Title (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title_en', 'Title (English):') !!}
    {!! Form::text('title_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('title_en') }}</small>
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slug', 'Slug:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('slug') }}</small>
</div>

<!-- Slug (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slug_en', 'Slug (English):') !!}
    {!! Form::text('slug_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('slug_en') }}</small>
</div>

<!-- Image Field -->
<div class="form-group col-sm-6">
    {!! Form::label('serv_img', 'Image:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('serv_img', ['class' => 'custom-file-input']) !!}
            {!! Form::label('serv_img', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
    <small class="text-danger">{{ $errors->first('serv_img') }}</small>
</div>

<!-- Description (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description (Arabic):') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
    <small class="text-danger">{{ $errors->first('description') }}</small>
</div>

<!-- Description (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('description_en', 'Description (English):') !!}
    {!! Form::textarea('description_en', null, ['class' => 'form-control', 'rows' => 3]) !!}
    <small class="text-danger">{{ $errors->first('description_en') }}</small>
</div>

<div class="clearfix"></div>
