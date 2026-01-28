<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $images->id }}</p>
</div>

<!-- Img Url Field -->
<div class="col-sm-12">
    {!! Form::label('img_url', 'Img Url:') !!}
    <p>{{ $images->img_url }}</p>
</div>

<!-- Main Img Field -->
<div class="col-sm-12">
    {!! Form::label('main_img', 'Main Img:') !!}
    <p>{{ $images->main_img }}</p>
</div>

<!-- Aqar Id Field -->
<div class="col-sm-12">
    {!! Form::label('aqar_id', 'Aqar Id:') !!}
    <p>{{ $images->aqar_id }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $images->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $images->updated_at }}</p>
</div>

