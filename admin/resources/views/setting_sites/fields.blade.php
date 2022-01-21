<div class="card-header mb-3 col-12">
    <h4 class="mb-0" style="color: gray;"> Main Setting</h4>
</div>
<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Title', 'Site Title:') !!} <span class="text-danger">*</span>
    {!! Form::text('Title', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('Title') }}</small>
</div>

<!-- Mail Field -->
<div class="form-group col-sm-6">
    {!! Form::label('mail', 'E-mail:') !!} <span class="text-danger">*</span>
    {!! Form::text('mail', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('mail') }}</small>
</div>

<!-- Mobile Field -->
<div class="form-group col-sm-4">
    {!! Form::label('Mobile', 'Mobile:') !!} <span class="text-danger">*</span>
    {!! Form::text('Mobile', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('Mobile') }}</small>
</div>

<!-- Phone  Land Line Field -->
<div class="form-group col-sm-4">
    {!! Form::label('Phone_land_line', 'Phone  Land Line:') !!} 
    {!! Form::text('Phone_land_line', null, ['class' => 'form-control']) !!}
</div>

<!-- Whatsapp Field -->
<div class="form-group col-sm-4">
    {!! Form::label('whatsapp', 'Whatsapp:') !!}
    {!! Form::text('whatsapp', null, ['class' => 'form-control']) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('Address', 'Location Address:') !!} <span class="text-danger">*</span>
    {!! Form::text('Address', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('Address') }}</small>
</div>

<!-- Map Link Field -->
<div class="form-group col-sm-6">
    {!! Form::label('map_link', 'Map Link:') !!} <span class="text-danger">*</span>
    {!! Form::text('map_link', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('Address') }}</small>
</div>

<div class="card-header mb-3 mt-3 col-12">
    <h4 class="mb-0" style="color: gray;"> Social Media</h4>
</div>

<!-- Facebook Field -->
<div class="form-group col-sm-6">
    {!! Form::label('facebook', 'Facebook:') !!} <span class="text-danger">*</span>
    {!! Form::text('facebook', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('facebook') }}</small>
</div>

<!-- Linkedin Field -->
<div class="form-group col-sm-6">
    {!! Form::label('linkedin', 'Linkedin:') !!} <span class="text-danger">*</span>
    {!! Form::text('linkedin', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('linkedin') }}</small>
</div>

<!-- Insta Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insta', 'Instagram:') !!} <span class="text-danger">*</span>
    {!! Form::text('insta', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('insta') }}</small>
</div>

<!-- Tiwiter Field -->
<div class="form-group col-sm-6">
    {!! Form::label('tiwiter', 'Twitter:') !!} <span class="text-danger">*</span>
    {!! Form::text('tiwiter', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('tiwiter') }}</small>
</div>

<!-- Youtube Field -->
<div class="form-group col-sm-6">
    {!! Form::label('youtube', 'Youtube:') !!} <span class="text-danger">*</span>
    {!! Form::text('youtube', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('youtube') }}</small>
</div>


<div class="card-header mb-3 mt-3 col-12">
    <h4 class="mb-0" style="color: gray;"> Ceo</h4>
</div>
<!-- Meta Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('meta_title', 'Meta Title:') !!}
    {!! Form::text('meta_title', null, ['class' => 'form-control']) !!}
</div>

<!-- Meta Keyword Field -->
<div class="form-group col-sm-6">
    {!! Form::label('meta_keyword', 'Meta Keyword:') !!} <span class="text-danger">(bress enter after each Keyword)</span>
    {!! Form::text('meta_keyword', null, ['class' => 'form-control','data-role'=>'tagsinput']) !!}
</div>

<!-- Meta Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('meta_description', 'Meta Description:') !!}
    {!! Form::textarea('meta_description', null, ['class' => 'form-control']) !!}
</div>

<div class="card-header mb-3 mt-3 col-12">
    <h4 class="mb-0" style="color: gray;"> Logo & Icon</h4>
</div>

<!-- logo -->
<div class="form-group col-sm-6 mt-3">
    {!! Form::label('logo', 'logo:') !!} <span class="text-danger">*</span>
    {!! Form::file('img_logo', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('logo') }}</small>
</div>

@if(!empty($settingSite->logo))
<div class="mb-2">
    <a href="{{Url($settingSite->logo)}}" data-toggle="lightbox"><img src="{{Url($settingSite->logo)}}" alt=""  class="img-fluid img-thumbnail" style="max-width: 60%;">
    </a>
</div>
@endif

<!-- icon -->
<div class="form-group col-sm-6 mt-3">
    {!! Form::label('icon', 'icon:') !!} <span class="text-danger">*</span>
    {!! Form::file('img_icon', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('icon') }}</small>
</div>

@if(!empty($settingSite->icon))
<div class="mb-2">
    <a href="{{Url($settingSite->icon)}}" data-toggle="lightbox"><img src="{{Url($settingSite->icon)}}" alt=""  class="img-fluid img-thumbnail" style="max-width: 60%;">
    </a>
</div>
@endif

<div class="card-header mb-3 mt-3 col-12">
    <h4 class="mb-0" style="color: gray;">Site Short Description</h4>
</div>

<!-- Short Dis About Field -->
<div class="form-group col-sm-12">
    {!! Form::label('short_dis_about', 'Short Description About:') !!}
    {!! Form::textarea('short_dis_about', null, ['class' => 'form-control']) !!}
</div>

<!-- Featured Ads Dis Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('featured_ads_dis', 'Featured Ads Description:') !!}
    {!! Form::textarea('featured_ads_dis', null, ['class' => 'form-control']) !!}
</div>

<!-- Estate Sale Dis Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('estate_sale_dis', 'Estate Sale Description:') !!}
    {!! Form::textarea('estate_sale_dis', null, ['class' => 'form-control']) !!}
</div>

<!-- Estate Sale Rent Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('estate_sale_rent', 'Estate Rent Description:') !!}
    {!! Form::textarea('estate_sale_rent', null, ['class' => 'form-control']) !!}
</div>

<!-- Services Dis Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('services_dis', 'Services Description:') !!}
    {!! Form::textarea('services_dis', null, ['class' => 'form-control']) !!}
</div>

<!-- Most Searched Dis Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('most_searched_dis', 'Most Searched Description:') !!}
    {!! Form::textarea('most_searched_dis', null, ['class' => 'form-control']) !!}
</div>

<!-- Connect Us Dis Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('connect_us_dis', 'Connect Us Description:') !!}
    {!! Form::textarea('connect_us_dis', null, ['class' => 'form-control']) !!}
</div>
