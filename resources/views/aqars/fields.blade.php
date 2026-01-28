<div class="card-header mb-3 col-12">
    <h4 class="mb-0" style="color: gray;"> Property type and location</h4>
</div>

<!-- Category Field -->
<div class="form-group col-sm-4">
    {!! Form::label('category', 'Category:') !!} <span class="text-danger">*</span>
    {!! Form::select('category', $aqarcategory, null, ['class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('category') }}</small>
</div>

<!-- Property Type Field -->
<div class="form-group col-sm-4">
    {!! Form::label('property_type', 'Property Type:') !!} <span class="text-danger">*</span>


    <?php // dd( $aqar->compound );?>
    <select name="property_type" class="form-control custom-select">


        @foreach ($propertytype as $propertytype_val)
            <option value="{{ $propertytype_val->id}}"

                    <?php if (@$aqar->property_type == $propertytype_val->id) {
                echo 'selected';
            } ?> >{{ $propertytype_val->property_type }}</option>

        @endforeach
    </select>


    <small class="text-danger">{{ $errors->first('property_type') }}</small>
</div>

<!-- Compound Field -->
<div class="form-group col-sm-4">
    {!! Form::label('compound', 'Compound:') !!}

    <?php // dd( $aqar->compound );?>
    <select name="compound" class="form-control custom-select">
        <option value=""> اختار</option>

        @foreach ($compound as $cat_compound)
            <option value="{{ $cat_compound->id}}" <?php if (@$aqar->compound == $cat_compound->id) {
                echo 'selected';
            } ?> >{{ $cat_compound->compound }}</option>

        @endforeach
    </select>


</div>

<!-- Governrate Id Field -->
<div class="form-group col-sm-4">
    {!! Form::label('governrate_id', 'Governrate:') !!} <span class="text-danger">*</span>
    {!! Form::select('governrate_id', $governrate, null, ['class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('governrate_id') }}</small>
</div>
<div class="form-group col-sm-4">
    {!! Form::label('slug', 'slug:') !!} <span class="text-danger">*</span>
    {!! Form::select('slug', $governrate, null, ['class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('governrate_id') }}</small>
</div>


<!-- District Id Field -->
<div class="form-group col-sm-4">
    {!! Form::label('district_id', 'District:') !!} <span class="text-danger">*</span>


    <select name="district_id" class="form-control custom-select">
        @foreach ($district as $cat)
            <option value="{{ $cat->id}}" <?php if (@$aqar->district_id == $cat->id) {
                echo 'selected';
            } ?> >{{ $cat->district }}</option>

        @endforeach
    </select>


    <small class="text-danger">{{ $errors->first('district_id') }}</small>
</div>


<!-- Area Id Field -->
<div class="form-group col-sm-4">
    {!! Form::label('area_id', 'Area:') !!}
    {!! Form::select('area_id', $subarea, null, ['placeholder' => 'Please select ...','class' => 'form-control
    custom-select']) !!}
</div>

<div class="card-header mb-3 mt-3 col-12">
    <h4 class="mb-0" style="color: gray;"> Ad details</h4>
</div>

<!-- User Id Field -->
<div id="user_name" class="form-group col-sm-12">
    {!! Form::label('user_id', 'User:') !!} <span class="text-danger">*</span>
    {!! Form::select('user_id', $users, null, ['placeholder' => 'Please select ...','class' => 'form-control
    custom-select']) !!}
    <small class="text-danger">{{ $errors->first('user_id') }}</small>
</div>
@if(Route::current()->getName() == 'aqars.edit')
    <div id="user_phonediv" class="form-group col-sm-4">
        {!! Form::label('user_phone', 'User Phone:') !!}
        {!! Form::input('user_phone', 'user_phone', $getPhoneFirst->MOP, ['class' => 'form-control user_phone' ,
        'readonly']) !!}
    </div>
@endif

<!-- Call Id Field -->
<div class="form-group col-sm-4">
    {!! Form::label('call_id', 'Times to contact:') !!} <span class="text-danger">*</span>
    {!! Form::select('call_id', $callTimes, null, ['class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('call_id') }}</small>
</div>
<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!} <span class="text-danger">*</span>
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('title') }}</small>
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slug', 'Slug:') !!} <span class="text-danger">*</span>
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('slug') }}</small>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Description:') !!} <span class="text-danger">*</span>
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('description') }}</small>
</div>

<!-- english fieldsssssssssssssssssssssssssss -->


<!-- Title_en Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title_en:') !!} <span class="text-danger">*</span>
    {!! Form::text('title_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('title_en') }}</small>
</div>

<!-- Slug_en Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slug_en', 'Slug_en:') !!} <span class="text-danger">*</span>
    {!! Form::text('slug_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('slug_en') }}</small>
</div>

<!-- Description_en Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description_en', 'Description_en:') !!} <span class="text-danger">*</span>
    {!! Form::textarea('description_en', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('description_en') }}</small>
</div>

<!-- end of englishssssssssssssssssssssssssssssssssssssssssssssssssssss -->

<div class="card-header mb-3 mt-3 col-12">
    <h4 class="mb-0" style="color: gray;"> Ad Specifications</h4>
</div>


<!-- Offer Type Field -->
<div class="form-group col-sm-4">
    {!! Form::label('offer_type', 'Offer Type:') !!} <span class="text-danger">*</span>
    {!! Form::select('offer_type', $offertype , null, ['class' => 'form-control custom-select']) !!}
    <small class="text-danger">{{ $errors->first('offer_type') }}</small>
</div>

<!-- Total Area Field -->
<div class="form-group col-sm-4">
    {!! Form::label('total_area', 'Total Area:') !!}
    {!! Form::number('total_area', null, ['class' => 'form-control']) !!}
</div>

<!-- Finishtype Field -->
<div id="finishtype" class="form-group col-sm-4">
    {!! Form::label('finishtype', 'Finishtype:') !!}
    {!! Form::select('finishtype', $finishtype, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Floor Field -->
<div id="floor" class="form-group col-sm-4">
    {!! Form::label('floor', 'floor:') !!}
    {!! Form::select('floor', $floor, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Rooms Field -->
<div id="rooms" class="form-group col-sm-4">
    {!! Form::label('rooms', 'number of rooms:') !!}
    {!! Form::number('rooms', null, ['class' => 'form-control']) !!}
</div>

<!-- Baths Field -->
<div id="baths" class="form-group col-sm-4">
    {!! Form::label('baths', 'number of bathrooms:') !!}
    {!! Form::number('baths', null, ['class' => 'form-control']) !!}
</div>

<!-- License Type Field -->
<div id="license_type" class="form-group col-sm-4">
    {!! Form::label('license_type', 'License Type:') !!}
    {!! Form::select('license_type', $licensetype, null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Finannce Bank Field -->
<div id="finannce_bank" class="form-group col-sm-4">
    {!! Form::label('finannce_bank', 'Finannce Bank:') !!}
    {!! Form::select('finannce_bank', ['No','Yes'], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Licensed Field -->
<div id="licensed" class="form-group col-sm-4">
    {!! Form::label('licensed', 'Licensed:') !!}
    {!! Form::select('licensed', ['No','Yes'], null, ['class' => 'form-control custom-select']) !!}
</div>


<!-- Trade Field -->
<div id="trade" class="form-group col-sm-4">
    {!! Form::label('trade', 'Trade:') !!}
    {!! Form::select('trade', ['No','Yes'], null, ['class' => 'form-control custom-select']) !!}
</div>

<!-- Number Of Floors Field -->
<div id="number_of_floors" class="form-group col-sm-6">
    {!! Form::label('number_of_floors', 'Number Of Floors:') !!}
    {!! Form::number('number_of_floors', null, ['class' => 'form-control']) !!}
</div>

<!-- Monthly Rent Field -->
<div id="monthly_rent" class="form-group col-sm-6">
    {!! Form::label('monthly_rent', 'Monthly Rent:') !!} <span class="text-danger">*</span>
    {!! Form::number('monthly_rent', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('monthly_rent') }}</small>
</div>

<!-- Total Price Field -->
<div id="total_price" class="form-group col-sm-6">
    {!! Form::label('total_price', 'Total Price:') !!} <span class="text-danger">*</span>
    {!! Form::text('total_price', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('total_price') }}</small>
</div>

<div class="row col-md-12">
    <!-- Downpayment Field -->
    <div id="installment_downpayment" class="form-group col-sm-4">
        {!! Form::label('downpayment', 'Downpayment:') !!}
        {!! Form::number('downpayment', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Installment Time Field -->
    <div id="installment_time" class="form-group col-sm-4">
        {!! Form::label('installment_time', 'Installment Time:') !!}
        {!! Form::number('installment_time', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Reciving Field -->
    <div id="installment_reciving" class="form-group col-sm-4">
        {!! Form::label('reciving', 'Receiving:') !!}
        {!! Form::select('reciving', ['Fawry','Not Fawry'], null, ['class' => 'form-control custom-select']) !!}
    </div>

    <div class="form-group col-sm-6">
        {!! Form::label('vip', 'Vip:') !!}
        <div class="form-check">
            <input class="form-check-input" type="radio" name="vip" id="vip-yes" value="1"
            @if(@$aqar->vip == 1) checked @endif>
            <label class="form-check-label" for="vip-yes">
                Yes
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="vip" id="vip-no" value="0"
                   @if(@$aqar->vip == 0) checked @endif>
            <label class="form-check-label" for="vip-no">
                No
            </label>
        </div>


    </div>


</div>

<!-- Installment Value Field -->
<!-- <div class="form-group col-sm-4">
    {!! Form::label('installment_value', 'Installment Value:') !!}
{!! Form::number('installment_value', null, ['class' => 'form-control']) !!}
</div> -->

<!-- Vip Field -->
<!-- <div class="form-group col-sm-6">
</div> -->

<!-- Ground Area Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('ground_area', 'Ground Area:') !!}
{!! Form::number('ground_area', null, ['class' => 'form-control']) !!}
</div> -->

<!-- Land Area Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('land_area', 'Land Area:') !!}
{!! Form::number('land_area', null, ['class' => 'form-control']) !!}
</div> -->

<!-- Mtr Price Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('mtr_price', 'Mtr Price:') !!}
{!! Form::text('mtr_price', null, ['class' => 'form-control']) !!}
</div> -->


<!-- Rec Time Field -->
<div id="rec_time" class="form-group col-sm-6">
    {!! Form::label('rec_time', 'Year Of Receipt:') !!}
    {!! Form::text('rec_time', null, ['class' => 'form-control']) !!}
</div>


<!-- Points Avail Field -->
<div class="form-group col-sm-6">
    {!! Form::label('points_avail', 'Points Avail:') !!}
    {!! Form::text('points_avail', null, ['class' => 'form-control']) !!}
</div>

<!-- Views Field -->
<div class="form-group col-sm-6">
    {!! Form::label('views', 'Views:') !!}

    {!! Form::number('views', null, ['class' => 'form-control']) !!}

</div>
<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    <select class="form-control" name="status">
    @foreach(\App\Enums\StatusEnum::values() as $key => $case)
            <option value="{{$case}}">{{$key}}</option>
        @endforeach
    </select>
</div>

<div class="card-header mb-3 mt-3 col-12">
    <h4 class="mb-0" style="color: gray;"> Ad Advantages</h4>
</div>

<div class="col-md-12 mb-3">
    {!! Form::label('perpert_id', 'Advantages:') !!}
    <input id="chkall" type="checkbox" class="ml-3">
    {!! Form::label('chkall', 'Select All:') !!}
    <select class="select2  select2-multiple" style="width: 100%" multiple="multiple" name="feature_id[]"
            data-placeholder="Choose" id="selecttested">
        @if(!empty($mzaya))
            @foreach($mzaya as $use)
                <option value="{{$use->id}}"
                        @if(!empty($mzayaAqar))@foreach($mzayaAqar as $gt) @if($gt->mzaya_id == $use->id)
                            selected @endif @endforeach @endif>{{$use->mzaya_type}}</option>
            @endforeach
        @endif
    </select>
</div>


<!--



    <div class="col-md-12 mb-3">
    <div class=:form-group>
        <label>Message</label>
        <select class="form-control" name="notif">
            <option selected value="1">تم قبول اعلانك</option>
            <option value="2">تم الرفض</option>

        </select>
    </div>
</div>



-->


<div class="card-header mb-3 mt-2 col-12">
    <h4 class="mb-0" style="color: gray;"> Ad Images</h4>
</div>
<div class="col-md-7">
    <label class="font-bold">
        <h4>Images<span style="color: red">*</span></h4>
    </label>
</div>
<div class="col-md-3">
    <a class="btn btn-danger waves-effect waves-light addimg">
        <i class="fas fa-plus"></i>
        <i class="fas fa-image"></i>
    </a>
</div>
<div class="clearfix"></div>
<div class="imagesmore col-sm-12">
</div>
<div class="row mt-3">
    @if(!empty($aqar->Images))
        @foreach($aqar->Images as $img)
            <div class="col-md-3 mt-3">

                <div class="col-md-8 ml-4">
                    <input type="text" @if($img->main_img == 1) value="Main Image" @else value="normal Image" @endif
                    class="form-control" style="text-align: center;" readonly>
                </div>

                <a href="#">
                    <div class="img-thumbnail text-center">
                        @if(!empty($img->img_url))
                            <a href="{{url('https://rightchoice-co.com/public/images/'.$img->img_url)}}"
                               data-toggle="lightbox">
                                <img src="{{url('https://rightchoice-co.com/public/images/'.$img->img_url)}}"
                                     width="100%" height="140"/>
                            </a>
                        @endif

                        <a onclick="return confirm('Are You Sure You Want To Delete This Record ?')"
                           href="{{url('/RemoveImageAqar')}}/{{$img->id}}"
                           class="btn waves-effect  waves-light btn-danger"
                           style="padding: 0.375rem 2.36rem; font-size: .875rem; border-radius: 0;">
                            <i class="far fa-trash-alt"> delete</i>
                        </a>
                    </div>
                </a>
            </div>
        @endforeach
    @endif
</div>


@if(@$activity_logs)
<div class="row mt-3">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                    type="button" role="tab" aria-controls="pills-home" aria-selected="true">سجلات النشاط
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                    type="button" role="tab" aria-controls="pills-profile" aria-selected="false">اترك تعليقك
            </button>
        </li>

    </ul>
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
             tabindex="0">
            @include('activity_log.index')
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
            @include('activity_log.create')
        </div>
    </div>
</div>
@endif
