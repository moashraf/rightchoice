
<!-- User Id Field -->
<div class="form-group col-sm-6">
       <a href="https://rightchoice-co.com/admin/public/user/<?php  echo $complaints->user_id ; ?>/edit" >
    {!! Form::label('user_id', 'User:') !!}
  </a>
     <select  name="user_id"  class="form-control custom-select">
                                             <option value="" >اختار </option> 

                                @foreach ($GetUsers as $user_val)
                                    <option value="{{ $user_val->id}}" <?php    if($complaints->user_id == $user_val->id) {echo 'selected' ;}  ?> >{{ $user_val->name }}</option>
    
                                @endforeach
                            </select>
                            
  
</div>

<!-- Aqar Id Field -->
<div class="form-group col-sm-6">
    
      <a href="https://rightchoice-co.com/admin/public/aqars/<?php  echo $complaints->aqars_id ; ?>/edit" >   Aqar  </a>
    {!! Form::select('aqars_id', $Getaqar, null, ['placeholder' => 'Please select ...','class' => 'form-control custom-select']) !!}
</div>

<!-- Message Field -->
<div class="form-group col-sm-6">
    {!! Form::label('message', 'Message:') !!}
    {!! Form::text('message', null, ['class' => 'form-control']) !!}
</div>