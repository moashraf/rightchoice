<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $complaints->id }}</p>
</div>

<!-- User Id Field -->
<div class="col-sm-12">
    {!! Form::label('user_id', 'User:') !!}
    <p>{{ $complaints->userinfo->name }}</p>
</div>

<!-- Aqar Id Field -->
<div class="col-sm-12">
    {!! Form::label('aqar_id', 'Aqar:') !!}
    <p>{{ $complaints->aqarinfo->title }}</p>
</div>

<!-- Message Field -->
<div class="col-sm-12">
    {!! Form::label('message', 'Message:') !!}
    <p>{{ $complaints->message }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $complaints->created_at->toDayDateTimeString() }}</p>
</div>


