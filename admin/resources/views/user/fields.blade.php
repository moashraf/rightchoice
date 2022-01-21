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
<div class="form-group col-sm-6">
    <div class="form-group">
        <label for="userName">Type Of User<span class="text-danger">*</span></label>
        {!! Form::select('type', ['1'=>'بائع','2'=>'مشتري','3'=>'     مطور عقاري '] ,null,['class'=>'form-control']) !!}
        <div class="text-danger">{{ $errors->first('type') }}</div>
    </div>
</div>
<div class="col-md-6 form-group">
    <label for="contact_role">Age<span style="color: red">*</span></label>
    {!! Form::select('type', ['From 18 - to 25'=>'From 18 - to 25','From 26 to 35'=>'From 26 to 35','From 36 to 45'=>'From 36 to 45','From 46 to 60'=>'From 46 to 60','More than 60'=>'More than 60'] ,null,['class'=>'form-control']) !!}
    <div class="text-danger">{{ $errors->first('Age') }}</div>
</div>
@if(Route::current()->getName() == 'user.edit')
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!} <span class="text-danger">*</span>
    {!! Form::select('status', ['Un Active', 'Active'] ,null,['class'=>'form-control']) !!} 
    <small class="text-danger">{{ $errors->first('status') }}</small>   
</div>
@endif
<!-- Profile Password Field -->
 
 
