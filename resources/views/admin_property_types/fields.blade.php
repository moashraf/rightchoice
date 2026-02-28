<!-- Property Type (Arabic) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('property_type', 'نوع العقار (عربي):') !!} <span class="text-danger">*</span>
    {!! Form::text('property_type', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('property_type') }}</small>
</div>

<!-- Property Type (English) Field -->
<div class="form-group col-sm-6">
    {!! Form::label('property_type_en', 'نوع العقار (إنجليزي):') !!}
    {!! Form::text('property_type_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('property_type_en') }}</small>
</div>

<!-- Category Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cat_id', 'الفئة:') !!} <span class="text-danger">*</span>
    {!! Form::select('cat_id', $category, null, ['placeholder' => 'اختر الفئة...', 'class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('cat_id') }}</small>
</div>

<div class="clearfix"></div>
