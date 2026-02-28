<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $licenseType->id }}</p>
</div>

<!-- License Type (Arabic) Field -->
<div class="col-sm-6">
    {!! Form::label('license_type', 'License Type (Arabic):') !!}
    <p>{{ $licenseType->license_type }}</p>
</div>

<!-- License Type (English) Field -->
<div class="col-sm-6">
    {!! Form::label('license_type_en', 'License Type (English):') !!}
    <p>{{ $licenseType->license_type_en }}</p>
</div>
