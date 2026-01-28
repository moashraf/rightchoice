<!-- Category Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_name', 'Category Name:') !!} <span class="text-danger">*</span>
    {!! Form::text('category_name', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('category_name') }}</small>
</div>