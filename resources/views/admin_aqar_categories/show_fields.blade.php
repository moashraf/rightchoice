<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $aqarCategory->id }}</p>
</div>

<!-- Category Name (Arabic) Field -->
<div class="col-sm-6">
    {!! Form::label('category_name', 'Category Name (Arabic):') !!}
    <p>{{ $aqarCategory->category_name }}</p>
</div>

<!-- Category Name (English) Field -->
<div class="col-sm-6">
    {!! Form::label('category_name_en', 'Category Name (English):') !!}
    <p>{{ $aqarCategory->category_name_en }}</p>
</div>
