<!-- District Field -->
<div class="form-group col-sm-6">
    {!! Form::label('district', 'District:') !!} <span class="text-danger">*</span>
    {!! Form::text('district', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('district') }}</small>
</div>

<!-- Govern Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('govern_id', 'Governrate:') !!} <span class="text-danger">*</span>
    {!! Form::select('govern_id', $governrate, null, ['class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('govern_id') }}</small>
</div>
