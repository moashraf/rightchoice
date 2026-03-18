<x-layout>
    @section('title')
        {{ $blog->title ?? 'مقال غير موجود' }}
    @endsection
    <br>
    <br><br>
    <section class="article-inner">
        <div class="container">
            @if($blog)
            <div class="row">
                <div class="col-lg-4">
                </div>
                <div class="col-lg-8 col-md-12">
                    <div class="adv-slider" id="section-slider">
                        <div class="single-items"><img
                                src="<?php if (isset($blog)){echo URL::to('/').'/images/'.$blog->single_photo  ;} ?>"
                                class="img-fluid" alt=""></div>

                    </div>
                </div>
            </div>
            <div class="portfolio-description">
                <h3 clsass="description_title">
                    {{ $blog->title }}
                </h3>
                <p class="description_description">
                    {{ $blog->description }}
                </p>
            </div>

            <x-call-to-action/>
            @else
            <div class="row">
                <div class="col-12 text-center py-5">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h4>عذراً، هذا المقال غير موجود أو تم حذفه.</h4>
                        <a href="{{ url('/') }}" class="btn btn-primary mt-3">العودة للرئيسية</a>
                    </div>
                </div>
            </div>
            @endif
        </div>


    </section>


</x-layout>
