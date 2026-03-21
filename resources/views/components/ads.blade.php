@props(['randomAds' => null])

@isset($randomAds)
<div class="ads_show">
    <a target="_blank" href="{{ $randomAds->name }}">
        <img src="{{ URL::to('/').'/images/'.$randomAds->img }}" class="image-fluid w-100 mx-auto mb-5"
             style=" max-height: 300px;" alt="">
    </a>
</div>
@endisset
