<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $requestPhotoSession->id }}</p>
</div>

<!-- User Id Field -->
<!-- <div class="col-sm-12">
    {!! Form::label('user_id', 'User :') !!}
    <p>{{ $requestPhotoSession->userinfo->name }}</p>
</div> -->

<!-- Phone Field -->
<div class="col-sm-12">
    {!! Form::label('phone', 'Phone:') !!}
    <p>{{ $requestPhotoSession->phone }}</p>
</div>

<!-- Email Field -->
<div class="col-sm-12">
    {!! Form::label('email', 'Email:') !!}
    <p>{{ $requestPhotoSession->email }}</p>
</div>

<!-- User Name Field -->
<div class="col-sm-12">
    {!! Form::label('user_name', 'User Name:') !!}
    <p>{{ $requestPhotoSession->user_name }}</p>
</div>

<!-- Address Field -->
<div class="col-sm-12">
    {!! Form::label('address', 'Address:') !!}
    <p>{{ $requestPhotoSession->address }}</p>
</div>

<!-- Description Field -->
<div class="col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    <p>{{ $requestPhotoSession->description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $requestPhotoSession->created_at->toDayDateTimeString() }}</p>
</div>

<!-- Updated At Field -->
<!-- <div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $requestPhotoSession->updated_at }}</p>
</div> -->

