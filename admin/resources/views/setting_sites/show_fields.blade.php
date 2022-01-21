
<!-- Title Field -->
<div class="col-sm-12">
    {!! Form::label('Title', 'Title:') !!}
    <p>{{ $settingSite->Title }}</p>
</div>

<!-- Address Field -->
<div class="col-sm-12">
    {!! Form::label('Address', 'Address:') !!}
    <p>{{ $settingSite->Address }}</p>
</div>

<!-- Mobile Field -->
<div class="col-sm-12">
    {!! Form::label('Mobile', 'Mobile:') !!}
    <p>{{ $settingSite->Mobile }}</p>
</div>

<!-- Phone  Land Line Field -->
<div class="col-sm-12">
    {!! Form::label('Phone_land_line', 'Phone  Land Line:') !!}
    <p>{{ $settingSite->Phone_land_line }}</p>
</div>

<!-- Mail Field -->
<div class="col-sm-12">
    {!! Form::label('mail', 'Mail:') !!}
    <p>{{ $settingSite->mail }}</p>
</div>

<!-- Facebook Field -->
<div class="col-sm-12">
    {!! Form::label('facebook', 'Facebook:') !!}
    <p>{{ $settingSite->facebook }}</p>
</div>

<!-- Linkedin Field -->
<div class="col-sm-12">
    {!! Form::label('linkedin', 'Linkedin:') !!}
    <p>{{ $settingSite->linkedin }}</p>
</div>

<!-- Insta Field -->
<div class="col-sm-12">
    {!! Form::label('insta', 'Insta:') !!}
    <p>{{ $settingSite->insta }}</p>
</div>

<!-- Tiwiter Field -->
<div class="col-sm-12">
    {!! Form::label('tiwiter', 'Tiwiter:') !!}
    <p>{{ $settingSite->tiwiter }}</p>
</div>

<!-- Youtube Field -->
<div class="col-sm-12">
    {!! Form::label('youtube', 'Youtube:') !!}
    <p>{{ $settingSite->youtube }}</p>
</div>

<!-- Map Link Field -->
<div class="col-sm-12">
    {!! Form::label('map_link', 'Map Link:') !!}
    <p>{{ $settingSite->map_link }}</p>
</div>

<!-- Meta Title Field -->
<div class="col-sm-12">
    {!! Form::label('meta_title', 'Meta Title:') !!}
    <p>{{ $settingSite->meta_title }}</p>
</div>

<!-- Meta Keyword Field -->
<div class="col-sm-12">
    {!! Form::label('meta_keyword', 'Meta Keyword:') !!}
    <p>{{ $settingSite->meta_keyword }}</p>
</div>

<!-- Meta Description Field -->
<div class="col-sm-12">
    {!! Form::label('meta_description', 'Meta Description:') !!}
    <p>{{ $settingSite->meta_description }}</p>
</div>

<!-- Logo Field -->
<div class="col-sm-12">
    {!! Form::label('logo', 'Logo:') !!}
    <!-- <p>{{ $settingSite->logo }}</p> -->
</div>
@if(!empty($settingSite->logo))
<div class="mb-2">
    <a href="{{Url($settingSite->logo)}}" data-toggle="lightbox"><img src="{{Url($settingSite->logo)}}" alt=""  class="img-fluid img-thumbnail" style="max-width: 60%;">
    </a>
</div>
@endif

<!-- Icon Field -->
<div class="col-sm-12">
    {!! Form::label('icon', 'Icon:') !!}
    <!-- <p>{{ $settingSite->icon }}</p> -->
</div>

@if(!empty($settingSite->icon))
<div class="mb-2">
    <a href="{{Url($settingSite->icon)}}" data-toggle="lightbox"><img src="{{Url($settingSite->icon)}}" alt=""  class="img-fluid img-thumbnail" style="max-width: 60%;">
    </a>
</div>
@endif

<!-- Short Description About Field -->
<div class="col-sm-12">
    {!! Form::label('short_Description_about', 'Short Description About:') !!}
    <p>{{ $settingSite->short_Description_about }}</p>
</div>

<!-- Whatsapp Field -->
<div class="col-sm-12">
    {!! Form::label('whatsapp', 'Whatsapp:') !!}
    <p>{{ $settingSite->whatsapp }}</p>
</div>

<!-- Featured Ads Description Field -->
<div class="col-sm-12">
    {!! Form::label('featured_ads_Description', 'Featured Ads Description:') !!}
    <p>{{ $settingSite->featured_ads_Description }}</p>
</div>

<!-- Estate Sale Description Field -->
<div class="col-sm-12">
    {!! Form::label('estate_sale_Description', 'Estate Sale Description:') !!}
    <p>{{ $settingSite->estate_sale_Description }}</p>
</div>

<!-- Estate Sale Rent Field -->
<div class="col-sm-12">
    {!! Form::label('estate_sale_rent', 'Estate Sale Rent:') !!}
    <p>{{ $settingSite->estate_sale_rent }}</p>
</div>

<!-- Services Description Field -->
<div class="col-sm-12">
    {!! Form::label('services_Description', 'Services Description:') !!}
    <p>{{ $settingSite->services_Description }}</p>
</div>

<!-- Most Searched Description Field -->
<div class="col-sm-12">
    {!! Form::label('most_searched_Description', 'Most Searched Description:') !!}
    <p>{{ $settingSite->most_searched_Description }}</p>
</div>

<!-- Connect Us Description Field -->
<div class="col-sm-12">
    {!! Form::label('connect_us_Description', 'Connect Us Description:') !!}
    <p>{{ $settingSite->connect_us_Description }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-12">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{{ $settingSite->created_at->toDayDateTimeString() }}</p>
</div>

<!-- Updated At Field -->
<!-- <div class="col-sm-12">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{{ $settingSite->updated_at }}</p>
</div> -->

