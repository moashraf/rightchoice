@include('SiteHomeOriginal')

<style>
    /* Active-slide animation layer */
    .rc-hero-slide::before {
        animation: none !important;
        transform: scale(1.02);
        will-change: transform;
    }

    .rc-hero-slide.slick-active::before {
        animation: rcActiveHeroZoom 8s cubic-bezier(.2, .7, .25, 1) both !important;
    }

    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-badge,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-title,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-subtitle,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-description,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-features,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-actions,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-search-card,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-benefits-bar {
        opacity: 0;
        will-change: opacity, transform;
    }

    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-badge,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-title,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-subtitle,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-description,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-features,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-actions,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-benefits-bar {
        transform: translate3d(0, 30px, 0);
    }

    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-search-card {
        transform: translate3d(-45px, 0, 0) scale(.985);
    }

    [dir="ltr"] .rc-hero-slider.slick-initialized .rc-hero-slide .rc-search-card {
        transform: translate3d(45px, 0, 0) scale(.985);
    }

    .rc-hero-slide.slick-active .rc-hero-badge,
    .rc-hero-slide.slick-active .rc-hero-title,
    .rc-hero-slide.slick-active .rc-hero-subtitle,
    .rc-hero-slide.slick-active .rc-hero-description,
    .rc-hero-slide.slick-active .rc-hero-features,
    .rc-hero-slide.slick-active .rc-hero-actions,
    .rc-hero-slide.slick-active .rc-benefits-bar {
        animation: rcHeroRevealUp .72s cubic-bezier(.22, 1, .36, 1) both !important;
    }

    .rc-hero-slide.slick-active .rc-search-card {
        animation: rcHeroCardRevealRtl .82s cubic-bezier(.22, 1, .36, 1) both !important;
    }

    [dir="ltr"] .rc-hero-slide.slick-active .rc-search-card {
        animation-name: rcHeroCardRevealLtr !important;
    }

    .rc-hero-slide.slick-active .rc-hero-badge { animation-delay: .08s !important; }
    .rc-hero-slide.slick-active .rc-hero-title { animation-delay: .16s !important; }
    .rc-hero-slide.slick-active .rc-hero-subtitle { animation-delay: .25s !important; }
    .rc-hero-slide.slick-active .rc-hero-description { animation-delay: .34s !important; }
    .rc-hero-slide.slick-active .rc-hero-features { animation-delay: .43s !important; }
    .rc-hero-slide.slick-active .rc-hero-actions { animation-delay: .54s !important; }
    .rc-hero-slide.slick-active .rc-search-card { animation-delay: .20s !important; }
    .rc-hero-slide.slick-active .rc-benefits-bar { animation-delay: .68s !important; }

    .rc-hero-slider.slick-initialized .rc-feature-item,
    .rc-hero-slider.slick-initialized .rc-benefit {
        opacity: 0;
        transform: translate3d(0, 12px, 0) scale(.97);
    }

    .rc-hero-slide.slick-active .rc-feature-item,
    .rc-hero-slide.slick-active .rc-benefit {
        animation: rcHeroItemPop .5s cubic-bezier(.2, .8, .2, 1) both;
    }

    .rc-hero-slide.slick-active .rc-feature-item:nth-child(1) { animation-delay: .52s; }
    .rc-hero-slide.slick-active .rc-feature-item:nth-child(2) { animation-delay: .60s; }
    .rc-hero-slide.slick-active .rc-feature-item:nth-child(3) { animation-delay: .68s; }
    .rc-hero-slide.slick-active .rc-benefit:nth-child(1) { animation-delay: .78s; }
    .rc-hero-slide.slick-active .rc-benefit:nth-child(2) { animation-delay: .85s; }
    .rc-hero-slide.slick-active .rc-benefit:nth-child(3) { animation-delay: .92s; }
    .rc-hero-slide.slick-active .rc-benefit:nth-child(4) { animation-delay: .99s; }

    .rc-hero-slide.slick-active .rc-primary-cta {
        animation: rcHeroCtaPulse 2.8s 1.2s ease-in-out infinite;
    }

    @keyframes rcActiveHeroZoom {
        from { transform: scale(1.02); }
        to { transform: scale(1.095); }
    }

    @keyframes rcHeroRevealUp {
        from { opacity: 0; transform: translate3d(0, 30px, 0); }
        to { opacity: 1; transform: translate3d(0, 0, 0); }
    }

    @keyframes rcHeroCardRevealRtl {
        from { opacity: 0; transform: translate3d(-45px, 0, 0) scale(.985); }
        to { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
    }

    @keyframes rcHeroCardRevealLtr {
        from { opacity: 0; transform: translate3d(45px, 0, 0) scale(.985); }
        to { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
    }

    @keyframes rcHeroItemPop {
        from { opacity: 0; transform: translate3d(0, 12px, 0) scale(.97); }
        to { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
    }

    @keyframes rcHeroCtaPulse {
        0%, 100% { box-shadow: 0 13px 32px rgba(19, 200, 155, .24); }
        50% { box-shadow: 0 16px 42px rgba(19, 200, 155, .42); }
    }

    @media (prefers-reduced-motion: reduce) {
        .rc-hero-slider .rc-hero-slide *,
        .rc-hero-slide::before,
        .rc-hero-slide.slick-active::before {
            opacity: 1 !important;
            transform: none !important;
            animation: none !important;
        }
    }
</style>
