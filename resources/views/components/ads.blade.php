@isset($random_ads)
<div class="ads_show">
    <a target="_blank" href="{{  $random_ads->name  }}">
        <img src="{{ URL::to('/').'/images/'.$random_ads->img}}" class="image-fluid w-100 mx-auto mb-5"
             alt="">
    </a>
</div>
@endisset
