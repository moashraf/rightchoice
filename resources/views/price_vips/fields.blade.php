<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!} <span class="text-danger">*</span>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!} <span class="text-danger">*</span>
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('price') }}</small>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Views Field -->
<div class="form-group col-sm-6">
    {!! Form::label('views', 'Views:') !!} <span class="text-danger">*</span>
    {!! Form::number('views', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('views') }}</small>
</div>