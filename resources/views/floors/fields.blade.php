<!-- Floor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('floor', 'Floor:') !!} <span class="text-danger">*</span>
    {!! Form::text('floor', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('floor') }}</small>
</div>