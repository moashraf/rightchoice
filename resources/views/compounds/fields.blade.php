<!-- Compound Field -->
<div class="form-group col-sm-6">
    {!! Form::label('compound', 'Compound:') !!} <span class="text-danger">*</span>
    {!! Form::text('compound', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('compound') }}</small>
</div>