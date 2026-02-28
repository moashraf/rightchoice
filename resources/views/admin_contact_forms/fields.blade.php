<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'الاسم:') !!} <span class="text-danger">*</span>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('name') }}</small>
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'الهاتف:') !!} <span class="text-danger">*</span>
    {!! Form::text('phone', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('phone') }}</small>
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'البريد الإلكتروني:') !!} <span class="text-danger">*</span>
    {!! Form::text('email', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('email') }}</small>
</div>

<!-- Subject Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subject', 'الموضوع:') !!} <span class="text-danger">*</span>
    {!! Form::text('subject', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('subject') }}</small>
</div>

<!-- Body Field -->
<div class="form-group col-sm-12">
    {!! Form::label('body', 'الرسالة:') !!} <span class="text-danger">*</span>
    {!! Form::textarea('body', null, ['class' => 'form-control']) !!}
    <small class="text-danger">{{ $errors->first('body') }}</small>
</div>

<div class="clearfix"></div>
