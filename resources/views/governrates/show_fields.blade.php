<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $governrate->id }}</p>
</div>

<!-- Governrate Field -->
<div class="col-sm-12">
    {!! Form::label('governrate', 'Governrate:') !!}
    <p>{{ $governrate->governrate }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $governrate->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $governrate->updated_at }}</p>
</div>

