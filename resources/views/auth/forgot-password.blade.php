<x-layout>
   <section id="register"  class="bg-light">
        <div class="container mt-5 mb-5" id="login-form">
            <div class="row">
                 <div class="col-lg-6">
                   <div class="card auth-card shadow-lg">
                    <div class="card-body">
                        <x-slot name="logo">
                            <!--<x-jet-authentication-card-logo />-->
                        </x-slot>
                
                        <div class="mb-4 text-sm text-gray-600">
                    نسيت رقمك السري؟ لا مشكلة. فقط أخبرنا بعنوان بريدك الإلكتروني  او رقم هاتفك وسنرسل لك رابط إعادة تعيين كلمة المرور عبر البريد الإلكتروني الذي سيسمح لك باختيار رقم سري جديد.
                        </div>
                
                        @if (session('status'))
                            <div class="mb-4 font-medium text-sm text-green-600">
                                {{ session('status') }}
                            </div>
                        @endif
                
                        <x-jet-validation-errors class="mb-4" />
                
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                
                            <!--<div class="block">-->
                            <!--    <x-jet-label for="email" value="{{ __('Email') }}" />-->
                            <!--    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />-->
                            <!--</div>-->
                            <div class="form-group">
								<label for="exampleInputEmail1"> البريد الإلكترونى او الهاتف</label>
								<input  oninvalid="this.setCustomValidity('Please enter a valid phone or email')"
                                     oninput="this.setCustomValidity('')" type="text" name="email" :value="old('email')" required  class="form-control" id="email" aria-describedby="emailHelp"  required autofocus>
							  </div>
                
                            <!--<div class="flex items-center justify-end mt-4">-->
                            <!--    <x-jet-button>-->
                            <!--        {{ __('Email Password Reset Link') }}-->
                            <!--    </x-jet-button>-->
                            <!--</div>-->
                            	<button type="submit" class="btn btn-primary">إرسال</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
