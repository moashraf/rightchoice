<!-- Photo Field -->
@if(!empty($company->photo))
<div class="col-sm-12">
    {!! Form::label('photo', 'Photo:') !!}
</div>
<div class="mb-2">
    <a href="{{Url('images/'.$company->photo)}}" data-toggle="lightbox"><img src="{{Url('images/'.$company->photo)}}" alt=""  class="img-fluid img-thumbnail" style="max-width: 25%;">
    </a>
</div>
@endif

<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $company->id }}</p>
</div>

<!-- User Id Field -->
@if($company->userinfo)
<div class="col-sm-12">
    {!! Form::label('user_id', 'User:') !!}
    <p>{{ $company->userinfo->name }}</p>
</div>
@endif

<!-- Name Field -->
@if($company->Name)
<div class="col-sm-12">
    {!! Form::label('Name', 'Name:') !!}
    <p>{{ $company->Name }}</p>
</div>
@endif

<!-- Slug Field -->
@if($company->slug)
<div class="col-sm-12">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{{ $company->slug }}</p>
</div>
@endif

<!-- Governrate Id Field -->
@if($company->governratinfo)
<div class="col-sm-12">
    {!! Form::label('governrate_id', 'Governrate:') !!}
    <p>{{ $company->governratinfo->governrate }}</p>
</div>
@endif

<!-- District Id Field -->
@if($company->districtinfo)
<div class="col-sm-12">
    {!! Form::label('district_id', 'District:') !!}
    <p>{{ $company->districtinfo->district }}</p>
</div>
@endif

<!-- Area Id Field -->
@if($company->subareainfo)
<div class="col-sm-12">
    {!! Form::label('area_id', 'Area:') !!}
    <p>{{ $company->subareainfo->area }}</p>
</div>
@endif

<!-- Serv Id Field -->
@if($company->serviceinfo)
<div class="col-sm-12">
    {!! Form::label('Serv_id', 'Service:') !!}
    <p>{{ $company->serviceinfo->Service }}</p>
</div>
@endif

<!-- Employee Name Field -->
@if($company->Employee_Name)
<div class="col-sm-12">
    {!! Form::label('Employee_Name', 'Employee Name:') !!}
    <p>{{ $company->Employee_Name }}</p>
</div>
@endif

<!-- Job Title Field -->
@if($company->Job_title)
<div class="col-sm-12">
    {!! Form::label('Job_title', 'Job Title:') !!}
    @if($company->Job_title == 1)
    <p>صاحب عمل</p>
    @elseif($company->Job_title == 2)
    <p>مدير عام</p>
    @elseif($company->Job_title == 3)
    <p>مدير تسويق</p>
    @elseif($company->Job_title == 4)
    <p>مدير فرع</p>
    @else
    <p>اخرى</p>
    @endif
</div>
@endif

<!-- Phone Field -->
@if($company->Phone)
<div class="col-sm-12">
    {!! Form::label('Phone', 'Phone:') !!}
    <p>{{ $company->Phone }}</p>
</div>
@endif

<!-- Building Number Field -->
@if($company->building_number)
<div class="col-sm-12">
    {!! Form::label('building_number', 'Building Number:') !!}
    <p>{{ $company->building_number }}</p>
</div>
@endif

<!-- Floor Field -->
@if($company->Floor)
<div class="col-sm-12">
    {!! Form::label('Floor', 'Floor:') !!}
    <p>{{ $company->Floor }}</p>
</div>
@endif

<!-- Unit Number Field -->
@if($company->unit_number)
<div class="col-sm-12">
    {!! Form::label('unit_number', 'Unit Number:') !!}
    <p>{{ $company->unit_number }}</p>
</div>
@endif

<!-- Details Field -->
@if($company->details)
<div class="col-sm-12">
    {!! Form::label('details', 'Details:') !!}
    <p>{{ $company->details }}</p>
</div>
@endif

<!-- Tax Card Field -->
@if($company->Tax_card)
<div class="col-sm-12">
    {!! Form::label('Tax_card', 'Tax Card:') !!}
    <p>{{ $company->Tax_card }}</p>
</div>
@endif

<!-- Commercial Register Field -->
@if($company->Commercial_Register)
<div class="col-sm-12">
    {!! Form::label('Commercial_Register', 'Commercial Register:') !!}
    <p>{{ $company->Commercial_Register }}</p>
</div>
@endif

<!-- Company Activity Field -->
<!-- <div class="col-sm-12">
    {!! Form::label('Company_activity', 'Company Activity:') !!}
    <p>{{ $company->Company_activity }}</p>
</div> -->

<!-- Status Field -->
<div class="col-sm-12">
    {!! Form::label('status', 'Status:') !!}
    @if($company->status == 1)
    <span class="badge badge-success">Active</span>
    @else
    <span class="badge badge-danger">UnActive</span>
    @endif
</div>

<!-- Created At Field -->
@if($company->created_at)
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $company->created_at->toDayDateTimeString() }}</p>
</div>
@endif
