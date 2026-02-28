<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $offerType->id }}</p>
</div>

<!-- Type Offer (Arabic) Field -->
<div class="col-sm-6">
    {!! Form::label('type_offer', 'Type Offer (Arabic):') !!}
    <p>{{ $offerType->type_offer }}</p>
</div>

<!-- Type Offer (English) Field -->
<div class="col-sm-6">
    {!! Form::label('type_offer_en', 'Type Offer (English):') !!}
    <p>{{ $offerType->type_offer_en }}</p>
</div>

<!-- Slug Field -->
<div class="col-sm-6">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{{ $offerType->slug }}</p>
</div>
