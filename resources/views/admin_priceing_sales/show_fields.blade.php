<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $priceingSale->id }}</p>
</div>

<!-- Type Field -->
<div class="col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    <p>{{ $priceingSale->type }}</p>
</div>

<!-- Price Field -->
<div class="col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    <p>{{ $priceingSale->price }}</p>
</div>

<!-- Points Field -->
<div class="col-sm-6">
    {!! Form::label('points', 'Points:') !!}
    <p>{{ $priceingSale->points }}</p>
</div>

<!-- Color Field -->
<div class="col-sm-4">
    {!! Form::label('color', 'Color:') !!}
    <p><span style="display:inline-block;width:20px;height:20px;background:{{ $priceingSale->color }};border:1px solid #ccc;vertical-align:middle;"></span> {{ $priceingSale->color }}</p>
</div>

<!-- Title Color Field -->
<div class="col-sm-4">
    {!! Form::label('title_color', 'Title Color:') !!}
    <p><span style="display:inline-block;width:20px;height:20px;background:{{ $priceingSale->title_color }};border:1px solid #ccc;vertical-align:middle;"></span> {{ $priceingSale->title_color }}</p>
</div>

<!-- Bk Color Field -->
<div class="col-sm-4">
    {!! Form::label('bk_color', 'Bk Color:') !!}
    <p><span style="display:inline-block;width:20px;height:20px;background:{{ $priceingSale->bk_color }};border:1px solid #ccc;vertical-align:middle;"></span> {{ $priceingSale->bk_color }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $priceingSale->description }}</p>
</div>

<!-- Desc1 Field -->
<div class="col-sm-12">
    {!! Form::label('desc1', 'Description One:') !!}
    <p>{{ $priceingSale->desc1 }}</p>
</div>

<!-- Desc2 Field -->
<div class="col-sm-12">
    {!! Form::label('desc2', 'Description Two:') !!}
    <p>{{ $priceingSale->desc2 }}</p>
</div>

<!-- Desc3 Field -->
<div class="col-sm-12">
    {!! Form::label('desc3', 'Description Three:') !!}
    <p>{{ $priceingSale->desc3 }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12 mt-2">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $priceingSale->created_at }}</p>
</div>
