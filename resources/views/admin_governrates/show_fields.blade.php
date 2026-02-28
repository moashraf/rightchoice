<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $governrate->id }}</p>
</div>

<!-- Governrate (Arabic) Field -->
<div class="col-sm-6">
    {!! Form::label('governrate', 'Governrate (Arabic):') !!}
    <p>{{ $governrate->governrate }}</p>
</div>

<!-- Governrate (English) Field -->
<div class="col-sm-6">
    {!! Form::label('governrate_en', 'Governrate (English):') !!}
    <p>{{ $governrate->governrate_en }}</p>
</div>
