<!-- Id Field -->
<div class="col-sm-6">
    {!! Form::label('id', 'Id:') !!}
    <p>{{ $jobTitle->id }}</p>
</div>

<!-- Job Title Arabic Field -->
<div class="col-sm-6">
    {!! Form::label('Job_title', 'المسمى الوظيفي:') !!}
    <p>{{ $jobTitle->Job_title }}</p>
</div>

<!-- Job Title English Field -->
<div class="col-sm-6">
    {!! Form::label('Job_title_en', 'Job Title (English):') !!}
    <p>{{ $jobTitle->Job_title_en }}</p>
</div>

<!-- Created At Field -->
<div class="col-sm-6">
    {!! Form::label('created_at', 'تاريخ الإنشاء:') !!}
    <p>{{ $jobTitle->created_at }}</p>
</div>

<!-- Updated At Field -->
<div class="col-sm-6">
    {!! Form::label('updated_at', 'آخر تحديث:') !!}
    <p>{{ $jobTitle->updated_at }}</p>
</div>
