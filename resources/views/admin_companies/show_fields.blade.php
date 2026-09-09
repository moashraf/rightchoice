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
    {!! Form::label('name', 'Name:') !!}
    <p>{{ $company->name }}</p>
</div>

<!-- Slug Field -->
<div class="col-sm-6">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{{ $company->slug }}</p>
</div>

<!-- Phone Field -->
<div class="col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    <p>{{ $company->phone }}</p>
</div>

<!-- Employee Name Field -->
<div class="col-sm-6">
    {!! Form::label('employee_name', 'Employee Name:') !!}
    <p>{{ $company->employee_name }}</p>
</div>

<!-- Job Title Field -->
<div class="col-sm-6">
    {!! Form::label('job_title', 'Job Title:') !!}
    <p>
        @if($company->jobTitle)
            @if(App::isLocale('en'))
                {{ $company->jobTitle->Job_title_en ?: $company->jobTitle->Job_title }}
            @else
                {{ $company->jobTitle->Job_title }}
            @endif
        @else
            {{ $company->job_title }}
        @endif
    </p>
</div>

<!-- Building Number Field -->
<div class="col-sm-6">
    {!! Form::label('building_number', 'Building Number:') !!}
    <p>{{ $company->building_number }}</p>
</div>

<!-- Floor Field -->
<div class="col-sm-6">
    {!! Form::label('floor', 'Floor:') !!}
    <p>{{ $company->floor }}</p>
</div>

<!-- Unit Number Field -->
<div class="col-sm-6">
    {!! Form::label('unit_number', 'Unit Number:') !!}
    <p>{{ $company->unit_number }}</p>
</div>

<!-- Tax Card Field -->
<div class="col-sm-6">
    {!! Form::label('tax_card', 'Tax Card:') !!}
    <p>{{ $company->tax_card }}</p>
</div>

<!-- Commercial Register Field -->
<div class="col-sm-6">
    {!! Form::label('commercial_register', 'Commercial Register:') !!}
    <p>{{ $company->commercial_register }}</p>
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
