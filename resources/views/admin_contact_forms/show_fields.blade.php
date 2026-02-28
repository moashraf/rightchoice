<!-- Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('id', 'ID:') !!}
    <p>{{ $contactForm->id }}</p>
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'الاسم:') !!}
    <p>{{ $contactForm->name }}</p>
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'الهاتف:') !!}
    <p>{{ $contactForm->phone }}</p>
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'البريد الإلكتروني:') !!}
    <p>{{ $contactForm->email }}</p>
</div>

<!-- Subject Field -->
<div class="form-group col-sm-6">
    {!! Form::label('subject', 'الموضوع:') !!}
    <p>{{ $contactForm->subject }}</p>
</div>

<!-- Body Field -->
<div class="form-group col-sm-12">
    {!! Form::label('body', 'الرسالة:') !!}
    <p>{{ $contactForm->body }}</p>
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'تاريخ الإرسال:') !!}
    <p>{{ $contactForm->created_at }}</p>
</div>
