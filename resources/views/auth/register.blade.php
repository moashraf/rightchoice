<x-layout>

 @section('title')
        تسجيل مستخدم جديد
    @endsection

    <section id="register" class="bg-light">



        <div class="container">
 
            <div class="row">



             

                <div class="col-lg-8">



                    <h2 style="font-weight: bold;" class="mb-5">سجل الان مجانا</h2>
 


                    @if (count($errors) > 0)



                    <ul style="
  COLOR: red;
  font-size: 20px;">



                        @foreach ($errors->all() as $error)



                        <li>{{ $error }}</li>



                        @endforeach



                    </ul>



                    @endif











                    <form method="POST" action="{{ route('custom_register', Config::get('app.locale')) }}" autocomplete="off" >



                        @csrf





                        <div class="row">



                            <div class="col-lg-6">

                                <div class="form-group">



                                    <label for="name">   
                                    
                                    الاسم الكامل 
                                    <span class="text-danger">*</span>
                                    </label>



                                    <input  oninvalid="this.setCustomValidity('   برجاء ادخال    الاسم     ')" oninput="this.setCustomValidity('')" 
                                    name="name" autocomplete="off"   value="{{ old('name') }}" required autofocus type="text"
                                        class="myselect" id="name" aria-describedby="" >

                                </div>
                            </div>





                            <div class="col-lg-6">



                                <div class="form-group">



                                    <label for="email">   
                                    البريد الالكتروني
                                                                        <span class="text-danger">*</span>

                                    </label>



                                    <input  
                                    oninvalid="this.setCustomValidity('   برجاء ادخال    البريد     ')" oninput="this.setCustomValidity('')"
                                    type="email" name="email" value="{{ old('email') }}" required
                                        class="myselect"  autocomplete="off" id="email" aria-describedby="emailHelp" 
                                       >



                                </div>









                            </div>

                        </div>









                        <div class="row">







                            <div class="col-lg-6">



                                <div class="form-group">



                                    <label for="user-type">
                            
                                        نوع المستخدم
                                        
                                        
                                                                            <span class="text-danger">*</span>

                                        </label>



                                    <select  
                                    oninvalid="this.setCustomValidity('   برجاء ادخال  نوع المستخدم    ')"
  oninput="this.setCustomValidity('')"
     autocomplete="off"  name="TYPE" id="user-type" class="myselect">


                                        <option value="">
أختار                                        </option>



 


                                        <option value="1">
                                            بائع او مؤجر
                                        </option>



                                        <option value="2">
                                            مشتري او مستأجر
                                        </option>



                                        <option value="3"> مطور عقاري </option>







                                    </select>



                                </div>



                            </div>
                    


    <div class="col-lg-6"> 

                        <div class="form-group  ">



                            <label name="phone" for="phone">
                                
                                رقم الهاتف
                                    <span class="text-danger">*</span></label>



                            <input  oninvalid="this.setCustomValidity('   برجاء ادخال    رقم الهاتف     ')" oninput="this.setCustomValidity('')"
                            required id="phone"  value="{{ old('MOP') }}" style="/* width:96% */" type="number" name="MOP"
                                class="myselect" />







                        </div>
    </div>



                        </div>














                        <div class="row" id="motwar" style="display:none;">
                            <div class="col-lg-4">

                                <div class="form-group {{ $errors->has('Employee_Name') ? ' has-error' : '' }}">
                                    <label for="employe">اسم الموظف المسئول<span class="text-danger">*</span></label>
                                    <input  type="text" name="Employee_Name" id="employe" class="form-control"
                                        value="">
                                    <small class="text-danger">{{ $errors->first('Employee_Name') }}</small>
                                </div>

                            </div>
                            
                            <div class="col-lg-4">
                                <div class="form-group {{ $errors->has('Job_title') ? ' has-error' : '' }}">
                                    <label for="employe-type">المسمى الوظيفي<span class="text-danger">*</span></label>
                                    <select class="myselect"  name="Job_title" id="employe-type">
                                        <option value="">اختر</option>
                                        <option value="1">صاحب عمل</option>
                                        <option value="2">مدير عام</option>
                                        <option value="3">مدير تسويق</option>
                                        <option value="4">مدير فرع</option>
                                        <option value="5">اخرى</option>
                                    </select>
                                    <small class="text-danger">{{ $errors->first('Job_title') }}</small>
                                </div>

                            </div>
                         
                         
                            <div class="col-lg-4">
                                <div class="form-group">

                                    <label for="togary-id">رقم السجل التجاري
                                                                        <span class="text-danger">*</span>

                                    </label>

                                    <input type="text"   autocomplete="off" name="Commercial_Register" id="togary-id" class="myselect">

                                </div>
                            </div>

                        </div>


                        <div class="row">



                            <div class="col-lg-6">





                                <div class="form-group">



                                    <label for="exampleInputPassword1">
                                        ادخل كلمه المرور
                                        
                                                                            <span class="text-danger">*</span></label>



                                    <input 
                                        oninvalid="this.setCustomValidity('   برجاء ادخال       كلمه  المرور مكونه من اكثر من 4 ارقام او احرف       ')" oninput="this.setCustomValidity('')"
                                        minlength="4" name="password" autocomplete="off"   required type="password" class="myselect passwordInput"
                                        id="exampleInputPassword1" placeholder="كلمه المرور">
							   <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>



                                </div>





                            </div>





                            <div class="col-lg-6">



                                <div class="form-group">



                                    <label for="exampleInputPassword1">
                                        اعد ادخال كلمه المرور
                                                                            <span class="text-danger">*</span></label>



                                    <input 
                                            
                                            oninvalid="this.setCustomValidity('   برجاء ادخال       كلمه  المرور مكونه من اكثر من 4 ارقام او احرف       ')" oninput="this.setCustomValidity('')"
                                            minlength="4" autocomplete="off"  name="password_confirmation" required type="password" class="myselect passwordInput"
                                                                                    id="exampleInputPassword1" >



                                </div>

                            </div>



                        </div>











                        <div class="form-check form-group">

<br>

                            <input oninvalid="this.setCustomValidity(' برجاء الضغط علي الموافقه علي الشروط والاحكام       ')" oninput="this.setCustomValidity('')"
                            required type="checkbox" class="form-check-input" name="check">




                            <label style="padding-right: 30px;" class="form-check-label" for="check">
                                          اوافق على
                                       <strong> <a target="_blank" href="{{ url(Config::get('app.locale').'/terms-conditions') }}">&nbsp;  شروط و احكام  &nbsp;  </a></strong>
موقع
Right Choice 

<span  id="termsCheckLabel"></span>
                                </label>



                        </div>
<br>
<div class="form-group">
                                           <label class="form-label"> </label>
                                                <div class="col-md-6">
                                                    <div class="caption-parent w-100" >
                                                            {!! NoCaptcha::display() !!}
                                                             <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
                                                    </div>
                                                
                                                </div>
                                        </div>
<br>
                        <button type="submit" class="btn our-btn">سجل</button>



                    </form>



                </div>

   <div class="col-lg-4">
 
<img src="{{asset('/images/03 (1).jpg')}}" alt="" style="  width: 100%;  padding-top: 25px;" >

 
                </div>



            </div>



        </div>







    </section>

    {!! NoCaptcha::renderJs() !!}
<style>
    .field-icon {
  float: left;
  margin-left: 10px;
  margin-top: -25px;
  position: relative;
  z-index: 2;
}
</style>


</x-layout>