@if($visible)
    <span {{ $attributes->class([
        'rc-property-badge',
        'rc-property-badge--featured',
        'rc-promotion-badge',
        $durationClass,
    ]) }}>
        <i class="fas fa-star" aria-hidden="true"></i>
        {{ App::isLocale('en') ? "Featured - {$durationDays} days" : "مميز - {$durationDays} يوم" }}
    </span>

    @once
        <style>
            .rc-promotion-badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                min-height: 28px;
                padding: 6px 10px;
                border: 1px solid rgba(255, 255, 255, .55) !important;
                border-radius: 999px;
                color: #fff !important;
                font-size: 11px;
                font-weight: 900;
                line-height: 1;
                white-space: nowrap;
                box-shadow: 0 7px 18px rgba(8, 40, 77, .18);
            }

            .rc-promotion-badge--7 {
                background: linear-gradient(135deg, #f89a4b, #e9681e) !important;
            }

            .rc-promotion-badge--14 {
                background: linear-gradient(135deg, #28b487, #12815f) !important;
            }

            .rc-promotion-badge--30 {
                background: linear-gradient(135deg, #2388d8, #075b9e) !important;
            }
        </style>
    @endonce
@endif
