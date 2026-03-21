<!-- Id Field -->
<div class="col-sm-12">
    {!! Form::label('id', 'الرقم:') !!}
    <p>{{ $ad->id }}</p>
</div>

<!-- Name (URL) Field -->
<div class="col-sm-12">
    {!! Form::label('name', 'الرابط:') !!}
    <p>
        @if(!empty($ad->name))
            <a href="{{ $ad->name }}" target="_blank">{{ $ad->name }}</a>
        @else
            -
        @endif
    </p>
</div>

<!-- Image Field -->
@if(!empty($ad->img))
<div class="col-sm-12 mb-3">
    {!! Form::label('img', 'الصورة:') !!}<br>
    <a href="{{ url('images/' . $ad->img) }}" data-toggle="lightbox">
        <img src="{{ url('images/' . $ad->img) }}" alt="" class="img-fluid img-thumbnail" style="max-width: 60%;">
    </a>
</div>
@endif

