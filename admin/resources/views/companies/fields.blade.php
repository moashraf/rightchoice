<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Name', 'Name:') !!}
    {!! Form::text('Name', null, ['class' => 'form-control']) !!}
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slug', 'Slug:') !!}
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
</div>

<!-- Area Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('area_id', 'Area Id:') !!}
    {!! Form::select('area_id', $subarea, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- District Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('district_id', 'District Id:') !!}
    {!! Form::select('district_id', $district, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Governrate Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('governrate_id', 'Governrate Id:') !!}
    {!! Form::select('governrate_id', $governrate, null, ['class' => 'form-control custom-select']) !!}
</div>




<!-- Serv Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Serv_id', 'Serv Id:') !!}
    {!! Form::select('Serv_id', $service, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('details', null, ['class' => 'form-control']) !!}
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
    {!! Form::select('Floor', $floor, null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Unit Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('unit_number', 'Unit Number:') !!}
    {!! Form::number('unit_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Details Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('details', 'Details:') !!}
    {!! Form::textarea('details', null, ['class' => 'form-control']) !!}
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
<div class="clearfix"></div>


<!-- Company Activity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Company_activity', 'Company Activity:') !!}
    {!! Form::select('Company_activity', ['' => ''], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
      <select  class="form-control custom-select" name="status">
        <option value="0">Not active</option>
        <option value="1">active</option>
    </select>
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    <select disabled class="form-control custom-select" name="user_id">
        <option value="{{ $users->id }}">{{ $users->name }}</option>
    </select>
</div>
