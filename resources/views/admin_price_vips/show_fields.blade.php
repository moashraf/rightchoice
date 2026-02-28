<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $priceVip->id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $priceVip->name }}</p>
</div>

<!-- Price Field -->
<div class="col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $priceVip->price }}</p>
</div>

<!-- Views Field -->
<div class="col-sm-6">
    {!! Form::label('views', 'Views:') !!}
    <p>{{ $priceVip->views }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $priceVip->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12 mt-2">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $priceVip->created_at->toDayDateTimeString() }}</p>
</div>
