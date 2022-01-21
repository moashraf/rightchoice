<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!} <span class="text-danger">*</span>
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('title') }}</small>
</div>
 <div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!} <span class="text-danger">*</span>
    {!! Form::select('status', ['Active','Un Active'] ,null,['class'=>'form-control']) !!} 
    <small class="text-danger">{{ $errors->first('status') }}</small>   
</div>
 <!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!} <span class="text-danger">*</span>
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('description') }}</small>
</div>

<!-- Seo Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('seo_title', 'Seo Title:') !!} <span class="text-danger">*</span>
    {!! Form::text('seo_title', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('seo_title') }}</small>
</div>

<!-- Slug Field -->
<div class="form-group col-sm-6">
    {!! Form::label('slug', 'Slug:') !!} <span class="text-danger">*</span>
    {!! Form::text('slug', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('slug') }}</small>
</div>


<!-- Meta Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('meta_description', 'Meta Description:') !!} <span class="text-danger">*</span>
    {!! Form::textarea('meta_description', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('meta_description') }}</small>
</div>

<!-- Canonical Field -->
<div class="form-group col-sm-4">
    {!! Form::label('canonical', 'Canonical:') !!} <span class="text-danger">*</span>
    {!! Form::text('canonical', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('canonical') }}</small>
</div>

<!-- Number Of Visits Field -->
<div class="form-group col-sm-4">
    {!! Form::label('number_of_visits', 'Number Of Visits:') !!} <span class="text-danger">*</span>
    {!! Form::number('number_of_visits', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('number_of_visits') }}</small>
</div>

<!-- Sort Num Field -->
<div class="form-group col-sm-4">
    {!! Form::label('sort_num', 'Sort Num:') !!} <span class="text-danger">*</span>
    {!! Form::number('sort_num', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('sort_num') }}</small>
</div>


<!-- Main Img Alt Field -->
<div class="form-group col-sm-6 mt-3">
    {!! Form::label('main_img_alt', 'Main Img Alt:') !!} <span class="text-danger">*</span>
    {!! Form::file('main_img_alt', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('main_img_alt') }}</small>
</div>

<!-- Single Photo Field -->
<div class="form-group col-sm-6 mt-3">
    {!! Form::label('single_photo', 'Single Photo:') !!} <span class="text-danger">*</span>
    {!! Form::file('single_photo', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('single_photo') }}</small>
</div>