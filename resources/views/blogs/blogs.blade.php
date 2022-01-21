<x-layout>
    
    
     @section('title')
المقالات
    @endsection
   <div class="image-cover hero-banner" style="background:url('{{ asset('assets/img/NoPath.png')}}') no-repeat;">

      <div class="container">

         <div class="row">

            

            



            <div class="col-lg-12 col-md-12">

             

               <div class="hero__p">

                  <h1>

                      

                      

                                    المقالات
                      

                      

                      

                  </h1>

                   

                  <p>
                      كل ما يهمك في مجال العقارات، الأخبار والأسعار وأهم التطورات في مجال العقارات والتسويق العقاري، ستجده هنا
                  </p>

               </div>

            </div>

         </div>

         

      </div>

   </div>
  

           



<section class="articels" dir="rtl">





    



   <div class="container">



	<h2>جميع المقالات</h2>

   
          
               
                     
                     
                     <br>
                     <br>
                     
    <div class="row">
@foreach($allBlogs as $blog)
<div class="col-lg-4 mt-3">



<a href="{{ URL::to(Config::get('app.locale') .'/blogs').'/'.$blog->slug }}">



<div class="box">



      <img src="{{ asset('/images').'/'.$blog->single_photo }}" class="img-fluid" alt="">



      <h3>{{ $blog->title }}</h3>



      <p></p>



    </div>



</a>



 </div> 
@endforeach

</div>






          {{ $allBlogs->links() }}  

</div>



</section>





    
</x-layout>