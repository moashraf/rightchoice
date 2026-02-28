<!-- Image Field -->
@if(!empty($mzaya->img_name))
<div class="col-sm-12 mb-2">
    {!! Form::label('img_name', 'Image:') !!}
    <div>
        <img src="{{ asset('uploads/mzaya/' . $mzaya->img_name) }}" alt="" class="img-fluid img-thumbnail" style="max-width: 200px;">
    </div>
</div>
@endif

<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $mzaya->id }}</p>
</div>

<!-- Mzaya Type Field -->
<div class="col-sm-6">
    {!! Form::label('mzaya_type', 'Mzaya Type:') !!}
    <p>{{ $mzaya->mzaya_type }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12 mt-2">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $mzaya->created_at }}</p>
</div>
