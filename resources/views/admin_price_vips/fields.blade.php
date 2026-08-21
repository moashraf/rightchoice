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

<!-- Views Field -->
<div class="form-group col-sm-6">
    {!! Form::label('views', 'Views:') !!} <span class="text-danger">*</span>
    {!! Form::number('views', null, ['class' => 'form-control', 'min' => 0]) !!}
    <small class="text-danger">{{ $errors->first('views') }}</small>
</div>

<!-- Description Field -->
<div class="form-group col-sm-6">
    {!! Form::label('duration_days', 'مدة التمييز:') !!} <span class="text-danger">*</span>
    {!! Form::select('duration_days', [7 => '7 أيام', 14 => '14 يومًا', 30 => '30 يومًا'], null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('duration_days') }}</small>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4]) !!}
</div>

<div class="clearfix"></div>
