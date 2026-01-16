@extends('layouts.app')
@section('title', 'المستخدمين')
@section('content')


    <ul class="list-group ">

  <li class="list-group-item" style="background-color:#343a40; color:#fff; font-weight:bold;"> User Details </li>
  <li class="list-group-item">{!! Form::label('id', 'User Id:') !!}  {{ $user->id }}</li> 

 <ul class="list-group ">
  <li class="list-group-item">{!! Form::label('name', 'User name:') !!}  {{$user->name}}</li>
    <li class="list-group-item">{!! Form::label('email', 'Email:') !!}  {{ $user->email }}</li>
  <li class="list-group-item">{!! Form::label('MOP', 'Mobile:') !!}  {{ $user->MOP }}</li>
    <li class="list-group-item">{!! Form::label('current_points', 'points:') !!}  {{ $user->current_points }}</li>

</ul>
@endsection

@push('page_scripts')
    <script>
        $(document).on('click', "#change_aqar_status_btn", function () {
            $("#change_aqar_status_form").attr('action', $(this).data('url'));
        })    
    </script>
@endpush


