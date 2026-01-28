<!-- Img Url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('img_url', 'Img Url:') !!}
    {!! Form::text('img_url', null, ['class' => 'form-control']) !!}
</div>

<!-- Main Img Field -->
<div class="form-group col-sm-6">
    {!! Form::label('main_img', 'Main Img:') !!}
    {!! Form::text('main_img', null, ['class' => 'form-control']) !!}
</div>

<!-- Aqar Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('aqar_id', 'Aqar Id:') !!}
    {!! Form::select('aqar_id', ['' => ''], null, ['class' => 'form-control custom-select']) !!}
</div>
