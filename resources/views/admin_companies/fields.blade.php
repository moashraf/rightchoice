<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Name', 'Name:') !!} <span class="text-danger">*</span>
    {!! Form::text('Name', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('Name') }}</small>
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slug', 'Slug:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
</div>

<!-- Governrate Field -->
<div class="form-group col-sm-6">
    {!! Form::label('governrate_id', 'Governrate:') !!}
    {!! Form::select('governrate_id', $governrate ?? [], null, ['class' => 'form-control']) !!}
</div>

<!-- District Field -->
<div class="form-group col-sm-6">
    {!! Form::label('district_id', 'District:') !!}
    {!! Form::select('district_id', $district ?? [], null, ['class' => 'form-control']) !!}
</div>

<!-- Sub Area Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area_id', 'Area:') !!}
    {!! Form::select('area_id', $subarea ?? [], null, ['class' => 'form-control']) !!}
</div>

<!-- Service Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Serv_id', 'Service:') !!}
    {!! Form::select('Serv_id', $service ?? [], null, ['class' => 'form-control']) !!}
</div>

<!-- Employee Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Employee_Name', 'Employee Name:') !!}
    {!! Form::text('Employee_Name', null, ['class' => 'form-control']) !!}
</div>

<!-- Job Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Job_title', 'Job Title:') !!}
    {!! Form::text('Job_title', null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Phone', 'Phone:') !!}
    {!! Form::text('Phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Building Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('building_number', 'Building Number:') !!}
    {!! Form::number('building_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Floor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Floor', 'Floor:') !!}
    {!! Form::number('Floor', null, ['class' => 'form-control']) !!}
</div>

<!-- Unit Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit_number', 'Unit Number:') !!}
    {!! Form::number('unit_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Tax Card Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Tax_card', 'Tax Card:') !!}
    {!! Form::text('Tax_card', null, ['class' => 'form-control']) !!}
</div>

<!-- Commercial Register Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Commercial_Register', 'Commercial Register:') !!}
    {!! Form::text('Commercial_Register', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    <select class="form-control" name="status">
        <option value="0" {{ (isset($company) && $company->status == 0) ? 'selected' : '' }}>Not Active</option>
        <option value="1" {{ (isset($company) && $company->status == 1) ? 'selected' : '' }}>Active</option>
    </select>
</div>

<!-- Photo Field -->
<div class="form-group col-sm-6">
    {!! Form::label('photo', 'Photo:') !!}
    <div class="input-group">
        <div class="custom-file">
            {!! Form::file('photo', ['class' => 'custom-file-input']) !!}
            {!! Form::label('photo', 'Choose file', ['class' => 'custom-file-label']) !!}
        </div>
    </div>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
</div>

<!-- Details Field -->
<div class="form-group col-sm-12">
    {!! Form::label('details', 'Details:') !!}
    {!! Form::textarea('details', null, ['class' => 'form-control', 'rows' => 4]) !!}
</div>

<div class="clearfix"></div>
