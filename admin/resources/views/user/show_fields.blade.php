<ul class="list-group">
  <li class="list-group-item" style="background-color:#343a40; color:#fff; font-weight:bold;"> User Details </li>

 <ul class="list-group ">
  <li class="list-group-item">{!! Form::label('name', 'User name:') !!}  {{$user->name}}</li>
    <li class="list-group-item">{!! Form::label('email', 'Email:') !!}  {{ $user->email }}</li>
  <li class="list-group-item">{!! Form::label('MOP', 'Mobile:') !!}  {{ $user->MOP }}</li>
     <li class="list-group-item">{!! Form::label('AGE', 'Age:') !!}
         <span>
        @php
            $ageOptions = [
                1 => 'From 18 - to 25',
                2 => 'From 26 to 35',
                3 => 'From 36 to 45',
                4 => 'From 46 to 60',
                5 => 'More than 60'
            ];
        @endphp

             @if ($user->AGE && array_key_exists($user->AGE, $ageOptions))
                 {{ $ageOptions[$user->AGE] }}
             @else
                 Not specified
             @endif
    </span>
     </li>


     <li class="list-group-item">{!! Form::label('TYPE', 'Type Of User:') !!}
         {{ $user->getUserType() ?: 'Not specified' }}
     </li>




    <li class="list-group-item">{!! Form::label('status', 'Status:') !!}  {{ $user->status ? 'Active' : 'Un Active' }}</li>
    <li class="list-group-item">{!! Form::label('current_points', 'points:') !!}  {{ $user->current_points }}</li>
    <li class="list-group-item">{!! Form::label('invited_by', 'تم الدعوة بواسطة:') !!}  {{ $user->invited_by ? $user->invited_by : 'غير محدد' }}</li>
    <li class="list-group-item">{!! Form::label('phone_sms_otp', 'OTP Code:') !!}  {{ $user->phone_sms_otp ?? 'غير متاح' }}</li>

</ul>
