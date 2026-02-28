<!-- Title Field -->
<div class="col-sm-6">
    {!! Form::label('Title', 'Title:') !!}
    <p>{{ $settingSite->Title }}</p>
</div>

<!-- Address Field -->
<div class="col-sm-6">
    {!! Form::label('Address', 'Address:') !!}
    <p>{{ $settingSite->Address }}</p>
</div>

<!-- Mobile Field -->
<div class="col-sm-4">
    {!! Form::label('Mobile', 'Mobile:') !!}
    <p>{{ $settingSite->Mobile }}</p>
</div>

<!-- Phone Land Line Field -->
<div class="col-sm-4">
    {!! Form::label('Phone_land_line', 'Phone Land Line:') !!}
    <p>{{ $settingSite->Phone_land_line }}</p>
</div>

<!-- Whatsapp Field -->
<div class="col-sm-4">
    {!! Form::label('whatsapp', 'Whatsapp:') !!}
    <p>{{ $settingSite->whatsapp }}</p>
</div>

<!-- Mail Field -->
<div class="col-sm-6">
    {!! Form::label('mail', 'Mail:') !!}
    <p>{{ $settingSite->mail }}</p>
</div>

<!-- Map Link Field -->
<div class="col-sm-6">
    {!! Form::label('map_link', 'Map Link:') !!}
    <p>{{ $settingSite->map_link }}</p>
</div>

<!-- Facebook Field -->
<div class="col-sm-6">
    {!! Form::label('facebook', 'Facebook:') !!}
    <p>{{ $settingSite->facebook }}</p>
</div>

<!-- Linkedin Field -->
<div class="col-sm-6">
    {!! Form::label('linkedin', 'Linkedin:') !!}
    <p>{{ $settingSite->linkedin }}</p>
</div>

<!-- Insta Field -->
<div class="col-sm-6">
    {!! Form::label('insta', 'Instagram:') !!}
    <p>{{ $settingSite->insta }}</p>
</div>

<!-- Twitter Field -->
<div class="col-sm-6">
    {!! Form::label('tiwiter', 'Twitter:') !!}
    <p>{{ $settingSite->tiwiter }}</p>
</div>

<!-- Youtube Field -->
<div class="col-sm-6">
    {!! Form::label('youtube', 'Youtube:') !!}
    <p>{{ $settingSite->youtube }}</p>
</div>

<!-- Meta Title Field -->
<div class="col-sm-6">
    {!! Form::label('meta_title', 'Meta Title:') !!}
    <p>{{ $settingSite->meta_title }}</p>
</div>

<!-- Logo Field -->
<div class="col-sm-12">
    {!! Form::label('logo', 'Logo:') !!}
    @if(!empty($settingSite->logo))
    <div class="mb-2">
        <a href="{{ url($settingSite->logo) }}" data-toggle="lightbox">
            <img src="{{ url($settingSite->logo) }}" alt="" class="img-fluid img-thumbnail" style="max-width: 200px;">
        </a>
    </div>
    @endif
</div>

<!-- Icon Field -->
<div class="col-sm-12">
    {!! Form::label('icon', 'Icon:') !!}
    @if(!empty($settingSite->icon))
    <div class="mb-2">
        <a href="{{ url($settingSite->icon) }}" data-toggle="lightbox">
            <img src="{{ url($settingSite->icon) }}" alt="" class="img-fluid img-thumbnail" style="max-width: 80px;">
        </a>
    </div>
    @endif
</div>

<!-- Created At Field -->
<div class="col-sm-12 mt-3">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $settingSite->created_at->toDayDateTimeString() }}</p>
</div>
