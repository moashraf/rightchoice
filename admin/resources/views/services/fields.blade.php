<!-- Service Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Service', 'Service:') !!} <span class="text-danger">*</span>
    {!! Form::text('Service', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('Service') }}</small>
</div>

<!-- serv Image Field -->
<div class="form-group col-sm-6 mt-2">
    {!! Form::label('serv_img', 'Banner:') !!}
    {!! Form::file('serv_img', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('serv_img') }}</small>
</div>

<!-- arabic description -->
<div class="form-group col-sm-6">
    {!! Form::label('description', 'Description:') !!} <span class="text-danger">*</span>
    {!! Form::text('description', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('description') }}</small>
</div>


<!-- Service Field english -->
<div class="form-group col-sm-6">
    {!! Form::label('Service_en', 'Service in english:') !!} <span class="text-danger">*</span>
    {!! Form::text('Service_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('Service_en') }}</small>
</div>


<!-- english description -->
<div class="form-group col-sm-6">
    {!! Form::label('description_en', 'Description:') !!} <span class="text-danger">*</span>
    {!! Form::text('description_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('description_en') }}</small>
</div>
