<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $mzaya->id }}</p>
</div>

<!-- Mzaya Type Field -->
<div class="col-sm-12">
    {!! Form::label('mzaya_type', 'Mzaya Type:') !!}
    <p>{{ $mzaya->mzaya_type }}</p>
</div>

<!-- Img Name Field -->
<div class="col-sm-12">
    {!! Form::label('img_name', 'Img Name:') !!}
    <p>{{ $mzaya->img_name }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $mzaya->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $mzaya->updated_at }}</p>
</div>

