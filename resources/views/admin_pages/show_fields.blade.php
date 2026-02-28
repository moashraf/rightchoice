<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $pages->id }}</p>
</div>

<!-- Page Name Field -->
<div class="col-sm-6">
    {!! Form::label('page_name', 'Page Name:') !!}
    <p>{{ $pages->page_name }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{!! $pages->description !!}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12 mt-2">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $pages->created_at }}</p>
</div>
