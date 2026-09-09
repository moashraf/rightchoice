<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!} <span class="text-danger">*</span>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
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
    {!! Form::label('serv_id', 'Service:') !!}
    {!! Form::select('serv_id', $service ?? [], null, ['class' => 'form-control']) !!}
</div>

<!-- Employee Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('employee_name', 'Employee Name:') !!}
    {!! Form::text('employee_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Job Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('job_title', 'Job Title:') !!}
    {!! Form::select('job_title', ['' => 'اختر'] + ($jobTitlesOptions ?? []), null, ['class' => 'form-control']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Building Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('building_number', 'Building Number:') !!}
    {!! Form::text('building_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Floor Field -->
<div class="form-group col-sm-6">
    {!! Form::label('floor', 'Floor:') !!}
    {!! Form::text('floor', null, ['class' => 'form-control']) !!}
</div>

<!-- Unit Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit_number', 'Unit Number:') !!}
    {!! Form::text('unit_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Tax Card Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tax_card', 'Tax Card:') !!}
    {!! Form::text('tax_card', null, ['class' => 'form-control']) !!}
</div>

<!-- Commercial Register Field -->
<div class="form-group col-sm-6">
    {!! Form::label('commercial_register', 'Commercial Register:') !!}
    {!! Form::text('commercial_register', null, ['class' => 'form-control']) !!}
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

<!-- Details Field -->
<div class="form-group col-sm-12">
    {!! Form::label('details', 'Details:') !!}
    {!! Form::textarea('details', null, ['class' => 'form-control', 'rows' => 4]) !!}
</div>

<div class="clearfix"></div>
