

<section class="bg call-to-act-wrap">

			<div class="container">

				<div class="row clltoAct">



					<div class="col-lg-5"><img width="70%" src="{{ asset('/assets/img/4740491.jpg') }}" height="90%" alt="">

					</div>

					<div class="col-lg-7">

						<br><br>

						<div class="call-to-act">

							<div style="text-align: center;" class="call-to-act-head">

								<h3 class="headingTitle2">
							التصوير الاحترافي للعقارات	
								<p class="mt-3">
								    
								    
								    رايت تشويز توفر لك فريق احترافي مع أفضل معدات الإضاءة والتصوير، لإظهار عقارك في أبهى صورة
								    
								    	</p>

								<a style="text-align: center" class="btn btn-call-to-act mt-3" id="trigger-3">{{ trans('langsite.subscribe_nw')}}</a>





							</div>



						</div>



					</div>



				</div>

			</div>

		</section>



		<div id="overlay-3">



			<div id="popup-3" style="height: auto !important; max-height: 600px !important;">
	
	
	
				<div id="close-3">X</div>
	
	
	
			
	
	
	
				<div class="mt-3">
	
	
						<form>
						     <div class="row">

							 <div class="col form-group">
								 <input type="text" name="user_session_phone" class="form-control" id="phone" placeholder="الهاتف"
									 required  @if(Auth::check()) value="{{ Auth::user()->MOP }}" @else value="{{ old('phone') }}" @endif>
								 @error('phone')
									 <p class="text-danger text-sm mt-1"> {{ $message }} </p>
								 @enderror
 
							 </div>
							 <div class="col form-group">
								 <input type="text" name="user_session_name" class="form-control" id="name" placeholder="الاسم"
									 required @if(Auth::check()) value="{{ Auth::user()->name }}" @else value="{{ old('user_name') }}" @endif>
								 @error('user_name')
									 <p class="text-danger text-sm mt-1"> {{ $message }} </p>
								 @enderror
 
							 </div>
						
    					 	 <div class="form-group">
    							 <input type="email" class="form-control" name="user_session_email" id="email"
    								 placeholder="البريد الاكتروني" required @if(Auth::check()) value="{{ Auth::user()->email }}" @else value="{{ old('email') }}" @endif>
    							 @error('email')
    								 <p class="text-danger text-sm mt-1"> {{ $message }} </p>
    							 @enderror
     
    						 </div>
    						 <div class="form-group">
    							 <input type="text" class="form-control" name="user_session_address" id="subject" placeholder="عنوان العقار"
    								 value="{{ old('address') }}"   required>
    							 @error('address')
    								 <p class="text-danger text-sm mt-1"> {{ $message }} </p>
    							 @enderror
     
    						 </div>
    						 <div class="form-group">
    							 <textarea  class="form-control" name="session_description" rows="5" placeholder="تفاصيل العقار المطلوب تصويره"
    								 required>{{ old('description') }}</textarea>
    							 @error('description')
    								 <p class="text-danger text-sm mt-1"> {{ $message }} </p>
    							 @enderror
     
    						 </div>
						 </div>
				
						 <div class="text-center">
					 	
	                         <a href="#" type="button" class="btn btn-primary  ml-2 SendUserSession" >ارسل</a>
	                     </div>
						</form>
	
				</div>
	
	
	
			</div>
	
	
	
		</div>
	