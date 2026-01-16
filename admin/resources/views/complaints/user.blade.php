
text/x-generic show.blade.php 
@extends('layouts.app')
@section('title', 'Complaints Details')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>تفاصيل المستخدم</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ url()->previous() }}">
                        رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">

            <div class="card-body">
                <div class="row">
                   <!-- Id Field -->
                    <div class="col-sm-12">
                      {!! Form::label('created_at', ' User Id:') !!}  
                        <p>{{ $user->id }}</p>
                    </div>
                    
                    <!-- User Id Field -->
                    <div class="col-sm-12">
                        {!! Form::label('created_at', ' User Name:') !!} 
                        <p>{{ $user->name }}</p>
                    </div>
                    
                    <!-- Aqar Id Field -->
                    <div class="col-sm-12">
                         {!! Form::label('created_at', ' User Email:') !!}
                        <p>{{ $user->email }}</p>
                    </div>
                    
                    <!-- Message Field -->
                    <div class="col-sm-12">
                        {!! Form::label('created_at', ' User Phone:') !!}
                        <p>{{ $user->MOP }}</p>
                    </div>
                    <!--<div class="col-sm-12">-->
                    <!--    {!! Form::label('created_at', 'User Age:') !!} -->
                    <!--    <p>{{ $user->AGE }}</p>-->
                    <!--</div>-->
                    
                    
                    <!-- Created At Field -->
                    <div class="col-sm-12">
                        {!! Form::label('created_at', 'Created At:') !!}
                        <p>{{ $user->created_at->toDayDateTimeString() }}</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection