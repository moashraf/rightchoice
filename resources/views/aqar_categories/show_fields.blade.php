<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $aqarCategory->id }}</p>
</div>

<!-- Category Name Field -->
<div class="col-sm-12">
    {!! Form::label('category_name', 'Category Name:') !!}
    <p>{{ $aqarCategory->category_name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $aqarCategory->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $aqarCategory->updated_at }}</p>
</div>

