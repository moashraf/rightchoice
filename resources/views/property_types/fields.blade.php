<!-- Property Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('property_type', 'Property Type:') !!} <span class="text-danger">*</span>
    {!! Form::text('property_type', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('property_type') }}</small>
</div>

<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('cat_id', 'Category:') !!} <span class="text-danger">*</span>
    {!! Form::select('cat_id', $category, null, ['class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('cat_id') }}</small>
</div>