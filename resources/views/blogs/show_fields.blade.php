<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $blog->id }}</p>
</div>

<!-- Seo Title Field -->
<div class="col-sm-12">
    {!! Form::label('seo_title', 'Seo Title:') !!}
    <p>{{ $blog->seo_title }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    @if($blog->status == 0)
    <span class="badge badge-success">نشط</span>
    @else
    <span class="badge badge-danger">غير نشط</span>
    @endif
    <!-- <p>{{ $blog->status }}</p> -->
</div>

<!-- Main Img Alt Field -->
<div class="col-sm-12">
    {!! Form::label('main_img_alt', 'Main Img Alt:') !!}
    <!-- <p>{{ $blog->main_img_alt }}</p> -->
</div>

@if(!empty($blog->main_img_alt))
<div class="mb-2">
    <a href="{{Url($blog->main_img_alt)}}" data-toggle="lightbox"><img src="{{Url($blog->main_img_alt)}}" alt=""  class="img-fluid img-thumbnail" style="max-width: 60%;">
    </a>
</div>
@endif

<!-- Single Photo Field -->
<div class="col-sm-12">
    {!! Form::label('single_photo', 'Single Photo:') !!}
    <!-- <p>{{ $blog->single_photo }}</p> -->
</div>

@if(!empty($blog->single_photo))
<div class="mb-2">
    <a href="{{Url($blog->single_photo)}}" data-toggle="lightbox"><img src="{{Url($blog->single_photo)}}" alt=""  class="img-fluid img-thumbnail" style="max-width: 60%;">
    </a>
</div>
@endif

<!-- Sort Num Field -->
<div class="col-sm-12">
    {!! Form::label('sort_num', 'Sort Num:') !!}
    <p>{{ $blog->sort_num }}</p>
</div>

<!-- Meta Description Field -->
<div class="col-sm-12">
    {!! Form::label('meta_description', 'Meta Description:') !!}
    <p>{{ $blog->meta_description }}</p>
</div>

<!-- Number Of Visits Field -->
<div class="col-sm-12">
    {!! Form::label('number_of_visits', 'Number Of Visits:') !!}
    <p>{{ $blog->number_of_visits }}</p>
</div>

<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('title', 'Title:') !!}
    <p>{{ $blog->title }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $blog->description }}</p>
</div>

<!-- Slug Field -->
<div class="col-sm-12">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{{ $blog->slug }}</p>
</div>

<!-- Canonical Field -->
<div class="col-sm-12">
    {!! Form::label('canonical', 'Canonical:') !!}
    <p>{{ $blog->canonical }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $blog->created_at->toDayDateTimeString() }}</p>
</div>


