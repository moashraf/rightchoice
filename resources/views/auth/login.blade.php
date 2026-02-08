<x-layout>
 @section('title')
    تسجيل دخول
    @endsection
<section id="register" class="bg-light">

    <br>
    <br>
    <br>
    <br>
                <div class="container" id="login-form">
                   <div class="row">
					   <div class="col-lg-4">


					            @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
						<form method="POST" action="{{ route('customLoginManual' , Config::get('app.locale') ) }}" >
                          @csrf
							<div class="form-group">
								<label for="exampleInputEmail1">البريد الالكنروني / الهاتف</label>
                                <input
                                    type="text"
                                    name="email"
                                    :value="old('email')"
                                    required
                                    class="form-control"
                                    id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    placeholder="email or phone"
                                    oninvalid="this.setCustomValidity('Please enter a valid phone or email')"
                                    oninput="this.setCustomValidity('')"
                                    pattern="^(?:01\d{9}|[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$"
                                />

                            </div>



							<div class="form-group">
							  <label for="exampleInputPassword1">كلمه المرور</label>
							  <input  type="password" name="password" required  class="form-control passwordInput" id="exampleInputPassword1" placeholder="كلمه المرور">
							   <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
							</div>
							<div class="" style="width: 20%;">
								<input name="remember"  class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
								<label class="form-check-label mr-4" for="flexCheckDefault">
								  تذكرني
								</label>
							  </div>
							<p>

							      @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        <!--{{ __('Forgot your password?') }}-->
                        نسيت كلمة المرور ؟
                    </a>
                @endif



 							</p>


							<button type="submit" class="btn btn-primary">الدخول</button>

							<P style="text-align: center;"><a href="{{ route('register', Config::get('app.locale')) }} ">ليس لديك حساب؟مستخدم جديد</a></P>
						  </form>
					   </div>
					   <x-jet-validation-errors class="mb-4 error-box"  />
				   </div>
                </div>



            </section>


            <x-adv-slider/>
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
