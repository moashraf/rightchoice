<ul class="list-group">
  <li class="list-group-item" style="background-color:#343a40; color:#fff; font-weight:bold;"> User Details </li>

 <ul class="list-group ">
    @if($user->name)
    <li class="list-group-item">{!! Form::label('name', 'User name:') !!}  {{$user->name}}</li>
    @endif

    @if($user->email)
    <li class="list-group-item">{!! Form::label('email', 'Email:') !!}  {{ $user->email }}</li>
    @endif

    @if($user->MOP)
    <li class="list-group-item">{!! Form::label('MOP', 'Mobile:') !!}  {{ $user->MOP }}</li>
    @endif

    @php
        $ageOptions = [
            1 => 'From 18 - to 25',
            2 => 'From 26 to 35',
            3 => 'From 36 to 45',
            4 => 'From 46 to 60',
            5 => 'More than 60'
        ];
    @endphp
    @if($user->AGE && array_key_exists($user->AGE, $ageOptions))
    <li class="list-group-item">{!! Form::label('AGE', 'Age:') !!}
        <span>{{ $ageOptions[$user->AGE] }}</span>
    </li>
    @endif

    @if($user->TYPE)
    <li class="list-group-item">{!! Form::label('TYPE', 'Type Of User:') !!}
        {{ $user->getUserType() }}
    </li>
    @endif

    <li class="list-group-item">{!! Form::label('status', 'Status:') !!}  {{ $user->status ? 'Active' : 'Un Active' }}</li>

    @if($user->current_points)
    <li class="list-group-item">{!! Form::label('current_points', 'points:') !!}  {{ $user->current_points }}</li>
    @endif

    @if($user->invited_by)
    <li class="list-group-item">{!! Form::label('invited_by', 'تم الدعوة بواسطة:') !!}  {{ $user->invited_by }}</li>
    @endif

    @if($user->phone_sms_otp)
    <li class="list-group-item">{!! Form::label('phone_sms_otp', 'OTP Code:') !!}  {{ $user->phone_sms_otp }}</li>
    @endif

    @if($user->Employee_Name)
    <li class="list-group-item">{!! Form::label('Employee_Name', 'Employee Name:') !!}  {{ $user->Employee_Name }}</li>
    @endif

    @if($user->Job_title)
    <li class="list-group-item">{!! Form::label('Job_title', 'Job Title:') !!}
        <span>
            @if($user->Job_title == 1)
                صاحب عمل
            @elseif($user->Job_title == 2)
                مدير عام
            @elseif($user->Job_title == 3)
                مدير تسويق
            @elseif($user->Job_title == 4)
                مدير فرع
            @endif
        </span>
    </li>
    @endif

    @if($user->Commercial_Register)
    <li class="list-group-item">{!! Form::label('Commercial_Register', '  company:') !!}  {{ $user->Commercial_Register }}</li>
    @endif

    @if($user->Tax_card)
    <li class="list-group-item">{!! Form::label('Tax_card', 'Tax Card:') !!}  {{ $user->Tax_card }}</li>
    @endif

</ul>
