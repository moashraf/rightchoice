@extends('layouts.app')
@section('title', 'Edit  ')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit  </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        <!-- @include('adminlte-templates::common.errors') -->

        <div class="card">

            {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'patch' ,'files' => true,'enctype' => 'multipart/form-data']) !!}

            <div class="card-body">
                <div class="row">

<!-- Title Field -->
<div class="form-group col-sm-4">
    {!! Form::label('name', 'Name:') !!} <span class="text-danger">*</span>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>
<div class="form-group col-sm-4">
    {!! Form::label('email', 'Email:') !!} <span class="text-danger">*</span>
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('email') }}</small>
</div>
<div class="form-group col-sm-4">
    {!! Form::label('MOP', 'Mobile Number:') !!} <span class="text-danger">*</span>
    {!! Form::number('MOP', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('MOP') }}</small>
</div>



<div class="form-group col-sm-4">
    {!! Form::label('created_at', '  created:') !!} <span class="text-danger">*</span>
    {!! Form::text('created_at', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('created_at') }}</small>
</div>

<div class="form-group col-sm-4">
    {!! Form::label('point', '  point:') !!} <span class="text-danger">*</span>
<input type="text" value="<?php

if( (isset($all_point_of_user)))

{
if($all_point_of_user->count() > 0){   echo($all_point_of_user->current_points);}
else{ echo 1; } 


}
else{ echo 1; } 
?>" class="form-control" name="current_points">
    <small class="text-danger">{{ $errors->first('current_points') }}</small>
</div>



<div class="form-group col-sm-4">
    {!! Form::label('status SMS', '  status SMS :') !!} <span class="text-danger">*</span>
 {!! Form::text('phone_verfied_sms_status', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('phone_verfied_sms_status') }}</small>
	
</div>


<div class="form-group col-sm-4">
    {!! Form::label('Code Otp', '  COde Otp:') !!} <span class="text-danger">*</span>
 {!! Form::text('phone_sms_otp', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('phone_sms_otp') }}</small>
	
</div>









<div class="form-group col-sm-4">
    <div class="form-group">
        <label for="userName">Type Of User<span class="text-danger">*</span></label>
        <?php  //dd($user);?>
             <select  name="TYPE"  class="form-control custom-select">
                     <option value=1 <?php    if($user->TYPE == 1) {echo 'selected' ;}  ?> >بائع او مؤجر  </option>
                     <option value=2 <?php    if($user->TYPE ==2) {echo 'selected' ;}  ?> >   مشتري أو مستأجر    </option>
                     <option value=3 <?php    if($user->TYPE ==3) {echo 'selected' ;}  ?> > مطور عقاري      </option>
                     <option value=4 <?php    if($user->TYPE == 4) {echo 'selected' ;}  ?> > شركه      </option>
    
                                
                            </select>
                            
                            
                            
        <div class="text-danger">{{ $errors->first('type') }}</div>
    </div>
</div>

<div class="form-group col-sm-4">
    {!! Form::label('AGE', '  AGE:') !!} <span class="text-danger">*</span>
    {!! Form::text('AGE', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('AGE') }}</small>
</div>

 
@if(Route::current()->getName() == 'user.edit')
<div class="form-group col-sm-4">
    {!! Form::label('status', 'Status:') !!} <span class="text-danger">*</span>
    {!! Form::select('status', ['Un Active', 'Active'] ,null,['class'=>'form-control']) !!} 
    <small class="text-danger">{{ $errors->first('status') }}</small>   
</div>
@endif
<!-- Profile Password Field -->
 
 


                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('user.index') }}" class="btn btn-default">Cancel</a>
            </div>

           {!! Form::close() !!}

        </div>
    </div>
@endsection
