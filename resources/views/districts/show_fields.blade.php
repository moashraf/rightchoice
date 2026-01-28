<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $district->id }}</p>
</div>

<!-- District Field -->
<div class="col-sm-12">
    {!! Form::label('district', 'District:') !!}
    <p>{{ $district->district }}</p>
</div>

<!-- Govern Id Field -->
<div class="col-sm-3">
    {!! Form::label('govern_id', 'Govern Id:') !!}
    <!-- <p>{{ $district->govern_id }}</p> -->
    {!! Form::select('govern_id', $governrate, null, ['class' => 'form-control custom-select' ,'disabled']) !!}
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $district->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $district->updated_at }}</p>
</div>

