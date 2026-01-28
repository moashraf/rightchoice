<!-- Type Field -->
<div class="form-group col-sm-4">
    {!! Form::label('type', 'Type:') !!} <span class="text-danger">*</span>
    {!! Form::text('type', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('type') }}</small>
</div>

<!-- Price Field -->
<div class="form-group col-sm-4">
    {!! Form::label('price', 'Price:') !!} <span class="text-danger">*</span>
    {!! Form::number('price', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('price') }}</small>
</div>

<!-- Points Field -->
<div class="form-group col-sm-4">
    {!! Form::label('points', 'Points:') !!} <span class="text-danger">*</span>
    {!! Form::number('points', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('points') }}</small>
</div>

<!-- Description Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('description', 'Description:') !!} <span class="text-danger">*</span>
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('description') }}</small>
</div>

<!-- Desc1 Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('description one', 'Description one:') !!} <span class="text-danger">*</span>
    {!! Form::textarea('desc1', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('desc1') }}</small>
</div>

<!-- Desc2 Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('description two', 'Description two:') !!} <span class="text-danger">*</span>
    {!! Form::textarea('desc2', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('desc2') }}</small>
</div>

<!-- Desc3 Field -->
<div class="form-group col-sm-6 col-lg-6">
    {!! Form::label('description three', 'Description three:') !!} <span class="text-danger">*</span>
    {!! Form::textarea('desc3', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('desc3') }}</small>
</div>

<!-- Color Field -->
<div class="form-group col-sm-4">
    {!! Form::label('color', 'Color:') !!} <span class="text-danger">*</span>
    {!! Form::text('color', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('color') }}</small>
</div>

<!-- Title Color Field -->
<div class="form-group col-sm-4">
    {!! Form::label('title color', 'Title Color:') !!} <span class="text-danger">*</span>
    {!! Form::text('title_color', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('title_color') }}</small>
</div>

<!-- Bk Color Field -->
<div class="form-group col-sm-4">
    {!! Form::label('bk color', 'Bk Color:') !!} <span class="text-danger">*</span>
    {!! Form::text('bk_color', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('bk_color') }}</small>
</div>