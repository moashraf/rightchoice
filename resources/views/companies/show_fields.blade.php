<!-- Photo Field -->
<div class="col-sm-12">
    {!! Form::label('photo', 'Photo:') !!}
    <!-- <p>{{ $company->photo }}</p> -->
</div>

@if(!empty($company->photo))
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
<div class="col-sm-12">
    {!! Form::label('user_id', 'User:') !!}
    <p>{{ $company->userinfo->name }}</p>
</div>

<!-- Name Field -->
<div class="col-sm-12">
    {!! Form::label('Name', 'Name:') !!}
    <p>{{ $company->Name }}</p>
</div>

<!-- Slug Field -->
<div class="col-sm-12">
    {!! Form::label('slug', 'Slug:') !!}
    <p>{{ $company->slug }}</p>
</div>

<!-- Governrate Id Field -->
<div class="col-sm-12">
    {!! Form::label('governrate_id', 'Governrate:') !!}
    <p>@if($company->districtinfo){{ $company->governratinfo->governrate }}@endif</p>
</div>

<!-- District Id Field -->
<div class="col-sm-12">
    {!! Form::label('district_id', 'District:') !!}
    <p>@if($company->districtinfo){{ $company->districtinfo->district }}@endif</p>
</div>

<!-- Area Id Field -->
<div class="col-sm-12">
    {!! Form::label('area_id', 'Area:') !!}
    <p>@if($company->subareainfo){{ $company->subareainfo->area }}@endif</p>
</div>

<!-- Serv Id Field -->
<div class="col-sm-12">
    {!! Form::label('Serv_id', 'Service:') !!}
    <p>@if($company->serviceinfo){{ $company->serviceinfo->Service }}@endif</p>
</div>


<!-- Employee Name Field -->
<div class="col-sm-12">
    {!! Form::label('Employee_Name', 'Employee Name:') !!}
    <p>{{ $company->Employee_Name }}</p>
</div>

<!-- Job Title Field -->
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

<!-- Phone Field -->
<div class="col-sm-12">
    {!! Form::label('Phone', 'Phone:') !!}
    <p>{{ $company->Phone }}</p>
</div>

<!-- Building Number Field -->
<div class="col-sm-12">
    {!! Form::label('building_number', 'Building Number:') !!}
    <p>{{ $company->building_number }}</p>
</div>

<!-- Floor Field -->
<div class="col-sm-12">
    {!! Form::label('Floor', 'Floor:') !!}
    <p>{{ $company->Floor }}</p>
</div>

<!-- Unit Number Field -->
<div class="col-sm-12">
    {!! Form::label('unit_number', 'Unit Number:') !!}
    <p>{{ $company->unit_number }}</p>
</div>

<!-- Details Field -->
<div class="col-sm-12">
    {!! Form::label('details', 'Details:') !!}
    <p>{{ $company->details }}</p>
</div>

<!-- Tax Card Field -->
<div class="col-sm-12">
    {!! Form::label('Tax_card', 'Tax Card:') !!}
    <p>{{ $company->Tax_card }}</p>
</div>

<!-- Commercial Register Field -->
<div class="col-sm-12">
    {!! Form::label('Commercial_Register', 'Commercial Register:') !!}
    <p>{{ $company->Commercial_Register }}</p>
</div>


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
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $company->created_at->toDayDateTimeString() }}</p>
</div>


