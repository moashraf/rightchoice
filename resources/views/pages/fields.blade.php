<!-- Page Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('page_name', 'Page Name:') !!} <span class="text-danger">*</span>
    {!! Form::text('page_name', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('page_name') }}</small>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!} <span class="text-danger">*</span>
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('description') }}</small>
</div>