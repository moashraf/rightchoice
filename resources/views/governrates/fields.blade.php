<!-- Governrate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('governrate', 'Governrate:') !!} <span class="text-danger">*</span>
    {!! Form::text('governrate', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('governrate') }}</small>
</div>