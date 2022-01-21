<x-layout>
     @section('title')
        {{ $blog->title }}
    @endsection
    <br>
<br><br>
        <section class="article-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                </div>
                <div class="col-lg-8 col-md-12">
                  <div class="adv-slider" id="section-slider">
                      <div class="single-items"><img src="<?php if (isset($blog)){echo URL::to('/').'/images/'.$blog->single_photo  ;} ?>"  class="img-fluid" alt=""></div> 

                  </div>
                </div>
            </div>
            <div class="portfolio-description">
                <h3>
{{ $blog->title }}         
</h3>
                <p>


                             {{ $blog->description }}   


                </p>
            </div>
    
        <x-call-to-action />
        </div>
        
        
    </section>
    

</x-layout>