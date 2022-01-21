
<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!} <span class="text-danger">*</span>
    {!! Form::select('type', ['specific user','all user'], null, ['class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('type') }}</small>
</div>

<!-- User Id Field -->
<div id="user_phonediv" class="form-group col-sm-6">
    {!! Form::label('user_id', 'User:') !!} <span class="text-danger">*</span>
    {!! Form::select('user_id', $users, null, ['placeholder' => 'Please select ...','class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('user_id') }}</small>
</div>


<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!} <span class="text-danger">*</span>
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('title') }}</small>
</div>

<!-- Message Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('message', 'Message:') !!} <span class="text-danger">*</span>
    {!! Form::textarea('message', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('message') }}</small>
</div>