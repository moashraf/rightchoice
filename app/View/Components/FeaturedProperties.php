<?php

namespace App\View\Components;

use App\Models\aqar;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class FeaturedProperties extends Component
{
    public Collection $properties;
    public string $title;
    public string $subtitle;
    public string $locale;
    public bool $isEnglish;
    public string $viewAllUrl;

    public function __construct(
        int $limit = 6,
        ?int $excludeUserId = null,
        ?string $title = null,
        ?string $subtitle = null
    ) {
        $this->locale    = app()->getLocale() ?: 'ar';
        $this->isEnglish = $this->locale === 'en';

        $this->title = $title
            ?? ($this->isEnglish ? 'Featured Properties' : 'عقارات مميزة مختارة لك');

        $this->subtitle = $subtitle
            ?? ($this->isEnglish
                ? 'Handpicked premium properties with active promotions.'
                : 'مجموعة مختارة من أفضل العقارات المميزة حاليًا على الموقع.');

        $this->viewAllUrl = url($this->locale . '/featured-properties');

        $query = aqar::query()
            ->where('status', 1)
            ->where('vip', 1)
            ->whereNotNull('vip_expires_at')
            ->where('vip_expires_at', '>', now())
            ->with(['mainImage', 'firstImage', 'offerTypes', 'governrateq', 'districte'])
            ->orderByDesc('vip_started_at')
            ->orderByDesc('id')
            ->limit(max(1, $limit));

        if ($excludeUserId) {
            $query->where('user_id', '!=', $excludeUserId);
        }

        $this->properties = $query->get()->map(function (aqar $property) {
            $offer   = $property->offerTypes;
            $offerId = (int) optional($offer)->id;

            $price = in_array($offerId, [3, 4], true)
                ? $property->monthly_rent
                : $property->total_price;

            $image = $property->mainImage
                ? url('/images/' . $property->mainImage->img_url)
                : ($property->firstImage
                    ? url('/images/' . $property->firstImage->img_url)
                    : asset('images/FBO.png'));

            $title = ($this->isEnglish && $property->title_en ? $property->title_en : $property->title)
                ?: ($this->isEnglish ? 'Property details' : 'تفاصيل العقار');

            $offerName = ($this->isEnglish && optional($offer)->type_offer_en
                    ? $offer->type_offer_en
                    : optional($offer)->type_offer)
                ?: ($this->isEnglish ? 'Property' : 'عقار');

            $property->setAttribute('featured_price', $price);
            $property->setAttribute('featured_has_price', is_numeric($price) && (float) $price > 0);
            $property->setAttribute('featured_image', $image);
            $property->setAttribute('featured_title', $title);
            $property->setAttribute('featured_offer_name', $offerName);
            $property->setAttribute('featured_url', url($this->locale . '/aqars/' . $property->slug));

            return $property;
        });
    }

    public function render(): View
    {
        return view('components.featured-properties');
    }
}
