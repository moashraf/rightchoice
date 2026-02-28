<!-- Category Name (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_name', 'Category Name (Arabic):') !!} <span class="text-danger">*</span>
    {!! Form::text('category_name', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('category_name') }}</small>
</div>

<!-- Category Name (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_name_en', 'Category Name (English):') !!}
    {!! Form::text('category_name_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('category_name_en') }}</small>
</div>

<div class="clearfix"></div>
