<!-- Photo Field -->
@if(!empty($company->photo))
<div class="col-sm-12 mb-2">
    {!! Form::label('photo', 'Photo:') !!}
    <div>
        <img src="{{ asset('uploads/company/' . $company->photo) }}" alt="" class="img-fluid img-thumbnail" style="max-width: 200px;">
    </div>
</div>
@endif

<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $company->id }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-6">
    {!! Form::label('Name', 'Name:') !!}
    <p>{{ $company->Name }}</p>
</div>

<!-- Slug Field -->
<div class="col-sm-6">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{{ $company->slug }}</p>
</div>

<!-- Phone Field -->
<div class="col-sm-6">
    {!! Form::label('Phone', 'Phone:') !!}
    <p>{{ $company->Phone }}</p>
</div>

<!-- Employee Name Field -->
<div class="col-sm-6">
    {!! Form::label('Employee_Name', 'Employee Name:') !!}
    <p>{{ $company->Employee_Name }}</p>
</div>

<!-- Job Title Field -->
<div class="col-sm-6">
    {!! Form::label('Job_title', 'Job Title:') !!}
    <p>{{ $company->Job_title }}</p>
</div>

<!-- Building Number Field -->
<div class="col-sm-6">
    {!! Form::label('building_number', 'Building Number:') !!}
    <p>{{ $company->building_number }}</p>
</div>

<!-- Floor Field -->
<div class="col-sm-6">
    {!! Form::label('Floor', 'Floor:') !!}
    <p>{{ $company->Floor }}</p>
</div>

<!-- Unit Number Field -->
<div class="col-sm-6">
    {!! Form::label('unit_number', 'Unit Number:') !!}
    <p>{{ $company->unit_number }}</p>
</div>

<!-- Tax Card Field -->
<div class="col-sm-6">
    {!! Form::label('Tax_card', 'Tax Card:') !!}
    <p>{{ $company->Tax_card }}</p>
</div>

<!-- Commercial Register Field -->
<div class="col-sm-6">
    {!! Form::label('Commercial_Register', 'Commercial Register:') !!}
    <p>{{ $company->Commercial_Register }}</p>
</div>

<!-- Status Field -->
<div class="col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    @if($company->status == 1)
        <span class="badge badge-success">Active</span>
    @else
        <span class="badge badge-danger">UnActive</span>
    @endif
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $company->description }}</p>
</div>

<!-- Details Field -->
<div class="col-sm-12">
    {!! Form::label('details', 'Details:') !!}
    <p>{{ $company->details }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12 mt-2">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $company->created_at }}</p>
</div>
