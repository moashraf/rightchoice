<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'ID:') !!}
    <p>{{ $propertyType->id }}</p>
</div>

<!-- Property Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('property_type', 'نوع العقار (عربي):') !!}
    <p>{{ $propertyType->property_type }}</p>
</div>

<!-- Property Type En Field -->
<div class="form-group col-sm-6">
    {!! Form::label('property_type_en', 'نوع العقار (إنجليزي):') !!}
    <p>{{ $propertyType->property_type_en }}</p>
</div>

<!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cat_id', 'الفئة:') !!}
    <p>{{ $propertyType->category ? $propertyType->category->category_name : '-' }}</p>
</div>
