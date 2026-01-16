<x-layout>


 @section('title')
    تواصل معنا
@endsection


    <div class="image-cover hero-banner single-items" style="background:url('{{asset('assets/img/contact.jpeg')}}') no-repeat;" loading="lazy">
        <div class="container">
            <div class="row">



                <div class="col-lg-12 col-md-12">

                    <div class="hero__p">
                        <h1>تواصل معنا</h1>

                        <p>
                            
                            اول موقع متميز في مصر من البائع للمشتري مباشر بدون
								عمولات وخدمات متكاملة مع افضل الشركات
                      </p>
                    </div>
                </div>
            </div>

        </div>
    </div>




    <!-- ======= Featured Services Section ======= -->
    <section id="featured-services" class="featured-services bg-light">
        <div class="container" data-aos="fade-up">
            <h1>تواصل معنا</h1>
       
            <div class="row mt-3">
                <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                        <div class="icon"><i class="ti ti-location-pin"></i></div>
                        <h4 class="title"><a href="#">العنوان</a></h4>
                        
                        <p   style=" font-weight: 100; font-size: 14px;" class="title   " >
                           <a href="#">  

                         <i class="ti ti-location-pin"></i>
                        
  محافظه القاهره , المعادي , دجله شارع 216 عماره 17 الدور الثاني فيلا 1                       
                       </a>
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                        <div class="icon"><i class="fa fa-phone"></i></div>
                        <h4 class="title"><a href="#">الهاتف</a></h4>
                        <p  style=" font-weight: 100; font-size: 14px;" class="title   " >
                              <a href="https://wa.me/0201060660079">
                                  <i style="padding:5px;" class="fab fa-whatsapp"></i>
                                  02-01060660079
                                  </a>
                              </p>
                        <p  style=" font-weight: 100; font-size: 14px;" class="title   ">
                        <a     href="tel:02-25196690">
                            <i style="padding:5px;" class="fa fa-phone"></i>
                            02-25196690
                            </a>
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 d-flex align-items-stretch mb-5 mb-lg-0">
                    <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                        <div class="icon"><i class="far fa-gem"></i></div>
                        <h4 class="title"><a href="#">البريد الالكتروني</a></h4>
                        <p   style=" font-weight: 100; font-size: 14px;" class="title   ">
                            <a   style=" font-weight: 100; font-size: 14px;" class="title   "href="mailto:info@rightchoice-co.com">
                                <i style="padding:5px;" class="fa fa-envelope"></i>
                                info@rightchoice-co.com  
                                </a>
                        </p>
                        <p   style=" font-weight: 100; font-size: 14px;" class="title   ">
                              <a href="mailto:sales@rightchoice-co.com">
                                  <i style="padding:5px;" class="fa fa-envelope"></i>
                                  sales@rightchoice-co.com
                                  </a>
                              </p>
                    </div>
                </div>



            </div>

        </div>
    </section><!-- End Featured Services Section -->

    <section id="contact" class="contact">
        <div class="container">
            <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <p>في حاله وجود استفسار او شكاوي يرجى التواصل بالاتي</p>

                <div class="col-lg-6 ">
              
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3456.576291485883!2d31.272069015113182!3d29.962863881912057!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xafd8aad70a777b1a!2zMjnCsDU3JzQ2LjMiTiAzMcKwMTYnMjcuMyJF!5e0!3m2!1sen!2seg!4v1637516409251!5m2!1sen!2seg"
          width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
              
                </div>

                <div class="col-lg-6">
                    <form style="max-height:400px" action="{{ Route('contact-info') }}" method="post" role="form" class="php-email-form">
                       
                       @csrf
                        <div class="row">


                            <div class="col form-group">
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="الهاتف"
                                    required>
                                @error('phone')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror

                            </div>
                            <div class="col form-group">
                                <input type="text" {{ old('name') }} name="name" class="form-control" id="name" placeholder="الاسم"
                                    required>
                                @error('name')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="البريد الاكتروني" required value="{{ old('email') }}">
                            @error('email')
                                <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                            @enderror

                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="الموضوع"
                                value="{{ old('subject') }}"   required>
                            @error('subject')
                                <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                            @enderror

                        </div>
                        <div class="form-group">
                            <textarea value="{{ old('body') }}" class="form-control" name="body" rows="5" placeholder="الرساله"
                                required></textarea>
                            @error('body')
                                <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                            @enderror

                        </div>
                        <div class="my-3">
                            <div class="error-message"></div>
                            <div class="sent-message">تم ارسال الرساله بنجاح</div>
                        </div>
                        <div class="text-center"><button class="btn btn-primary" type="submit">ارسل</button></div>
                    </form>
                </div>

            </div>
        </div>
    </section>



</x-layout>
