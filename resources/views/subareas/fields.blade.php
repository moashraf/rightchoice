<!-- Area Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area', 'Area:') !!} <span class="text-danger">*</span>
    {!! Form::text('area', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('area') }}</small>
</div>