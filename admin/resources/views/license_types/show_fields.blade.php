<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $licenseType->id }}</p>
</div>

<!-- License Type Field -->
<div class="col-sm-12">
    {!! Form::label('license_type', 'License Type:') !!}
    <p>{{ $licenseType->license_type }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $licenseType->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $licenseType->updated_at }}</p>
</div>

