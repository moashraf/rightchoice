<!-- Job Title Arabic Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Job_title', 'المسمى الوظيفي:') !!} <span class="text-danger">*</span>
    {!! Form::text('Job_title', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('Job_title') }}</small>
</div>

<!-- Job Title English Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Job_title_en', 'Job Title (English):') !!}
    {!! Form::text('Job_title_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('Job_title_en') }}</small>
</div>

<div class="clearfix"></div>
