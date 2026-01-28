<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $slider->id }}</p>
</div>

<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $slider->title }}</p>
</div>

<!-- Sub Title Field -->
<div class="col-sm-12">
    {!! Form::label('sub_title', 'Sub Title:') !!}
    <p>{{ $slider->sub_title }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $slider->description }}</p>
</div>

<!-- Image Field -->
<div class="col-sm-12">
    {!! Form::label('image', 'Image:') !!}
    <!-- <p>{{ $slider->image }}</p> -->
</div>

@if(!empty($slider->image))
<div class="mb-2">
    <a href="{{Url($slider->image)}}" data-toggle="lightbox"><img src="{{Url($slider->image)}}" alt=""  class="img-fluid img-thumbnail" style="max-width: 60%;">
    </a>
</div>
@endif

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $slider->created_at->toDayDateTimeString() }}</p>
</div>


