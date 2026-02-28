<!-- Image Field -->
@if(!empty($services->image))
<div class="col-sm-12 mb-2">
    {!! Form::label('image', 'Image:') !!}
    <div>
        <img src="{{ asset('uploads/service/' . $services->image) }}" alt="" class="img-fluid img-thumbnail" style="max-width: 200px;">
    </div>
</div>
@endif

<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $services->id }}</p>
</div>

<!-- Service Field -->
<div class="col-sm-6">
    {!! Form::label('Service', 'Service (Arabic):') !!}
    <p>{{ $services->Service }}</p>
</div>

<!-- Service (English) Field -->
<div class="col-sm-6">
    {!! Form::label('Service_en', 'Service (English):') !!}
    <p>{{ $services->Service_en }}</p>
</div>

<!-- Title Field -->
<div class="col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $services->title }}</p>
</div>

<!-- Title (English) Field -->
<div class="col-sm-6">
    {!! Form::label('title_en', 'Title (English):') !!}
    <p>{{ $services->title_en }}</p>
</div>

<!-- Slug Field -->
<div class="col-sm-6">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{{ $services->slug }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description (Arabic):') !!}
    <p>{{ $services->description }}</p>
</div>

<!-- Description (English) Field -->
<div class="col-sm-12">
    {!! Form::label('description_en', 'Description (English):') !!}
    <p>{{ $services->description_en }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12 mt-2">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $services->created_at }}</p>
</div>
