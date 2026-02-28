<!-- Type Offer (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_offer', 'Type Offer (Arabic):') !!} <span class="text-danger">*</span>
    {!! Form::text('type_offer', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('type_offer') }}</small>
</div>

<!-- Type Offer (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type_offer_en', 'Type Offer (English):') !!}
    {!! Form::text('type_offer_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('type_offer_en') }}</small>
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slug', 'Slug:') !!} <span class="text-danger">*</span>
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('slug') }}</small>
</div>

<div class="clearfix"></div>
