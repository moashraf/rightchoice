<!-- Type Offer Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_offer', 'Type Offer:') !!} <span class="text-danger">*</span>
    {!! Form::text('type_offer', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('type_offer') }}</small>
</div>